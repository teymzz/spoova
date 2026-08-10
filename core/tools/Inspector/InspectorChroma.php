<?php 

namespace spoova\mi\core\tools\Inspector; 

class InspectorChroma extends InspectorBridge{
    
    public const themes = [
        'default',
        'default' => 'default',

        'navy',
        'navy' => 'navy',

        'light',
        'light' => 'light',

        'dark',
        'dark' => 'dark',

        'velvet',
        'velvet' => 'velvet',

        'dracula',
        'dracula' => 'dracula',

        'maroon',
        'maroon' => 'maroon',

        'contrast',
        'contrast' => 'contrast',
    ];

    public static function theme($name){

        $theme = self::style();
        
        $theme .= in_array($name, self::themes)? self::$name() : '';
        return $theme;

    }

    private static function style(){
        static $count = 0;
        $count++;
        if($count > 1) return '';

        $keyLen = InspectorBridge::keyLen();
        
        return '
            details[\:inspect] {
                margin: 1px 0;
                padding: 10px;
                overflow: auto;
            }
            [\:inspect], .inspection-field {
                --margin-left: 6px;
                scrollbar-width: none;
                -ms-overflow-style: none;
                background-color: #191a47;
                color: white;
                font-size: clamp(10px, .85em, 15px);
                padding: 4px;
                font-family: \'fira code\', firacode , calibri;
                width:100%;
            }
            [\:inspect]::-webkit-scrollbar {
                display:none;
            }
            [\:inspect] .flex {
                display: flex;
            }
            [\:inspect] .gap-2 { 
                gap: .5em;
            }   
            [\:inspect] .flex-grid {
                display: grid;
                grid-template-columns: 1fr 20fr;
            }
            [\:inspect] summary.none::marker {
                content: "";
            }
            [\:inspect] > summary + .main {
                margin-top: 10px;
            }
            [\:inspect]:not([\:inspect="object"]) details ~ details {
                margin-top: 5px;
            }
            [\:inspect] .inspection-field summary {
                background-color: inherit;
            }
            [\:inspect] details.inspection-field :where(.methods, .properties) summary:where(.public, .protected, .private) {
                padding: 2px 6px;
            }
            [\:inspect] details.inspection-field :where(.methods, .properties) summary:where(.public, .private, .protected) + div {
                margin-top: 5px;
            }
            [\:inspect="object"] .v-btn{
                --margin-left: 10px;
            }
            [\:inspect] .v-btn > summary::marker {
                content: "⦾";
            }
            [\:inspect] .v-btn[open] > summary::marker {
                content: "⦿";
            }
            [\:inspect] .inspection-field .v-object {
                white-space: nowrap;
            }
            [\:inspect] .inspection-field .item-key{
                display: flex;
                align-items: flex-start;
                user-select: none;
                padding: 10px;
                margin: 2px 0;
                min-width: '.$keyLen.'px;
                overflow: auto;
                scrollbar-width: none;
                -ms-overflow-style: none;
            }
            [\:inspect] .inspection-field .item-key::-webkit-scrollbar{
                display:none;
            }
            [\:inspect] .inspection-field .item-info{
                font-size: .85em;
                margin-bottom: 4px;
                color: #bebfdf;
            }
            [\:inspect] .inspection-field .item-val{
                margin: 2px 0;
                user-select: initial;
                padding: 10px;
            }
            [\:inspect] .inspection-field .item-type{
                user-select: none;
            }
            [\:inspect] .inspection-field .item-type:not(.item-val){
                margin-top:2px;
            }
            [\:inspect] .inspection-field .item-type:not(.item-array){
                /* display:grid; */
            }
            [\:inspect] .inspection-field .item-object{
                margin: 2px 0;
                display: grid;
                align-items: center;
                padding: 10px;
                width:100%;
            }
            [\:inspect] .inspection-field .item-object .inspection-field{
                background-color: transparent;
                padding: 0;
            }
            [\:inspect] .inspection-field.title{
                font-size: clamp(10px, .85em, 15px);
            }
            [\:inspect] .inspection-field .item-object .inspection-field.title{
                padding: 0 4px;
            }
            [\:inspect] .inspection-field .item-object .item-info{
                margin-top: 2px;
            }
            [\:inspect] .inspection-field .item-object .item-pointer{
                display: none;
            }
            [\:inspect] .inspection-field .item-object > details{
                /* margin-left: -2px; */
            }
            [\:inspect] .inspection-field .item-btn{
                width:100%;
                white-space: nowrap;
            }
            [\:inspect="object"] > div > details > summary {
                margin-left: var(--margin-left);
            }
            [\:inspect] .inspection-field :where(.item-method, .item-property){
                margin-left: 35px;
            }
            [\:inspect] .inspection-field summary{
                user-select: none;
            }
            [\:inspect] .inspection-field details:where(.methods, .properties){
                margin: 5px;
            }
            [\:inspect] .inspection-field summary:where(.methods, .properties){
                margin-left: calc(var(--margin-left) + 10px);
                margin-right: calc(var(--margin-left) + 10px);
            }
            [\:inspect] .inspection-field summary:where(.public, .private, .protected){
                margin-left: 23px;
            }';
    }


    public static function default() {
        
        return self::navy();
    }

    public static function light() {
        return '
        
            [\:inspect], .inspection-field {
                background-color: rgba(247, 247, 247, 0.58);
                color: rgb(44, 48, 55);
            }
            [\:inspect] details.inspection-field :where(.methods, .properties) summary.public {
                background-color: rgb(28, 125, 125);
                color: rgb(255, 255, 255);
            }
            [\:inspect] details.inspection-field :where(.methods, .properties) summary.protected {
                background-color: rgb(159, 101, 59);
                color: rgb(255, 255, 255);
            }
            [\:inspect] details.inspection-field :where(.methods, .properties) summary.private {
                background-color: rgb(174, 30, 50);
                color: rgb(255, 255, 255);
            }
            [\:inspect] .v-btn {
                color: rgb(145, 101, 19);
            }
            [\:inspect] .inspection-field.title {
                color: rgb(145, 101, 19);
                background-color: transparent;
            }
            [\:inspect] .inspection-field.main {
                border: solid 1px #ffffff21;
            }
            [\:inspect] .inspection-field .item-key{
                color: rgb(70, 85, 112);
                background-color: rgba(232, 232, 232, 0.48);
            }
            [\:inspect] .main summary:not(object) ::marker, 
            [\:inspect] .main .item-pointer{
                color:#66778a;
            }
            [\:inspect] .inspection-field .item-info{
                color: #848596;
            }
            [\:inspect] .inspection-field .item-val{
                color: inherit;
                background-color: rgba(241, 241, 241, 0.57);
            }
            [\:inspect] .inspection-field .item-array{
                color:  rgb(145, 99, 12);
            }
            [\:inspect] .inspection-field .item-integer{
                color:  rgb(232, 135, 105);
            }
            [\:inspect] .inspection-field .item-double{
                color:  rgb(232, 135, 105);
            }
            [\:inspect] .inspection-field .item-boolean{
                color: rgb(188, 63, 63);
            }
            [\:inspect] .inspection-field .item-NULL{
                color:  rgb(244, 175, 175);
            }
            [\:inspect] .inspection-field .item-string{
                color:  rgb(0, 127, 32);
            }
            [\:inspect] .inspection-field .item-object{
                color: rgb(161, 145, 60);
            }
            [\:inspect] .inspection-field :where(.item-method, .item-property){
                color: rgb(137, 115, 0);
            }
            [\:inspect] .inspection-field :where(.item-method, .item-property).static{
                color: rgb(35, 50, 64);
                color: rgb(84, 91, 97);
            }
            [\:inspect] .inspection-field :where(.item-method, .item-property).instance{
                color: rgb(130, 112, 17);
            }
            
        ';
    }

    public static function dark() {
        return '
            [\:inspect], .inspection-field {
                background-color: rgb(0, 0, 0);
                color: rgb(255, 255, 255);
            }
            [\:inspect] details.inspection-field :where(.methods, .properties) summary.public {
                background-color: rgb(21, 76, 76);
            }
            [\:inspect] details.inspection-field :where(.methods, .properties) summary.protected {
                background-color: rgb(95, 61, 36);
            }
            [\:inspect] details.inspection-field :where(.methods, .properties) summary.private {
                background-color: rgb(72, 44, 61);
            }
            [\:inspect] .v-btn {
                color: rgb(255, 166, 0);
            }
            [\:inspect] .inspection-field.title {
                color: rgb(255, 165, 0);
            }
            [\:inspect] .inspection-field .item-key{
                color: rgb(159, 176, 204);
                background-color: rgba(47, 60, 77, 0.51);
            }
            [\:inspect] .inspection-field .item-info{
                color: #c19b9b;
            }
            [\:inspect] .inspection-field .item-val{
                color: inherit;
                background-color: rgba(44, 50, 68, 0.39);
            }
            [\:inspect] .inspection-field .item-array{
                color:  rgb(255, 167, 0);
            }
            [\:inspect] .inspection-field .item-integer{
                color:  rgb(232, 135, 105);
            }
            [\:inspect] .inspection-field .item-double{
                color:  rgb(232, 135, 105);
            }
            [\:inspect] .inspection-field .item-boolean{
                color:  rgb(244, 175, 175);
            }
            [\:inspect] .inspection-field .item-NULL{
                color:  rgb(244, 175, 175);
            }
            [\:inspect] .inspection-field .item-string{
                color:  rgb(141, 221, 161);
            }
            [\:inspect] .inspection-field .item-object{
                color: rgb(255, 165, 0);
            }
            [\:inspect] .inspection-field :where(.item-method, .item-property){
                color: rgb(255, 215, 0);
            }
            [\:inspect] .inspection-field :where(.item-method, .item-property).static{
                color: rgb(168, 163, 176);
            }
            [\:inspect] .inspection-field :where(.item-method, .item-property).instance{
                color: rgb(255, 215, 0);
            }
        ';
    }

    public static function contrast() {
        return '
            [\:inspect], .inspection-field {
                background-color: rgb(33, 30, 30);
                color: rgb(255, 255, 255);
            }
            [\:inspect] details.inspection-field :where(.methods, .properties) summary.public {
                background-color: rgb(21, 76, 76);
            }
            [\:inspect] details.inspection-field :where(.methods, .properties) summary.protected {
                background-color: rgb(95, 61, 36);
            }
            [\:inspect] details.inspection-field :where(.methods, .properties) summary.private {
                background-color: rgb(72, 44, 61);
            }
            [\:inspect] .v-btn {
                color: rgb(255, 166, 0);
            }
            [\:inspect] .inspection-field.title {
                color: rgb(255, 165, 0);
            }
            [\:inspect] .inspection-field .item-key{
                color: rgb(159, 176, 204);
                background-color: rgb(43, 43, 55);
            }
            [\:inspect] .inspection-field .item-val{
                color: inherit;
                background-color: rgb(10, 10, 11);
            }
            [\:inspect] .inspection-field .item-array{
                color:  rgb(255, 167, 0);
            }
            [\:inspect] .inspection-field .item-integer{
                color:  rgb(232, 135, 105);
            }
            [\:inspect] .inspection-field .item-double{
                color:  rgb(232, 135, 105);
            }
            [\:inspect] .inspection-field .item-boolean{
                color:  rgb(244, 175, 175);
            }
            [\:inspect] .inspection-field .item-NULL{
                color:  rgb(244, 175, 175);
            }
            [\:inspect] .inspection-field .item-string{
                color:  rgb(141, 221, 161);
            }
            [\:inspect] .inspection-field .item-object{
                color: rgb(255, 165, 0);
                background-color: rgb(39, 39, 51);
            }
            [\:inspect] .inspection-field :where(.item-method, .item-property){
                color: rgb(255, 215, 0);
            }
            [\:inspect] .inspection-field :where(.item-method, .item-property).static{
                color: rgb(168, 163, 176);
            }
            [\:inspect] .inspection-field :where(.item-method, .item-property).instance{
                color: rgb(255, 215, 0);
            }
        ';
    }

    public static function navy() {
        return 
            '
            [\:inspect], .inspection-field {
                background-color: rgb(25, 26, 71);
                color: rgb(255, 255, 255);
            }
            [\:inspect] .inspection-field.main {
                border: solid 1px #1e3383;
            }
            [\:inspect] details.inspection-field :where(.methods, .properties) summary.public {
                background-color: rgb(28, 98, 125);
            }
            [\:inspect] details.inspection-field :where(.methods, .properties) summary.protected {
                background-color: rgb(159, 101, 59);
            }
            [\:inspect] details.inspection-field :where(.methods, .properties) summary.private {
                background-color: rgb(119, 39, 88);
            }
            [\:inspect] .v-btn {
                color: rgb(255, 165, 0);
            }
            [\:inspect] .inspection-field.main {
                border: solid 1px #25275c;
            }                                               
            [\:inspect] .inspection-field.title {
                color: rgb(255, 165, 0);
            }
            [\:inspect] .inspection-field .item-method.none {
                color: rgb(102, 90, 128);
            }
            [\:inspect] .inspection-field .item-key{
                color: rgb(159, 176, 204);
                background-color: rgba(54, 55, 106, 0.51);
            }
            [\:inspect] .inspection-field .item-info{
                color: #bebfdf;
            }
            [\:inspect] .inspection-field .item-val{
                color: inherit;
                background-color: rgb(46, 47, 104);
                background-color: rgba(46, 47, 104, 0.39);
            }
            [\:inspect] .inspection-field .item-pointer{
                color: #8290a6;
            }
            [\:inspect] .inspection-field [dt-type] > summary{
                color:  #939294;
            }
            [\:inspect] .inspection-field .item-array{
                color:  rgb(162, 150, 128);
            }
            [\:inspect] .inspection-field .item-integer{
                color:  rgb(232, 135, 105);
            }
            [\:inspect] .inspection-field .item-double{
                color:  rgb(232, 135, 105);
            }
            [\:inspect] .inspection-field .item-boolean{
                color:  rgb(244, 175, 175);
            }
            [\:inspect] .inspection-field .item-NULL{
                color:  rgb(244, 175, 175);
            }
            [\:inspect] .inspection-field .item-string{
                color:  rgb(141, 221, 161);
            }
            [\:inspect] .inspection-field .item-object{
                color:  rgb(255, 165, 0);
                background-color: rgba(46, 47, 104, 0.39);
            }
            [\:inspect] .inspection-field :where(.item-method, .item-property){
                color: rgb(255, 215, 0);
            }
            [\:inspect] .inspection-field :where(.item-method, .item-property).static{
                color: rgb(168, 163, 176);
            }
            [\:inspect] .inspection-field :where(.item-method, .item-property).instance{
                color: rgb(255, 215, 0);
            }
        ';
    }

    public static function dracula() {
        return 
            '
            [\:inspect], .inspection-field {
                background-color: rgb(31, 19, 59);
                color: rgb(255, 255, 255);
            }
            [\:inspect] .inspection-field.main {
                border: solid 1px #152c40;
            }
            [\:inspect] details.inspection-field :where(.methods, .properties) summary.public {
                background-color: rgb(18, 83, 83);
            }
            [\:inspect] details.inspection-field :where(.methods, .properties) summary.protected {
                background-color: rgb(88, 70, 57);
            }
            [\:inspect] details.inspection-field :where(.methods, .properties) summary.private {
                background-color: rgb(88, 51, 74);
            }
            [\:inspect] .v-btn {
                color: rgb(255, 165, 0);
            }
            [\:inspect] .inspection-field.title {
                color: rgb(255, 165, 0);
            }
            [\:inspect] .inspection-field .item-method.none {
                color: rgb(117, 108, 134);
            }
            [\:inspect] .inspection-field .item-key{
                color: rgb(159, 176, 204);
                background-color: rgba(48, 47, 77, 0.51);
            }
            [\:inspect] .inspection-field .item-info{
                color: #bebfdf;
            }
            [\:inspect] .inspection-field .item-val{
                color: inherit;
                background-color: rgba(44, 45, 68, 0.39);
            }
            [\:inspect] .inspection-field .item-pointer{
                color: #8290a6;
            }
            [\:inspect] .inspection-field [dt-type] > summary{
                color:  #939294;
            }
            [\:inspect] .inspection-field .item-array{
                color:  rgb(162, 150, 128);
            }
            [\:inspect] .inspection-field .item-integer{
                color:  rgb(232, 135, 105);
            }
            [\:inspect] .inspection-field .item-double{
                color:  rgb(232, 135, 105);
            }
            [\:inspect] .inspection-field .item-boolean{
                color:  rgb(244, 175, 175);
            }
            [\:inspect] .inspection-field .item-NULL{
                color:  rgb(244, 175, 175);
            }
            [\:inspect] .inspection-field .item-string{
                color:  rgb(141, 221, 161);
            }
            [\:inspect] .inspection-field .item-object{
                color:  rgb(255, 165, 0);
            }
            [\:inspect] .inspection-field :where(.item-method, .item-property){
                color: rgb(255, 215, 0);
            }
            [\:inspect] .inspection-field :where(.item-method, .item-property).static{
                color: rgb(132, 148, 164);
            }
            [\:inspect] .inspection-field :where(.item-method, .item-property).instance{
                color: rgb(255, 215, 0);
            }
        ';
    }

    public static function maroon() {
        return '
            [\:inspect], .inspection-field {
                background-color: rgb(71, 30, 51);
                color: white;
            }
            [\:inspect] .inspection-field.main {
                border: solid 1px #1e3383;
            }
            [\:inspect] details.inspection-field :where(.methods, .properties) summary.public {
                background-color: rgb(21, 82, 89);
            }
            [\:inspect] details.inspection-field :where(.methods, .properties) summary.protected {
                background-color: rgb(159, 101, 59);
            }
            [\:inspect] details.inspection-field :where(.methods, .properties) summary.private {
                background-color: rgb(119, 39, 88);
            }
            [\:inspect] .v-btn {
                color: rgb(255, 165, 0);
            }
            [\:inspect] .inspection-field.main {
                border: solid 1px #5c2637;
            }
            [\:inspect] .inspection-field.title {
                color: rgb(255, 165, 0);
            }
            [\:inspect] .inspection-field .item-key{
                color: rgb(176, 192, 218);
                background-color: rgba(94, 32, 32, 0.51);
            }
            [\:inspect] .inspection-field .item-pointer{
                color: #be9798;
            }
            [\:inspect] .inspection-field .item-info{
                color: #c19b9b;
            }
            [\:inspect] .inspection-field .item-val{
                color: inherit;
                background-color: rgba(104, 46, 57, 0.39);
            }
            [\:inspect] .inspection-field .item-array{
                color: rgb(255, 167, 0); /* orange */
            }
            [\:inspect] .inspection-field .item-integer{
                color: rgb(232, 135, 105);
            }
            [\:inspect] .inspection-field .item-double{
                color: rgb(232, 135, 105);
            }
            [\:inspect] .inspection-field .item-boolean{
                color: rgb(244, 175, 175);
            }
            [\:inspect] .inspection-field .item-NULL{
                color: rgb(244, 175, 175);
            }
            [\:inspect] .inspection-field .item-string{
                color: rgb(141, 221, 161);
            }
            [\:inspect] .inspection-field .item-object{
                color: rgb(255, 165, 0);
            }
            [\:inspect] .inspection-field :where(.item-method, .item-property){
                color: rgb(255, 215, 0); /* gold */
            }
            [\:inspect] .inspection-field :where(.item-method, .item-property).static{
                color: rgb(168, 163, 176);
            }
            [\:inspect] .inspection-field :where(.item-method, .item-property).instance{
                color: rgb(255, 215, 0);
            }
        ';
    }


}