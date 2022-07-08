<?php

namespace spoova\core\classes;

use spoova\core\classes\Model;

class FormField {

    private $id = '';    
    private $type = 'text';
    private $attrs = [];
    private $class = 'i-flex-full';

    public function __construct(Model $model, string $type = 'text', string $id, array $attrs = []){

        $this->id = trim($id);
        $this->type = trim($type);
        //remove class
        $class = $attrs['class']?? '';
        if($class) $this->class = $class; 
        unset($attrs['class']);
        $this->attrs = $attrs;
        return $this;
        
    }

    public function attrs(array $attrs){
        $this->attrs = $attrs;
    }

    public function __toString(){
        $type = $this->type;
        $attrs = $this->attrs; 
        $id   = $this->id;
        $attributes = ''; $text = '';
        foreach($attrs as $attr => $attrval){
            if($type === 'button' || $type == 'textarea'){
                if($attr === 'text'){
                    $text = $attrval;
                }
                continue;
            }
            $attributes .= ' '.$attr.'="'.$attrval.'"';
        }
        
        if($this->class) $class = ' class="'.$this->class.'" ';
        
        $idattr = ' id="'.$id.'"';
        $attrs = trim($idattr.$attributes.$class, " ");
        if($attrs) $attrs = ' '.$attrs;

        if(strtolower($type) === 'textarea'){
            $value = '<textarea'.$attrs.'>'.$text.'</textarea>';
        }elseif($type === 'button'){
            $value = '<button'.$attrs.'>'.$text.'</button>';
        }elseif($type === 'btn'){
            $value = '<input type="button"'.$attrs.'>';
        }else{
            $value = '<input type="'.$type.'"'.$attrs.'>';
        }
        

        $this->type = 'text';
        $this->attrs = [];
        $this->id = '';
        return $value;
    }


}