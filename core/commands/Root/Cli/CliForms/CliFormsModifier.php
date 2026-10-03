<?php 

namespace spoova\mi\core\commands\Root\Cli\CliForms;

use Closure;
use spoova\mi\core\classes\Ghost\GhostDraft;
use spoova\mi\core\classes\Ghost\GhostFunction;
use spoova\mi\core\classes\Ghost\GhostProxy;
use spoova\mi\core\classes\TClass;
use spoova\mi\core\commands\Root\Cli;
use spoova\mi\core\commands\Root\Cli\CliDraw;
use spoova\mi\core\commands\Root\Cli\CliForms;
use spoova\mi\core\commands\Root\Cli\CliForms\CliFlow;

Trait CliFormsModifier {

    protected static $using_requirements = false;
    
    /**
     *  For all input fields except : choice, radio, select
     *   - borderColor key supports any valid color including 'currentColor" or "color' 
     *     which points to the currently defined text color. 
     *  */
    public const design = ['width' => 50, 'indent' => 0, 'shape' => 'square', 'textColor' => 'ash', 'borderColor' => 'ash'];

    /**
     *  For input choice, radio, select
     *   - borderColor key supports any valid color including 'currentColor" or "color' 
     *     which points to the currently selected item's text color. 
     *  */
    public const flow_design = ['width' => 50, 'indent' => 0, 'shape' => 'square', 'textColor' => 'valid', 'borderColor' => 'ash'];
    
    /** Specified by a white color */
    public const text_field_color = 'ash';

    /** Specified by a greenish color */
    public const text_field_valid_color = 'valid';

    private static function modified(?Closure $modifier, array $defaults, array $chars, string $argType = 'array') : CliFlow {
      $md = array_values(TClass::funcParams($modifier));

      $Ghost = new GhostFunction(['ghostData']);

      if(count($md)>0 && is_array($md[0]) && $md[0][0] === CliFlow::class){
        
        // custom modifier
        $data = [
          'chars' => $chars,
          'count' => count($chars), 
          'value' => implode('',$chars)
        ];
        $data = (object) array_merge($data, $defaults); // textColor, borderColor, advance (optional)
        
        $Ghost->ghostData(fn($key) => $data->$key ?? null);

        /** @var CliFlow */
         $flow = GhostProxy::new($Ghost, fn(GhostDraft $draft) => new class($draft) extends CliFlow{});

        $modifier($flow, $flow->value); // modifier receives and modifies CliFlow object
        $mod = $flow;
      }else{
        // Default modifier receives input value argument as string (type hinting) or array
        $modArgument = ($argType === 'string')? implode('',$chars) : $chars; // modifier argument
        $mod = $modifier($modArgument); //  array / CliFlow object 

        $Ghost = new GhostFunction(['ghostData']);
        if($mod instanceof CliFlow){
          $Ghost->ghostData(fn($key) => $mod->$key ?? null);
        }else{
          $mod = (object) (is_array($mod)? array_merge($defaults, $mod) : $defaults);
          $Ghost->ghostData(fn($key) => $mod->$key ?? null);
        }

        /** @var CliFlow */
         $mod = GhostProxy::new($Ghost, fn(GhostDraft $draft) => new class($draft) extends CliFlow{});
      }

      return $mod;
    }

    protected static function use_requirements() {
        if(self::$using_requirements) return ;
        Cli::requires('stty', fn() => Cli::errorView('Cli text input requires stty', break: 2) );
        Cli::requires('pcntl', fn() => Cli::textPlain('Cli input requires pcntl extension') );
        self::$using_requirements = true;
    }

    /**
     * Generate a configuration template for input fields
     *
     * @param string $category optional [text|choice]
     *    - text: for input fields password, text, alpha, number
     * @param array $arguments argument supplied to input field type.
     * @return array keys  : shape, width, height, margin, info, borderColor, textColor, defaults, cursor
     */
    protected static function draft(string $category, array $arguments) : array {
        if($category === 'text'){
          return self::draft_text($arguments);
        }elseif($category === 'choice'){
          return self::draft_choice($arguments);
        }
        return [];
    }

    private static function draft_text(array $arguments) : array {

        // arguments received 
        $placeholder = $arguments['placeholder'];
        $required = $arguments['required'];
        $maxlength = $arguments['maxlength'];
        $design = $arguments['design'];
        $modifier = $arguments['modifier'];

        $width = $design['width'] ?? 25;
        $margin = $design['indent'] ?? 0;
        $shape = $design['shape'] ?? 'square';

        $textColor = $design['textColor'] ?? CliForms::text_field_color;
        $borderColor = $design['borderColor'] ?? CliForms::text_field_color;

        // set accepted configuration for default values 
        if(!in_array($shape, ['square','round'])) $shape = 'square';

        $width = (!is_numeric($width) || ($width < 25))? 25 : (int) $width;
        $margin = (!is_numeric($margin))? 0 : (int) $margin;

        // Ensure width is not greater than screen width at initial draw
        $margin = CliDraw::fitIndent($margin);           // guard against excessive indent
        $width  = CliDraw::fitWidth($width, $margin);    // keep box within the screen

        $advance = (object) ['advance'=>null];

        $defaults['textColor'] = $textColor;
        $defaults['borderColor'] = $borderColor;
        $defaults['advance'] = $advance;

        $info['x'] = $width; //width
        $info['y'] = $height = 1; //height
        $info['chars'] = []; // keep text characters
        $info['charsNum'] = 0; // keep text characters
        $info['margin'] = $margin; // left margin
        $info['placeholder'] = $placeholder; // placeholder
        $info['color'] = $textColor;
        $info['required'] = $required;
        $info['maxlength'] = $maxlength;
        $cursor = 0; // text end point
        $info['bound'] = 0;

        // Extras
        $info['bdcolor-state'] = 'white';
        $info['text-state'] = '';

        if(!$modifier){
            $modifier = function(array $chars) use ($borderColor, $textColor){
            
                return (object) [
                    'chars' => $chars, 
                    'count' => count($chars), 
                    'value' => implode('', $chars), 
                    'textColor' => $textColor, 
                    'borderColor' => $borderColor
                ];

            };
        }

        return compact('shape', 'width', 'height', 'margin', 'info', 'borderColor', 'textColor', 'defaults', 'cursor', 'modifier');
    }

    private static function draft_choice(array $arguments) : array {

        // arguments received 
        $selected = $arguments['selected'];
        $design = $arguments['design'];
        $modifier = $arguments['modifier'];
        $options = $arguments['options'];

        $width = $design['width'] ?? 25;
        $height = count($options);
        $indent = $design['indent'] ?? 0;
        $shape = $design['shape'] ?? 'square';

        $textColor = $design['textColor'] ?? CliForms::text_field_color;
        $borderColor = $design['borderColor'] ?? CliForms::text_field_color;

        // set accepted configuration for default values 
        if(!in_array($shape, ['square','round'])) $shape = 'square';

        $width = (!is_numeric($width) || ($width < 25))? 25 : (int) $width;
        $indent = (!is_numeric($indent))? 0 : (int) $indent;

        // Ensure width is not greater than screen width at initial draw
        $indent = CliDraw::fitIndent($indent);           // guard against excessive indent
        $width  = CliDraw::fitWidth($width, $indent);    // keep box within the screen

        $defaults['textColor'] = $textColor;
        $defaults['borderColor'] = $borderColor;

        //requires options and arrows .... 
        if(!is_numeric($selected) || !array_key_exists($selected, $options)){
          $selected = 0;
        }
        
        if(!$modifier){
            $modifier = function(array $chars) use ($borderColor, $textColor){
            
                return (object) [
                    'chars' => $chars, 
                    'count' => count($chars), 
                    'value' => implode('', $chars), 
                    'textColor' => $textColor, 
                    'borderColor' => $borderColor
                ];

            };
        }

        return compact('selected','shape', 'width', 'height', 'indent', 'borderColor', 'textColor', 'defaults', 'modifier');
    }

}