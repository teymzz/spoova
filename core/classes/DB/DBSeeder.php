<?php 

namespace spoova\mi\core\classes\DB;

use spoova\mi\core\classes\Bundle\Filemanager\Filemanager;
use spoova\mi\core\classes\Fabricator\DB\FabricateDate;
use spoova\mi\core\classes\Fabricator\FabricateEmail;
use spoova\mi\core\classes\Fabricator\FabricateName;
use spoova\mi\core\classes\Fabricator\Fabricator;

/**
 * Database class for seeding and unseeding database
 */
class DBSeeder{ 

    private DBHandler $conn;
    private static array $properties = [];
    private static int $seeds_count = 0;
    private static array $seeds = [];
    private static array $unseeds = [];
    private static array $data = [];
    /** Target DBSeed subclass whose seed_* overrides should be honoured, if any. */
    private static ?string $seeder = null;


    /**
     * Initializes and resolves selected database table's column names.
     *
     * @param DBHandler $conn
     * @param string $table
     */
    public function __construct(DBHandler $conn, private string $table) {

        $this->conn =  $conn;
        $this->table = $table;

        $props = $this->properties();

        $columns = [];

        foreach($props as $i => $prop) {

            if(!isset($columns[$props[$i]['COLUMN_NAME']])){
                $columns[$props[$i]['COLUMN_NAME']] = [];
            }
            foreach($prop as $key => $val){
                if($key !== 'COLUMN_NAME'){
                    $columns[$props[$i]['COLUMN_NAME']][$key] = $val;
                }
            }

        }
        
        self::$properties = $columns;

    }

    /**
     * References the selected database table fields (or columns).
     *
     * @return void
     */
    public static function fields(){
      return self::$properties;
    }

    /**
     * Registers the seeder class whose seed_* overrides should be honoured when
     * fabricating values. Ignored unless the class exists and extends DBSeed, so
     * it is safe to call with a not-yet-created class (first generation).
     *
     * @param string|null $class fully-qualified DBSeed subclass name
     * @return void
     */
    public static function useSeeder(?string $class) : void {
      self::$seeder = ($class && is_subclass_of($class, DBSeed::class)) ? $class : null;
    }
    
    /**
     * Generates the seeder file with a specified amount of seeds
     *
     * @param integer $count
     * @return array
     */
    public static function seed(int $count) : array{
        $columns = self::$properties;
        self::$seeds_count = 0;
        for($i = 0; $i < $count; $i++){
          self::$seeds_count = $i;
          Fabricator::count($count);
          $seed = [];
          foreach ($columns as $column => $info){
              $seeded = self::process($column, $info, $set, $i);
              if($seeded !== false){
                /** @var bool $set */
                if($set){
                  $seed[$column] = $seeded;
                  self::$data[$column][] = $seeded;
                }
              }
          }
          self::$seeds[$i] = $seed;
        }
        
        $seeds = (self::$seeds);
        Fabricator::reset();
        return $seeds;
    }
    
    private static function process(string $column, array $info, ?bool &$set = false, ?int $i = null) : mixed {

      $inc  = $info['EXTRA'] ?? '';
      $type = strtolower(trim((string) ($info['DATA_TYPE'] ?? '')));
      $size = $info['CHARACTER_MAXIMUM_LENGTH'] ?? null;

      // Columns the database fills itself (auto_increment / generated) are skipped.
      $set = ($inc) ? false : true;
      if(!$set) return false;

      $col = strtolower($column);

      if(in_array($col, ['firstname','fname','lastname','lname'])) {
        return FabricateName::fabricate('firstname');
      }elseif(in_array($col, ['email','usermail','umail','mail'])){
        $email = null;
        self::refine($email, $column, $info, fn() => FabricateEmail::fabricate(domain: ['dummy.com','test.com','example.com']));

        return $email;
      }elseif(in_array($col, ['cookie','hash','secret','secret_key','hashkey','keyhash'])){
        return base_encode(randice(20));
      }elseif(in_array($col,['pass','passkey','password'])){
        $pass = randice(10);
        return ($size !== null) ? substr($pass, 0, (int) $size) : $pass;
      }elseif(strpos($col, 'date') !== false){
        return FabricateDate::fabricate();
      }

      // Tiers 2 & 3 (the default seed_* handlers) live on DBSeed so that seeder
      // subclasses inherit them, get IDE support, and can override any of them.
      // Dispatch through the target seeder class when one is known so its
      // overrides win; otherwise fall back to DBSeed's defaults.
      $resolver = (self::$seeder && is_subclass_of(self::$seeder, DBSeed::class)) ? self::$seeder : DBSeed::class;

      return $resolver::fabricate($type, $info);
    }

    private static function refine(mixed &$value, string $column, array $info, callable $callback){
      $value = $callback();
      if(isset(self::$data[$column]) && in_array($value, self::$data[$column])){
       if($info['COLUMN_KEY'] === 'UNI'){
         $value = self::refine(...func_get_args());
       }
      }
      return $value;
    }

    public function properties() {

        $db = $this->conn; 
        $database = $db->currentDB();
        $table = $this->table;

        $sql = "SELECT COLUMN_NAME, COLUMN_TYPE, COLUMN_KEY, DATA_TYPE, CHARACTER_MAXIMUM_LENGTH, 
        COLUMN_DEFAULT, IS_NULLABlE, EXTRA FROM INFORMATION_SCHEMA.COLUMNS 
        WHERE TABLE_SCHEMA = '$database' AND TABLE_NAME = '$table'"; 
        $db->query($sql)->read();
        return $db->results();
    }

    /**
     * Build information relative to seeder associate files.
     *
     * @return array
     */
    public static function pathInfo() : array {
      return [
        'directory' => docroot.'/db/seeders',
        'namespace' => scheme("db\seeders\\", false)
      ];
    }
 
    /**
     * Returns array list of seeder filenames and their corresponding namespaces as values.
     *
     * @return void
     */
    public static function seeders(){

      [$directory, $namespace] = self::pathInfo();

      $Filemanager = new Filemanager;
      $Filemanager->setUrl($directory);
      $files = $Filemanager->getFiles(false, false);

      $seeders = $files;

      $seeds = [];

      foreach ($seeders as $seeder){

        $seeder = pathinfo($seeder, PATHINFO_FILENAME);
        $seederClass = $namespace.'\\'.$seeder;

        $seeds[$seeder] = $seederClass;

      }

      return $seeds;
    }

}