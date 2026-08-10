<?php

/**
 * @author Akinola Saheed <akinolasaheed001@gmail.com> .
 *
 * This class is for adding temporary notes for easy development
 */
namespace spoova\mi\core\commands\Support;

use Closure;
use spoova\mi\core\commands\Root\Cli\CliPrompt;

use spoova\mi\core\classes\Enums\inflect;
use spoova\mi\core\classes\Bundle\Filemanager\Filemanager;
use spoova\mi\core\commands\Root\Cli;
use spoova\mi\core\commands\Root\Cli\CliPulser;
use spoova\mi\core\commands\Root\Cli\CliPulser\CliMatch;
use spoova\mi\core\commands\Root\Entry;
use spoova\mi\core\tools\BytesConverter;

class Notes extends Entry{

    private static $notes = [];

    private const noteExt = '.md';
    private const noteEnc = '.enc';
    private const noteZip = '.zip';

    /**
     * Names accepted for note files. Note names end up inside file paths and inside
     * the command used to launch an editor, so anything outside this pattern is rejected
     * before it is ever used.
     */
    private const namePattern = '/^[A-Za-z0-9][A-Za-z0-9._-]{0,63}$/';

    /**
     * Editors probed when no explicit editor is configured, in order of preference.
     * The key is the executable looked up on PATH, the value is the launch command.
     */
    private const editors = [
        'code'      => 'code -r',
        'codium'    => 'codium -r',
        'subl'      => 'subl --add',
        'phpstorm'  => 'phpstorm --reuse-window',
        'notepad++' => 'notepad++',
    ];

    /** Process exit codes */
    private const exitOk = 0;
    private const exitError = 1;
    private const exitUsage = 2;

    /**
     * Path of an archive currently renamed out of its resting extension.
     *
     * Every read of a protected note temporarily renames ```.enc``` to ```.zip``` so that
     * ZipArchive can open it. Should the process end before it is renamed back, the
     * shutdown handler registered by {@see Notes::guard_archive()} puts it back.
     *
     * @var string|null
     */
    private static ?string $pendingArchive = null;

    function __construct($args = []) {

        $this->set_configurations(); // configure file and directory paths
        $this->recover_storage();    // repair anything a previous interrupted run left behind

        if($args){

            $command = $args[0];
            $isDirective = (($command !== '') && ($command[0] === ':'));
            Cli::headerView('spoova notes ' .Cli::warn($command), break: 2);

            switch($command){
                case ':delete': $this->delete_note($args);
                break;
                case ':list': $this->list_notes($args);
                break;
                case ':save': $this->save_note($args);
                break;
                case ':view': $this->view_note($args);
                break;
                case ':add': $this->add_note_entry($args);
                break;
                default: $isDirective? $this->invalid_directive($command) : $this->new_note($args);
            }

        } else {
            Cli::bashView(Cli::danger(Cli::emo('point-list', '|1').'spoova notes '))->break(2);
            Cli::textView(Cli::error('No arguments supplied'))->break(2);
            self::terminate(null, 0, self::exitUsage);
        }
    }


    private function set_configurations(){

        $notesPath['dir']  = 'notes/';
        $notesPath['encDir'] = $notesPath['dir'].'enc/';

        self::$notes = $notesPath;
    }

    /**
     * Get paths or file information relative to note file using predefined access name
     *
     * @param string $access_name [dir|encDir]
     *  - dir : directory of note file.
     *  - encDir : directory where encrypted files are stored.
     * @param string $subpath suffix paths appended on paths retrieved.
     * @return string
     */
    private static function notes($access_name = '', $subpath = '') : string {

        $path = self::$notes[$access_name];

        if($subpath) $path .= $subpath;

        return $path;

    }

    /**
     * Resolve every path belonging to a single note.
     *
     * @param string $name validated note name
     * @return array keys: md (note file), zip (working archive), enc (resting archive),
     *  tempDir & tempFile (per-run scratch space inside the encryption directory)
     */
    private static function note_paths(string $name) : array {

        $scratch = '_temp'.randice(10);

        return [
            'md'       => domroot(self::notes('dir', $name.self::noteExt)),
            'zip'      => domroot(self::notes('encDir', $name.self::noteZip)),
            'enc'      => domroot(self::notes('encDir', $name.self::noteEnc)),
            'tempDir'  => domroot(self::notes('encDir', $scratch)),
            'tempFile' => domroot(self::notes('encDir', $scratch.'/'.$name.self::noteExt)),
        ];
    }

    /**
     * Reject note names that cannot safely be used as a file name or shell argument.
     *
     * @param string $name
     * @return string the validated name
     */
    private static function validate_name(string $name) : string {

        if(!preg_match(self::namePattern, $name) || str_contains($name, '..')){

            Cli::textView(Cli::error('invalid note name '.Cli::warn('"'.$name.'"')))->break(2);
            Cli::infoView(' Info ', 'note names may only contain letters, numbers, dots, dashes and underscores (64 characters max).', break: 2);
            self::terminate(null, 0, self::exitUsage);

        }

        return $name;

    }

    /**
     * Displays a final message and ends the process with a meaningful exit code
     * so that notes commands can be chained inside scripts.
     *
     * @param string|null $message
     * @param integer $breaks line breaks added after the message
     * @param integer $code process exit code
     * @return never
     */
    private static function terminate(?string $message = null, int $breaks = 0, int $code = self::exitOk) : never {

        if($message !== null){
            Cli::textPlain($message);
            if($breaks) Cli::break($breaks);
        }

        Cli::showCursor();
        exit($code);

    }

    /**
     * Generate enc or zip file from path extension
     *
     * @param string $path
     * @return bool TRUE when the file was renamed to its counterpart extension
     */
    private static function reform(string $path) : bool {

        $ext = strtolower(pathinfo($path, PATHINFO_EXTENSION));

        if(!in_array($ext, ['zip','enc'])) return false;
        if(!is_file($path)) return false;

        $newExt = ($ext === 'zip')? 'enc' : 'zip';
        $target = substr($path, 0, strlen($path) - strlen($ext)).$newExt;

        if(is_file($target) && !@unlink($target)) return false;

        return @rename($path, $target);

    }

    /**
     * Remember an archive that is currently renamed to ```.zip``` so that it is
     * renamed back even when the process ends through an exit or a fatal error,
     * neither of which run a finally block.
     *
     * @param string $zipPath
     * @return void
     */
    private static function guard_archive(string $zipPath) : void {

        static $registered = false;

        self::$pendingArchive = $zipPath;

        if($registered) return;
        $registered = true;

        register_shutdown_function(static function(){
            if(self::$pendingArchive !== null) self::reform(self::$pendingArchive);
            self::$pendingArchive = null;
        });

    }

    /**
     * Run a callback against a note archive with the archive renamed from ```.enc```
     * to ```.zip``` for the duration of the call, restoring it afterwards no matter
     * how the callback ends.
     *
     * @param array $paths note paths as returned by {@see Notes::note_paths()}
     * @param Closure $work
     * @return mixed the callback's return value
     */
    private static function within_archive(array $paths, Closure $work) : mixed {

        if(!self::reform($paths['enc'])){
            self::terminate(Cli::error('note storage file could not be prepared for reading.'), 2, self::exitError);
        }

        self::guard_archive($paths['zip']);

        try{
            return $work();
        }finally{
            self::reform($paths['zip']);
            self::$pendingArchive = null;
        }

    }

    /**
     * Replace a note's resting archive with a freshly built one.
     *
     * The new archive is only put in place once it exists, and the previous archive is
     * only discarded once the replacement has landed, so an interrupted save can never
     * leave the note without a recoverable copy.
     *
     * @param string $newZip freshly built archive
     * @param string $encPath resting archive it should replace
     * @return boolean
     */
    private static function swap_archive(string $newZip, string $encPath) : bool {

        if(!is_file($newZip)) return false;

        $backup = $encPath.'.bak';

        if(is_file($backup)) @unlink($backup);
        if(is_file($encPath) && !@rename($encPath, $backup)) return false;

        if(!@rename($newZip, $encPath)){
            if(is_file($backup)) @rename($backup, $encPath); // roll back
            return false;
        }

        if(is_file($backup)) @unlink($backup);
        return true;

    }

    /**
     * Repair storage left inconsistent by an interrupted run.
     *
     * Archives stranded with a ```.zip``` extension are renamed back (never overwriting an
     * existing ```.enc```), and abandoned scratch directories, which may still hold a
     * decrypted note, are removed.
     *
     * @return void
     */
    private function recover_storage() : void {

        $encDir = domroot(self::notes('encDir'));

        if(!is_dir($encDir)) return;

        foreach(glob($encDir.'*'.self::noteZip) ?: [] as $archive){
            $resting = substr($archive, 0, strlen($archive) - 3).'enc';
            if(!is_file($resting)) @rename($archive, $resting);
        }

        $stale = glob($encDir.'_temp*', GLOB_ONLYDIR) ?: [];

        if($stale){
            $Filemanager = new Filemanager;
            foreach($stale as $directory) $Filemanager->deleteFile($directory);
        }

    }

    /**
     * Create the notes directories on first use and keep them out of both the
     * web server's reach and the project's git history.
     *
     * @return void
     */
    private static function prepare_storage() : void {

        $dir = domroot(self::notes('dir'));
        $encDir = domroot(self::notes('encDir'));

        if(!is_dir($dir)) @mkdir($dir, 0755, true);
        if(!is_dir($encDir)) @mkdir($encDir, 0755, true);

        // Deny direct web access even when this directory is deployed by mistake.
        $htaccess = $dir.'.htaccess';

        if(is_dir($dir) && !is_file($htaccess)){
            file_put_contents($htaccess, implode(PHP_EOL, [
                '# Development notes are local working files and must never be served.',
                '<IfModule mod_authz_core.c>',
                '    Require all denied',
                '</IfModule>',
                '<IfModule !mod_authz_core.c>',
                '    Order allow,deny',
                '    Deny from all',
                '</IfModule>',
            ]).PHP_EOL);
        }

        self::register_gitignore();

    }

    /**
     * Add the notes directory to the project's .gitignore the first time a note is created.
     *
     * Notes routinely hold credentials, staging urls and unfinished thinking, so they are
     * excluded from version control automatically rather than by convention.
     *
     * @return void
     */
    private static function register_gitignore() : void {

        $gitignore = domroot('.gitignore');
        $entry = rtrim(self::notes('dir'), '/');

        if(is_file($gitignore)){

            foreach(file($gitignore, FILE_IGNORE_NEW_LINES) ?: [] as $line){
                $line = trim($line);
                if($line === '' || $line[0] === '#') continue;
                if(rtrim(ltrim($line, '/'), '/') === $entry) return; // already ignored
            }

            $content = file_get_contents($gitignore);
            $lead = (($content !== '') && !str_ends_with($content, PHP_EOL))? PHP_EOL : '';
            $added = file_put_contents($gitignore, $lead.PHP_EOL.'# spoova development notes (local only)'.PHP_EOL.$entry.'/'.PHP_EOL, FILE_APPEND);

        }else{

            $added = file_put_contents($gitignore, '# spoova development notes (local only)'.PHP_EOL.$entry.'/'.PHP_EOL);

        }

        if($added !== false){
            Cli::infoView(' Info ', Cli::warn($entry.'/').' added to .gitignore', break: 2);
        }

    }

    /**
     * Resolve the command used to open a note file.
     *
     * An explicit editor always wins, then the editor whose terminal the command was
     * launched from, then the first known editor found on PATH.
     *
     * @return string launch command or an empty string when no editor was resolved
     */
    private static function resolve_editor() : string {

        $preferred = getenv('SPOOVA_EDITOR') ?: getenv('VISUAL') ?: getenv('EDITOR') ?: '';

        if($preferred) return $preferred;

        $termProgram = strtolower($_SERVER['TERM_PROGRAM'] ?? '');
        if($termProgram === 'vscode') $termProgram = 'code';

        if($termProgram && isset(self::editors[$termProgram])) return self::editors[$termProgram];

        foreach(self::editors as $program => $command){
            if(self::has_program($program)) return $command;
        }

        return '';

    }

    /**
     * Determine whether an executable is available on the current PATH
     *
     * @param string $program
     * @return boolean
     */
    private static function has_program(string $program) : bool {

        $finder = (Cli::isTerminal(['windows','wt']) || (getOs() === 'windows'))? 'where' : 'command -v';

        @exec($finder.' '.escapeshellarg($program).' 2>&1', $output, $code);

        return $code === 0;

    }

    /**
     * Open a note file in the resolved editor.
     *
     * @param string $path
     * @return boolean TRUE only when the editor was launched and reported success
     */
    private static function open_in_editor(string $path) : bool {

        $command = self::resolve_editor();

        if($command === '') return false;

        @exec($command.' '.escapeshellarg($path).' 2>&1', $output, $code);

        return $code === 0;

    }

    /**
     * Hand a note file over to the editor and report the outcome.
     *
     * @param string $path
     * @param string $reference wording used to describe the note in the response
     * @return void
     */
    private static function deliver_note(string $path, string $reference = 'note') : void {

        if(self::resolve_editor() === ''){
            Cli::infoView(' Info ', "no supported editor was found. view {$reference} at: ".Cli::warn(Cli::italics(self::relative($path))), break: 2);
            return;
        }

        Cli::pulseView("Opening {$reference} file ...", function($char, CliPulser $mod) {
            return $mod->from('...', fn($char)=> Cli::alert($char));
        })->pulseToggle(3, 10)->pause(1)->clearLine();

        if(self::open_in_editor($path)){
            Cli::textView(Cli::success("{$reference} file opened!"))->break(2);
            return;
        }

        Cli::textView(Cli::error('note file could not be opened by the editor.'))->break(1);
        Cli::infoView(' Info ', "view {$reference} at: ".Cli::warn(Cli::italics(self::relative($path))), break: 2);

    }

    /**
     * Express an absolute note path relative to the project root for display
     *
     * @param string $path
     * @return string
     */
    private static function relative(string $path) : string {

        $root = domroot('');

        return str_replace('\\', '/', str_replace($root, '', $path));

    }

    /**
     * Request a password, optionally asking for it a second time.
     *
     * A mistyped password on a new note can never be recovered, so creation always
     * confirms while unlocking an existing note does not.
     *
     * @param string $request prompt text
     * @param boolean $confirm request the password twice and compare
     * @return string
     */
    private static function prompt_password(string $request, bool $confirm = false) : string {

        $password = self::request_secret($request);

        if(!$confirm) return $password;

        $repeat = self::request_secret('Confirm password: ');

        if(!hash_equals($password, $repeat)){
            self::terminate(Cli::error('passwords did not match. no encryption file was generated.'), 2, self::exitError);
        }

        return $password;

    }

    /**
     * Read a single secured value from the terminal
     *
     * @param string $request prompt text
     * @return string
     */
    private static function request_secret(string $request) : string {

        $request_invalid = $request.Cli::danger('invalid');

        Cli::pulseView($request, eachChar: fn($char) => $char);

        $choice = Cli::q([], fn() => [
            'init' => function($inp) use($request){

                if($inp->trials() > 0 && $inp->trials() < 3){
                    Cli::textPlain($request);
                }

            },
            'test' => fn($inp) => trim($inp->value()?:'') ? true : false,
            'failed' => function($inp) use($request_invalid){
                if($inp->value() === null){
                    //Run this if process was terminated
                    Cli::clearLine();
                    Cli::textPlain($request_invalid)->break();
                    self::terminate(Cli::error('Process termination successful.'), 2, self::exitError);
                }
                if($inp->trials() < 3){
                    //Run this if no value was supplied
                    Cli::clearUp();
                    Cli::textPlain($request_invalid)->break();
                    return true;
                }
                Cli::clearUp()->textPlain($request_invalid)->break();
                return false;
            }
        ], 3, secured: true);

        if(!$choice){
            if(Cli::qmax()){
                self::terminate(Cli::error('no password received after '.Cli::qTrials().' trials.'), 2, self::exitError);
            }
            self::terminate(Cli::error('Process terminated successfully'), 2, self::exitError);
        }

        Cli::clearUp(1);

        return $choice;

    }

    /**
     * Initial content written into a freshly created note file
     *
     * @param string $name
     * @return string
     */
    private static function note_template(string $name) : string {

        return '# '.$name.PHP_EOL.PHP_EOL
             .'> development notes started '.date('Y-m-d').PHP_EOL.PHP_EOL;

    }

    /**
     * Handles opening or generation of new notes.
     *
     * @param array $args
     * @return void|never
     */
    function new_note(array $args) {

        if(count($args) > 1){
            Cli::textView(Cli::error('opening or creating new note does not require extra arguments'));
            Cli::break(2);
            self::terminate(null, 0, self::exitUsage);
        }

        $notesName = self::validate_name($args[0]);

        Cli::hideCursor()
           ->pulseView('Preparing note ... ', eachChar: function($char, CliPulser $pulse){
                return $pulse->offset(16, fn()=> Cli::alert($char));
            }, beats: 10000)
           ->pause(1)
           ->pulseBack(4, 10)->pulseFront(4, 20000)
           ->pulseBack(4, 10)->pulseFront(4, 20000)
           ->pulseBack(4, 10)->pulseFront(4, 20000)
           ->pulseBack(4, 10)->pulseFront(4, 20000)->showCursor()->clearLine();

        $paths = self::note_paths($notesName);
        $notesPath = $paths['md'];
        $notesEncPath = $paths['enc'];

        $Filemanager = new Filemanager;

        if(!is_file($notesPath) || is_file($notesEncPath)){

            //Check for encrypted file ...
            if(is_file($notesEncPath)){

                $searchword = $notesName;
                $message = 'Enter note password for ';
                $messages[1] = $message.$notesName.' : ';
                $messages[2] = $message.Cli::warn("{$notesName}")." : ";
                $messages[3] = $message.Cli::warn("{$notesName}")." : ".Cli::danger('invalid');
                $messages[4] = $message.$searchword." : ".Cli::danger('invalid');

                Cli::pulseView($messages[1], function($char, CliPulser $mod) use($searchword){
                    return $mod->match($searchword, fn(CliMatch $bits) => Cli::warn($char));
                });

                $password = Cli::q([], fn() => [
                     'init' => function($inp) use($messages) {
                         if($inp->trials() > 0){
                             Cli::textPlain($messages[1]);
                         }
                     },
                     'test' => function($inp){
                         return $inp->value()? true : false;
                     },
                     'failed' => function($inp) use($messages) {
                         if($inp->value() === null){
                             Cli::clearLine()->textView($messages[3])->break();
                         }else{
                             Cli::clearUp()->textView($messages[4])->break();
                         }
                         return $inp->trials() < 3 ? true : false;
                     }
                 ], secured: true);

                if($password === null){
                    Cli::textView(Cli::error('Process terminated by user.'))->break(2);
                    self::terminate(null, 0, self::exitError);
                }elseif($password === ''){
                    Cli::textView(Cli::error('Process terminated after 3 trials.'))->break(2);
                    self::terminate(null, 0, self::exitError);
                }

                $cursorView = Cli::cursorView();
                Cli::hideCursor(); Cli::pause(2); Cli::clearUp(1);

                // Unzip secured & encrypted note file
                $unzipped = self::within_archive($paths, function() use($Filemanager, $paths, $password){
                    $Filemanager->source($paths['zip']);
                    $Filemanager->secure(fn() => $Filemanager->unzip(to: $paths['tempDir'], dirs: true), $password);
                    return $Filemanager->unzipped();
                });

                if(!$unzipped){
                    $Filemanager->deleteFile($paths['tempDir']);
                    Cli::cursorView($cursorView);
                    Cli::textView(Cli::error('File decryption failed - '. $Filemanager->zipError()));
                    Cli::break(2);
                    self::terminate(null, 0, self::exitError);
                }

                if(is_file($notesPath)) $content1 = file_get_contents($notesPath);

                $content2 = $Filemanager->decryptFrom($paths['tempFile'], $password);
                $Filemanager->deleteFile($paths['tempDir']); // never leave a decrypted note behind
                Cli::cursorView($cursorView);

                if($content2 === false){
                    self::terminate(Cli::error('file access denied.'), 2, self::exitError);
                }

                $message = 'file access granted.';
                Cli::successView('')->wait(500000)->pulseView($message, 200)->pause(2)->clearLine();

                if(isset($content1)){
                    // Handle cases where current/encrypted files content mismatch happens when opening file.
                    if($content1 !== $content2){
                        Cli::pulseView('Notice: local note differs from the protected copy. Replace local with protected? [Y/N] ', 10000, fn($char, CliPulser $mod) => $mod->words(['Notice:','[Y/N]'], fn($char, $i, $w)=> $w == 'Notice:'? Cli::warn($char) : Cli::alert($char)));
                        $choice = Cli::q(["::case"=>'lower'], fn()=> ['test' => fn() => true]);
                        if($choice === null){
                            self::terminate(Cli::error('process terminated by user'), 2, self::exitError);
                        }elseif($choice === 'y'){
                            // Overwrite file..
                            Cli::clearUp(1);
                            if(file_put_contents($notesPath, $content2) === false){
                                self::terminate(Cli::error('failed to overwrite existing file'), 2, self::exitError);
                            }
                        }else{
                            Cli::clearUp(1);
                            $reference = 'unprotected note';
                        }
                    }
                }else{
                    // restore note from encryption, an empty note included ...
                    self::prepare_storage();
                    if(file_put_contents($notesPath, $content2) === false){
                        self::terminate(Cli::error('protected note could not be restored'), 2, self::exitError);
                    }
                }

                $reference = $reference?? 'protected note';

                self::deliver_note($notesPath, $reference);
                self::terminate();
            }

            // Generate new note if backup encryption file does not exist.
            $length = strlen($notesName)+2;
            $indices = array_keys(array_fill(6, $length, null));

            Cli::pulseView('Note ('.$notesName.') is not available:', eachChar:function($char, $index) use($indices){
                return (in_array($index, $indices))? Cli::warn($char) : $char;
            })->break(1);
            Cli::pulseView('Create this note? [Y/N] ', eachChar: function($char, $index){
                return ($index > 18)? Cli::alert($char) : $char;
            });

            $choice = Cli::prompt(['y','n', '::nocase'=>true], function(CliPrompt $prompt){
                if($prompt->trials() > 0){
                    if($prompt->matches('n')){
                        Cli::hideCursor()->break();
                        Cli::textView(Cli::warn('Process exited successfully.'))->break(1)->bashBreak(1)->showCursor();
                        self::terminate();
                    }
                    if($prompt->active() && $prompt->invalid()){
                        Cli::clearUp(4);
                        Cli::bashView(Cli::danger(Cli::emo('point-list', '|1').'spoova notes'))->break(1);
                        Cli::bashBreak(1);
                        Cli::textView(Cli::error('Process terminated by wrong option'))->break(1);
                        Cli::bashBreak(1);
                        self::terminate(null, 0, self::exitUsage);
                    }
                }
            },1);

            if($choice->imatches('n')){
                Cli::hideCursor()->break();
                Cli::textView(Cli::warn('Process exited successfully.'))->break(1)->bashBreak(1)->showCursor();
                self::terminate();
            }

            /* Create a password for new note file */
            $message = 'Generate Encryption File? [Y/N] ';
            $choiceIndex = strpos($message, '[');
            Cli::pulseView($message, eachChar: function($char, $index) use($choiceIndex){
                return ($index >= $choiceIndex)? Cli::alert($char) : $char;
            });

            $choice = Cli::prompt(['y','n'], function(CliPrompt $prompt){
                if($prompt->inactive()){

                    Cli::bashView(Cli::danger(Cli::emo('point-list', '|1').'spoova notes'))->break(1);
                    Cli::bashBreak(1);
                    if($prompt->invalid()){
                        Cli::textView(Cli::error('Process terminated by wrong option'))->break(1);
                        self::terminate(null, 0, self::exitUsage);
                    }elseif($prompt->imatches('n')){
                        Cli::textView(Cli::error('Process terminated by user'))->break(1);
                        self::terminate(null, 0, self::exitError);
                    }

                }

            }, 1);

            if($choice->imatches('y')){
                $password = self::prompt_password('Your encryption password: ', confirm: true);
            }

            $create_note = true;
            self::prepare_storage();

            Cli::pulseView('Creating note ... ', eachChar: function($char, $index){
                    return (in_array($index, [15,16,17]))? Cli::alert($char) : $char;
                })
                ->pulseToggle(4, 5, 50000)
            ;

            Cli::clearLine();

        }

        // Try accessing existing note file or create new if possible.
        if($Filemanager->openFile(true, $notesPath)){

            if(isset($create_note)){

                if(filesize($notesPath) === 0){
                    file_put_contents($notesPath, self::note_template($notesName));
                }

                Cli::pulseView('Note generated successfully', 0, eachChar: function($char, $index){
                        return $char;
                    })->pause(1);

                Cli::clearLine();
            }

            if(isset($password)){

                $message = 'Generating encryption file ...';
                $dots = strpos($message,'.');
                Cli::pulseView($message, eachChar: function($char, $index, $mod) use($dots){
                    return ($index >= $dots)? Cli::alert($char) : $char;
                }) ->pulseToggle(4, 5, 50000) ;

                // Create a protected note file
                $Filemanager->source($notesPath);
                $secured = $Filemanager->secure(function(Filemanager $Filemanager) use($paths){
                    return $Filemanager->zipUrl($paths['zip'])->zipped();
                }, $password);

                Cli::clearLine();

                if($secured && self::swap_archive($paths['zip'], $paths['enc'])){

                    Cli::pulseView('Encryption file generated', eachChar: function($char, $index) {
                        return $char;
                    })->pause(1);
                    Cli::clearLine();

                }else{
                    @unlink($paths['zip']);
                    $message = 'Encryption file generation failed';
                    Cli::pulseView($message, eachChar: function($char, $index) {
                        return Cli::danger($char);
                    })->pause(1)->break();
                }

            }

            self::deliver_note($notesPath, 'note');
            self::terminate();

        }

        Cli::textView(Cli::error('File cannot be opened!'))->pause(1)->break(2);
        self::terminate(null, 0, self::exitError);

    }

    /**
     * Handles deleting note files
     *
     * @return void
     */
    function delete_note(array $args){

        $Filemanager = new Filemanager;
        $Files = $this->get_notes($Filemanager);
        $FilesCount = count($Files);

        if(!$FilesCount) {
            Cli::textView(Cli::notice(title: 'Notice: ', text: "no development notes detected."));
            Cli::break(2);
            self::terminate();
        }

        if(!isset($args[1])){
            Cli::textView(Cli::error('a note name or '.Cli::warn('*').' is required'))->break(2);
            Cli::infoView(' Info ', 'use '.Cli::warn('mi notes :delete <name>').' for one note or '.Cli::warn('mi notes :delete *').' for every note.', break: 2);
            self::terminate(null, 0, self::exitUsage);
        }

        $file = $args[1];

        if($file === '*'){

            Cli::textView(Cli::notice(title: 'Notice: ', text: "{$FilesCount} development ".inflect(['note','notes'], $FilesCount, inflect::smart)." detected."))
               ->break(2)
               ->pulseView('Are you sure you want to delete '.inflect(['this note','these notes'], $FilesCount, inflect::smart).'? [Y/N] ', 10)
               ->pause(2)
               ->showCursor();

            $option = Cli::prompt(['y','n','::nocase'=>true], function(CliPrompt $input)use($FilesCount){
                if($input->invalid()){
                    if(!Cli::promptIsMax()){
                        if($input->trials() < 3){
                            Cli::clearLine();
                            Cli::textView('Are you sure you want to delete '.inflect(['this note','these notes'], $FilesCount, inflect::smart).'?'.Cli::alert(' [Y/N] '));
                        } else {
                            Cli::break(2);
                            if($input->trials() !== 3){
                                Cli::break();
                                Cli::textView('Are you sure you want to delete '.inflect(['this note','these notes'], $FilesCount, inflect::smart).'?'.Cli::alert(' [Y/N] '));
                            }
                        }
                    }else{
                        Cli::clearUp(1)
                        ::textView('Process terminated after '.Cli::warn($input->trials()).' trials')
                        ::break(2);
                        self::terminate(null, 0, self::exitError);
                    }
                    return false;
                }
            }, 3);

            Cli::clearUp(1);

            if($option->matches('n')) {

                Cli::textView(Cli::caution('operation cancelled successfully!', title: 'Notice: '));
                Cli::break(2);
                self::terminate();

            } elseif($option->matches('y')) {

                Cli::break(); $deletions = 0;
                Cli::pulseView('Deleting saved notes ...', 10, function($char, $index){
                    return ($index > 21)? Cli::danger($char) : $char;
                })->pulseToggle(3, 10)->pause(2);

                //Delete notes here
                foreach($Files as $File){
                    if($Filemanager->removeFile($File)) $deletions++;
                }

                // Final response message
                Cli::clearLine()->textView($deletions.' notes deleted successfully.')->break(2);
                self::protected_notes_hint();
                self::terminate();

            }

            self::terminate();
        }

        $file = self::validate_name($file);
        $paths = self::note_paths($file);
        $filepath = $paths['md'];

        if(!is_file($filepath)){

            $prefix = 'File error:';
            $ntname = $file.self::noteExt;
            $middle = " $ntname ";
            $suffix = 'note file does not exist.';
            $message = $prefix.$middle.$suffix;
            $x1 = strlen($prefix) + 1; //start point
            $x2 = $x1 + strlen($middle); // end point

            Cli::pause(2)
               ->pulseView($message, 0, function($char, $index) use($x1, $x2){
                    if($index < 11) return Cli::danger($char);
                    return ($index > $x1 && $index < $x2)? Cli::warn($char) : $char;
                })
               ->break(2)
               ->showCursor();
            self::terminate(null, 0, self::exitError);
        }


        $message = 'Delete this note? [Y/N] ';
        $choiceIndex = strpos($message, '[');

        Cli::pause(1)->textView(Cli::notice(title: 'Notice: ', text: 'about to delete → '.Cli::warn(self::relative($filepath))))
           ->break(2)
           ->pulseView($message, 10, fn($char, $index) => ($index >= $choiceIndex)? Cli::alert($char) : $char)
           ->pause(2)
           ->showCursor();

        $option = Cli::prompt(['y','n', '::nocase'=> true], function(CliPrompt $input){
            if($input->invalid()){
                if(!Cli::promptIsMax()){
                    if($input->trials() < 3){
                        Cli::clearLine();
                        Cli::textView('Delete this note? ['.Cli::danger('Y').'/'.Cli::valid('N').'] ');
                    } else {
                        Cli::break(2);
                        if($input->trials() !== 3){
                            Cli::break();
                            Cli::textView('Are you sure you want to delete notes?'.Cli::alert(' [Y/N] '));
                        }
                    }
                }else{
                    Cli::clearUp(1)
                    ::textView('Process terminated after '.Cli::warn($input->trials()).' trials')
                    ::break(2);
                    self::terminate(null, 0, self::exitError);
                }
                return false;
            }
        }, 3);

        Cli::clearUp(2);

        if($option->matches('n')) {

            Cli::break();
            Cli::textView(Cli::caution('operation cancelled successfully!', title: 'Notice: '));
            Cli::break(2);
            self::terminate();

        } elseif($option->matches('y')) {

            Cli::break();
            Cli::pulseView('Deleting saved note ...', 10, function($char, $index){
                return ($index < 21)? Cli::danger($char) : $char;
            })->pulseToggle(3, 10)->pause(2);

            if(!$Filemanager->removeFile($filepath)){
                Cli::clearLine()->textView(Cli::warn("({$file}.md)").' note removal failed.')->break(2);
                self::terminate(null, 0, self::exitError);
            }

            Cli::clearLine()->textView(Cli::success(Cli::warn(Cli::underline($file)).' removed from notes.'))->break(2);

            if(is_file($paths['enc'])){
                Cli::infoView(' Info ', 'a protected copy remains in '.Cli::warn(self::relative($paths['enc'])).'. run '.Cli::warn('mi notes '.$file).' to restore it.', break: 2);
            }

            self::terminate();
        }

        Cli::clearLine()->textView(Cli::error('exited successfully'))->break(2);
        self::terminate();

    }

    /**
     * Mention protected copies left behind after a bulk delete
     *
     * @return void
     */
    private static function protected_notes_hint() : void {

        $archives = glob(domroot(self::notes('encDir', '*'.self::noteEnc))) ?: [];

        if(!$archives) return;

        $count = count($archives);

        Cli::infoView(' Info ', $count.' protected '.inflect(['copy','copies'], $count, inflect::smart).' still available in '.Cli::warn(self::relative(domroot(self::notes('encDir')))), break: 2);

    }

    function list_notes(array $args) {

        self::requires_arguments($args, 2);

        $flag = $args[1] ?? '';

        if($flag !== '' && $flag !== '-s'){
            self::terminate(Cli::error('unknown flag '.Cli::warn('"'.$flag.'"').'. only '.Cli::warn('-s').' is supported'), 2, self::exitUsage);
        }

        $Filemanager = new Filemanager;
        $Files = $this->get_notes($Filemanager, false);

        if(!$Files) {
            Cli::pulseView('No note files detected on this project app.')->break(2);
            self::terminate();
        }

        sort($Files);
        $width = max(array_map('strlen', $Files)) + 2;

        foreach($Files as $File) {

            $path = domroot(self::notes('dir', $File));
            $name = pathinfo($File, PATHINFO_FILENAME);

            $details = [date('Y-m-d H:i', filemtime($path))];

            if($flag === '-s'){
                array_unshift($details, BytesConverter::convert(filesize($path))->toStringBytes());
            }

            if(is_file(domroot(self::notes('encDir', $name.self::noteEnc)))) $details[] = 'protected';

            Cli::pulseView('--'.str_pad($File, $width).'('.implode(' | ', $details).')', 10000, fn($chars, CliPulser $pulse)=>
                $pulse->offset(3, fn() => Cli::color($chars, 'blue'))
            )->break();
        }

        Cli::break();

    }

    /**
     * Print the contents of a note file without opening an editor
     *
     * @param array $args
     * @return void
     */
    function view_note(array $args) {

        self::requires_arguments($args, 2, 2);

        $name = self::validate_name($args[1]);
        $paths = self::note_paths($name);

        if(!is_file($paths['md'])){

            if(is_file($paths['enc'])){
                Cli::infoView(' Info ', 'note '.Cli::warn($name).' is protected and not currently restored.', break: 1);
                Cli::textView('run '.Cli::warn('mi notes '.$name).' to restore it first.')->break(2);
                self::terminate(null, 0, self::exitError);
            }

            self::terminate(Cli::error('note file '.Cli::warn($name).' does not exist'), 2, self::exitError);
        }

        $content = file_get_contents($paths['md']);

        if($content === false){
            self::terminate(Cli::error('note file could not be read'), 2, self::exitError);
        }

        if(trim($content) === ''){
            Cli::infoView(' Info ', 'note '.Cli::warn($name).' is empty.', break: 2);
            self::terminate();
        }

        Cli::textView($content)->break(2);
        self::terminate();

    }

    /**
     * Append a timestamped entry to a note without leaving the terminal.
     *
     * @param array $args
     * @return void
     */
    function add_note_entry(array $args) {

        if(count($args) < 3){
            Cli::textView(Cli::error('a note name and a message are required'))->break(2);
            Cli::infoView(' Info ', 'usage: '.Cli::warn('mi notes :add <name> "<message>"'), break: 2);
            self::terminate(null, 0, self::exitUsage);
        }

        $name = self::validate_name($args[1]);
        $message = trim(implode(' ', array_slice($args, 2)));

        if($message === ''){
            self::terminate(Cli::error('an empty message cannot be added'), 2, self::exitUsage);
        }

        $paths = self::note_paths($name);
        $created = !is_file($paths['md']);

        if($created){

            if(is_file($paths['enc'])){
                Cli::infoView(' Info ', 'note '.Cli::warn($name).' is protected and not currently restored.', break: 1);
                Cli::textView('run '.Cli::warn('mi notes '.$name).' to restore it before adding entries.')->break(2);
                self::terminate(null, 0, self::exitError);
            }

            self::prepare_storage();

            if(file_put_contents($paths['md'], self::note_template($name)) === false){
                self::terminate(Cli::error('note file could not be created'), 2, self::exitError);
            }

        }

        $entry = '- ['.date('Y-m-d H:i').'] '.$message.PHP_EOL;

        if(file_put_contents($paths['md'], $entry, FILE_APPEND | LOCK_EX) === false){
            self::terminate(Cli::error('entry could not be added to '.Cli::warn($name)), 2, self::exitError);
        }

        if($created) Cli::textView(Cli::success('note '.Cli::warn($name).' created.'))->break(1);

        Cli::textView(Cli::success('entry added to '.Cli::warn(self::relative($paths['md']))))->break(2);

        if(is_file($paths['enc'])){
            Cli::infoView(' Info ', 'run '.Cli::warn('mi notes :save '.$name).' to store this change in the protected copy.', break: 2);
        }

        self::terminate();

    }

    function invalid_directive(string $directive) {

        Cli::textView(Cli::error('Process terminated by invalid command directive '.Cli::warn('"'.$directive.'"')))->break(2);
        Cli::infoView(' Info ', 'supported directives: '.Cli::warn(':list, :view, :add, :save, :delete'), break: 2);
        self::terminate(null, 0, self::exitUsage);

    }

    /**
     * Fetch files with ```".md"``` extension from notes directory
     *
     * @param Filemanager $Filemanager
     * @param boolean $fullpath
     * @return array|never
     */
    private function get_notes(Filemanager $Filemanager, bool $fullpath = true){
        $Filepath = domroot('notes');

        if(!is_dir($Filepath)){
            Cli::textView(Cli::notice(title: 'Notice: ', text: 'no development notes detected on this project'));
            Cli::break(2);
            self::terminate();
        }

        $Filemanager->source($Filepath); //set source directory
        $Files = $Filemanager->dirFiles('md', $fullpath); // fetch only md files
        return $Files;
    }

    private function save_note(array $args){

        self::requires_arguments($args, 2, 2);

        $filename = self::validate_name($args[1]);
        $paths = self::note_paths($filename);

        $noteFilePath = $paths['md'];
        $noteEncPath = $paths['enc'];
        $noteTempFileDir = $paths['tempDir'];
        $noteTempFilePath = $paths['tempFile'];

        if(!is_file($noteFilePath)){
            if(is_file($noteEncPath)){
                Cli::errorView('saving missing note denied.', break: 2);
            }else{
                Cli::errorView('note file does not exist.', break: 2);
            }
            self::terminate(null, 0, self::exitError);
        }

        $Filemanager = new Filemanager;

        if(!is_file($noteEncPath)){

            // Request a secured encryption password to save a note file.
            $password = self::prompt_password('Set encryption password: ', confirm: true);

            self::prepare_storage();

            $message = 'Generating encryption file ...';
            $dots = strpos($message,'.');
            Cli::pulseView($message, eachChar: function($char, $index) use($dots){
                return ($index >= $dots)? Cli::alert($char) : $char;
            })
            ->pulseToggle(4, 5, 50000)
            ;

            if(!$Filemanager->openFile(true, $noteTempFilePath)){
                Cli::clearLine();
                self::terminate(Cli::error('process terminated and unable to save note file.'), 2, self::exitError);
            }

            // Move to encryption directory
            if($Filemanager->encryptFile($noteFilePath, $noteTempFilePath, $password)){

                Cli::clearLine();
                Cli::pulseView('Saving note file ...', eachChar: function($char, CliPulser $pulse) {
                    return $pulse->offset(18, fn()=> Cli::alert($char));
                })->pulseToggle(3, 4);

                // Create encryption file
                $Filemanager->source($noteTempFilePath);

                $secured = $Filemanager->secure(function(Filemanager $Filemanager) use($paths){
                    return $Filemanager->zipUrl($paths['zip'])->zipped();
                }, $password);
                $Filemanager->deleteFile($noteTempFileDir); // delete note temporaries after use.
                Cli::pulseToggle(3, 4)->pause(1);
                Cli::clearLine();

                if($secured && self::swap_archive($paths['zip'], $noteEncPath)){

                    Cli::pulseView('Encryption file generated.', 200, eachChar: function($char, $index) {
                        return $char;
                    })->pause(2);
                    Cli::clearLine();

                    self::terminate(Cli::success('note saved successfully.'), 2);

                }

                @unlink($paths['zip']);

            }

            $Filemanager->deleteFile($noteTempFileDir);
            Cli::pulseView('Encryption file generation failed', eachChar: function($char, $index) {
                return Cli::danger($char);
            })->pause(1)->break(2);
            self::terminate(Cli::error($Filemanager->err()?: 'note file could not be protected'), 2, self::exitError);
        }

        Cli::pulseView('Ensure to save new changes before encryption.', 100)->pause(1)->break(2);

        $message = 'Please enter password : ';
        Cli::textView($message);

        $password = Cli::q([], fn() => ['test'=> fn() => true], secured: true);
        if($password === null){
            Cli::clearLine()->textView($message)->showCursor(); // create a smart effect
            Cli::textView(Cli::danger('exited!'))->pause(1);
            Cli::break();
            self::terminate(Cli::error('process terminated by user.'), 2, self::exitError);
        }
        Cli::hideCursor()->pause(1)->moveUp();
        Cli::clearLine()->textView($message)->showCursor(); // create a smart effect
        Cli::pulseView('...', fn($char)=> Cli::alert($char))->pulseToggle(3, 10);

        //Try extracting file with password..
        $unzipped = self::within_archive($paths, function() use($Filemanager, $paths, $password){
            $Filemanager->source($paths['zip']);
            $Filemanager->secure(fn() => $Filemanager->unzip(to: $paths['tempDir'], dirs: true), $password);
            return $Filemanager->unzipped();
        });

        if(!$unzipped){
            Cli::clearLine();
            $Filemanager->deleteFile($noteTempFileDir);
            self::terminate(Cli::error(strtolower($Filemanager->zipError()?: 'wrong password or damaged storage file')), 2, self::exitError);
        }

        // File password successful
        $content2 = $Filemanager->decryptFrom($noteTempFilePath, $password);
        $Filemanager->deleteFile($noteTempFilePath); //delete extracted file
        Cli::pause(1);

        if($content2 === false){
            $Filemanager->deleteFile($noteTempFileDir);
            Cli::clearLine();
            self::terminate(Cli::error('wrong password or damaged storage file.'), 2, self::exitError);
        }

        if($content2 === file_get_contents($noteFilePath)){
            $Filemanager->deleteFile($noteTempFileDir);
            Cli::pause(1)->clearLine();
            Cli::infoView(' Info ','note file is already updated.', break: 2);
            self::terminate();
        }

        //Encrypt the recently modified note file
        if(!$Filemanager->encryptFile($noteFilePath, $noteTempFilePath, $password)){
            $Filemanager->deleteFile($noteTempFileDir); //delete extraction directory
            self::terminate(Cli::error('process failed while encrypting data.'), 2, self::exitError);
        }

        Cli::pause(1)->clearLine()->textView($message.Cli::valid('success'))->pause(1);
        Cli::clearLine()->pulseView('Updating note file ...', fn($char, CliPulser $mod) => $mod->from('...', fn($char) => Cli::alert($char)))->pulseToggle(3, 10);
        Cli::clearLine()->pulseView('Warning: new changes will overwrite old ones [Y/N] ', 5000, fn($char, CliPulser $mod) => $mod->words(['Warning:','[Y/N]'], fn($char, $i) => $i<9? Cli::warn($char) : Cli::alert($char)));
        $choice = Cli::q(["::case"=>'lower'], fn() => ['test'=> fn() => true]);

        if($choice !== 'y'){
            $Filemanager->deleteFile($noteTempFileDir); //delete extraction directory
            Cli::clearUp(1);
            Cli::infoView(' Info ','no changes made.', break: 2);
            self::terminate();
        }

        Cli::clearUp(1)->pulseView('Saving new changes ...', fn($char, CliPulser $mod) => $mod->from('...', fn($char) => Cli::alert($char)))->pulseToggle(3, 10);

        // Build the replacement archive beside the old one, then swap it in.
        $Filemanager->source($noteTempFilePath);
        $Filemanager->secure(fn() => $Filemanager->zipUrl($paths['zip']), $password); // zip to enc directory
        $zipped = $Filemanager->zipped();
        $Filemanager->deleteFile($noteTempFileDir); //delete extraction directory

        if(!$zipped){
            @unlink($paths['zip']);
            Cli::pause(1)->clearLine();
            self::terminate(Cli::error($Filemanager->zipError()?: 'new changes could not be stored'), 2, self::exitError);
        }

        if(!self::swap_archive($paths['zip'], $noteEncPath)){
            @unlink($paths['zip']);
            Cli::pause(1)->clearLine();
            self::terminate(Cli::error('new changes could not replace the existing storage file'), 2, self::exitError);
        }

        Cli::pause(1)->clearLine();
        self::terminate(Cli::success('new changes saved.'), 2);

    }

    /**
     * Constrain the number of arguments accepted by a directive
     *
     * @param array $args
     * @param integer $maxcount highest number of arguments accepted
     * @param integer|null $mincount lowest number of arguments accepted
     * @return void
     */
    private static function requires_arguments(array $args, int $maxcount, ?int $mincount = null) {
        if(count($args) > $maxcount){
            self::terminate(Cli::error('maximum number of arguments exceeded'), 2, self::exitUsage);
        }
        if(($mincount !== null) && (count($args) < $mincount)){
            self::terminate(Cli::error('not enough arguments supplied'), 2, self::exitUsage);
        }
    }

}
