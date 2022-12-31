<?php

namespace spoova\core\classes;

class Spinner {

    function widget($text = '') {


        return self::basicStyle().'

            <div class="widget box relative px-100">
                <div class="relative box rad-r" style="z-index:1000">
                    <div class="roller-circle absolute box rad-r grid-center" style="z-index:11">
                        <div class="roller rad-r ov-d4 absolute ico-spin"></div>
                        <div class="roller-text rad-r absolute flow-hide ov-l1 c-grey anc-btn-link">
                            <div class="px-full grid-center font-em-d6">
                                '.$text.'
                            </div>    
                        </div>        
                    </div>            
                </div>
            </div>

        ';

    }

    static function basicStyle() {

        return file_get_contents(_core.'server/.wigi');

    }

}