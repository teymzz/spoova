<style rel="core.custom.templates._metrics.metrics"> 
body[\:\:sensor-open]{
    overflow: hidden;
}
[\:\:sensor].sensor:not(.minimized) {
    position: fixed; 
    top:0 !important;
    left: 0 !important;
    right: 0 !important;
    bottom: 0 !important;
}
[\:\:sensor].sensor {
    all: initial;
    font-family: "Poppins", "Roboto", sans-serif;
    padding: 1em;
    background-color: #3c2148;
    background-image: linear-gradient(#220e2b, #691168c9);
    color : #c6a0c7;
    font-size: 16px;
    z-index: 10000;
    min-height: 100vh;
    height: 100%;
}
[\:\:sensor].sensor .sensor-metrics {
    display: none;
}
[\:\:sensor].sensor.minimized :where(.sensor-metrics, .pro-analysis-pane) {
    display: none;
}
[\:\:sensor].sensor.minimized {
    position: fixed; 
    height: initial;
    top: 0;
    left: 90%;
    bottom: initial;
    min-height: initial;
    border-radius: 100vh;
    background: transparent;
}
[\:\:sensor].sensor.minimized .banner{
    padding: 4px;
    position: fixed;
}
[\:\:sensor].sensor .pro-runtime-pane{
    grid-area: rpane;
}
[\:\:sensor].sensor:not(.minimized) .pro-runtime-pane{
    display: none;
}
[\:\:sensor].sensor.minimized .app-runtime-pane{
    padding: 30px 20px;
    border-radius: 15px;
    outline: rgba(122, 39, 122, 0.698) solid 4px;
    outline-offset: 4px;
    position: fixed;
}
[\:\:sensor].sensor:not(.minimized) .app-runtime-pane{
    min-width: 320px;
    position: relative;
    left: initial !important;
    top: initial !important;
    height: 200px;
    background-image: linear-gradient(#340b3d, #511856);
    border-radius: 5px 5px 5px 5px;
}
[\:\:sensor].sensor.minimized .app-runtime-pane + .processes{
    display: none;
}
[\:\:sensor].sensor:not(.minimized) .app-runtime-pane + .processes {
    padding: 10px 0;
    height: 100%;
}
[\:\:sensor].sensor:not(.minimized) .app-runtime-pane + .processes > * {
    background-image: linear-gradient(#220e2b00, #2d0f2cc9);
    overflow: hidden;
    border-radius: 5px;
    height: 100%;
}
[\:\:sensor].sensor:not(.minimized) .app-runtime-pane + .processes .process-items-header{
    background: #452346b9;
    display: flex;
    text-align: left;
    font-size: 12px;
    padding: 5px 10px;
}
[\:\:sensor].sensor:not(.minimized) .app-runtime-pane + .processes .process-items-header > :first-child{
    width: 100%;
}
[\:\:sensor].sensor:not(.minimized) .app-runtime-pane + .processes .process-items-header > *{
    display: flex;
    color: #ad5bb3;
    align-items: center;
    white-space: nowrap;
}
[\:\:sensor].sensor:not(.minimized) .app-runtime-pane + .processes .process-items-header .square{
    color: #5c2461;
    box-shadow: #221921 0px 0px 3px 2px;
    border-radius: 100vh;
    border: solid 2px;
    cursor: pointer;  
}
[\:\:sensor].sensor:not(.minimized) .app-runtime-pane + .processes .process-items-header .square:active{
    opacity: .5; 
}
[\:\:sensor].sensor:not(.minimized) .app-runtime-pane + .processes .process-items-header .square.active{
    color: #a55290;
    animation: icospin .2s linear infinite;
    -webkit-animation: icospin .2s linear infinite;
}
[\:\:sensor].sensor:not(.minimized) .app-runtime-pane + .processes .process-items-header .square.success{
    color: #c776c7;
}
[\:\:sensor].sensor:not(.minimized) .app-runtime-pane + .processes .process-items-header .spinner{
    border:solid 2px; 
    width: 12px; 
    height: 12px; 
    border-radius: 100vh;
    border-left-color:transparent; 
    border-top-color:transparent; 
    border-bottom-color:transparent;
}
[\:\:sensor].sensor:not(.minimized) .app-runtime-pane + .processes .process-items-header .spinner-dot{
    position: absolute;
    top:0; 
    left:0; 
    transform: translate(150%, 150%);
    width: 4px; 
    height: 4px; 
    background-color: currentColor;
    border-radius: 100vh;
}
[\:\:sensor].sensor:not(.minimized) .app-runtime-pane + .processes .process-items-header .free-memory:active{
    cursor: pointer;
    opacity: .2;
}
[\:\:sensor].sensor:not(.minimized) .app-runtime-pane + .processes .process-items-header button{
    padding: 8px;
    color: rgb(158, 97, 144);
    background: linear-gradient(#462b48,#2f0c30);
    align-self: flex-end;
    border-radius: 50vh;
    white-space: nowrap;
}
[\:\:sensor].sensor:not(.minimized) .app-runtime-pane + .processes .process-items-list {
    font-size: inherit;
    height: calc(100vh - 305px);
    overflow: auto;
}
[\:\:sensor].sensor:not(.minimized) .app-runtime-pane + .processes .process-items-list button:not(.process-name){
    background: #31262661;
    white-space: nowrap;
    color: #d686b1;
    width:100%;
    border-radius: 50vh;
}
[\:\:sensor].sensor:not(.minimized) .app-runtime-pane + .processes .process-items-list button.process-name{
    background: #31262661;
    color: #d686b1;
    overflow-x: auto;
    width:auto;
    width: 100px;
    scrollbar-width: none;
    white-space: nowrap;
    text-align: left;
}
[\:\:sensor].sensor:not(.minimized) .app-runtime-pane + .processes .process-items-list button.process-name::-webkit-scrollbar{
    display: none;
}
[\:\:sensor].sensor:not(.minimized) .app-runtime-pane + .processes table{
    width: 100%;
    border-spacing: 5px;
    border-collapse: separate;
}
[\:\:sensor].sensor:not(.minimized) .app-runtime-pane + .processes table :where(tr){
    padding: 2px;
}
[\:\:sensor].sensor:not(.minimized) .app-runtime-pane + .processes table :where(tr.no-process td){
    padding: 6px;
    color: rgb(186, 154, 187);
}
[\:\:sensor].sensor:not(.minimized) .app-runtime-pane + .processes table :where(tr, td){
    background: transparent;
}
[\:\:sensor].sensor:not(.minimized) .app-runtime-pane + .processes table :where(td:first-child){
    width: 100%;
    background: #4e1e4e;
    border-radius: 2px;
}
[\:\:sensor].sensor:not(.minimized) .app-runtime-pane + .processes table :where(td:nth-child(2)){
    width: 50%;
    background: #481b48;
    border-radius: 2px;
    margin-left: 2px;
}
[\:\:sensor].sensor .app-runtime-pane .bi-arrows-move{
    display: none;
}
[\:\:sensor].sensor.minimized .app-runtime-pane .bi-arrows-move:hover{
    opacity: .5;
}
[\:\:sensor].sensor.minimized .app-runtime-pane .bi-arrows-move:active{
    opacity: .2;
}
[\:\:sensor].sensor.minimized .app-runtime-pane .bi-arrows-move{
    display: block;  
    cursor: move;  
    opacity: .7;
    z-index: 100;
}
[\:\:sensor].sensor .app-runtime{
    cursor: default;
    user-select: none;
}
[\:\:sensor].sensor.minimized .app-runtime:active{
    opacity: .5;
}
[\:\:sensor].sensor code {
    border: none;
}
[\:\:sensor].sensor .rb {
    font-size: .85em;
}
[\:\:sensor].sensor .rb > *{
    background-color: #4d1e4e75;
    color: #e16de5;
    padding: 6px;
    border-radius: 5px;
    box-shadow: #000 #000 #000 inset;
}
[\:\:sensor].sensor:not(.minimized) .banner {
    display: grid;
}
[\:\:sensor].sensor .banner {
    grid-template-areas: 'midpane' 'rpane';
    padding: 20px;
    padding-bottom: 0;
    border-radius: 2vh;
    height: 100%;
}
[\:\:sensor].sensor:not(.minimized) .banner {
    position: relative;
    overflow: auto;
    scrollbar-width: none;
}
[\:\:sensor].sensor:not(.minimized) .banner::-webkit-scrollbar {
    display: none;
}
[\:\:sensor].sensor .sensor-metrics {
    width: 100%;
    position: sticky;
    grid-area: lpane;
    top: 0;
}
[\:\:sensor].sensor .sensor-header {
    text-align: left;
    color: #fe3afb;
}
[\:\:sensor].sensor .route-path {
    max-width: 250px;
}
[\:\:sensor].sensor .web-route .bi-nav {
    font-size: .75em;
}
[\:\:sensor].sensor .web-route.tracker-2 {
    font-size: .65em;
}
[\:\:sensor].sensor  details.trackers > summary::marker {
    content: "⦾";
}
[\:\:sensor].sensor  details[open].trackers > summary::marker {
    content: "⦿";
}
[\:\:sensor].sensor  details.trackers > summary > span {
    position: relative;
    top: 1px;
}
[\:\:sensor].sensor .app-runtime-pane {
    padding: 1em;
    background-image: linear-gradient(#340b3d, #5513560d);
    border-radius: 5px 5px 5px 5px;
}
[\:\:sensor].sensor .app-runtime  {
    border:solid 5px #58185a;
    padding: 2px;
}
[\:\:sensor].sensor .app-runtime > * {
    border-radius: 100vh;
    border: solid 3px #2a0931;
    background-color: #fff;
    color: #e18fb9;
    background-image: linear-gradient(50deg, #4a0b4c,#581258, #3d1045, #48064e);
}
[\:\:sensor] .xh-scroll{
    overflow-x: auto;
    scrollbar-width: none;
}
[\:\:sensor] .xh-scroll::-webkit-scrollbar{
    display: none;
}
[\:\:sensor] .yh-scroll{
    overflow-y: auto;
    scrollbar-width: none;
}
[\:\:sensor] .yh-scroll::-webkit-scrollbar{
    display: none;
}
[\:\:sensor] .xvh-scroll{
    overflow-x: auto;
    overflow-y: auto;
    scrollbar-width: none;
}
[\:\:sensor] .xvh-scroll::-webkit-scrollbar{
    display: none;
}
[\:\:sensor].sensor .runtime-circle {
    display: inline-block;
    border: dotted 4px #461558;
    width: 300px;
    height: 300px;
    animation: runcircle 2s linear infinite;
    transform:translate(-35%, -35%);
    border-radius: 100vh;
    position: absolute;
    top:0; 
    left:0; 
    z-index: 0; 
    background-image: radial-gradient(circle, #80008059, #0f051059);
    background-image: radial-gradient(circle, #3c105059, #42063059);
    box-shadow: 0px 0px 0px 2px #3e0a46, 0px 6px 8px 5px #29082e inset;
}
[\:\:sensor].sensor .runtime-btx{
    position:absolute; 
    right:5px; 
    top:0; 
    font-size: 11px;
    background-color:red; 
    width:20px; 
    height:20px; 
    color:white;
    display: grid;
    place-items: center;
    cursor: pointer;
}
[\:\:sensor].sensor .runtime-btx:active {
    background-color: transparent;
    background-image: none;
}
[\:\:sensor].sensor .runtime-btx .bi{
    position: relative;
    --top: 1.5px;
    left: -1px;
    top: var(--top);
    color: #f679e0;
}
[\:\:sensor].sensor .time-box{
    font-size: .8em;
}
@keyframes runcircle{
    0% {
        transform: translate(-35%, -35%) rotate(360deg);
    }
    100% {
        transform: translate(-35%, -35%) rotate(0deg);
    }
}
[\:\:sensor].sensor .trackers-pane {
    height: auto;
    background-color: #4a184e59;
    padding: 10px;
    border-radius: 5px;
    box-shadow: 0px 0px 2px 2px #501f61;
    border: solid 1px #901388;
    background-image: linear-gradient(#5b145a5c, #330c418a);
}
[\:\:sensor].sensor .trackers-pane .init-config-list table{
    margin-top: 4px;
    color: #da70d3;
}
[\:\:sensor].sensor .trackers-pane .init-config-list table :where(tr){
    padding: 0;
}
[\:\:sensor].sensor .trackers-pane .init-config-list table :where(tr td){
    background-color: #531e57;
    padding: 4px 6px;
    color: inherit;
    font-size: 11px;
}
[\:\:sensor].sensor .tracker-count {
    background-color: rgb(106, 48, 108);
    border-radius: 5px;
    border: solid 3px #780d7861;
    height: 20px;
    min-width: 20px;
    padding: 0 .2em;
    font-family: firacode;
    box-shadow: 0px 13px 11px 0px #1e071e inset;
}
[\:\:sensor].sensor .trackers-list-pane{
    max-height: 90vh;
    overflow-y: auto;
    scrollbar-width: none;
    -ms-overflow-style: none;
}
[\:\:sensor].sensor .trackers-list-pane::-webkit-scrollbar{
    display: none;
}
[\:\:sensor].sensor .trackers-field{
    height: 100%;
}
[\:\:sensor].sensor .time-box {
    width: 70px;
    height: 70px;
}
[\:\:sensor].sensor .pro-analysis-pane  {
    grid-area: midpane;
}
[\:\:sensor].sensor .pro-analysis-pane  .runtime-btn{
    background-color: #320d38;
    background: linear-gradient(#360f3c, #46144c);
    padding: 4px 6px;
    border-radius: 5px;
}
[\:\:sensor].sensor .pro-analysis-pane  .runtime-btn.metrics-live span:first-child [ctrl-ico]{
  margin-top: 2px;
}
[\:\:sensor].sensor .pro-analysis-pane  .runtime-btn .bi-x{
    border-radius: 100vh;
    padding: 2px;
    background: #260723;
}
[\:\:sensor].sensor .pro-analysis-pane .primary-header  {
    padding: 10px 14px;
    font-size: 15px;
    color: #d394d3;
    background: #3c0e41;
    border-radius: 5px 5px 0px 0px;
}
[\:\:sensor].sensor .pro-analysis-pane #primary-menu  {
    user-select: none;
}
[\:\:sensor].sensor .pro-analysis-pane .indicator-header-pane::-webkit-scrollbar{
    display: none;
}
[\:\:sensor].sensor .pro-analysis-pane .indicator-header-pane  {
    scrollbar-width: none;
    -ms-overflow-style: none;
    overflow: auto;
}
[\:\:sensor].sensor .pro-analysis-pane .indicator-header-pane > *  {
    user-select: none;
}
[\:\:sensor].sensor .pro-analysis-pane .pro-analysis-header  {
    color: #a88c9a;
    padding-block: .5em;
    background-image: linear-gradient(#340b3d, #5513560d);
    border-radius: .2em;
    font-size: .95em;
    box-shadow: 0px 0px 4px 0px #2e0537de, 0px 0px 4px 0px #2f0d37cc inset;
}
[\:\:sensor].sensor .pro-analysis-pane .pro-analysis  {
    margin-top: .5em;
    padding-block: .5em;
    background-image: linear-gradient(#340b3d, #5513560d);
    border-radius: .2em;
    min-height: 250px;
}
[\:\:sensor].sensor .pro-analysis-pane .pro-analysis-header > * {

    cursor: pointer;
    padding-inline: 1em;

}
[\:\:sensor].sensor .pro-analysis-pane .pro-analysis-header > *:hover {

    opacity: .5;

}
[\:\:sensor].sensor .pro-analysis-pane .pro-analysis-header > *[checked="checked"] {
    color: #d472dc;
}
[\:\:sensor].sensor .pro-analysis-pane .pro-analysis-header > *:not(:last-child) {

    border-right: groove 2px #4e2f4e;
    
}
[\:\:sensor].sensor .pro-analysis-pane .pro-analysis-header > *:active {

    opacity: .2;

}
[\:\:sensor].sensor .pro-analysis-pane .pro-analysis-header > *[checked="checked"]:hover {
   
    opacity: 1; 

}
[\:\:sensor].sensor .bi-tracked-ico{
    color: #340738;
}
[\:\:sensor].sensor .shutter-info {
    background-color: #401c42;
    background-color: #7b1a81;
    background-image: linear-gradient(#401c4296,#370e3f);
    box-shadow: 0px 0px 5px 0px #290825;
    border-radius: .5em;
}
[\:\:sensor].sensor .shutter-info :where(.s-info code, code)
{
    background-color: rgb(56, 8, 59);
}
[\:\:sensor].sensor .shutter-info .dbcon
{
   color: #e045c3;
}
[\:\:sensor].sensor .controllers-icon {
    color: #672e67;
}
[\:\:sensor].sensor .indicator-pane .note-box {
    background-color: rgb(117, 38, 119); 
    outline: dashed 1px #501e4d; 
    border-radius: 100vh;
    outline-offset: .2em;
    width: 10px;
    height: 10px;
}
[\:\:sensor].sensor .indicator-pane > * {
    white-space: nowrap;
}
[\:\:sensor].sensor .indicator-pane .note-title {
    color: #bb7eb4;
}
[\:\:sensor].sensor .indicator-pane .note-box:where(.db-pane, .map-pane, .shutter-pane) {
    color:rgb(103, 35, 118);
    background-color: #310f38;
    width:auto;
    height:auto;
}
[\:\:sensor].sensor .indicator-pane .note-box:where(.db-pane, .map-pane, .shutter-pane) {
    outline: dashed 1px transparent; 
    outline-offset: .2em;
}
[\:\:sensor].sensor .indicator-pane .note-box.db-pane[active] {
    background-color: trasparent;
}
[\:\:sensor].sensor .tracked-shutter-pane {
    display: flex;
    flex-direction: column;
    gap: .2em;
    font-size: .7em;
    padding: 10px;
    background-color: #3e1045;
    border-radius: .5em;
    box-shadow: 0px 0px 5px 0px #721472 inset;
    border: solid 1px #470e56;
    background-image: linear-gradient(#320e3a7a, #42094287);
}
[\:\:sensor].sensor .tracked-shutter-pane [view-controller] {
    width: 20px;
    height: 20px;
    display: flex;
    justify-content: center;
    align-items: center;
    cursor: pointer;
    border-radius: 14px;
    background-color: #751875b5;  
    background-image: linear-gradient(#d960d91a, #791479);
    box-shadow: 0px 0px 5px 3px #28092f inset, 0px 0px 3px 0px #621078;
    color: #4a0d4a;
    color: #242424;
}
[\:\:sensor].sensor .tracked-shutter-pane i[view-controller][checked="checked"] {
    background-color: #750075b5;
    background-image: linear-gradient(#d960d91a, #791479);
    box-shadow: 0px 0px 5px 3px #28092f inset, 0px 0px 3px 0px #621078;
    color: #ee0ecb;
}
[\:\:sensor].sensor .tracked-controller {
    display: flex;
    align-items: center;
    color: #ba94bb;
    gap: .2em;
    padding: 1em 0;
}
[\:\:sensor].sensor .tracked-shutter-field {
    background-color: #4d154d;
    background-image: linear-gradient(#461446,#3c0e3c);
    box-shadow: 0px 0px 3px 0px #280a30;
    border-radius: 4px;
    width: 100%;
}
[\:\:sensor].sensor .tracked-shutter {
    padding: .5em 1em;
    border-radius: 2px;
    background-color: #4e0f5352;
    background-image: linear-gradient(#501a5869,#5b17658a);
    text-transform: uppercase;
}
[\:\:sensor].sensor .tracked-shutter .route-list-pane{
    text-transform: none;
    background-color: transparent;
    background-image: linear-gradient(#5111575e, #1e0a1d5c);
    padding: 1em;
}
[\:\:sensor].sensor .tracked-url {
    padding: 1.2em;
}
[\:\:sensor].sensor .tracked-shutter.shutter-buttons {
    cursor: pointer;
    border: solid 1px #460b46;
    display: flex;
    gap: .2em;
}
[\:\:sensor].sensor .tracked-shutter.shutter-buttons:active {
    opacity: .5;
}
[\:\:sensor].sensor .tracked-shutter.shutter-buttons[checked="checked"] .bi-play{
    display: inline-flex;
    height: 17px;
}
[\:\:sensor].sensor .controllers-indicator{
    display: flex;
    gap: .2em;
}
[\:\:sensor].sensor .controllers-indicator .shutter-level{
    background-color: #43164e; 
    border-radius: .2em;
    padding: 2px 6px;
}
[\:\:sensor].sensor .indicator-light {
    width: 25px;
    height: 6px;
    padding: .15em;
    color:rgb(99, 8, 88);
    border: solid 1px currentColor;
}
[\:\:sensor].sensor .indicator-light .indicator{
    width: 100%;
    height: 100%;
    background-color: currentColor;
}
[\:\:sensor].sensor .indicator-light[active]{
    color: orange;
    border: solid 1px rgb(99, 8, 88);
}
[\:\:sensor].sensor .indicator-light.low[active]{
    color: #df2102;
}
[\:\:sensor].sensor .indicator-light.high[active]{
    color:rgb(17, 223, 2);
}
[\:\:sensor].sensor .indicator-light.med[active]{
    color:rgb(223, 216, 2);
}
[\:\:sensor].sensor .indicator-light[active] .indicator{
    background-color: currentColor;
}
[\:\:sensor].sensor .caller-list-pane {
    font-size: .95em;
    display: flex;
    flex-direction: column;
    gap: .5em;
}
[\:\:sensor].sensor .caller-list-pane > [data-role="checkbox-list"] {
    flex-wrap: wrap; 
    gap: .2rem !important;
}
[\:\:sensor].sensor .metrics-disabled {
    border-radius: .3em;
    box-shadow: 0px 0px 7px 4px #000 inset,0px 0px 3px 4px #310c36;
}
[\:\:sensor].sensor .metrics-code-help {
    background-color: #61246100;
    background-image: linear-gradient(#561e5038 , #4b244e);   
}
[\:\:sensor].sensor .metrics-code-help-header {
    background-color: #551055b5;
}
[\:\:sensor].sensor .memory-analysis.shutter-info code {
    background-color: #331131;
}
[\:\:sensor].sensor .sql-info {
    background-color: #3f1543;
    outline: solid 1px #67126f;
    outline-offset: .25em;
    padding: 4px;
}
[\:\:sensor].sensor .sql-info > span:nth-child(2){
    font-size: .85em;
}
[\:\:sensor].sensor .sql-icon {
    padding: 4px;
    display: inline-block;
    background-color: #591b63;
}
[\:\:sensor].sensor .bi-arrow-right-short {
    font-size: 1.5em;
}
[\:\:sensor].sensor .sense-route{
    border: dashed 1px purple;
    color: #ab6dab;
    padding: 10px;
    border-radius: 5px
}
[\:\:sensor].sensor .dock {
    position: relative;
    left: 42%;
    top: 5%;
}
[\:\:sensor].sensor .dock > [spoova-role="live-control"] {
    background-image: linear-gradient(rgb(57 16 65 / 60%), rgb(49 10 41));
    outline: dotted 2px #510651;
    outline-offset: 2px;
    color: #e786cc;
    box-shadow: 0px 0px 13px 0px #4a0d4a inset;
    top: 0 !important;
    bottom: 0 !important;
    position: relative !important;
}
[\:\:sensor].sensor.minimized .dock {
    left: 5%;
}
[\:\:sensor].sensor.minimized:has([spoova-role="live-control"]) .mover#x {
    left: 175% !important;
    top: 105px !important;
    cursor: grab;
    color: #d259d2 !important;
}
@media screen and (min-width: 1040px) {
    [\:\:sensor].sensor .pro-analysis-pane .primary-header  {
        display: none;
    }
    
    [\:\:sensor].sensor:not(.minimized) .sensor-metrics {
        display: block;
    }
    [\:\:sensor].sensor:not(.minimized) .banner {
        display: grid;
        grid-template-areas: 'lpane midpane rpane';
        grid-template-columns: 2fr minmax(400px, 4fr) 2fr;
    }
    [\:\:sensor].sensor:not(.minimized) .pro-runtime-pane{
        display: block;
    }
    [\:\:sensor].sensor:not(.minimized) .banner {
        overflow: hidden;
    }
}
 </style>

<?= Rexit::load('intervalJS') ?>
<style>
    body {
        font-family: Arial;
        background-color: #3452b2ff;
        color: white;
    }
    table {
        border: hidden;
        width: 90%; 
        margin: auto;
        text-align: left;
        white-space: wordwrap;
    }
    th, td {
        white-space: wordwrap; 
        font-size: .75em;
        width: 120px;
    }
    button {
        padding: 5px 10px;
        font-style: calibri;
        border: hidden;
        border-radius: 2px;
    }
</style>
<?php if($overlay): ?>
<style>
    [\:\:sensor].sensor {
        z-index: <?= $overlay ?? '' ?>;
    }
</style>
<?php endif; ?>
<?= Rexit::ss(':headers','selector', 'switcher', 'checkBox', 'itemDragger') ?>
<?php use \spoova\mi\core\classes\Sensor\SensorBase; ?>
<?php use \spoova\mi\core\tools\BytesConverter; ?>
<?php use \spoova\mi\core\classes\DB; ?>
<?php use \spoova\mi\core\classes\Init; ?>
<?php use \spoova\mi\core\classes\Livescript; ?>
<div class="sensor vhm-50 moveable" ::sensor hidden>
    <div class="banner gap-4">
        <div class="sensor-metrics f-col wid-full">
            <div class="font-em-1d5 sensor-header poppins">Sensor metrics</div>
            <div class="calibri flex-col wid-full">
                <div class="flex gap-1 rb midv web-route no-wrap"> 
                    <span class="route-button"><i class="bi-globe"></i> Route</span> 
                    <div class="route-path no-wrap xvh-scroll"><?= Rexit::navico($route.':bi-chevron-compact-right bi-nav') ?></div>
                </div>
            </div> <br>
            <div class="flex midv pxs-6 sense-route gap-2 poppins">
                <?php 
                  $state404 = '404 Page not found!';
                  $state200 = '200 Page resolved';
                  $ico = Window::isShut()? 'bi-exclamation-triangle' : 'bi-window-dock bi-error';
                  $state = Window::isShut()? $state404 : $state200;
                ?>
                <?php echo "<i class='$ico'></i> $state"; ?>
                <!-- {{ Window::isShut()? '<i class="bi-exclamation-triangle"></i> '.$state404 : '<i class="bi-window-dock bi-error"></i> '.$state200 }} -->
            </div><br>
            <div class="flex-col gap-2">
                <div class="flex-col trackers-pane">
                    <div class="font-em-d85">
                        <details open class="trackers">
                            <summary class="firacode text-upps">
                                <span class="">Controllers (Routes)</span>
                            </summary>
                            <div class="font-em-d85 pxs-12 mvt-6">
                                <?php for($x = 0; $x <= count($controllers)-1; $x++): ?>
                                    <?php $ico = $x == 0 ? ' bi-square-fill ' : ' bi-circle-fill ' ?>
                                    <?php $ico = $controllers[$x] === 'closure()' ? ' bi-arrow-right-short ' : $ico ?>
                                    <div class="fira flex midv gap-1 pxs-4 pxl-<?php echo $controllers[$x] === 'closure()' ? 16 : 4; ?> ">
                                        <span class="flex mid"> <i class="controllers-icon<?php echo $ico; ?>font-em-d7"></i> </span>
                                        <?php 
                                            $controller = $controllers[$x]; $scheme = scheme('Windows\Routes', false); 
                                        ?>
                                        <span class="flex mid"><?php echo ltrim(str_ireplace($scheme, '', $controller),'\\'); ?></span>
                                    </div>
                                <?php endfor; ?>
                            </div>
                        </details>
                    </div>
                </div>
                                                    
                <div class="flex-col trackers-pane">
                    <div class="font-em-d85">
                        <details class="trackers shutters">
                            <summary class="firacode">
                                <span>
                                    SHUTTERS <span class="in-flex mid tracker-count"><?php echo count($shutters);; ?></span>
                                </span>
                            </summary>
                            <div class="font-em-d85 pxl-14 fira">
                                <?php $shutter['total'] = 0 ?>
                                <?php for($x = 0; $x <= count($shutters)-1; $x++): ?>
                                    <details class="mvt-6 f-col gap-1">  
                                        <summary class="text-uppercase">
                                             <?php $shutter['methods'] = count($shutters) ?>
                                             <?php echo $shutters[$x][0];; ?><i class="bi-hash"></i><?php echo count($shutters[$x][1]);; ?> <br>
                                             <?php $shutter['total'] += count($shutters[$x][1]) ?>
                                        </summary>
                                        <div class="trackers-list-pane">
                                            <div class="flex-col pxs-10 gap-1">
                                                <?php for($y = 0; $y < count($shutters[$x][1]); $y++): ?>
                                                    <div class="fira trackers-list pxl-6 no-wrap flex midv gap-1 flow-hide">
                                                        <?php $rname = array_keys($shutters[$x][1])[$y] ?>
                                                        <i class="bi-dot font-em-d9"></i> <?php echo trim($rname)? $rname : '[:main]'; ?>
                                                    </div>
                                                <?php endfor; ?>
                                            </div>
                                        </div>
                                    </details>
                                <?php endfor; ?>
                            </div>
                        </details>
                    </div>
                </div>
                <div class="flex-col trackers-pane">
                    <div class="font-em-d85">
                        <details class="trackers shutters">
                            <summary class="firacode">
                                <span>APP CONFIGURATION</span>
                            </summary>
                            <div class="font-em-d85 pxs-10">
                                <div class="init-config-list">
                                    <table>
                                        <tr>
                                            <td>LIVE SERVER MODE</td>
                                            <td><?php echo Livescript::key('CONTROLS') ?? '--NIL--'; ?></td>
                                        </tr>
                                        <tr>
                                            <td>RESOURCE HANDLER</td>
                                            <td><?php echo Init::key('RESOURCE_HANDLER') ?? '--NIL--'; ?></td>
                                        </tr>
                                        <tr>
                                            <td>LIVE STATE RUNTIME</td>
                                            <td>
                                                <?php $LiveTime = Init::key('LIVE_STATE_RUNTIME') ?? 0 ?>
                                                <?php echo toSuffix($LiveTime, 'millisecs', '0', $LiveTime); ?>
                                            </td>
                                        </tr>
                                    </table>
                                </div>
                                <!-- @if($metrics_mode === 0):
                                <div class="metrics-code-help-header pxv-10">
                                    Database metrics is not enabled yet. Information 
                                    about database queries will not be available.
                                </div>
                                @endif; -->
                                <!-- @loop($x: 0 -> count($shutters)-1):
                                    ::{{ $shutters[$x][0]; }} <br>
                                @endloop; -->
                            </div>
                        </details>
                    </div>
                </div>
            </div>
        </div>
        <div class="pro-analysis-pane">
            <div class="primary-header sensor-metrics-2">
                <div class="">
                    <i class="bi-speedometer"></i> Sensor metrics
                </div>
                <div class="flex">
                    <div class="flex gap-1 rb midv web-route tracker-2 no-wrap"> 
                        <span class="route-button"><i class="bi-globe"></i> Route</span> 
                        <div class="route-path no-wrap xvh-scroll"><?= Rexit::navico($route.':bi-chevron-compact-right bi-nav') ?></div>
                    </div>
                    <div class="flex-full gap-1 flex-r">
                        <span class="runtime-btn flex f-col font-12">
                            <span class="flex mid gap-1"> Runtime <i class="bi-x runtime-btx-2 flex mid px-15"></i></span>
                            <span class="font-10 flex midv"><?= $runtime ?? '' ?></span>
                        </span>  
                        <span hidden class="runtime-btn metrics-live flex f-col font-12" ::metrics-live>
                            <span class="flex midv gap-1"> Live <i class="bi-play" ctrl-ico></i></span>
                            <span class="font-10 flex midv">mode: <?php echo Livescript::key('CONTROLS') ?? 'default'; ?></span>
                        </span>  
                    </div>
                </div>
            </div>
            <div id="primary-menu" class="pro-analysis-header flex text-uppercase" data-role="checkbox-list" data-bind="radio">
                <div class="flex" data-role="checkbox" active>
                    <div menu-list>
                        <i class="bi-person-fill-gear"></i> Controllers
                    </div>
                    <input type="checkbox" checked="true">
                </div>
                <div class="flex" data-role="checkbox">
                    <div menu-list>
                        <i class="bi-database-gear"></i> Queries
                    </div>
                    <input type="checkbox" checked="false">
                </div>
                <div class="flex" data-role="checkbox">
                    <div menu-list>
                        <i class="bi-sd-card"></i>  Memory
                    </div>
                    <input type="checkbox" checked="false">
                </div>
                <div class="flex" data-role="checkbox">
                    <div menu-list>
                        <i class="bi-cpu"></i> CPU
                    </div>
                    <input type="checkbox" checked="false">
                </div>
            </div>
            <div class="pro-analysis">

                <!-- project indicator header -->
                <div class="flex pxv-4 indicator-header-pane">
                    <div class="flex midv indicator-pane">
                        <div class="flex mid gap-2 pxl-10 pxr-5">
                            <div class="note-box project-pane grid-center">
                                
                            </div>
                            <div class="note-title font-em-d7">Project :</div>
                        </div>
                        <div class="font-em-d7"><?php echo $logic;; ?></div>
                    </div>
                    <div class="flex midv indicator-pane">
                        <div class="flex mid gap-2 pxl-10 pxr-5">
                            <div class="note-box map-pane grid-center">
                                <i class="bi-braces-asterisk flex mid"></i>
                            </div>
                            <div class="note-title font-em-d7">Map :</div>
                        </div>
                        <div class="font-em-d7"><?php echo \spoova\mi\core\server\Serve::mapped() ? 'mapped' : 'unmapped'; ?></div>
                    </div>
                    <div class="flex midv indicator-pane">
                        <div class="flex mid gap-2 pxl-10 pxr-5">
                            <div class="note-box db-pane grid-center"<?php echo $dbstatus? ' active': '';; ?>>
                                <?php if($dbstatus): ?>
                                    <i class="bi-database-check flex mid"></i>
                                <?php else: ?>
                                    <i class="bi-database-x flex mid"></i>
                                <?php endif; ?>
                            </div>
                            <div class="note-title font-em-d7">DB :</div>
                        </div>
                        <div class="font-em-d7"><?php echo $dbstatus;; ?></div>
                    </div>
                    <div class="flex midv indicator-pane">
                        <?php 
                            $calls = round($shutter['methods'] / $shutter['total'] * 100, 2);
                        ?>
                        <div class="flex mid gap-2 pxl-10 pxr-5">
                            <div class="note-box shutter-pane grid-center">
                                <?php if($dbstatus): ?>
                                    <i class="bi-shield-lock flex mid"></i>
                                <?php else: ?>
                                    <i class="bi-x flex mid"></i>
                                <?php endif; ?>
                            </div>
                            <div class="note-title font-em-d7">Shutters :</div>
                        </div>
                        <div class="font-em-d7"><?php echo $calls; ?>%</div>
                    </div>
                    <div class="">
                        <div class="flex-full flex-rt pxs-6 font-em-d65 controllers-indicator">
                            <div class="shutter-level pxs-4">
                                <div class="flex mid gap-1">Best<?php echo ($calls > 55) ? '<i class="flex mid bi-patch-check"></i>' : ''; ?></div>
                            </div>
                            <div class="shutter-level pxs-4">
                                <div class="flex mid gap-1">Average
                                    <?php echo (($calls < 55) && ($calls > 30)) ? '<i class="flex mid bi-patch-check"></i>' : ''; ?>
                                </div>
                            </div>
                            <div class="shutter-level pxs-4">
                                <div class="flex mid gap-1">Poor
                                    <?php echo ($calls < 30) ? '<i class="flex mid bi-patch-check"></i>' : ''; ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="trackers-field route-controllers trackers-list-pane">
                    <div class="pxv-6">
                        <?php if($calls < 50): ?>
                            <div class="shutter-info font-em-d7 pxv-10">
                                <i class="bi-exclamation-triangle"></i> Project shutters are running low at <code class=""><?php echo $calls;; ?>%</code>. Consider using 
                                <code>trunk()</code> to keep this above 50% for a better performance.
                            </div>
                        <?php elseif($calls <= 55): ?>
                            <div class="shutter-info font-em-d7 pxv-10">
                                <i class="bi-exclamation-circle"></i> Project shutters are running averagely at <code><?php echo $calls;; ?>%</code>. You can improve this performance through <code>trunk()</code>. Learn more.
                            </div>
                        <?php else: ?> 
                            <div class="shutter-info font-em-d7 pxv-10">
                                <i class="bi-exclamation-circle"></i> Project shutters seems to be running fine.  
                                <?php if(count($controllers) > 5): ?>
                                    However calling multiple controllers may still impact your project performance.
                                <?php endif; ?>
                            </div>
                        <?php endif; ?>
                    </div>
                    <div class="flex-col fira pxs-6 gap-1">
                        <?php $h = -1; ?>
                        <?php foreach($trackers as $tracker => $shutters): ?>
                            <?php $i = 1; $h++; ?>
                            <div class="tracked-shutter-pane"> 
                                <div class="tracked-controller flex gap-1">
                                    <div class="view-contoller flex gap-1" >
                                        <i view-controller class="bi-<?php echo $h ? 'circle-fill' : 'circle'; ?>" source="bi-circle|bi-circle" data-assign="checked|source|class"></i> 
                                        <input type="checkbox" checked="false">
                                    </div>
                                    <?php echo unscheme(to_namespace($tracker, false));; ?> [<?php echo count($shutters); ?>] <br>
                                </div>
                                <div hidden class="tracked-shutter caller-list-pane">
                                    <div class="flex gap-1" data-role="checkbox-list" data-bind="radio">
                                        <?php foreach($shutters as $shutter): ?>
                                            <?php foreach($shutter as $call => $handler): ?>
                                                <div id="track-<?php echo $i; ?>"  checked="<?php echo $i === 1 ? 'checked' : 'unchecked'; ?>" class="tracked-shutter shutter-buttons" data-role="checkbox">
                                                    <div class="flex gap-1" checkbox data-color="@white|#fa27ed" data-flip="true">
                                                        <i class="bi-play flex mid" marker></i>
                                                        <i class="bi-play-fill flex mid" marker></i>
                                                        <?php echo $call; ?>
                                                    </div>
                                                    <input type="checkbox" checked="<?php echo $i === 1 ? 'true' : 'false'; ?>">
                                                </div>
                                                <?php $tracked['track-field-'.$i] = is_string($handler)? str_replace('-','_',$handler) : $handler; $i++ ?>
                                            <?php endforeach; ?>
                                        <?php endforeach; ?>
                                    </div>
                                    <div class="flex-col">
                                        <?php for($t = 1; $t <= count($tracked); $t++): ?>
                                            
                                            <div <?php echo $t !== 1 ? 'hidden' : ''; ?> track-id="track-field-<?php echo $t; ?>" class="tracked-shutter route-list-pane">
                                            <?php foreach($tracked['track-field-'.$t] as $route => $routeHandler): ?>
                                                <div class="route-list">
                                                    <i class="bi-dot"></i> 
                                                    <?php echo $route?: '[:main]'; ?> -> <?php echo is_closure($routeHandler)? 'closure()' : (is_object($routeHandler)? get_class($routeHandler) : $routeHandler ); ?>
                                                </div>
                                            <?php endforeach; ?>
                                            <?php echo $tracked['track-field-'.$t] ? '' : '[:pending]'; ?>
                                            </div>
    
                                        <?php endfor; ?>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>
                <div hidden class="trackers-field queries pxv-6 flex-col gap-1">
                    <?php use spoova\mi\core\classes\Enums\inflect; ?>
                    <?php if($queries ?? ''): ?>
                        
                        <div class="shutter-info font-em-d7 pxv-10 flex midv">
                            <div class="s-info flex-full midv">
                                <span>
                                    <i class="bi-exclamation-circle"></i> Page loaded with <code class="pxs-6"><?php echo count($queries); ?></code> detected sql <?php echo inflect(['query','queries'], count($queries), inflect::smart); ?>
                                </span>
                            </div>
                            <div class="flex mid">
                                <code class="pxs-6 dbcon flex gap-1 midv"><i class="bi-server"></i><?php echo join(',',DB::DBCON()); ?></code>
                            </div>
                        </div>
                        <?php foreach($queries as $query => $info): ?>
                            <div class="font-em-d7 tracked-shutter">
                                <div class="pvs-10">
                                    <div class="sql-info">
                                        <span class="sql-icon">
                                            <i class="bi-server"></i> 
                                        </span>
                                        <span>
                                            <?php echo $info['query']; ?>
                                        </span>
                                    </div>
                                </div>
                                <div class="flex midv gap-1">
                                    <div class="">
                                       <?php echo $info['response']; ?>
                                    </div>
                                </div>
                                <div class="flex flex-r f-col">
                                    <div class="text-right">
                                       <?php echo $info['status']; ?>
                                    </div>
                                    <div class="text-right font-em-d8"> 
                                    <?php echo $info['conName']; ?> | Time: <?php echo $info['timeframe']; ?>secs
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <div class="pxv-6">
                            No database queries currently detected!
                        </div>
                        <?php if($metrics_mode === 0): ?>
                        <div class="font-em-d8 metrics-disabled flow-hide">
                            <div class="metrics-code-help-header flex midv gap-1 pxv-10">
                                <i class="bi-exclamation-circle flex mid"></i> Database metrics is not enabled in your project application.
                            </div>
                            <div class="metrics-code-help font-em-d9">
                                <div class=" pxv-20">
                                    You can enable this through your code or globally through init configuration file. 
                                    <span class="rule-dotted c-orange" style="color: #d563df;">Learn more</span>
                                </div>
                            </div>
                        </div>
                        <?php endif; ?>
                    <?php endif; ?>
                </div>
                <div hidden class="trackers-field flex-col gap-1 memory pxv-6">
                    <?php if($processes): ?>
                        <div class="shutter-info font-em-d7 pxv-10">
                            <i class="bi-exclamation-circle"></i> You are currently using <code class="pxs-6"><?php echo $memory['percent-used'];; ?>%</code> memory on your device. 
                            <?php if($memory['percent-used'] > 70): ?>
                                Too high usage will impact your project application's performance.
                            <?php elseif($memory['percent-used'] > 55): ?>
                                High usage may impact your project application's performance.
                            <?php elseif($memory['percent-used'] >= 40): ?>
                                This performance is good for your project application.
                            <?php endif; ?>
                        </div>
                        <div class="shutter-info memory-analysis font-em-d7 pxv-10">
                            <div class="pxv-10">
                                <div class="">
                                    <div class="flex-col gap-1">
                                        <div class="flex" style="width: 100%">
                                            <div class="flex-col flex-full gap-2">
                                                <div class="">Allocated memory</div>
                                                <div class="">Total <code><?php echo $memory['total'];; ?></code></div>
                                            </div>
                                            <div class="flex-col flex-full gap-2">
                                                <div class="">Percent allocation</div>
                                                <div class="">100%</div>
                                            </div>
                                            <div class="flex-col flex-full gap-2">
                                                <div class="">Ratings</div>
                                                <div class=""><i>Not available</i></div>
                                            </div>
                                        </div>
                                        <div class="flex stretch" style="width: 100%">
                                            <div class="flex midv flex-full gap-1">
                                                <div class="">Used</div>
                                                <div class=""><code><?php echo $memory['used'];; ?></code></div>
                                            </div>
                                            <div class="flex-col flex-full">
                                                <div class=""><?php echo $memory['percent-used'];; ?>%</div>
                                            </div>
                                            <div class="flex-col flex-full">
                                                <div class=""><?php echo $memstat($memory['percent-used']);; ?></div>
                                            </div>
                                        </div>
                                        <div class="flex stretch" style="width: 100%">
                                            <div class="flex midv flex-full gap-1">
                                                <div class="">Free</div>
                                                <div class=""><code><?php echo $memory['free'];; ?></code></div>
                                            </div>
                                            <div class="flex-col flex-full">
                                                <div class=""><?php echo $memory['percent-free'];; ?>%</div>
                                            </div>
                                            <div class="flex-col flex-full">
                                                <div class=""><?php echo $memstat($memory['percent-free']);; ?></div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php else: ?>
                        <div class="shutter-info font-em-d7 pxv-10">
                            <i class="bi-exclamation-circle"></i> Sensor cannot retrieve memory information of this device. Ensure you are 
                            running on windows operating system or you have essential permission to retrieve device information on your <?php echo getOs(); ?> device.
                        </div>
                    <?php endif; ?>
                </div>
                <div hidden class="trackers-field flex-col gap-1 cpu pxv-6">
                    <?php if($processes): ?>
                        <div class="shutter-info font-em-d7 pxv-10">
                            <i class="bi-exclamation-circle"></i> <?php echo count($processes); ?> apps are running processes above <code class="pxs-6"><?php echo $procs_scale; ?></code> on your device.  
                            This may impact your application's performance.
                        </div>
                        <div class="shutter-info font-em-d7 pxv-10">
                            <div class="pxv-10">
                                <?php foreach($processes as $p => $v): ?>
                                    <div class="">
                                        <div class="flex gap-1">
                                            <div class="" style="width: 50%"><?php echo $p;; ?></div>
                                            <div class="" style="width: 50%"><?php echo $v;; ?></div>
                                            <div class="no-wrap" style="width: 50%">
                                                <!-- {{ $procs_map[$p] }}  -->
                                                Processes id <i class="bi-arrow-right"></i>
                                                [<?php echo implode(', ',$procs_id[$p]); ?>]
                                            </div>
                                            <div class="no-wrap" style="width: 50%"></div>
                                        </div>
                                    </div>
                                <?php endforeach; ?>
                            </div>
                        </div>
                    <?php else: ?>
                        <div class="shutter-info font-em-d7 pxv-10">
                            <i class="bi-exclamation-circle"></i> Sensor cannot retrieve os information on this device. Ensure you are 
                            running on windows operating system or you have essential permission to retrieve device information on your <?php echo getOs(); ?> device.
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
        <div class="pro-runtime-pane">
            <div class="flex flex-lt app-runtime-pane flow-hide relative">
                <div class="upper-section">
                    <span id="x" type="checkbox" class="bi-arrows-move mover relative" style="left:90%; top:-20px"></span>
                    <div class="rad-r app-runtime relative flow-hide"  style="z-index: 2;">
                        <div class="">
                            <div class="grid-center text-center relative time-box">
                                <div class="center">
                                    <span class="text-uppercase">RUNTIME</span>
                                    <span class="runtime"><?= $runtime ?? '' ?></span>  
                                </div>
                            </div>
                        </div>
                        <div class="runtime-btx">
                            <i class="bi bi-x"></i>
                        </div>
                    </div>
                    <div class="runtime-circle"></div>
                </div>
                <!-- <div class="">
                    Hey there...
                </div> -->
                <!-- <div class="">
                    <div class="px-100 grid-center">
                        <div class="">
                            <div class="">Device memory</div>
                            <div class="flex">
                                <span class="total">total {{ $memory['total'] }}</span>
                                <span class="free">free {{ $memory['free'] }}</span>
                                <span class="used">used {{ $memory['used'] }}</span>
                            </div>
                        </div>
                    </div>
                </div> -->
                <div class="dock" ::sp-dock=""></div>
            </div>
            <div class="processes">
                <div class="">
                    <div class="process-items-header">
                        <div class="">High Processes</div>
                            <div class="gap-1"><div class="square px-20 relative rad-r bd-2 flex mid">
                                    <div class="spinner-dot"></div>
                                    <div class="spinner"></div>
                            </div>
                            <button class="free-memory">Free memory</button>
                        </div>
                    </div>
                    <div class="process-items-list">
                        <table id="processTable" class="process-item wid-full">
                            <!-- {{: $processes = SensorBase::senseProcesses(); }} -->
                             <tbody>
                                <?php $processes = null ?>

                                <!-- @if($processes):
                                    @each($processes['apps'] as $process):
                                        <tr class="flex">
                                            <td><button class="process-name">{{ str_replace('.exe', '', $process['name']) }}</button></td>
                                            <td><button>{{ $process['total_memory_kb'] }}</button></td>
                                        </tr>
                                    @endeach;
                                @endif; -->

                                <?php if(!$processes): ?>
                                    <tr class="no-process">
                                     <td><i class="bi-exclamation-circle"></i> NO PROCESSES FOUND</td> 
                                    </tr>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php if(!$processes): ?>
    <script>

        // defined variables to prevent long polls for memory state.
        let mem_poll_max = 5;
        let mem_poll_count = 0;
        
        let fm = document.querySelector('.free-memory'); 
        let trim = false;

        // defined to trim memory cache
        async function trimMemory(pid, type) {
            trim = true;
            let xuri = "<?php echo uri; ?>";
            xuri = xuri.replace(/\?.*/,'');
            xuri = xuri+'?ssmetrix='+xuri+'&ssmetrim=true';
            const res = await fetch(xuri, {headers: {'X-Requested-With':'XMLHttpRequest'}});

            if(res.headers.get('content-type') === 'application/json'){
                const data = await res.json();
                if (data.status === 'ok') {
                    fm.closest('.process-items-header').querySelector('.square').classList.remove('active');
                    fm.closest('.process-items-header').querySelector('.square').classList.add('success');
                    setTimeout(()=>{
                        fm.closest('.process-items-header').querySelector('.square').classList.remove('success');
                    },2000)
                    fetchProcesses(); // Refresh after trimming
                } else {
                    // failed to trim memory
                    fm.closest('.process-items-header').querySelector('.square').classList.remove('active');
                }
            }
            trim = false;
        }
        
        // button event to trim memory
        fm.addEventListener('click',function(element){
            if(!trim){
                fm.closest('.process-items-header').querySelector('.square').classList.add('active');
                trimMemory();
                if(mem_poll_count > mem_poll_max){
                    mem_poll_count = 0;
                    memory_poll();
                }
            }
        })
        let action = 'list'; let termination = false;

        // defined function to fetch memory processes
        async function fetchProcesses() {
            let xuri = "<?php echo uri; ?>";
            xuri = xuri.replace(/\?.*/,'');
            xuri = xuri+'?ssmetrix='+xuri;
            const res = await fetch(xuri, {headers: {'X-Requested-With':'XMLHttpRequest'}});
            const responseType = res.headers.get('content-type');
            const responseText = await res.text();
            
            if(responseType === 'application/json'){
                // const data = await res.json();

                try{
                    const data = JSON.parse(responseText);
                    const tbody = document.querySelector('#processTable tbody');
                    tbody.innerHTML = '';
        
                    if(data.apps){
                        data.apps.forEach(p => {
                            const tr = document.createElement('tr');
                            tr.setAttribute('class','flex');
                            if(action === 'list'){
                                tr.innerHTML = `
                                    <td><button class="process-name">${p.name}</button></td>
                                    <td><button>${p.total_memory_kb}</button></td>
                                `;
                                tbody.appendChild(tr);
                            }else{
                                tr.innerHTML = `
                                    <td><button class="process-name">${p.name}>/button></td>
                                    <td><button>${p.total_memory_kb}</button></td>
                                `;
                                tbody.appendChild(tr);
                            }
                        });
                    }else{
                        const tr = document.createElement('tr');
                            tr.setAttribute('class','flex');
                            tr.innerHTML = `
                                    <td>No processes detected.</td>
                                `;
                            tbody.appendChild(tr);
                    }
                }catch{
                    console.error('JSON response format expected.')
                    termination = true;
                }

                
            } else{
                termination = true;
                console.error('Memory response data error')
            }

        }
    </script>
    <script type="module">
        let interval = ss.interval(), timeout;
        window.memory_poll = () => {
            timeout = interval.start(() => {
                fetchProcesses();
                if(!termination) {
                    if(mem_poll_count <= mem_poll_max) timeout.recall(10000);
                } 
                mem_poll_count++;
            });
        }
        memory_poll()
    </script>
<?php endif; ?>

<script>

window.addEventListener('load', function(){ 
    let spoova_sensor_menu_toggler = ss.checkBox(false);
    let spoova_sensor_selector = '['+CSS.escape('::sensor')+']';

    spoova_sensor_menu_toggler.check({

        target: spoova_sensor_selector + ' [checkbox]', //custom box selector,
        toggle: (props) => {

            if(props.checked){
                
                $trackedItem = `[track-id="track-field-${props.listId}"]`;
                $parent = props.checkList;
                $field = $parent.closest('.tracked-shutter');
                $($field).find('[track-id]').attr({'hidden':'hidden'});
                $($field).find($trackedItem).removeAttr('hidden');

            }

        }

    });

    spoova_sensor_menu_toggler.check({

        target: spoova_sensor_selector + ' [view-controller]', //custom box selector,
        toggle: (props) => {

            $trackedItem = `.caller-list-pane`;
            $checkbox = props.custom;
            $field = $checkbox.closest('.tracked-shutter-pane');

            if(props.checked){

                $($field).find($trackedItem).removeAttr('hidden');
                
            }else{
                $($field).find($trackedItem).attr({'hidden':'hidden'});
            }

        }

    });

    spoova_sensor_menu_toggler.check({

        target: spoova_sensor_selector + ' [menu-list]', //custom box selector,
        init: (props) => {
            if(props.checked){  
                $('.controllers-indicator').removeAttr('hidden')
            }
        },
        toggle: (props) => {

            id = props.listId;

            if(props.checked){
                $('.trackers-field').attr({hidden : 'hidden'})
                fields = {
                    1: 'route-controllers',
                    2: 'queries',
                    3: 'memory',
                    4: 'cpu',
                }

                $('.trackers-field.'+fields[id]).removeAttr('hidden')

                if(id === 1) {
                    $('.controllers-indicator').removeAttr('hidden')
                }else{
                    $('.controllers-indicator').attr({'hidden':'hidden'})
                }

            }
        }


    });

    function calibrateSensor(sensor){
        const app_runtime = sensor.querySelector('.app-runtime-pane')
        if(!app_runtime) return;

        // Collapsed, the sensor is pinned by CSS at left:90%, which only fits when
        // the box is narrower than a tenth of the viewport. Jumping to a hardcoded
        // 85% was still a guess, so a wider box stayed over the right edge and took
        // the drag handle with it. Shift by the overflow actually measured instead.
        const gap = 8; // keeps the handle clear of the very edge, so it stays grabbable
        const computed = window.getComputedStyle(sensor);
        const rect = app_runtime.getBoundingClientRect();

        const overflowRight = rect.right - (window.innerWidth - gap);
        const overflowBottom = rect.bottom - (window.innerHeight - gap);

        if (overflowRight > 0) {
            // read the resolved position: sensor.style.left is empty until it has been
            // set inline, and parseInt("") is NaN, which writes an ignored "NaNpx"
            const left = (parseFloat(computed.left) || 0) - overflowRight;
            sensor.style.left = Math.max(left, gap) + "px";
        }
        if (overflowBottom > 0) {
            const top = (parseFloat(computed.top) || 0) - overflowBottom;
            sensor.style.top = Math.max(top, gap) + "px";
        }
    }

    let selector = ss.selector();
    let runtimeBtx = selector.select('.runtime-btx');
    let runtimeBtx2 = document.querySelector('.runtime-btx-2');
    runtimeBtx2.addEventListener('click', function(){
        document.querySelector('.runtime-btx').click();
    })

    let body = document.querySelector('body'); 
    body.setAttribute('::sensor-open', true)

    runtimeBtx.forEach(btx => {
        btx.addEventListener('click', function(){
            selector.select(spoova_sensor_selector).forEach(sensor => {
                let body = document.querySelector('body'); 
                if(sensor.classList.contains('minimized')){
                    sensor.classList.remove('minimized')
                    body.setAttribute('::sensor-open', true)
                } else {
                    body.removeAttribute('::sensor-open')
                    sensor.classList.add('minimized') 

                    let computes = window.getComputedStyle(sensor)

                    calibrateSensor(sensor)
                }
                
            })
        })
    })

    let itemDragger = ss.itemDragger();
    itemDragger.select('.mover','.moveable').drag(function(e){
        e.started(function(item, count){
    
            if(count === 1) {
                let sensor = item.closest('['+CSS.escape('::sensor')+']'); 
                let banner = item.querySelector('.banner'); 
    
                item.style.position = "absolute";
                sensor.style.position = "absolute"; 
                sensor.style.right = 'initial';
            }
    
        })
    });

    let isDocked = false;

    let docker = setInterval(() => {
        let remoteSelector = '[id="'+CSS.escape('::')+'sp-control"]';
        let sensor = ss.select(spoova_sensor_selector);
        let dock = sensor.find('.dock').get();
        docked = dock.querySelector(remoteSelector)
        idDocked = docked ? true : false;
        if(!isDocked){
            let undocked = ss.select(remoteSelector);
            if(undocked.exists()){
              let zIndex = getComputedStyle(sensor.get()).zIndex;
              dock.appendChild(undocked.get())
              docked = undocked;
              setTimeout(() => {
                  calibrateSensor(sensor.get())
              },200)
              docked.css({'z-index': parseInt(zIndex) + 1, right: '5px'});
            //   dock.html(spLive.get().outerHTML);
            }
        }else{
            clearInterval(docker)
        }
    }, 2000)

    // display sensor only after page is loaded
    ss.select(spoova_sensor_selector).removeAttr('hidden')

    setTimeout(()=>{

        // define queries to select elements
        let liveDockQuery = '['+CSS.escape('::')+'sp-dock]';
        let remoteSelector = '[id="'+CSS.escape('::')+'sp-control"]';

        // apply queries to select elements
        let sensor = ss.select(spoova_sensor_selector);
        let remote = document.querySelector(remoteSelector)
        let liveDock = ss.select(liveDockQuery)
        let sensorLive = sensor.find('['+CSS.escape('::')+'metrics-live]');
        let sensorControl = sensorLive.find('[ctrl-ico]');
        let controlIconState = '';
       
        // use selected elements to render behaviour
        if(liveDock.exists() && sensor.exists() && remote){
            let spControl = liveDock.find('[spoova-role]');
            let liveControl = remote.querySelector('[live-control]');
            let sensorControlx = controlIconState = sensorControl.get();
            let controlClass = ss.select(liveControl).attr('class');
            remote.addEventListener('dblclick', function(){
                let controlClass = ss.select(liveControl).attr('class');
                controlClass = controlClass.replace('bi-play-circle', 'bi-play');
                sensorControl.attr({class: controlClass});
            });
            sensorControl.addClass(controlClass);
            let currentClass = controlClass;
            sensorLive.removeAttr('hidden')

            sensorControlx.addEventListener('dblclick',function(){
                const event = new MouseEvent('dblclick', {
                    bubbles: true,
                    cancelable: true,
                    view: window
                });
                liveControl.click();
                liveControl.dispatchEvent(event)
                // setTimeout(()=> {
                //     sensorControl.removeClass(currentClass);
                //     currentClass = ss.select(liveControl).attr('class');
                //     sensorControl.addClass(currentClass);
                // }, 200);
            })
        }else{
            sensorLive.remove();
        }

    },1000)

})

</script>