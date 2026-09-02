<?php 

namespace spoova\mi\core\classes\Enums;

enum inflect: string {

    case default = 'default';
    case hard  = 'hard'; //strict
    case soft  = 'soft'; //unstrict
    case smart = 'smart';//smart

}