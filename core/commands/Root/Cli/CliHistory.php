<?php 

namespace spoova\mi\core\commands\Root\Cli;

use spoova\mi\core\classes\Bundle\Filemanager\Filemanager;
use spoova\mi\core\commands\Root\Cli;
use spoova\mi\core\commands\Root\Cli\CliPulser\CliWords;

final class CliHistory
{
    protected string $file;
    protected array $items = [];
    protected int $index = 0;

    /**
     * @param string $file relative path to history file (from home directory)
     */
    public function __construct(string $file = '/.history')
    {
        $this->file = $file;
        $CLIPath = domroot('core/commands/Root/Cli/Resources');
        $CLIPath .= $file;
        $this->load();
    }

    protected function load(): void
    {
        $Filemanager = new Filemanager();

        if(CliDev::isWSL()){
            if(!is_file($this->file)){
                $posix = Cli::cursorPosition();
                Cli::wait(5000);
                Cli::break();
                Cli::pulseView("Error: CLI history cannot be saved to: '{$this->file}'",5000, function(CliPulser $pulse){
                    return $pulse->words(['Error:'], function(CliWords $word){
                       return Cli::color($word->char(), 'red');
                    });
                })->pause(2)->pulseClear(beats: 0);
                Cli::moveTo($posix['col'], $posix['row']);
                return ;
            }
        }

        if($Filemanager->openFile(true, $this->file) === false){
            if(!$Filemanager->createFile($this->file)){
                throw new \Exception("Unable to generate history file at {$this->file}");
            }
        }

        $this->items = array_values(array_filter(
            array_map('rtrim', file($this->file, FILE_IGNORE_NEW_LINES)),
            fn($v) => $v !== ''
        ));

        // cursor starts AFTER last entry
        $this->index = count($this->items);
    }

    public function push(string $line): void
    {
        $line = trim($line);
        if ($line === '') return;

        // avoid duplicates (last entry only)
        if (end($this->items) === $line) return;

        file_put_contents($this->file, $line . PHP_EOL, FILE_APPEND);
        $this->items[] = $line;
        $this->index = count($this->items);
    }

    public function up(): ?string
    {
        if ($this->index <= 0) return null;
        $this->index--;
        return $this->items[$this->index] ?? null;
    }

    public function down(): ?string
    {
        if ($this->index >= count($this->items)) {
            $this->index = count($this->items);
            return '';
        }

        $this->index++;
        return $this->items[$this->index] ?? '';
    }

    public function resetCursor(): void
    {
        $this->index = count($this->items);
    }
}
