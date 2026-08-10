<?php 

namespace spoova\mi\core\tools\IconExtractor;

use Closure;
use spoova\mi\core\classes\DB\DBSchema\DRAFT;
use spoova\mi\core\classes\Bundle\Filemanager\Filemanager;
use spoova\mi\core\classes\Ghost\GhostDraft;
use spoova\mi\core\classes\Ghost\GhostProxy;

class IconExtractor {

    private static IconExtractor $path;
    private array $icon;
    private array $iconsList;

    public function __construct(string $path, ?Closure $control = null)
    {
        $Filemanager = new Filemanager;
        self::$path = $this;

        $Filemanager->source($path, 'svg');
        $this->icon  = $Filemanager->getFiles();

    }

    public function extract(bool|Closure $populate = false) : array {

        $this->iconsList = []; 
        if(!isset($this->iconsList) || $populate){
            $i = 0;

            $icons = ['icons'=> $this->icon];

            /* @var IconList $iconsList */
            $iconsList = GhostProxy::new($icons, fn(GhostDraft $draft) => new class($draft) extends IconList {});

            if(!is_bool($populate)) {
                $this->iconsList = $populate($iconsList);
            }else{
                foreach($this->icon as $icon){
                    $i++; 
                    $name = basename($icon);
                    $name = \pathinfo($name, \PATHINFO_FILENAME);
                    $this->iconsList[$name] = $icon;
                    //if($i === $limit) break;
                }
            }
        }
        return $this->iconsList;
    }

    
    public function getIcons() : array {
        return isset($this->iconsList)? $this->iconsList : false;
    }


}