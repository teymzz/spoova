<?php 

namespace spoova\core\classes\DB\DBSchema;

use spoova\core\commands\Cli;

trait TBCREATE {

    use TBALTER, TBGROUP;

    public static array $CREATE = [];

    
    /**
     * This creates an auto increment primary key field. The defualt field name is 
     * "id" if not supplied.
     *
     * @param int $size 
     *   - zero(0) will use the default auto increment int size 11
     *   - Value Range: 1 - 255
     * @param string $name primary field name. Default is "id"
     * @return DRAFT
     */
    public static function ID(int $size = 0, string $name = 'id') : DRAFT {
        self::callables(__FUNCTION__);
        self::field($name, "int");

        self::$CREATE['TABLE']['FIELDS'][$name] = "INT".($size? "({$size})" : '')." NOT NULL AUTO_INCREMENT";
        //self::$CREATE['TABLES'][$name] =  "INT".($size? "({$size})" : '')." NOT NULL AUTO_INCREMENT";
        self::$CREATE['TABLE']['::PRIMARY_KEY'] = "{$name}";        
        // self::$formats[$name] = "INT".($size? "({$size})" : '')." NOT NULL AUTO_INCREMENT";
        // self::$formats['::PRIMARY_KEY'] = "{$name}";
        return self::$instance;
    }
    
    /**
     * Creates a bit field
     *
     * @param array|string $name name of the field
     * @return DRAFT
     */
    public static function BIT(array|string $name) : DRAFT {
        self::callables(__FUNCTION__);
        self::assent_mode(['ALTER','CREATE'], __FUNCTION__, $name);

        if(is_array($name)){
             $namee = array_keys($name)[0]; //old name
             $value = array_values($name)[0]." "; //new name
             $name = $namee;
        }
        setVar($value);

        self::field($name, 'bit');

        $TYPE = self::$TYPE[0] ?? ''; //CREATE or ALTER
        $MODE = self::$TYPE[1] ?? ''; //MODIFY, CHANGE or FIELDS OR FIELDS

        if($TYPE === 'ALTER') {

            if($MODE === 'MODIFY'){     
                self::$ALTER['TABLE']['MODIFY'][$name] =  "BIT";      
            }elseif($MODE === 'CHANGE'){
                self::$ALTER['TABLE']['CHANGE'][$name] =  ($value? "`{$value}` " :"")."BIT";     
            }else{
                self::$ALTER['TABLE']['FIELDS'][$name] =  "BIT";    
            }

        }else{

            self::$CREATE['TABLE']['FIELDS'][$name] = "BIT";
        }

        return self::$instance;
    }
    
    /**
     * Creates a binary field
     *
     * @param array|string $name name of field
     * @param string $default default value
     * @return DRAFT
     */
    public static function BINARY(array|string $name, int $default = 0) : DRAFT {
        self::callables(__FUNCTION__);
        self::assent_mode(['ALTER','CREATE'], __FUNCTION__, $name);

        $TYPE = self::$TYPE[0] ?? ''; //CREATE or ALTER
        $MODE = self::$TYPE[1] ?? ''; //MODIFY, CHANGE or FIELDS

        if(is_array($name)){
             $namee = array_keys($name)[0];
             $value = array_values($name)[0]." ";
             $name = $namee;
        }
        setVar($value);

        self::field($name, 'binary');
        
        if($TYPE === 'ALTER') {

            if($MODE === 'MODIFY'){     
                self::$ALTER['TABLE']['MODIFY'][$name] =  "BINARY";      
            }elseif($MODE === 'CHANGE'){
                self::$ALTER['TABLE']['CHANGE'][$name] =  ($value? "`{$value}` " :"")."BINARY"; 
            }else{
                self::$ALTER['TABLE']['FIELDS'][$name] =  "BINARY"; 
            }

        }else{
            self::$CREATE['TABLE']['FIELDS'][$name] = "BINARY";
        }
        
        if(trim($default)){
            self::$$TYPE['TABLE'][$MODE][$name] .= " DEFAULT ".self::format_default($default);
        }

        return self::$instance;
    }
    
    /**
     * Creates a BOOL Field
     *
     * @param array|string $name
     * @param int $default - zero(0) will not be applied
     * @return DRAFT
     */
    public static function BOOL(array|string $name, int $default = 0) : DRAFT {
        self::callables(__FUNCTION__);
        self::assent_mode(['ALTER','CREATE'], __FUNCTION__, $name);

        if(is_array($name)){
             $namee = array_keys($name)[0];
             $value = array_values($name)[0]." ";
             $name = $namee;
        }
        setVar($value);

        self::field($name, 'bool');
        
        $TYPE = self::$TYPE[0] ?? ''; //CREATE or ALTER
        $MODE = self::$TYPE[1] ?? ''; //MODIFY, CHANGE or FIELDS

        if($TYPE === 'ALTER') {

            if($MODE === 'MODIFY'){     
                self::$ALTER['TABLE']['MODIFY'][$name] =  "BOOL";      
            }elseif($MODE === 'CHANGE'){
                self::$ALTER['TABLE']['CHANGE'][$name] =  ($value? "`{$value}` " :"")."BOOL";     
            }else{
                self::$ALTER['TABLE']['FIELDS'][$name] =  "BOOL";
            }

        }else{
            self::$CREATE['TABLE']['FIELDS'][$name] = "BOOL";
        }
        
        
        if(trim($default)){
            self::$$TYPE['TABLE'][$MODE][$name] .= " DEFAULT {$default}";
        }

        return self::$instance;
    }
    
    /**
     * Create a JSON Field
     *
     * @param array|string $name
     * @return DRAFT
     */
    public static function JSON(array|string $name) : DRAFT {
        self::callables(__FUNCTION__);
        self::assent_mode(['ALTER','CREATE'], __FUNCTION__, $name);

        if(is_array($name)){
             $namee = array_keys($name)[0];
             $value = array_values($name)[0]." ";
             $name = $namee;
        }
        setVar($value);

        self::field($name, 'json');
        
        $TYPE = self::$TYPE[0] ?? ''; //CREATE or ALTER
        $MODE = self::$TYPE[1] ?? ''; //MODIFY, CHANGE or FIELDS

        if($TYPE === 'ALTER') {

            if($MODE === 'MODIFY'){     
                self::$ALTER['TABLE']['MODIFY'][$name] =  "JSON";      
            }elseif($MODE === 'CHANGE'){
                self::$ALTER['TABLE']['CHANGE'][$name] =  ($value? "`{$value}` " :"")."JSON";      
            }else{
                self::$ALTER['TABLE']['FIELDS'][$name] =  "JSON";  
            }

        }else{
            self::$CREATE['TABLE']['FIELDS'][$name] = "JSON";
        }

        return self::$instance;
    }
    
    /**
     * Creates a varchar field
     *
     * @param array|string $name
     * @param int $size
     * @param string $default
     * @return DRAFT
     */
    public static function VARCHAR(array|string $name, int $size = 30, string $default = '') : DRAFT {
        self::callables(__FUNCTION__);
        self::assent_mode(['ALTER','CREATE'], __FUNCTION__, $name);

        if(is_array($name)){
             $namee = array_keys($name)[0];
             $value = array_values($name)[0]." ";
             $name = $namee;
        }
        setVar($value);

        self::field($name, 'varchar');
        
        $TYPE = self::$TYPE[0] ?? ''; //CREATE or ALTER
        $MODE = self::$TYPE[1] ?? ''; //MODIFY, CHANGE or FIELDS

        if($TYPE === 'ALTER') {
            if($MODE === 'MODIFY'){    
                self::$ALTER['TABLE']['MODIFY'][$name] = "VARCHAR({$size})";
            }elseif($MODE === 'CHANGE'){
                self::$ALTER['TABLE']['CHANGE'][$name] = ($value? "`{$value}` " :"")."VARCHAR({$size})"; 
            }else{
                self::$ALTER['TABLE']['FIELDS'][$name] = "VARCHAR({$size})";
            }

        }else{

            self::$CREATE['TABLE']['FIELDS'][$name] = "VARCHAR({$size})";
            
        }
        
        if(trim($default)){
            self::$$TYPE['TABLE'][$MODE][$name] .= " DEFAULT ".self::format_default($default);
        }

        return self::$instance;
    }

    /**
     * Set CHAR fields
     *
     * @param array|string $name
     * @param integer $size
     * @param string $default
     * @return DRAFT
     */
    public static function CHAR(array|string $name, int $size = 30, string $default = '') : DRAFT {
        self::callables(__FUNCTION__);

        if(self::assent_mode(['ALTER','CREATE'], __FUNCTION__, $name)){
            if(is_array($name)){
                $namee = array_keys($name)[0];
                $value = array_values($name)[0]." ";
                $name = $namee;
            }
            setVar($value);

            self::field($name, 'char');
            
            $TYPE = self::$TYPE[0] ?? ''; //CREATE or ALTER
            $MODE = self::$TYPE[1] ?? ''; //MODIFY, CHANGE or FIELDS

            if($TYPE === 'ALTER') {

                if($MODE === 'MODIFY'){        
                    self::$ALTER['TABLE']['MODIFY'][$name] = "CHAR({$size})";
                }elseif($MODE === 'CHANGE'){
                    self::$ALTER['TABLE']['CHANGE'][$name] = ($value? "`{$value}` " :"")."CHAR({$size})";   
                }else{
                    self::$ALTER['TABLE']['FIELDS'][$name] = "CHAR({$size})"; 
                }

            }else{

                self::$CREATE['TABLE']['FIELDS'][$name] = "CHAR({$size})";

            }
            
            if(trim($default)){
                self::$$TYPE['TABLE'][$MODE][$name] .= " DEFAULT ".self::format_default($default);
            }
        }


        return self::$instance;
    }

    /**
     * Set ENUM fields
     *
     * @param array|string $name
     * @param array $options
     * @param string $default
     * @return DRAFT
     */
    public static function ENUM(array|string $name, array $options, string $default = '') : DRAFT {
        self::callables(__FUNCTION__);

        if(self::assent_mode(['ALTER','CREATE'], __FUNCTION__, $name)){
            if(is_array($name)){
                $namee = array_keys($name)[0];
                $value = array_values($name)[0]." ";
                $name = $namee;
            }
            setVar($value);

            self::field($name, 'enum');
            
            $TYPE = self::$TYPE[0] ?? ''; //CREATE or ALTER
            $MODE = self::$TYPE[1] ?? ''; //MODIFY, CHANGE or FIELDS

            $options = implode(',', $options);

            if($TYPE === 'ALTER') {

                if($MODE === 'MODIFY'){        
                    self::$ALTER['TABLE']['MODIFY'][$name] = "ENUM({$options})";
                }elseif($MODE === 'CHANGE'){
                    self::$ALTER['TABLE']['CHANGE'][$name] = ($value? "`{$value}` " :"")."ENUM({$options})";   
                }else{
                    self::$ALTER['TABLE']['FIELDS'][$name] = "ENUM({$options})"; 
                }

            }else{

                self::$CREATE['TABLE']['FIELDS'][$name] = "ENUM({$options})";

            }
            
            if(trim($default)){
                self::$$TYPE['TABLE'][$MODE][$name] .= " DEFAULT {$default}";
            }
        }


        return self::$instance;
    }

    /**
     * Sets TEXT fields
     *
     * @param array|string $name name of the field
     * @param integer $size size of the text field
     * @param string $default default value of the text field
     * @return DRAFT
     */
    public static function TEXT(array|string $name, int $size, string $default = '') : DRAFT{
        self::callables(__FUNCTION__);

        if(self::assent_mode(['ALTER','CREATE'], __FUNCTION__, $name)){
            if(is_array($name)){
                $namee = array_keys($name)[0];
                $value = array_values($name)[0]." ";
                $name = $namee;
            }
            setVar($value);

            self::field($name, 'text');
            
            $TYPE = self::$TYPE[0] ?? ''; //CREATE or ALTER
            $MODE = self::$TYPE[1] ?? ''; //MODIFY, CHANGE or FIELDS

            if($TYPE === 'ALTER') {

                if($MODE === 'MODIFY'){        
                    self::$ALTER['TABLE']['MODIFY'][$name] = "TEXT({$size})";
                }elseif($MODE === 'CHANGE'){
                    self::$ALTER['TABLE']['CHANGE'][$name] = ($value? "`{$value}` " :"")."TEXT({$size})";    
                }else{
                    self::$ALTER['TABLE']['FIELDS'][$name] = "TEXT({$size})"; 
                }

            }else{

                self::$CREATE['TABLE']['FIELDS'][$name] = "TEXT({$size})";

            }
            
            if(trim($default)){
                self::$$TYPE['TABLE'][$MODE][$name] .= " DEFAULT ".self::format_default($default);
            }
        }


        return self::$instance;
    }

    /**
     * Sets a text field with acceptable options
     *
     * @param string $type options [TEXT|TINY|MEDIUM|LONG]
     * @param array|string $name
     * @param int $size size of the text field
     * @param string $default the default value of the text field
     * @return DRAFT
     */
    public static function TEXTFIELD(string $type, array|string $name, int $size = 0, string $default = '') : DRAFT {        
        self::callables(__FUNCTION__);
        
        if(self::assent_mode(['ALTER','CREATE'], __FUNCTION__, $name)){
            $type = strtoupper($type);

            if(!array_key_exists($type, self::options('TEXT'))){
                Cli::textView(Cli::error("invalid option [{$type}] supplied for TEXTFIELD(".implode(', ', func_get_args()).")"), 2, "|2");
                return self::callError(Cli::error("invalid option [{$type}] supplied for TEXTFIELD(".implode(', ', func_get_args()).")"), 2, "|2");
            }else{
                $type = self::options('TEXT')[$type];
            }

            if(is_array($name)){
                $namee = array_keys($name)[0];
                $value = array_values($name)[0]." ";
                $name = $namee;
            }
            setVar($value);

            self::field($name, $type);
            
            $TYPE = self::$TYPE[0] ?? ''; //CREATE or ALTER
            $MODE = self::$TYPE[1] ?? ''; //MODIFY, CHANGE or FIELDS

            if($TYPE === 'ALTER') {

                if($MODE === 'MODIFY'){
                    self::$ALTER['TABLE']['MODIFY'][$name] = "$type".($size? '('.$size.')' : '');          
                }elseif($MODE === 'CHANGE'){
                    self::$ALTER['TABLE']['CHANGE'][$name] = ($value? "`{$value}` " :"")."$type".($size? '('.$size.')' : '');   
                }else{
                    self::$ALTER['TABLE']['FIELDS'][$name] = "$type".($size? '('.$size.')' : '');   
                }

            }else{

                self::$CREATE['TABLE']['FIELDS'][$name] = "$type".($size? '('.$size.')' : '');
                
            }
            
            if(trim($default)){
                self::$$TYPE['TABLE'][$MODE][$name] .= " DEFAULT ".self::format_default($default);
            }            
        }



        return self::$instance;
    }

    /**
     * Sets the integer field
     *
     * @param array|string $name name of the integer field
     * @param integer $size size of the field
     * @param string $default the default value of the text field
     * @return DRAFT
     */
    public static function INT(array|string $name, int $size = 2, int $default = null) : DRAFT {        
        self::callables(__FUNCTION__);
        
        if(self::assent_mode(['ALTER','CREATE'], __FUNCTION__, $name)){
            
            if(is_array($name)){
                $namee = array_keys($name)[0];
                $value = array_values($name)[0]." ";
                $name = $namee;
            }
            setVar($value);
    
            self::field($name, 'int');
            
            $TYPE = self::$TYPE[0] ?? ''; //CREATE or ALTER
            $MODE = self::$TYPE[1] ?? ''; //MODIFY, CHANGE or FIELDS
    
            if($TYPE === 'ALTER') {
    
                if($MODE === 'MODIFY'){        
                    self::$ALTER['TABLE']['MODIFY'][$name] = "INT({$size})";
                }elseif($MODE === 'CHANGE'){
                    self::$ALTER['TABLE']['CHANGE'][$name] =  ($value? "`{$value}` " :"")."INT({$size})";     
                }else{
                    self::$ALTER['TABLE']['FIELDS'][$name] =  "INT({$size})";
                }
    
            }else{
    
                self::$CREATE['TABLE']['FIELDS'][$name] = "INT({$size})";
                
            }
            
            if(is_int($default)){
                self::$$TYPE['TABLE'][$MODE][$name] .= " DEFAULT {$default}";
            }

        }

        return self::$instance;
    }

    /**
     * Sets the integer fields
     *
     * @param string $type the type of the integer field [INT|TINY|SMALL|BIG]
     * @param array|string $name the name of the int field
     * @param integer $size the size of the int field
     * @param string $default the default value of the integer field
     * @return DRAFT
     */
    public static function INTFIELD(string $type, array|string $name, int $size = 0, string $default = '') : DRAFT {        
        self::callables(__FUNCTION__);

        if(self::assent_mode(['ALTER','CREATE'], __FUNCTION__, $name)){

            $type = strtoupper($type);
            if(!array_key_exists($type, self::options('INT'))){
                Cli::textView(Cli::error("invalid option [{$type}] supplied for INTFIELD(".implode(', ', func_get_args()).")"), 2, "|2");
                return self::callError(Cli::error("invalid option [{$type}] supplied for INTFIELD(".implode(', ', func_get_args()).")"), 2, "|2");
            }else{
                $type = self::options('INT')[$type];
            }
    
            if(is_array($name)){
                $namee = array_keys($name)[0];
                $value = array_values($name)[0]." ";
                $name = $namee;
            }     
            setVar($value);
            
            self::field($name, strtolower($type));
            
            $TYPE = self::$TYPE[0] ?? ''; //CREATE or ALTER
            $MODE = self::$TYPE[1] ?? ''; //MODIFY, CHANGE or FIELDS 
            
            if($TYPE === 'ALTER') {
    
                if($MODE === 'MODIFY'){
                    self::$ALTER['TABLE']['MODIFY'][$name] = "$type".($size? '('.$size.')' : '');          
                }elseif($MODE === 'CHANGE'){
                    self::$ALTER['TABLE']['CHANGE'][$name] = ($value? "`{$value}` " :"")."$type".($size? '('.$size.')' : '');   
                }else{
                    self::$ALTER['TABLE']['FIELDS'][$name] = "$type".($size? '('.$size.')' : '');   
                }
    
            }else{
    
                self::$CREATE['TABLE']['FIELDS'][$name] = "$type".($size? '('.$size.')' : '');
                
            }
            
            if(is_int($default)){
                self::$$TYPE['TABLE'][$MODE][$name] .= " DEFAULT ".self::format_default($default);
            }

        }

        return self::$instance;
    }

    /**
     * sets a serial field
     *
     * @param array|string $name the name of the field
     * @param integer $default the default value of the serial field
     * @return DRAFT
     */
    public static function SERIAL(array|string $name, int $default = 0) : DRAFT {        
        self::callables(__FUNCTION__);
        
        if(self::assent_mode(['ALTER','CREATE'], __FUNCTION__, $name)){
            
            if(is_array($name)){
                $namee = array_keys($name)[0];
                $value = array_values($name)[0]." ";
                $name = $namee;
            }
            setVar($value);
    
            self::field($name, 'serial');
            
            $TYPE = self::$TYPE[0] ?? ''; //CREATE or ALTER
            $MODE = self::$TYPE[1] ?? ''; //MODIFY, CHANGE or FIELDS
    
            if($TYPE === 'ALTER') {
    
                if($MODE === 'MODIFY'){     
                    self::$ALTER['TABLE']['MODIFY'][$name] =  "SERIAL";      
                }elseif($MODE === 'CHANGE'){
                    self::$ALTER['TABLE']['CHANGE'][$name] =  ($value? "`{$value}` " :"")."SERIAL";      
                }else{
                    self::$ALTER['TABLE']['FIELDS'][$name] =  "SERIAL";  
                }
    
            }else{
    
                self::$CREATE['TABLE'][$MODE][$name] = "SERIAL";
    
            }
            
            if(is_int($default)){
                self::$$TYPE['TABLE'][$MODE][$name] .= " DEFAULT ".self::format_default($default);
            }

        }

        return self::$instance;
    }


    /**
     * Set a float field
     *
     * @param array|string $name
     * @param array $size array(width, scale)
     *  - maximum: [255, 30]
     * @param integer|null $default
     * @return DRAFT
     */
    public static function FLOAT(array|string $name, array $size = [], int $default = null){        
        self::callables(__FUNCTION__);
        
        if(self::assent_mode(['ALTER','CREATE'], __FUNCTION__, $name)){
    
            if(is_array($name)){
                $namee = array_keys($name)[0];
                $value = array_values($name)[0]." ";
                $name = $namee;
            }
            setVar($value);
            
            self::field($name, 'float');
    
            $TYPE = self::$TYPE[0] ?? ''; // CREATE or ALTER
            $MODE = self::$TYPE[1] ?? ''; // MODIFY, CHANGE or FIELDS
            
            if(count($size) > 2){
                Cli::textView(Cli::error("invalid size count for FLOAT(size: [".implode(", ", $size)."])"), 0, "|2");
                return self::callError(Cli::error("invalid size count for FLOAT(size: [".implode(", ", $size)."])"), 0, "|2");
            }
    
            if($TYPE === 'ALTER') {
    
                if($MODE === 'MODIFY'){     
                    self::$ALTER['TABLE']['MODIFY'][$name] =  "FLOAT".($size? '('.implode(',', $size).')' : '');      
                }elseif($MODE === 'CHANGE'){
                    self::$ALTER['TABLE']['CHANGE'][$name] =  ($value? "`{$value}` " :"")."FLOAT".($size? '('.implode(',', $size).')' : '');      
                }else{
                    self::$ALTER['TABLE']['FIELDS'][$name] =  "FLOAT".($size? '('.implode(',', $size).')' : '');  
                }
    
            }else{
    
                self::$CREATE['TABLE'][$MODE][$name] = "FLOAT".($size? '('.implode(',', $size).')' : '');
    
            }
            
            if(is_int($default)){
                self::$$TYPE['TABLE'][$MODE][$name] .= " DEFAULT ".self::format_default($default);
            }

        }

        return self::$instance;
    }

    /**
     * Set a double field
     *
     * @param array|string $name
     * @param array $size array(width, scale)
     *  - maximum: [255, 30]
     * @param integer|null $default
     * @return DRAFT
     */
    public static function DOUBLE(array|string $name, array $size = [], int $default = null) : DRAFT{        
        self::callables(__FUNCTION__); 
        
        if(self::assent_mode(['ALTER','CREATE'], __FUNCTION__, $name)){
    
            if(is_array($name)){
                    $namee = array_keys($name)[0];
                    $value = array_values($name)[0]." ";
                    $name = $namee;
            }
            setVar($value);
    
            self::field($name, 'double');
    
            $TYPE = self::$TYPE[0] ?? ''; //CREATE or ALTER
            $MODE = self::$TYPE[1] ?? ''; //MODIFY, CHANGE or FIELDS
            
            if(count($size) > 2){
                Cli::textView(Cli::error("invalid size count for DOUBLE(size: [".implode(", ", $size)."])"), 0, "|2");
                return self::callError(Cli::error("invalid size count for DOUBLE(size: [".implode(", ", $size)."])"), 0, "|2");
            }
    
            if($TYPE === 'ALTER') {
                
                if($MODE === 'MODIFY'){     
                    self::$ALTER['TABLE']['MODIFY'][$name] =  "DOUBLE".($size? '('.implode(',', $size).')' : '');      
                }elseif($MODE === 'CHANGE'){
                    self::$ALTER['TABLE']['CHANGE'][$name] =  ($value? "`{$value}` " :"")."DOUBLE".($size? '('.implode(',', $size).')' : '');      
                }else{
                    self::$ALTER['TABLE']['FIELDS'][$name] =  "DOUBLE".($size? '('.implode(',', $size).')' : '');  
                }
    
            }else{
    
                self::$CREATE['TABLE'][$MODE][$name] = "DOUBLE".($size? '('.implode(',', $size).')' : '');
    
            }
            
            if(is_int($default)){
                self::$$TYPE['TABLE'][$MODE][$name] .= " DEFAULT ".self::format_default($default);
            }

        }

        return self::$instance;
    }

    /**
     * Set a decimal field
     *
     * @param string|array $name
     * @param array $size array(precision, scale)
     *  - maximum: [65, 30]
     * @param integer|null $default
     * @return DRAFT
     */
    public static function DECIMAL(array|string $name, array $size = [], int $default = null) : DRAFT{
        self::callables(__FUNCTION__);
        
        if(self::assent_mode(['ALTER','CREATE'], __FUNCTION__, $name)) {
    
            if(is_array($name)){
                    $namee = array_keys($name)[0];
                    $value = array_values($name)[0]." ";
                    $name = $namee;
            }
            setVar($value);
    
            self::field($name, 'decimal');
    
            $TYPE = self::$TYPE[0] ?? ''; //CREATE or ALTER
            $MODE = self::$TYPE[1] ?? ''; //MODIFY, CHANGE or FIELDS
            
            if(count($size) > 2){
                Cli::textView(Cli::error("invalid size count for DECIMAL(size: [".implode(", ", $size)."])"), 0, "|2");
                return self::callError(Cli::error("invalid size count for DECIMAL(size: [".implode(", ", $size)."])"), 0, "|2");
            }
    
            if($TYPE === 'ALTER') {
                
                if($MODE === 'MODIFY'){     
                    self::$ALTER['TABLE']['MODIFY'][$name] =  "DECIMAL".($size? '('.implode(',', $size).')' : '');      
                }elseif($MODE === 'CHANGE'){
                    self::$ALTER['TABLE']['CHANGE'][$name] =  ($value? "`{$value}` " :"")."DECIMAL".($size? '('.implode(',', $size).')' : '');      
                }else{
                    self::$ALTER['TABLE']['FIELDS'][$name] =  "DECIMAL".($size? '('.implode(',', $size).')' : '');  
                }
    
            }else{
    
                self::$CREATE['TABLE'][$MODE][$name] = "DECIMAL".($size? '('.implode(',', $size).')' : '');
    
            }
            
            if(is_int($default)){
                self::$$TYPE['TABLE'][$MODE][$name] .= " DEFAULT ".self::format_default($default);
            }

        }

        return self::$instance;
    }

    /**
     * Set a decimal field
     *
     * @param array|string $name
     * @param array $size array(precision, scale)
     *  - maximum: [65, 30]
     * @param integer|null $default
     * @return DRAFT
     */
    public static function REAL(array|string $name, array $size = [], int $default = null) : DRAFT{
        self::callables(__FUNCTION__);
        
        if(self::assent_mode(['ALTER','CREATE'], __FUNCTION__, $name)){
    
            if(is_array($name)){
                    $namee = array_keys($name)[0];
                    $value = array_values($name)[0]." ";
                    $name = $namee;
            }
    
            self::field($name, 'real');
    
            $TYPE = self::$TYPE[0] ?? ''; //CREATE or ALTER
            $MODE = self::$TYPE[1] ?? ''; //MODIFY, CHANGE or FIELDS
            
            if(count($size) > 2){
                Cli::textView(Cli::error("invalid size count for REAL(size: [".implode(", ", $size)."])"), 0, "|2");
                return self::callError(Cli::error("invalid size count for REAL(size: [".implode(", ", $size)."])"), 0, "|2");
            }
    
            if($TYPE === 'ALTER') {
                
                if($MODE === 'MODIFY'){     
                    self::$ALTER['TABLE']['MODIFY'][$name] =  "REAL".($size? '('.implode(',', $size).')' : '');      
                }elseif($MODE === 'CHANGE'){
                    self::$ALTER['TABLE']['CHANGE'][$name] =  ($value? "`{$value}` " :"")."REAL".($size? '('.implode(',', $size).')' : '');      
                }else{
                    self::$ALTER['TABLE']['FIELDS'][$name] =  "REAL".($size? '('.implode(',', $size).')' : '');  
                }
    
            }else{
    
                self::$CREATE['TABLE'][$MODE][$name] = "REAL".($size? '('.implode(',', $size).')' : '');
    
            }
            
            if(is_int($default)){
                self::$$TYPE['TABLE'][$MODE][$name] .= " DEFAULT {$default}";
            }

        }

        return self::$instance;
    }

    /**
     * Set a date field
     *
     * @param array|string $name name of field
     * @param string $default default date
     * @return
     */
    public static function DATE(array|string $name, string $default = '') : DRAFT{
        self::callables(__FUNCTION__);
        
        if(self::assent_mode(['ALTER','CREATE'], __FUNCTION__, $name)){
    
            if(is_array($name)){
                    $namee = array_keys($name)[0];
                    $value = array_values($name)[0]." ";
                    $name = $namee;
            }
            setVar($value);
    
            self::field($name, 'date');
    
            $TYPE = self::$TYPE[0] ?? ''; //CREATE or ALTER
            $MODE = self::$TYPE[1] ?? ''; //MODIFY, CHANGE or FIELDS
    
            if($TYPE === 'ALTER') {
                
                if($MODE === 'MODIFY'){     
                    self::$ALTER['TABLE']['MODIFY'][$name] = "DATE"; 
                }elseif($MODE === 'CHANGE'){
                    self::$ALTER['TABLE']['CHANGE'][$name] = ($value? "`{$value}` " :"")."DATE";  
                }else{
                    self::$ALTER['TABLE']['FIELDS'][$name] = "DATE";
                }
    
            }else{
    
                self::$CREATE['TABLE'][$MODE][$name] = "DATE";
    
            }
            
            if(func_num_args() > 2){
                self::$$TYPE['TABLE'][$MODE][$name] .= " DEFAULT ".self::format_default($default);
            }

        }

        return self::$instance;
    }

    /**
     * Set a datetime field
     *
     * @param string $name name of field
     * @param integer $precision precision is only added if it is greater than 0
     * @param string $default default datetime (e.g '(NOW())', '(CURRENT_TIMESTAMP)' )
     * @return DRAFT
     */
    public static function DATETIME($name, int $precision = 0, string $default = '') : DRAFT{
        self::callables(__FUNCTION__);
        
        if(self::assent_mode(['ALTER','CREATE'], __FUNCTION__, $name)){
    
            if(is_array($name)){
                    $namee = array_keys($name)[0];
                    $value = array_values($name)[0]." ";
                    $name = $namee;
            }
            setVar($value);
    
            self::field($name, 'date');
    
            $TYPE = self::$TYPE[0] ?? ''; //CREATE or ALTER
            $MODE = self::$TYPE[1] ?? ''; //MODIFY, CHANGE or FIELDS
    
            if($TYPE === 'ALTER') {
                
                if($MODE === 'MODIFY'){     
                    self::$ALTER['TABLE']['MODIFY'][$name] = "DATETIME".($precision? '('.$precision.')' : ''); 
                }elseif($MODE === 'CHANGE'){
                    self::$ALTER['TABLE']['CHANGE'][$name] = ($value? "`{$value}` " :"")."DATE".($precision? '('.$precision.')' : '');  
                }else{
                    self::$ALTER['TABLE']['FIELDS'][$name] = "DATETIME".($precision? '('.$precision.')' : '');
                }
    
            }else{
    
                self::$CREATE['TABLE'][$MODE][$name] = "DATE";
    
            }    
            
            if(func_num_args() > 2){
                self::$$TYPE['TABLE'][$MODE][$name] .= " DEFAULT ".self::format_default($default);
            }

        }

        return self::$instance;
    }

    /**
     * Set a timestamp field
     *
     * @param string $name name of field
     * @param integer $precision precision is only added if it is greater than 0 
     * @param string $default default timestamp
     * @return DRAFT
     */
    public static function TIMESTAMP($name, int $precision = 0, string $default = '') : DRAFT{
        self::callables(__FUNCTION__);

        if(self::assent_mode(['ALTER','CREATE'], __FUNCTION__, $name)){
    
            if(is_array($name)){
                    $namee = array_keys($name)[0];
                    $value = array_values($name)[0]." ";
                    $name = $namee;
            }
            setVar($value);
    
            self::field($name, 'timestamp');
    
            $TYPE = self::$TYPE[0] ?? ''; //CREATE or ALTER
            $MODE = self::$TYPE[1] ?? ''; //MODIFY, CHANGE or FIELDS
    
            if($TYPE === 'ALTER') {
                
                if($MODE === 'MODIFY'){     
                    self::$ALTER['TABLE']['MODIFY'][$name] = "TIMESTAMP".($precision? '('.$precision.')' : ''); 
                }elseif($MODE === 'CHANGE'){
                    self::$ALTER['TABLE']['CHANGE'][$name] = ($value? "`{$value}` " :"")."TIMESTAMP".($precision? '('.$precision.')' : '');  
                }else{
                    self::$ALTER['TABLE']['FIELDS'][$name] = "TIMESTAMP".($precision? '('.$precision.')' : '');
                }
    
            }else{
    
                self::$CREATE['TABLE'][$MODE][$name] = "TIMESTAMP".($precision? '('.$precision.')' : '');
    
            }            
            
            if(func_num_args() > 2){
                self::$$TYPE['TABLE'][$MODE][$name] .= " DEFAULT ".self::format_default($default);
            }

        }

        return self::$instance;
    }

    /**
     * Set a time field
     *
     * @param string $name name of field
     * @param integer $precision precision is only added if it is greater than 0
     * @param string $default default time
     * @return DRAFT
     */
    public static function TIME($name, int $precision = 0, string $default = '') : DRAFT{
        self::callables(__FUNCTION__);
        
        if(self::assent_mode(['ALTER','CREATE'], __FUNCTION__, $name)){
    
            if(is_array($name)){
                    $namee = array_keys($name)[0];
                    $value = array_values($name)[0]." ";
                    $name = $namee;
            }
            setVar($value);
    
            self::field($name, 'time');
    
            $TYPE = self::$TYPE[0] ?? ''; //CREATE or ALTER
            $MODE = self::$TYPE[1] ?? ''; //MODIFY, CHANGE or FIELDS
    
            if($TYPE === 'ALTER') {
                
                if($MODE === 'MODIFY'){     
                    self::$ALTER['TABLE']['MODIFY'][$name] = "TIME".($precision? '('.$precision.')' : ''); 
                }elseif($MODE === 'CHANGE'){
                    self::$ALTER['TABLE']['CHANGE'][$name] = ($value? "`{$value}` " :"")."TIME".($precision? '('.$precision.')' : '');  
                }else{
                    self::$ALTER['TABLE']['FIELDS'][$name] = "TIME".($precision? '('.$precision.')' : '');
                }
    
            }else{
                self::$CREATE['TABLE'][$MODE][$name] = "TIME".($precision? '('.$precision.')' : '');
    
            }         
            
            if(func_num_args() > 2){
                self::$CREATE['TABLE'][$MODE][$name] .= " DEFAULT ".self::format_default($default);
            }

        }

        return self::$instance;
    }

    /**
     * Set a datetime field
     *
     * @param string $name name of field
     * @param string $precision option 4 sets the year syntax to 4 digits
     * @param string $default default year
     * @return DRAFT
     */
    public static function YEAR($name, int $precision = 0, string $default = '') : DRAFT{
        self::callables(__FUNCTION__);
        
        if(self::assent_mode(['ALTER','CREATE'], __FUNCTION__, $name)) {

            if(is_array($name)){
                 $namee = array_keys($name)[0];
                 $value = array_values($name)[0]." ";
                 $name = $namee;
            }
            setVar($value);
    
            self::field($name, 'year');
    
            $TYPE = self::$TYPE[0] ?? ''; //CREATE or ALTER
            $MODE = self::$TYPE[1] ?? ''; //MODIFY, CHANGE or FIELDS
    
            if($TYPE === 'ALTER') {
                
                if($MODE === 'MODIFY'){     
                    self::$ALTER['TABLE']['MODIFY'][$name] = "YEAR".($precision? '('.$precision.')' : ''); 
                }elseif($MODE === 'CHANGE'){
                    self::$ALTER['TABLE']['CHANGE'][$name] = ($value? "`{$value}` " :"")."YEAR".($precision? '('.$precision.')' : '');  
                }else{
                    self::$ALTER['TABLE']['FIELDS'][$name] = "YEAR".($precision? '('.$precision.')' : '');
                }
    
            }else{
    
                self::$CREATE['TABLE'][$MODE][$name] = "YEAR".($precision? '('.$precision.')' : '');
    
            }          
    
            if(is_int($default)){
                self::$CREATE['TABLE']['FIELDS'][$name] .= " DEFAULT ".self::format_default($default);
            }

        }

        return self::$instance;
    }

    /**
     * Sets a blob field
     *
     * @param array|string $name name of the field
     * @param integer $size size of the field
     * @param string $default the default value of the field
     * @return DRAFT
     */
    public static function BLOB(array|string $name, string $default = '') : DRAFT {
        self::callables(__FUNCTION__);
        
        if(self::assent_mode(['ALTER','CREATE'], __FUNCTION__, $name)){
    
            if(is_array($name)){
                    $namee = array_keys($name)[0];
                    $value = array_values($name)[0]." ";
                    $name = $namee;
            }
            setVar($value);
            
            self::field($name, 'blob');
            
            $TYPE = self::$TYPE[0] ?? ''; //CREATE or ALTER
            $MODE = self::$TYPE[1] ?? ''; //MODIFY, CHANGE or FIELDS
    
            if($TYPE === 'ALTER') {
    
                if($MODE === 'MODIFY'){    
                    self::$ALTER['TABLE']['MODIFY'][$name] = "BLOB";
                }elseif($MODE === 'CHANGE'){
                    self::$ALTER['TABLE']['CHANGE'][$name] = ($value? "`{$value}` " : "")."BLOB"; 
                }else{
                    self::$ALTER['TABLE']['FIELDS'][$name] = "BLOB";
                }
    
            }else{
    
                self::$CREATE['TABLE']['FIELDS'][$name] = "BLOB";
                
            }
            
            if(func_num_args() > 1){
                self::$$TYPE['TABLE'][$MODE][$name] .= " DEFAULT {$default}";
            }

        }

        return self::$instance;
    }

    /**
     * Sets the BLOB field
     *
     * @param string $type the type of field [BLOB|TINY|SMALL|MEDIUM|LONG]
     * @param string $name the name of the field
     * @param string $default the default value of the field
     * @return DRAFT
     */
    public static function BLOBFIELD(string $type, string $name, string $default = '') : DRAFT {
        self::callables(__FUNCTION__);
        
        if(self::assent_mode(['ALTER','CREATE'], __FUNCTION__, $name)){
    
            if(is_array($name)){
                    $namee = array_keys($name)[0];
                    $value = array_values($name)[0]." ";
                    $name = $namee;
            }
            setVar($value);
    
            $type = strtoupper($type);
            if(!array_key_exists($type, self::options('BLOB'))){
                Cli::textView(Cli::error("invalid option [{$type}] supplied for BLOBFIELD(".implode(', ', func_get_args()).")"), 2, "|2");
                return self::callError(Cli::error("invalid option [{$type}] supplied for BLOBFIELD(".implode(', ', func_get_args()).")"), 2, "|2");
            }else{
                $type = self::options('BLOB')[$type];
            }
            
            self::field($name, $type);
            
            $TYPE = self::$TYPE[0] ?? ''; //CREATE or ALTER
            $MODE = self::$TYPE[1] ?? ''; //MODIFY, CHANGE or FIELDS
    
            if($TYPE === 'ALTER') {
                if($MODE === 'MODIFY'){    
                    self::$ALTER['TABLE']['MODIFY'][$name] = "BLOB";
                }elseif($MODE === 'CHANGE'){
                    self::$ALTER['TABLE']['CHANGE'][$name] = ($value? "`{$value}` " : "")."BLOB"; 
                }else{
                    self::$ALTER['TABLE']['FIELDS'][$name] = "BLOB";
                }
    
            }else{
    
                self::$CREATE['TABLE']['FIELDS'][$name] = "BLOB";
                
            }
    
            if(trim($default)){
                self::$$TYPE['TABLE'][$MODE][$name] .= " DEFAULT ".self::format_default($default);
            }
            
        }

        return self::$instance;

    }

    /**
     * Sets contraints on fields
     *
     * @param string $name name used for storing constraint
     * @return DRAFT
     */
    public static function CONSTRAINT($name = '') : DRAFT {
        self::callables(__FUNCTION__);
        
        self::field($name, '::constraint');        
        return self::$instance;      
    }

    
    /**
     * This constraint is applied on an integer field
     * @return DRAFT
     */
    public function SIGNED() : DRAFT {
        self::callables(__FUNCTION__);
                
        $TYPE = self::$TYPE[0] ?? ''; //CREATE or ALTER
        $MODE = self::$TYPE[1] ?? ''; //MODIFY, CHANGE or FIELDS

        self::$CREATE['TABLE'][$MODE][self::$field] .= " SIGNED";
        return self::$instance;
    }
    
    /**
     * This constraint is applied on an integer field
     * @return DRAFT
     */
    public function UNSIGNED() : DRAFT {
        self::callables(__FUNCTION__);
                
        $TYPE = self::$TYPE[0] ?? ''; //CREATE or ALTER
        $MODE = self::$TYPE[1] ?? ''; //MODIFY, CHANGE or FIELDS

        self::$$TYPE['TABLE'][$MODE][self::$field] .= " UNSIGNED";
        return self::$instance;
    }
    
    /**
     * This constraint comes after the field data type (e.g VARCHAR) is set
     * This will set a "NOT NULL" constraint. If a default is applied, the default will also be set
     * @param string $check
     * @return DRAFT
     */
    public function NOT_NULL(string|int $default = '') : DRAFT {
        self::callables(__FUNCTION__);
                
        $TYPE = self::$TYPE[0] ?? ''; //CREATE or ALTER
        $MODE = self::$TYPE[1] ?? ''; //MODIFY, CHANGE or FIELDS
        
        $statement =  self::$$TYPE['TABLE'][$MODE][self::$field];
        $statementTrim = trim($statement);        
        
        if(
            (strpos($statementTrim, ' NULL ') !== false) || 
            (strpos($statementTrim, ' NOT NULL ') !== false)){
            Cli::textView(Cli::error("applying NOT NULL or NULL constraints on field more than once is disallowed"));
            return self::callError(Cli::error("applying NOT NULL or NULL constraints on field more than once is disallowed"));
        }

        self::$$TYPE['TABLE'][$MODE][self::$field] .= " NOT NULL";
        
        if(func_num_args() > 0) {
            self::$$TYPE['TABLE'][$MODE][self::$field] .= " DEFAULT ".self::format_default($default);
        }
        return self::$instance;
    }
    
    /**
     * This constraint comes after the field data type (e.g VARCHAR) is set
     * This will set a "NULL" constraint along with a default if applied
     * @param string $check
     * @return DRAFT
     */
    public function NULL(string|int $default = '') : DRAFT {
        self::callables(__FUNCTION__);
        //check last statement of create first 
                
        $TYPE = self::$TYPE[0] ?? ''; //CREATE or ALTER
        $MODE = self::$TYPE[1] ?? ''; //MODIFY, CHANGE or FIELDS
    
        $statement = self::$$TYPE['TABLE'][$MODE][self::$field];
        $statementTrim = trim($statement);
        
        if(
            (strpos($statementTrim, ' NULL ') !== false) || 
            (strpos($statementTrim, ' NOT NULL ') !== false)){
            Cli::textView(Cli::error("applying NULL or NOT NULL constraints on field more than once is disallowed"));
            return self::callError(Cli::error("applying NULL or NOT NULL constraints on field more than once is disallowed"));
        }

        self::$$TYPE['TABLE'][$MODE][self::$field] .= " NULL";

        if(func_num_args() > 0) {
            self::$$TYPE['TABLE'][$MODE][self::$field] .= " DEFAULT ".self::format_default($default);
        }

        return self::$instance;

    }

    /**
     * Set default constraint on fields
     *
     * @param int|string $default optional [NULL|NOT NULL|$default]
     *
     * @return DRAFT
     */
    public function DEFAULT(int|string $default = 'NULL') : DRAFT {
        self::callables(__FUNCTION__);
                
        $TYPE = self::$TYPE[0] ?? ''; //CREATE or ALTER
        $MODE = self::$TYPE[1] ?? ''; //MODIFY, CHANGE or FIELDS
    
        $currentField = self::$instance->currentField();
        
        $field = $currentField[0];

        if( ($default === 'NULL') || ($default === 'NOT NULL') ){
            self::$$TYPE['TABLE'][$MODE][$field] .= " DEFAULT {$default}";
        }else{
            self::$$TYPE['TABLE'][$MODE][$field] .= " DEFAULT ".self::format_default($default);
        }
        
        return self::$instance;
    }

    /**
     * Set default constraint on fields
     *
     * @param int|string $default optional [NULL|NOT NULL|$default]
     *
     * @return DRAFT
     */
    public function ON_UPDATE(string $value) : DRAFT {
        self::callables(__FUNCTION__);
                
        $TYPE = self::$TYPE[0] ?? ''; //CREATE or ALTER
        $MODE = self::$TYPE[1] ?? ''; //MODIFY, CHANGE or FIELDS
    
        $currentField = self::$instance->currentField();
        
        $field = $currentField[0];
        self::$$TYPE['TABLE'][$MODE][$field] .= " ON UPDATE ".self::format_default($value);
        
        return self::$instance;
    }

    /**
     * Set unique constraint on fields
     *
     * @param string[] $args list of binded unique fields [optional]
     *  -if no argument is supplied it sets unique constraint on the current field
     * @return DRAFT
     */
    public function UNIQUE($args = []) : DRAFT {
        self::callables(__FUNCTION__);
        $currentField = self::$instance->currentField();
        
        $field = $currentField[0];
        $type = $currentField[1];
        
        if($type ==='::constraint'){
            
            if(trim($field)){
                //field here means constraint name
                self::$instance->constraints['UNIQUE'] = [ $field => func_get_args() ];
            } else {
                Cli::textView(Cli::error('undefined contraint name for unique fields ('.implode(', ', func_get_args()).')'), 2, '|2');
                return self::callError(Cli::error('undefined contraint name for unique fields ('.implode(', ', func_get_args()).')'), 2, '|2');
            }
            
        }else{
            if(func_num_args() > 0){
                return self::callError(Cli::error('no arguments are expected for UNIQUE() method unless chained on CONSTRAINT()', 2, '|2'));
            }
            self::$instance->uniqueFields[] = $currentField[0];
        }
        return self::$instance;
    }

    /**
     * Sets a primary field
     *
     * @param string|array $field name of the field
     * @return DRAFT
     */
    public static function PRIMARY_KEY(string|array $field = '') : DRAFT{
        self::callables(__FUNCTION__);
                
        $TYPE = self::$TYPE[0] ?? ''; //CREATE or ALTER
        $MODE = self::$TYPE[1] ?? ''; //MODIFY, CHANGE or FIELDS


        $table = array_key_exists('TABLE', self::$$TYPE)? self::$$TYPE['TABLE'] : [];

        if(array_key_exists('::PRIMARY_KEY', $table)){
            Cli::textView(Cli::error('a primary field cannot be set more than once'), 2, '|2');
            return self::callError(Cli::error('a primary field cannot be set more than once'), 2, '|2');         
        }        

        if(func_num_args() < 1){
            $currentField = self::$instance->currentField();
            $field = $currentField[0];
            if(!trim($field)){
                return self::callError(Cli::error('a primary field cannot be an empty value.'), 2, '|2');         
            }
        }
        
        self::$$TYPE['TABLE']['::PRIMARY_KEY'] = $field;
        return self::$instance;
    }

    /**
     * Add auto increment feature to field
     *
     * @return DRAFT
     */
    public function AUTO_INCREMENT(){
        self::callables(__FUNCTION__);
                
        $TYPE = self::$TYPE[0] ?? ''; //CREATE or ALTER
        $MODE = self::$TYPE[1] ?? ''; //MODIFY, CHANGE or FIELDS

        self::$$TYPE['TABLE'][$MODE][$field] .= " AUTO_INCREMENT ";
        
        return self::$instance;
    }

    /**
     * Alias for AUTO_INCREMENT()
     *
     * @return DRAFT
     */
    public function AUTO(){
        $this->AUTO_INCREMENT();
    }

    /**
     * Sets a foreign key on the current selected table
     *
     * @param string $parentTable name of the parent table
     * @param array $relation array of foreign key (index) and local key (value) 
     * @return DRAFT
     */
    public static function FOREIGN_KEY(string $parentTable, array $relation){
        self::callables(__FUNCTION__);
        self::$CREATE['TABLE']['::FOREIGN_KEY'][] = [$parentTable => $relation];
        return self::$instance;
    }

    /**
     * Sets a foreign key on the current selected table
     *
     * @param string $parentTable name of the parent table
     * @param array $relation array of foreign key (index) and local key (value) 
     * @return DRAFT
     */
    public function CASCADE(){
        if(self::$LASTCALLED != 'FOREIGN_KEY'){
            Cli::textView(Cli::error('CASCADE can only be used with the foreign key method'));
            return self::callError(Cli::error('CASCADE can only be used with the foreign key method'));
        }
        self::callables(__FUNCTION__);
        $lastKey = count(self::$CREATE['TABLE']['::FOREIGN_KEY']) - 1;
        //update the last key
        self::$CREATE['TABLE']['::FOREIGN_KEY'][$lastKey]['::OPTIONS'][0] = 'CASCADE';        
        return self::$instance;
    }

    /**
     * Sets a foreign key on the current selected table
     *
     * @param string $parentTable name of the parent table
     * @param array $relation array of foreign key (index) and local key (value) 
     * @return void
     */
    public function RESTRICT(){
        if((self::$LASTCALLED != 'FOREIGN_KEY') && (self::$LASTCALLED != 'CASCADE')){
            Cli::textView(Cli::error('RESTRICT can only be used along with the FOREIGN_KEY or CASCADE method'));
            Cli::textView(Cli::error('RESTRICT cannot be used with '.self::$LASTCALLED));
            return self::callError(Cli::error('RESTRICT cannot be used with '.self::$LASTCALLED));
        }
        self::callables(__FUNCTION__);
        $lastKey = count(self::$CREATE['TABLE']['::FOREIGN_KEY']) - 1;

        //update the last key
        self::$CREATE['TABLE']['::FOREIGN_KEY'][$lastKey]["::OPTIONS"][1] = "RESTRICT";
    }

    /**
     * Sets a check constaint that comes after default is set (if default set).
     *
     * @param string $check 
     * @return DRAFT
     */
    public function CHECK(string $check) : DRAFT{
        self::callables(__FUNCTION__);
        self::$CREATE['TABLE']['FIELDS'][self::$field] .= " CHECK('{$check}')";
        return self::$instance;
    }

    /**
     * Add a comment to a field white creating (after default, if set)
     *
     * @param string $check 
     * @return DRAFT
     */
    public function COMMENT(string $comment) : DRAFT{
        self::callables(__FUNCTION__);
        self::$$TYPE['TABLE']['FIELDS'][self::$field] .= " COMMENT '{$comment}'";
        return self::$instance;
    }

    /**
     * Set unique constraint on fields
     *
     * @param string[] $args list of binded unique fields [optional]
     *  -if no argument is supplied it sets unique constraint on the current field
     * @return void
     */
    public function INDEX($args = []){
        self::callables(__FUNCTION__);
        $currentField = self::$instance->currentField();
        
        $field = $currentField[0];
        $type = $currentField[1];
        
        if($type ==='::constraint'){
            
            if(trim($field)){

                //field here means constraint name
                self::$instance->constraints['UNIQUE'] = [ $field => func_get_args() ];
            }
            
        }else{
            self::$instance->uniqueFields[] = $currentField[0];
        }
    }

    /**
     * Creates a unique index on a table. This method should not be 
     * called with other methods
     *
     * @param string $type optional [UNIQUE|BTREE] 
     *  - option "UNIQUE" creates a unique index on the specified $field.
     *  - option "BTREE" creates a unique index on the specified $field using BTREE.
     * @return void
     */
    public static function CREATE_INDEX(string $field, string $indexName, string $type = ''){
        
        self::callables(__FUNCTION__);
        
        self::$CREATE["TABLE"]["INDEX"] = [$field, $indexName, $type];

    }

    /**
     * Build the entire draft query
     *
     * @param string $TABLE name of the table to be created
     * @return string draft string
     */
    protected static function BUILD_CREATE(string $TABLE) : string {

        $Table = self::$CREATE['TABLE'] ?? [];

        if(($Table['INDEX']??'') && ($Table['FIELDS']??'')){

            Cli::textView(Cli::error('syntax "CREATE_INDEX" cannot be initialized with table fields!'), 2, '|2');
            return self::callError(Cli::error('syntax "CREATE_INDEX" cannot be initialized with table fields!'), 2, '|2');

        }elseif($Table['INDEX']??''){
            return self::BUILD_INDEX($TABLE);
        }

        $PRIMARY_KEY = (array) ($Table['::PRIMARY_KEY'] ?? []);
        $PRIMARY_KEY = implode(', ',$PRIMARY_KEY);

        print_r($Table);
        
        $FOREIGN_KEY = $Table['::FOREIGN_KEY'] ?? [];
        $REFERENCES  = [];
        
        $FIELDS = array_map(function($value, $key){

            return "`".$key."` ".$value;

        }, $Table['FIELDS'], array_keys($Table['FIELDS']) );

        $DRAFT = implode(', ', $FIELDS);

        $uniqueFields = self::$instance->uniqueFields;

        $constraints =  self::$instance->constraints;

        //add unique fields 
        if($UNIQUES = ($constraints['UNIQUE']??'')){
            foreach($UNIQUES as $UNIQUE => $UNIQUEVALUES){
               $DRAFT .= ", CONSTRAINT {$UNIQUE} UNIQUE(".implode(', ', $UNIQUEVALUES).")";
            }
        }

        //handle foreign keys
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
                    return "INDEX ({$foreigns}), FOREIGN KEY({$foreigns}) REFERENCES $index({$locals}){$statement}"; 
                
            }, $foreign, array_keys($foreign));

        }

        $STATEMENT = '';
        foreach($REFERENCES as $REFERENCE){

            $STATEMENT .= ($REFERENCE)? ", ".implode(",", $REFERENCE) : '';

        }

        $REFERENCES = $STATEMENT;

        if($uniqueFields){
           $DRAFT .= ", UNIQUE(".implode(', ', $uniqueFields).")";
        }
        
        $PRIMARY = ($PRIMARY_KEY)? ", PRIMARY KEY({$PRIMARY_KEY})" : "";

        $DRAFT .= $PRIMARY;

        $DRAFT = "CREATE TABLE IF NOT EXISTS {$TABLE} ({$DRAFT}{$REFERENCES})";
        $DRAFT .= self::$CREATE['PARTITION_BY'] ?? '';

        return $DRAFT;

    }

    protected static function BUILD_INDEX(string $TABLE) : string {

        $INDEX = self::$CREATE['TABLE']['INDEX'];
        $fieldName = $INDEX[0]??'';
        $indexName = $INDEX[1]??'';
        $type      = strtoupper($INDEX[2]??'');
        $useBTREE  = '';

        if(!in_array($type, ['', 'UNIQUE', 'BTREE'])){
            Cli::textView(Cli::error('invalid option supplied on BUILD_INDEX. Option if specified can only be UNIQUE.'), 2, '|2');
            return self::callError(Cli::error('invalid option supplied on BUILD_INDEX. Option if specified can only be UNIQUE.'), 2, '|2');
        }

        if($type == 'BTREE'){
            $type = 'UNIQUE';
            $useBTREE = "USING BTREE";
        }


        return "CREATE {$type} INDEX {$indexName} ON {$TABLE}({$fieldName}) {$useBTREE}";

    }

    /**
     * Validate CHANGE scope only
     *
     * @param array $scopes allowed main scope(s) of call
     * @param string $function
     * @param string $name
     * @return boolean 
     */
    private static function assent_mode(array $scopes,$function, &$name = null) : bool {

        $TYPE = self::$TYPE[0] ?? ''; //CREATE or ALTER
        $MODE = self::$TYPE[1] ?? ''; //MODIFY, CHANGE or FIELDS

        if(in_array($TYPE, $scopes)){
            if($MODE === 'CHANGE'){

                $arg = (array) $name;
                
                if(count($arg) > 1){
                    Cli::textView(Cli::error('the argument(#1) supplied on '.Cli::warn($function."()").'" should be a string or a single array of string key and value pairs.'));
                    return self::callError(Cli::error('the argument(#1) supplied on '.Cli::warn($function."()").'" should be a string or a single array of string key and value pairs.'));                
                }

                $key = array_keys($arg)[0] ?? '';
                $val = array_values($arg)[0] ?? '';

                if(((is_numeric($key) && $key !== 0) && is_numeric($val)) || is_bool($val)){
                    Cli::textView(Cli::error('the argument(#1) supplied on '.Cli::warn($function."()").'" should be a string or a single array of string key and value pairs.'));
                    return self::callError(Cli::error('the argument(#1) supplied on '.Cli::warn($function."()").'" should be a string or a single array of string key and value pairs.'));          
                }else if(($key === 0) && is_string($val)){
                    $key = $val;
                }else{
                    Cli::textView(Cli::error('the argument(#1) supplied on '.Cli::warn($function."()").'" should be a string or a single array of string key and value pairs.'));
                    return self::callError(Cli::error('the argument(#1) supplied on '.Cli::warn($function."()").'" should be a string or a single array of string key and value pairs.'));                  
                }

                $name = [$key => $val];


            }else{

                if(is_array($name)){
                    Cli::textView(Cli::error('array can only be supplied on '.Cli::warn($function."()").'" within '.Cli::alert('CHANGE').' scope.'));
                    return self::callError(Cli::error('array can only be supplied on '.Cli::warn($function."()").'" within '.Cli::alert('CHANGE').' scope.'));
                }

            }
        }else{
            Cli::textView(Cli::error(' invalid scope of call for '.$function.'() '));
            return self::callError(Cli::error(' invalid scope of call for '.$function.'() '));
        }

        return true;

    }

    private static function format_default(int|string &$value) : int|string {

        $firstChars = substr($value, 0, 2);
        $lastChars = substr($value, strlen($value) - 2);

        $firstChars1 = substr($value, 0, 1);
        $lastChars1 = substr($value, strlen($value) - 1);

        if(is_float($value) || is_int($value) && !is_string($value)){
            $value = $value;
        }elseif( ($firstChars === "((") && ($lastChars === "))") ) {

            $value = substr($value, 1, $value);
            $value = substr($value, -1, $value);

            $value = "'".$value."'";

        }elseif(($firstChars1 === "(") && ($lastChars1 === ")")){
            $value = substr($value,  1, strlen($value) - 2);
        }else{
            $value = "'".$value."'";
        }

        return $value;

    }

}