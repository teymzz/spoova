<?php 

namespace spoova\core\classes\DB\DBSchema;

use Closure;
use spoova\core\commands\Cli;

trait TBALTER {

    use TBGROUP;

    public static array $ALTER = [];

    /**
     * Drops a table, column, indexes or primary key 
     *
     * @param string $name 
     *  - if $name is bool(true), the current table will be dropped
     *  - if $name is string, the current table's column $name will be dropped
     *  - if $name is "PRIMARY KEY", the current table's primary key index will be dropped
     * @param string $identifier
     *  - $identifier must be a foreign key (or index identifer) name
     *  - if $identifier is supplied, then first argument option ranges are: ["INDEX"|"UNIQUE"|"FORIEGN KEY"|"PRIMARY KEY"]
     * @return void|false
     */
    static function DROP(string|bool $name, string $identifier = ''){

        self::callables(__FUNCTION__);

        $argsCount = func_num_args();

        if($argsCount > 2) {
                Cli::textView(Cli::error('invalid number of arguments count on "'.Cli::warn('DRAFT::DROP()').'" method'));
                return self::callError(Cli::error('invalid number of arguments count on "'.Cli::warn('DRAFT::DROP()').'" method'));                
        }

        if(strtoupper($name) === 'PRIMARY KEY'){
            $argsCount = 2;
        }


        if($argsCount < 2){

            if($name === true){
                self::$ALTER['DROP']['TABLE'][] = $name;
            }elseif(is_string($name)){

                if(trim($name)){
                    self::$ALTER['DROP']['COLUMN'][] = $name;
                }else{
                    Cli::textView(Cli::error('argument(#1) of "'.Cli::warn('DROP()').'" cannot be an empty value"'));
                    return self::callError(Cli::error('argument(#1) of "'.Cli::warn('DROP()').'" cannot be an empty value"'));
                }

            }

        }else{

            $indexOptions = ['PRIMARY KEY', 'INDEX', 'FOREIGN KEY'];

            if(!in_array($name, $indexOptions)){
                Cli::textView(Cli::error('invalid index type suppied on argument(#1) of "'.Cli::warn('DROP()')));
                return self::callError(Cli::error('invalid index type suppied on argument(#1) of "'.Cli::warn('DROP()')));
            }

            if(trim($identifier)){

                self::$ALTER['DROP']['INDEX'][] = [$name => $identifier];

            }else{
                Cli::textView(Cli::error('argument(#2) of "'.Cli::warn('DROP()').'" cannot be an empty value"'));
                return self::callError(Cli::error('argument(#2) of "'.Cli::warn('DROP()').'" cannot be an empty value"'));
            }

        }

    }

    /**
     * Drop a database table
     *
     * @return void|false
     */
    static function DROP_TABLE(){
        return self::DROP(true);
    }

    /**
     * Rename the current table name to a new supplied name
     *
     * @param string $newName
     * @return void
     */
    static function RENAME_TO(string $newName){
        self::callables(__FUNCTION__);
        self::$ALTER['RENAME_TO'] = $newName;
    }

    /**
     * Convert table to a new character set (e.g latin1)
     *
     * @param string $character
     * @return void
     */
    static function CONVERT_TO(string $character){
        self::callables(__FUNCTION__);
        self::$ALTER['CONVERT_TO'] = $character;
    }

    /**
     * Modify a table
     *
     * @param Closure $callback
     * @return DRAFT
     */
    static function MODIFY(Closure $callback){ 
        self::callables(__FUNCTION__);
        
        $DRAFT = $callback();

        unset(self::$TYPE[1]);

        if($DRAFT instanceof DRAFT){

            return $DRAFT;

        } else {

            Cli::textView(Cli::error("the ".Cli::warn('"MODIFIER()"')." method must be return a draft object."));
            return self::callError(Cli::error("the ".Cli::warn('"MODIFIER()"')." method must be return a draft object."));             

        }

        return self::$instance;
    }
    
    /**
     * Change old field to new field
     *
     * @param Closure $callback
     * @return DRAFT|false
     */
    static function CHANGE(Closure $callback){

        self::callables(__FUNCTION__);
        
        $DRAFT = $callback();

        unset(self::$TYPE[1]);

        if($DRAFT instanceof DRAFT){

            return $DRAFT;

        } else {

            Cli::textView(Cli::error("the ".Cli::warn('"CHANGE()"')." method must be return a draft object."));
            return self::callError(Cli::error("the ".Cli::warn('"CHANGE()"')." method must be return a draft object."));       

        }
            
    }

    /**
     * Add a field to the beginning of a table's list of fields
     *
     * @return DRAFT
     */
    public function FIRST() : DRAFT {
        self::callables(__FUNCTION__);     
        self::$ALTER['TABLE']['FIELDS'][self::$field]  .= " FIRST";
        return self::$instance;
    }

    /**
     * Add a new field after another field
     *
     * @param string $fieldName
     * @return DRAFT
     */
    public function AFTER(string $fieldName) : DRAFT{
        self::callables(__FUNCTION__); 
        self::$ALTER['TABLE']['FIELDS'][self::$field]  .= " AFTER {$fieldName}";
        return self::$instance;
    }

    protected static function BUILD_ALTER(string $TABLE){
        
        #add a new field
        $DRAFT = '';
        $ALTER = (static::$ALTER);

        //add items
        $Table = $ALTER['TABLE'] ?? [];
        $ADD = $Table['FIELDS'] ?? [];

        //include drop statement
        $DROPS = $ALTER['DROP'] ?? []; //GLOBAL SCOPE
        $MODIFIES = $Table['MODIFY'] ?? []; //TABLE SCOPE
        $CHANGES = $Table['CHANGE'] ?? []; //TABLE SCOPE

        if($ADD){
            //$DRAFT .= "ALTER TABLE {$TABLE}"; //Base Query

            $FIELDS = array_map(function($value, $key){

                return "ADD `".$key."` ".$value;

            }, $Table['FIELDS'], array_keys($Table['FIELDS']) );

            $DRAFT .= implode(', ', $FIELDS);
        }

        if($MODIFIES){
            $MODIFY = array_map(function($value, $key){ 

                return "MODIFY `".$key."` ".$value;

            }, $Table['MODIFY'], array_keys($Table['MODIFY']) );

            $DRAFT .= implode(', ', $MODIFY);
        }

        if($CHANGES){
            $CHANGE = array_map(function($value, $key){

                return "CHANGE `".$key."` ".$value;

            }, $Table['CHANGE'], array_keys($Table['CHANGE']) );

            $DRAFT .= implode(', ', $CHANGE);
        }

        if($DROPS){

            $FIELDS = array_map(function($value, $key) use(&$DRAFT){

                $DROP = array_map(function($val, $inkey)use($key){

                        if(is_array($val)){
                            $key = array_keys($val)[0]?? '';
                            $rel = array_values($val)[0]?? '';
                            $value = $key." ".$rel;
                        }else{
                            if($key === 'COLUMN'){
                                $value = "COLUMN {$val}";
                            }else{

                                $value = $val;
                            }
                        }
                        return "DROP $value";

                }, $value, array_keys($value)); 

                $DRAFT .= implode(', ', $DROP);

            }, $DROPS, array_keys($DROPS));

        }
        

        $PRIMARY_KEY = (array) ($Table['::PRIMARY_KEY'] ?? []);
        $FOREIGN_KEY = $Table['::FOREIGN_KEY'] ?? [];

        $PRIMARY_KEY = implode(', ',$PRIMARY_KEY);

        $uniqueFields = self::$instance->uniqueFields;

        $constraints =  self::$instance->constraints;

        // //add unique fields 
        if($UNIQUES = ($constraints['UNIQUE']??'')){
            foreach($UNIQUES as $UNIQUE => $UNIQUEVALUES){
               $DRAFT .= ", CONSTRAINT {$UNIQUE} UNIQUE(".implode(', ', $UNIQUEVALUES).")";
            }
        }

        // // //handle foreign keys
        foreach($FOREIGN_KEY as $foreignKey => $foreign) {

            $statement = '';
            if(array_key_exists("::OPTIONS", $foreign)){
                $OPTIONS = $foreign['::OPTIONS'];
                $cascade = $OPTIONS[0]?? '';
                $restrict = $OPTIONS[1]?? '';
                $statement .= ($cascade)? " ON UPDATE CASCADE" : "";
                $statement .= ($restrict)? " ON DELETE RESTRICT" : "";

                unset($foreign['::OPTIONS']);
            }

            $REFERENCES[] = array_map(function($value, $index) use(&$CASCADE, $statement) {

                    $keys = array_keys($value); 
                    $values = array_values($value);
                    $foreigns = implode(',',$keys);
                    $locals = implode(',',$values);
                    return ", ADD FOREIGN KEY({$foreigns}) REFERENCES $index({$locals}){$statement}"; 
                
            }, $foreign, array_keys($foreign));

        }

        $STATEMENT = '';
        foreach($REFERENCES as $REFERENCE){

            $STATEMENT .= ($REFERENCE)? ", ".implode(",", $REFERENCE) : '';

        }

        $REFERENCES = $STATEMENT;
        
        $PRIMARY = ($PRIMARY_KEY)? ", PRIMARY KEY({$PRIMARY_KEY})" : "";

        $DRAFT .= $PRIMARY;

        if($rename = (self::$ALTER['RENAME_TO'] ?? '')){
            $DRAFT .= ", RENAME TO ".$rename;
        }

        if($convert = (self::$ALTER['CONVERT_TO'] ?? '')){
            $DRAFT .= ", CONVERT TO CHARACTER SET ".$rename;
        }

        $DRAFT = ltrim($DRAFT, ',');

        $DRAFT = trim("ALTER TABLE {$TABLE} {$DRAFT}");
        return $DRAFT;

    }

}