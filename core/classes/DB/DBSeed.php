<?php

namespace spoova\mi\core\classes\DB;

use spoova\mi\core\classes\Fabricator\DB\FabricateBinary;
use spoova\mi\core\classes\Fabricator\DB\FabricateInt;
use spoova\mi\core\classes\Fabricator\DB\FabricateTimestamp;
use spoova\mi\core\classes\Fabricator\DB\FabricateDate;
use spoova\mi\core\classes\Fabricator\FabricateText;

/**
 * Base class for database seeders.
 *
 * A seeder file (e.g. db/seeders/seed_users.php) extends this class and must
 * declare {@see DBSeed::seeds()} and {@see DBSeed::table()}.
 *
 * The seed_* methods below define the DEFAULT value fabricated for each SQL
 * column type. They are inherited by every seeder, so an IDE lists them and a
 * seeder can override any one of them to customise how a type is generated:
 *
 *     protected static function seed_varchar(array $info) : string {
 *         return 'my custom value';
 *     }
 *
 * Overrides are honoured during seed generation whenever the seeder class is
 * loadable at that time (see {@see DBSeeder}).
 */
abstract class DBSeed {

    abstract static function seeds(): array;

    abstract static function table(): string;

    /**
     * Resolves a fabricated value for a column, honouring subclass overrides.
     *
     * Tier 2: an exact seed_<DATA_TYPE>() handler (lets a seeder add support for
     *         any custom/arbitrary type by simply defining the method).
     * Tier 3: {@see DBSeed::fabricateByType()} groups related types onto a handler.
     *
     * Uses static:: throughout so a seeder subclass that overrides a seed_*
     * method (or adds a new one) takes precedence over these defaults.
     *
     * @param string $type lower-cased DATA_TYPE
     * @param array  $info full column information row
     * @return mixed
     */
    public static function fabricate(string $type, array $info) : mixed {
      if(method_exists(static::class, 'seed_'.$type)){
        return static::{'seed_'.$type}($info);
      }
      return static::fabricateByType($type, $info);
    }

    /**
     * Fabricates a value from the column's SQL type family when no dedicated
     * seed_<type>() handler matches the exact DATA_TYPE.
     *
     * MySQL's INFORMATION_SCHEMA.DATA_TYPE reports names that don't map 1:1 to
     * the handlers below (e.g. "int" has no seed_int, "longtext" is
     * seed_long_text), so related types are grouped here and routed to a
     * Fabricator-backed handler. Only a genuinely unknown type falls through to
     * seed_none() (an empty value). Uses static:: so subclass overrides win.
     *
     * @param string $type lower-cased DATA_TYPE
     * @param array  $info full column information row
     * @return mixed
     */
    protected static function fabricateByType(string $type, array $info) : mixed {

      // tinyint(1) is conventionally a boolean flag.
      if(strtolower((string) ($info['COLUMN_TYPE'] ?? '')) === 'tinyint(1)'){
        return static::seed_bool();
      }

      return match(true){
        in_array($type, ['int','integer','tinyint','smallint','mediumint','bigint'], true)
                                                          => static::seed_integer($info),
        in_array($type, ['float','double','double precision','real'], true)
                                                          => static::seed_float($info),
        in_array($type, ['decimal','dec','numeric','fixed'], true)
                                                          => static::seed_decimal($info),
        $type === 'year'                                  => static::seed_year($info),
        $type === 'bit'                                   => static::seed_bit(),
        $type === 'date'                                  => static::seed_date($info),
        in_array($type, ['datetime','timestamp'], true)   => static::seed_datetime($info),
        $type === 'time'                                  => static::seed_time($info),
        $type === 'enum'                                  => static::seed_enum($info),
        $type === 'set'                                   => static::seed_set($info),
        in_array($type, ['binary','varbinary','blob','tinyblob','mediumblob','longblob'], true)
                                                          => static::seed_binary($info),
        $type === 'tinytext'                              => static::seed_tiny_text($info),
        in_array($type, ['mediumtext','longtext'], true)  => static::seed_long_text($info),
        $type === 'text'                                  => static::seed_text($info),
        in_array($type, ['char','varchar','string'], true)
                                                          => static::seed_varchar($info),
        $type === 'json'                                  => json_encode(['seed' => FabricateInt::fabricate(4)]),
        default                                           => static::seed_none(),
      };
    }

    protected static function seed_integer(array $info = []) : int {
        return FabricateInt::fabricate(4);
    }
    protected static function seed_binary(array $info = []) : string {
        $length = $info['CHARACTER_MAXIMUM_LENGTH'] ?? 10;
        return FabricateBinary::fabricate($length);
    }
    protected static function seed_float(array $info = []) : float {
        return (float) mt_rand(100, 10000) / mt_rand(1, 100);
    }
    protected static function seed_decimal(array $info = []) : string {
        return (string) ((mt_rand(100, 10000) / mt_rand(1, 100)));
    }
    protected static function seed_time(array $info = []) : string {
        $hour = str_pad(mt_rand(0, 23), 2, '0', STR_PAD_LEFT);
        $minute = str_pad(mt_rand(0, 59), 2, '0', STR_PAD_LEFT);
        $second = str_pad(mt_rand(0, 59), 2, '0', STR_PAD_LEFT);
        return $hour . ':' . $minute . ':' . $second;
    }
    protected static function seed_date(array $info = []) : string {
        return FabricateDate::fabricate();
    }
    protected static function seed_datetime(array $info = []) : string {
        return FabricateTimestamp::fabricate();
    }
    protected static function seed_timestamp(array $info = []) : string {
        return FabricateTimestamp::fabricate();
    }
    protected static function seed_year(array $info = []) : int {
        return mt_rand(date('Y') - 10, date('Y'));
    }
    protected static function seed_bool() : int {
        $bools = [0, 1];
        return $bools[array_rand($bools)];
    }
    protected static function seed_bit(){
      $bools = [1, 0];
      return $bools[array_rand($bools)];
    }
    protected static function seed_varchar(array $info){
      $length = $info['CHARACTER_MAXIMUM_LENGTH'] ?? null;
      $chars = mt_rand(20, 255);
      return substr(FabricateText::fabricate($chars.'|Phrase'), 0, $length);
    }
    protected static function seed_char(array $info){
      $length = $info['CHARACTER_MAXIMUM_LENGTH'] ?? null;
      return substr(FabricateText::fabricate('200|Sentence'), 0, $length);
    }
    protected static function seed_text(array $info) : string {
      return FabricateText::fabricate('200|Phrase');
    }
    protected static function seed_tiny_text(array $info) : string {
      return FabricateText::fabricate('150|Lorem');
    }
    protected static function seed_long_text(array $info) : string {
        return FabricateText::fabricate('500|Lorem');
    }
    protected static function seed_enum(array $info){
      $type = str_replace("'","",substr($info['COLUMN_TYPE'], strlen($info['DATA_TYPE']), -2));
      $options = explode(',', $type);
      return $options[array_rand($options)];
    }
    protected static function seed_set(array $info){
      $type = str_replace("'","",substr($info['COLUMN_TYPE'], strlen($info['DATA_TYPE']), -2));
      $options = explode(',', $type);
      return $options[array_rand($options)];
    }
    protected static function seed_none(){
      return '';
    }

}
