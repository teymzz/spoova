<style>
/*input form css*/
  
  form{
    margin: 0px;
  }

  form .hide-margin{
    margin-bottom: 0px;
  }

  .form-table{
    display: table;
    position: relative;
    margin-top: 5px;
    margin-bottom: 5px;
    border-collapse: separate;
  }
  .form-table > span, .form-table > .span-btns, .form-table > fieldset, .form-table > input, .form-table > textarea, .form-table > select{
    display: table-cell;
    border-collapse: separate;
    font-size: inherit;
  }
  .form-table > .span-btns{
    width:1%;
    white-space: nowrap;
    border-collapse: collapse;
    position: relative;
    vertical-align: middle;
    font-weight: 300;
    font-family: calibri;
    color:white;
  }
  .form-table > .span-btns:empty {
    padding: 6 8px;
  }
  .form-table > .span-btns:not(:empty){
    padding: 0 0;
  }
  .form-table > .span-btns.btns{
    padding: 6 8px;
  } 
  .form-table > .span-btns:not(:empty) > button,  .form-table > .span-btns:not(:empty) > input[type='submit'] {
    padding:4px;
    width:100%;
    display: inline;
    background-color: inherit;
    border:none;
  }
  .form-table:not(.free-colors) > .span-btns{
    background-color:#99a5a5;
  }
  .form-table > fieldset > input:not(.anim-child), .form-table > fieldset > select:not(.anim-child){
    padding: 6px;
    border-collapse: separate;
  }
  .form-table.anim-cover{
    width:100%;
  }
  .form-table > fieldset .anim-child[disabled],.form-table > fieldset .anim-child[readonly] {
    cursor: not-allowed !important;
  }

  fieldset[disabled] .anim-child, fieldset .anim-child[readonly] {
    cursor: not-allowed !important;
  }  


 /*anim-legend / anim-child...............................................................*/
 .anim-legend{
    width:100%;
    float: left;
    position: relative;
    border:solid 1px rgba(220,220,220,0.4);
  }

  .anim-legend input.anim-child:focus{
    background-color: white /*transparent !important*/;
  }

  input:-ms-reval, input:-ms-clear {
    display: none; /* remove auto eye and auto cancel buttons */
  }

  input:-webkit-autofill {
    -webkit-animation-delay: 1s; /* Safari support - any positive time runs instantly */ 
    -webkit-animation-name: autofill; 
    -webkit-animation-fill-mode: both; 
  }  

  @-webkit-keyframes autofill { 
     0%,100% { 
        color: #666; 
        background: transparent; 
      }
   } 

 .bg-cover[bg-img], .bg-cover.bg-img, .bg-cover{
     background-size:cover;
     background-repeat: no-repeat;
  }

 .anim-legend:not([class*=bg-]):not([class*=btn-]){
    background-color: #e1e1e1;
    color: #7e8c8d;
  }
 .anim-legend textarea.anim-child{
    height: inherit;
    padding-top:4px !important;
    padding-left:4px;
  }
  .anim-legend, .anim-button{
    overflow: hidden;
  }  
  .anim-legend:not([class*=radius]), .anim-button:not([class*=radius]){
    border-radius:2px;
  }

  .anim-child{
    min-height: 35px;
    line-height: normal;
    border: none; 
    position: relative;
    padding: 0 6px; 
   }

  .form-field.stretch .form-table{
    width: 100%;
  }
  .form-field.stretch .form-row{
    display: flex;
    justify-content: space-between;
    align-items: stretch;
  }
  .form-field.stretch .form-row .form-table{
    width:auto;
  }  
  .form-field.stretch .form-row.col-2 .form-table{
    --widthA: calc(100% - 10px);
    --widthB: calc(var(--widthA) / 2);
    width: calc(var(--widthB));
  } 
  .form-field.stretch .form-row.col-3 .form-table{
    --widthA: calc(100% - 10px);
    --widthB: calc(var(--widthA) / 3);
    width: calc(var(--widthB));
  } 

  .form-field.stretch .form-tab{
    display: table;
  }
  .form-field.stretch .form-tab .form-table{
    display: table-cell;
  } 
  .form-field.stretch .form-tab .form-table:nth-child(1){
    width: -moz-content-width;
    white-space: nowrap;
    margin-right: 5px;
  }


  /*.live-form.live-effect .form-table .anim-legend.anim-effect .anim-child, .form-table .anim-button.anim-effect .anim-child {
      transition: 5s;
      box-shadow: 0 0 5px rgba(191, 191, 191, 0.2) inset;
  }*/

  /* fieldsets .....................................................................................................*/

  fieldset:not(.table).anim-button input.anim-child,
  fieldset:not(.table).anim-button input.anim-child:hover,
  fieldset:not(.table).anim-button input.anim-child:focus,
  fieldset:not(.table).anim-legend input.anim-child,
  fieldset:not(.table).anim-legend input.anim-child:hover,
  fieldset:not(.table).anim-legend input.anim-child:focus,
  fieldset:not(.table).anim-button button.anim-child,
  fieldset:not(.table).anim-button button.anim-child:hover,
  fieldset:not(.table).anim-button button.anim-child:focus,
  fieldset:not(.table).anim-legend button.anim-child,
  fieldset:not(.table).anim-legend button.anim-child:hover,
  fieldset:not(.table).anim-legend button.anim-child:focus,  
  fieldset:not(.table).anim-legend select.anim-child, 
  fieldset:not(.table).anim-legend select.anim-child:hover, 
  fieldset:not(.table).anim-legend select.anim-child:focus,
  fieldset:not(.table).anim-legend textarea.anim-child, 
  fieldset:not(.table).anim-legend textarea.anim-child:hover, 
  fieldset:not(.table).anim-legend textarea.anim-child:focus{
    border: none;
    background-color: transparent;
    width: 100%;
    box-shadow: 0px 0px 0px transparent;
    outline: none;
  }

  fieldset.multi.anim-button input.anim-child,
  fieldset.multi.anim-button input.anim-child:hover,
  fieldset.multi.anim-button input.anim-child:focus,
  fieldset.multi.anim-legend input.anim-child,
  fieldset.multi.anim-legend input.anim-child:hover,
  fieldset.multi.anim-legend input.anim-child:focus,
  fieldset.multi.anim-button button.anim-child,
  fieldset.multi.anim-button button.anim-child:hover,
  fieldset.multi.anim-button button.anim-child:focus,
  fieldset.multi.anim-legend button.anim-child,
  fieldset.multi.anim-legend button.anim-child:hover,
  fieldset.multi.anim-legend button.anim-child:focus,  
  fieldset.multi.anim-legend select.anim-child, 
  fieldset.multi.anim-legend select.anim-child:hover, 
  fieldset.multi.anim-legend select.anim-child:focus,
  fieldset.multi.anim-legend textarea.anim-child, 
  fieldset.multi.anim-legend textarea.anim-child:hover, 
  fieldset.multi.anim-legend textarea.anim-child:focus{
    border: none;
    background-color: transparent;
    width: unset;
    box-shadow: 0px 0px 0px transparent;
    outline: none;
  }
  
  fieldset{
    border:solid 1px rgba(220,220,220,0.4);
    font-size: 12px;
  }
  fieldset.border{
    border: solid thin #c4c9cc;
  }

  fieldset.anim-button[disabled]:not([class*=bg-]){
    background-color:#e1e1e1;
  }
  fieldset.anim-button:not([disabled]):not([class*=bg-]):not([class*=btn-]){
    background-color: #e1e1e1;
  }  
  fieldset.anim-button:not([disabled]):not([class*=bg-]){
    transition: .5s;
    border:solid 1px transparent;
  }
  fieldset.anim-button[disabled]{
    transition: .5s;
    opacity: 0.6;
    border:solid 1px transparent;
    cursor: not-allowed;
  }

  fieldset.anim-button:not([disabled]):not(.multi)):active{
    opacity: 0.4;
  }

  fieldset.anim-legend textarea{
    resize: none;
    height: 100%;
    width: 100%;
  }
  fieldset legend{
    margin-bottom:auto;
    border:none;
    width:auto;
    text-align:left
  }
  fieldset:not(.table) input.field, fieldset:not(.table) select.field, fieldset:not(.table) textarea.field,  fieldset:not(.table) span.field{
    border: none;
    width: 100%;
    box-shadow: none;
    background-color: transparent;
  }
  fieldset{
    background-color: #fcfcfc;
    color: #7f7f7f;
  }
  fieldset input.field:hover,
  fieldset input.field:focus, 
  fieldset select.field:hover, 
  fieldset select.field:focus, 
  fieldset textarea.field:hover, 
  fieldset textarea.field:focus{
    border: none;
    background-color: transparent;
    width: 100%;
    box-shadow: 0px 0px 0px transparent;
    outline: none;
  }
  fieldset input[field], fieldset select[field], fieldset textarea[field]{
    background-color: transparent;
    border: none;
    border-radius: inherit;
    width: 100%;
    box-shadow: none;
    resize: none;
    transition: .2s;
  }
  fieldset input[field]:not(.no-radius), fieldset select[field]:not(.no-radius), fieldset textarea[field]:not(.no-radius){
    border-radius: inherit;
  }

  fieldset :read-write[disabled]{
    cursor: not-allowed;
  }

  /*tables .....................................................................*/
  div.table-cell{
    display: table;
    border-collapse: collapse;
  }
  div.table-cell > div{
    display: table-row;
    border-collapse: separate;  
  }
  div.table-cell:not(.clear-wrap) > div{
    white-space: nowrap;   
  }
  div.table-cell:not(.no-line) > div{
    border:solid thin;
    border-color: inherit;
  } 
  div.table-cell > div > span, div.table-cell > div > div{
    display: table-cell;
    border-collapse: separate; 
    padding: 6px;
  }
  div.table-cell:not(.no-line) > div > span, div.table-cell:not(.no-line) > div > div{
    border:solid thin inherit;
  }
  div.table-cell.spreadsheet > div > span, div.table-cell > div.spreadsheet > span{
    border:solid thin;
  }

  div.table-list > div{
    margin:10px 0px;
  }
  div.table-list.lined > div > span{
    border: solid thin;
    border-color: inherit;
  }


  /* ul styling ...............................................................................................*/
  ul.list-square li{
    list-style: square;
  }
  ul.list-disc li{
    list-style: disc;
  }
  ul.list-free li{
    list-style: none;
  }

  ul > li.link-padds > a, ul > li.link-padds > span{
    display: inline-block;
    width:100%;
    height:100%;
    color:inherit;
  }


  /*input fields / tags .......................................................................................*/
  section{
    width:100%;
  }

  input::placeholder{
    color:#555;
  }

  textarea.textarea:focus{
    box-shadow: 0px 0px 2px #aaa;
    border: solid thin #aaa;
  }
  textarea:focus{
    box-shadow: none;
    outline: none;
  }

  span.submit{
    border:solid thin;
    border-color: #aaa;
    color: #757575;
    padding: 4px;
    border-radius: 4px;
  }
  span.submit:hover{
    cursor: pointer;
  }

  button.submit{
    border:solid thin;
    border-color: #aaa;
    color: #757575;
    background-color: transparent;
    padding: 4px;
    border-radius: 4px;
  }
  button.submit:hover{
    cursor: pointer;
  }  
  button#mybutton{
    border:solid thin inherit;
  }

  input:not([type=submit]){
    border-radius: 4px;
    padding:2px 4px;
    font-size: inherit;
  }
  input:not([type=submit]):focus{
    box-shadow: #a6a6a6 0px 0px 0px;
    outline: none;
  }

  input.sp-inputs{
    position: relative;
    top:2px;
  }

  a:visited{
    border: none;
    color: inherit;
    font-family: inherit !important; 
  }
  a:active{
    border: none;
    color: inherit;
    font-family: inherit !important; 
  }
  a, a:hover, a:focus, a:visited, a[href]:after{
    text-decoration: none;
    outline: none;
  }
  a[href]:after{
    content:none important;
  }
  a.no-uline:hover{
    text-decoration: none;
    color: inherit;
  }
  a.inherit{
    text-decoration: none;
    color: inherit;
  }

  img[checkbox] + input[type='checkbox']{
    display: none;
    visibility: hidden;
  }

  [class~=more]{
    border: solid thin #aaa;
    border-radius:4px;
    padding:2px;
    color: #0080c0;
    background-color: #cad0ce;
  }

  /*headers.................................................................................*/
  #header{
    height: auto;
  }

  /*float items ............................................................................*/
  .pull-left{
    float: left;
  }
  .pull-right{
    float: right;
  }


  /*customs boxes ................................................*/
  .mycover, .mycover-full, .mybox, .mybox-full, .mycover-box{
    display: inline-block;
    height: auto;
    line-height: 1.42857143;
    -webkit-box-sizing: border-box;
    -moz-box-sizing: border-box;
    box-sizing: border-box;
    -webkit-transition: all .2s ease-in-out;
    -o-transition: all .2s ease-in-out;
    transition: all .2s ease-in-out;
  }
  .mycover, .mycover-full{
    padding: 4px;
    border-radius: 4px;
   }
  .mybox, .mycover{
    max-width: 100%;
   }
  .mybox-full, .mycover-full{
    width: 100%;
   } 
  .mycover.image{
    float: left;
    margin: 4px 4px 4px 4px;
  }

  .numb-box{
    display: inline-block;
    box-sizing: border-box;
    border:solid thin;
    position: relative;
    padding-left: 5px;
    padding-right: 5px;
    padding-top: 0px;
    padding-bottom: 0px;
    border-radius: 50px;
    top: -4px;
    font-size: 10;
    font-weight: bold;
    background-color:#aaa inherit;
    color: inherit;
  }

  .fine-box{
    border: dotted 2px #aaa;
    border-radius:2px;
  }

  .fine-wall{
    border-right: dotted 2px #aaa;
    border-left: dotted 2px #aaa;
    border-bottom: none;
    border-top: none;
    border-radius:2px;
  }
  .fine-box2{
    border:none;
    border-radius:2px;
  }
  .icon{
    height: 15px;
    width:15px;
  }
  .icon2{
    height: 25px;
    width:20px;
  }
  .icon-box .icon{
    vertical-align: unset;
  }


  /*content positions ................................................*/

  .fixed{
    position: fixed;
  }
  .relative{
    position: relative;
  }
  .absolute{
    position: absolute;
  }
  .static{
    position: static;
  }

  
  /* text alignment ................................................*/

  .text-justify{
    text-align: justify;
  }
  .text-center{
    text-align: center; 
  }
  .text-right{
    text-align: right; 
  }
  .text-left{
    text-align: left;
  }

  .break-all{
    word-break: break-all;
  }


  /* text fonts sizes ...............................................................*/
  .font8{
    font-size: 8px;
  }

  .font9{
    font-size: 9px;
  }

  .font10{
    font-size: 10px;
  }

  .font11{
    font-size: 11px;
  }

  .font12{
    font-size: 12px;
  }

  .font13{
    font-size: 12px;
  }

  .font14{
    font-size: 14px;
  }

  .font15{
    font-size: 15px;
  }

  .font16{
    font-size: 16px;
  }

  .font18{
    font-size: 18px;
  }

  .font20{
    font-size: 20px;
  }

  .font22{
    font-size: 22px;
  }

  
  .font-em-d1{
     font-size: .1em;
  }

  .font-em-d11{
     font-size: .11em;
  }

  .font-em-d12{
     font-size: .12em;
  }

  .font-em-d15{
     font-size: .15em;
  }

  .font-em-d17{
     font-size: .17em;
  } 

  .font-em-d19{
     font-size: .19em;
  }

  .font-em-d2{
     font-size: .2em;
  } 

  .font-em-d21{
     font-size: .21em;
  }

  .font-em-d22{
     font-size: .22em;
  }

  .font-em-d25{
     font-size: .25em;
  }

  .font-em-d27{
     font-size: .27em;
  } 

  .font-em-d29{
     font-size: .29em;
  }    

  .font-em-d3{
     font-size: .3em;
  }

  .font-em-d31{
     font-size: .31em;
  }

  .font-em-d32{
     font-size: .32em;
  }

  .font-em-d35{
     font-size: .35em;
  }

  .font-em-d37{
     font-size: .37em;
  } 

  .font-em-d39{
     font-size: .39em;
  }

  .font-em-d4{
     font-size: .4em;
  }

  .font-em-d41{
     font-size: .41em;
  }

  .font-em-d42{
     font-size: .42em;
  }

  .font-em-d45{
     font-size: .45em;
  }

  .font-em-d47{
     font-size: .47em;
  } 

  .font-em-d49{
     font-size: .49em;
  } 

  .font-em-d5{
     font-size: .5em;
  }

  .font-em-d51{
     font-size: .51em;
  }

  .font-em-d52{
     font-size: .52em;
  }

  .font-em-d55{
     font-size: .55em;
  }

  .font-em-d57{
     font-size: .57em;
  } 

  .font-em-d59{
     font-size: .59em;
  } 

  .font-em-d6{
     font-size: .6em;
  }

  .font-em-d61{
     font-size: .61em;
  }

  .font-em-d62{
     font-size: .62em;
  }

  .font-em-d65{
     font-size: .65em;
  }

  .font-em-d67{
     font-size: .67em;
  } 

  .font-em-d69{
     font-size: .69em;
  }

  .font-em-d7{
     font-size: .7em;
  }

  .font-em-d71{
     font-size: .71em;
  }

  .font-em-d72{
     font-size: .72em;
  }

  .font-em-d75{
     font-size: .75em;
  }

  .font-em-d77{
     font-size: .77em;
  } 

  .font-em-d79{
     font-size: .79em;
  }

  .font-em-d8{
     font-size: .8em;
  }

  .font-em-d81{
     font-size: .81em;
  }

  .font-em-d82{
     font-size: .82em;
  }

  .font-em-d85{
     font-size: .85em;
  }

  .font-em-d87{
     font-size: .87em;
  } 

  .font-em-d89{
     font-size: .89em;
  } 

  .font-em-d9{
     font-size: .9em;
  }

  .font-em-d91{
     font-size: .21em;
  }

  .font-em-d92{
     font-size: .92em;
  }

  .font-em-d95{
     font-size: .95em;
  }

  .font-em-d97{
     font-size: .97em;
  } 

  .font-em-d99{
     font-size: .29em;
  }

  .font-em-1{
     font-size: 1em;
  } 

  .font-em-1d1{
     font-size: 1.1em;
  }

  .font-em-1d2{
     font-size: 1.2em;
  } 

  .font-em-1d3{
     font-size: 1.3em;
  } 


  .font-em-1d5{
     font-size: 1.5em;
  } 

  .font-em-1d7{
     font-size: 1.7em;
  }

  .font-em-1d9{
     font-size: 1.9em;
  }

  .font-em-2{
     font-size: 2em;
  }

  .font-em-2d1{
     font-size: 2.1em;
  }

  .font-em-2d2{
     font-size: 2.2em;
  } 

  .font-em-2d5{
     font-size: 2.5em;
  } 

  .font-em-2d7{
     font-size: 2.7em;
  }

  .font-em-2d9{
     font-size: 2.9em;
  }

  .font-em-3{
     font-size: 3em;
  }

  .font-em-3d1{
     font-size: 3.1em;
  }

  .font-em-3d2{
     font-size: 3.2em;
  } 

  .font-em-3d5{
     font-size: 3.5em;
  } 

  .font-em-3d7{
     font-size: 3.7em;
  }

  .font-em-3d9{
     font-size: 3.9em;
  }

  .font-em-4{
     font-size: 4em;
  }

  .font-em-4d1{
     font-size: 4.1em;
  }

  .font-em-4d2{
     font-size: 4.2em;
  } 

  .font-em-4d5{
     font-size: 4.5em;
  } 

  .font-em-4d7{
     font-size: 4.7em;
  }

  .font-em-4d9{
     font-size: 4.9em;
  }

  .font-em-4{
     font-size: 4em;
  }

  .font-em-4d2{
     font-size: 4.2em;
  } 

  .font-em-4d5{
     font-size: 4.5em;
  } 

  .font-em-4d7{
     font-size: 4.7em;
  }

  .font-em-4d9{
     font-size: 4.9em;
  }

  .font-em-5{
     font-size: 5em;
  }

  .font-em-5d1{
     font-size: 5.1em;
  }

  .font-em-5d2{
     font-size: 5.2em;
  } 

  .font-em-5d5{
     font-size: 5.5em;
  } 

  .font-em-5d7{
     font-size: 5.7em;
  }

  .font-em-5d9{
     font-size: 5.9em;
  }
  

  .i, .font-i{
    font-style: italic;
  }
  .pre, .font-pre{
    display: block;
    width:inherit;
    white-space: pre-wrap;
  }
  .small, .font-small{
    font: menu;
  }
  .small2{
    font-size: small;
    font-weight: lighter;
  }
  .small3{
    font-size: 13px;
    font-weight: lighter;
  }
  .bold, .font-bold{
    font-weight:bold;
  }
  .italic, .font-italic{
    font-style: italic;
  }

  .font-all input, .font-all textarea, .font-all > *{
    font-size: inherit;
  }


  /* font family */

  .helvetica{
    font-family: helvetica;
  }

  .roboto{
    font-family: roboto;
  }

  .calibri{
    font-family: calibri;
  }

  .verdana{
    font-family: verdana;
  }



  /*badges ................................................*/
  .mybadge{
    border:solid thin;
  }

  .badge-1, .badge-2, .badge-3{
    display: inline-block;
    padding: 0 4px;
    border-radius: 50px;
  }  

  .badge-1{
    background-color: #9dadb0;
  }

  .badge-2{
    background-color: #5c6769;
  }

  .badge-3{
    background-color: #3c494b;
  }


  /* buttons ...............................................*/

  .anc-btn-link{
     cursor:pointer;
   }

  .anc-btn-link:active, .anc-btn:active{
     opacity: .5;
   }

   
  .button-link{
    border:none;
    background-color: #408080;
    color: white;
  }
  .fine-btn{
    border: none;
    background: #bfb6a4;
    color:white;
  }
  .over:hover{
    opacity: 0.8;
  }


  .header-name{
    font-style: italic;
    color:#7c8d72;
  }
  .x-close{
    padding: 2px;
    background-color: #a60000;
    color:#b7b7b7;
  }

  /*pointers ...................................................*/
  .c-pointer, .cpointer{
    cursor: pointer;
  }
  [data-rdr]{
    cursor: pointer;  
  }
  [data-scroll]{
    cursor: pointer;
  }
  [disabled="true"], .disabled, [disabled]{
    cursor: not-allowed;
  }

  .midbullet{
    vertical-align: 2px;
    font-size: 6px;
  }

  .flow-hide{
    overflow: hidden;
  }

  .flow-auto{
    overflow:auto;
  }

  .flow-scroll{
    overflow: scroll;
  }

  .flow-hide-x{
    overflow-x: hidden;
  }

  .flow-hide-y{
    overflow-y: hidden;
  }

  .flow-auto-x{
    overflow-x: auto;
  }

  .flow-auto-y{
    overflow-y: auto;
  }

  

  /* forcing item to center and middle..........................*/
  .center{
    margin: auto !important;
  }

  .mid-outer { 
    display: table; 
    position: absolute; 
    top: 0; 
    left: 0; 
    height: 100%; 
    width: 100%; 
  }
  .mid-outer .middle { 
    display: table-cell; 
    vertical-align: middle; 
   } 
  .mid-outer .inner { 
    margin-left: auto; 
    margin-right: auto; 
   }
  .mid-outer.relative{
    position: relative;
  }
  .mid-outer.fixed{
    position: fixed;
  }

  /* fluid boxes ....................................................................................*/
  .fluid-box, .fluid-box-2{
    position: relative;
  }
  .fluid-box .fluid-control{
    display: none;
    margin-top: 75%;
  }
  .fluid-box-2 .fluid-control{
    display: none;
    margin-top: 90%;
  }
  .fluid-box:before{
    content:"";
    display: inline-block;
    margin-top: 75%;
  }
  .fluid-box-2:before{
    content:"";
    display: inline-block;
    margin-top: 90%;
  }
  .fluid-box .fluid-content, .fluid-box-2 .fluid-content{
    position: absolute;
    top:0;
    bottom: 0;
    right: 0;
    left:0;
  }


  /* styling images-thumbs..............................................*/
  .img-thumbnail.hide-default{
    border:none;
    background-color:transparent;
  }
  .image-thumb{
    position: relative;
    display: inline-block;
    line-height: 1.42857143;
    -webkit-box-sizing: border-box;
    -moz-box-sizing: border-box;
    box-sizing: border-box;
    -webkit-transition: all .2s ease-in-out;
    -o-transition: all .2s ease-in-out;
    transition: all .2s ease-in-out;
    padding: 2px;
  }
  .image-thumb .image{
    position: relative;
    overflow: hidden;
  }
  .image-thumb .image .image-label{
    position: absolute;
    bottom: 0;
    left:0;
    right:0;
    width:100%;
    padding:4px;
  }

  .image-thumb .image .image-label[data-anime='slide-up']:not(.slide-up){
    bottom: -30%;
    transition: 2s;
  }

  .image-thumb .image .image-label.slide-up{
    bottom: 0;
    transition: 1s;
  }

  /*overlay item ...........................................................................*/
  .page-overlay{
    position: fixed;
  }
  .overlay{
    position: absolute;
  }
  .page-overlay, .overlay{
    top:0;
    bottom: 0;
    left:0;
    right: 0; 
  }


  /*custom btns ...................................................*/
  .span-btns, .span-btn, .btn-box{
    cursor: pointer;
  }
  .btns{
    background-color:#99a5a5;
  }
  .btn-box{
    display: inline-block;
  }  
  .span-btns{
    display: inline-block;
    padding:6px 8px;
  }
  .span-btns.border{
    border: solid thin #d2d2d2;
  }
  .span-btns.border2{
    border: solid thin #828282;
  }


  /*margins ....................................................*/
  .mg.mtp1{
    margin-top:1px; 
  }
  .mg.mtp2{
    margin-top:2px; 
  }
  .mg.mtp4{
    margin-top:4px;  
  }
  .mg.mtp5{
    margin-top:5px;  
  }
  .mg.mtp6{
    margin-top:6px;  
  }
  .mg.mtp8{
    margin-top:8px;  
  }
  .mg.mtp10{
    margin-top:10px;  
  }
  .mg.mtp12{
    margin-top:12px;  
  }
  .mg.mtp15{
    margin-top:15px;   
  }
  .mg.mtp20{
    margin-top:20px;   
  }
  .mg.mtp2-rvs{
    margin-top:-2px; 
  }
  .mg.mtp4-rvs{
    margin-top:-4px;  
  }
  .mg.mtp6-rvs{
    margin-top:-6px;  
  }
  .mg.mtp8-rvs{
    margin-top:-8px;  
  }
  .mg.mtp10-rvs{
    margin-top:-10px;  
  }
  .mg.mtp12-rvs{
    margin-top:-12px;  
  }
  .mg.mtp15-rvs{
    margin-top:-15px;   
  }
  .mg.mtp20-rvs{
    margin-top:-20px;   
  }
  
  .mg.btm2{
    margin-top:2px; 
  }
  .mg.mbtm4{
    margin-bottom:4px;  
  }
  .mg.mbtm6{
    margin-bottom:6px;  
  }
  .mg.mbtm8{
    margin-bottom:8px;  
  }
  .mg.mbtm10{
    margin-bottom:10px;  
  }
  .mg.mbtm12{
    margin-bottom:12px;  
  }
  .mg.mbtm15{
    margin-bottom:15px;   
  }
  .mg.mbtm20{
    margin-bottom:20px;   
  }
  .mg.mbtm2-rvs{
    margin-bottom:-2px; 
  }
  .mg.mbtm4-rvs{
    margin-bottom:-4px;  
  }
  .mg.mbtm6-rvs{
    margin-bottom:-6px;  
  }
  .mg.mbtm8-rvs{
    margin-bottom:-8px;  
  }
  .mg.mbtm10-rvs{
    margin-bottom:-10px;  
  }
  .mg.mbtm12-rvs{
    margin-bottom:-12px;  
  }
  .mg.mbtm15-rvs{
    margin-bottom:-15px;   
  }
  .mg.mbtm20-rvs{
    margin-bottom:-20px;   
  }


  .mg.mlft2{
    margin-left:2px; 
  }
  .mg.mlft4{
    margin-left:4px;  
  }
  .mg.mlft6{
    margin-left:6px;  
  }
  .mg.mlft8{
    margin-left:8px;  
  }
  .mg.mlft10{
    margin-left:10px;  
  }
  .mg.mlft12{
    margin-left:12px;  
  }
  .mg.mlft15{
    margin-left:15px;   
  }
  .mg.mlft20{
    margin-left:20px;   
  }


  .mg.mrgt2{
    margin-right:2px; 
  }
  .mg.mrgt4{
    margin-right:4px;  
  }         
  .mg.mlft6{
    margin-right:6px;  
  }         
  .mg.mrgt8{
    margin-right:8px;  
  }
  .mg.mrgt10{
    margin-right:10px;  
  }
  .mg.mrgt12{
    margin-right:12px;  
  }
  .mg.mrgt15{
    margin-right:15px;   
  }
  .mg.mrgt20{
    margin-right:20px;   
  }


  /* paddings..................................................*/

  /* strict padding ......................................*/
  
  .no-padding{
    padding:0px !important;
  }

  .padding0{
    padding:0px !important;
  }
  .padding1{
    padding:1px !important;
  }
  .padding2{
    padding:2px !important;
  }
  .padding4{
    padding:4px !important;
  }
  .padding5{
    padding:5px !important;
  }
  .padding6{
    padding:6px !important;
  }
  .padding8{
    padding:8px !important;
  }
  .padding10{
    padding:10px !important;
  }

  /*soft paddings .......................................................................*/

  [class~='padds']{
    padding-top:0.5px;
    padding-bottom:0.5px;
    padding-left:2px;
    padding-right:2px;
    border: solid thin #aaa;
    border-radius: 2px;
  }
  .span-btns{
    padding: 4px;
    cursor: pointer;
  }

  .padd-all{
    padding: 2px 4px 2px 4px;
  }
  .padd-btn{
    border: solid thin #4e505c;
    box-shadow: 0px 0px 2px #e1e1e1 inset;
  }
  .padd-btn:hover{
    cursor: pointer;
    box-shadow: 0px 0px 3px #e1e1e1 inset;
  }
  .padd-up, .padd-top{
    padding-top: 2px;
  }
  .padd-bottom{
    padding-bottom: 2px; 
  }
  .padd-left{
    padding-left: 2px; 
  }
  .padd-right{
    padding-right: 2px; 
  }



  .padd-none{
    padding:0px;
  }
  .padd-1{
    padding: 1px;
  }
  .padd-2{
    padding: 2px;
  }
  .padd-3{
    padding: 3px;
  }
  .padd-4{
    padding: 4px;
  }
  .padd-6{
    padding: 6px; 
  }
  .padd-8{
    padding: 8px;
  }
  .padd-10{
    padding: 10px; 
  }
  .padd-11{
    padding: 11px;
  }
  .padd-12{
    padding: 12px;
  }
  .padd-14{
    padding: 14px;
  }
  .padd-15{
    padding: 16px; 
  }
  .padd-16{
    padding: 16px; 
  }
  .padd-18{
    padding: 18px;
  }
  .padd-20{
    padding: 20px; 
  }


  .padd-up-none{
    padding-top: 0px;
  }
  .padd-up-1{
    padding-top: 1px;
  }
  .padd-up-2{
    padding-top: 2px;
  }
  .padd-up-3{
    padding-top: 3px;
  }
  .padd-up-4{
    padding-top: 4px;
  }
  .padd-up-6{
    padding-top: 6px; 
  }
  .padd-up-8{
    padding-top: 8px;
  }
  .padd-up-10{
    padding-top: 10px; 
  }

  .padd-up-11{
    padding-top: 11px;
  }
  .padd-up-12{
    padding-top: 12px;
  }
  .padd-up-14{
    padding-top: 14px;
  }
  .padd-up-15{
    padding-top: 16px; 
  }
  .padd-up-16{
    padding-top: 16px; 
  }
  .padd-up-18{
    padding-top: 18px;
  }
  .padd-up-20{
    padding-top: 20px; 
  }

  .padd-bottom-none{
    padding-bottom: 0; 
  }
  .padd-bottom-1{
    padding-bottom: 1px; 
  }
  .padd-bottom-2{
    padding-bottom: 2px; 
  }
  .padd-bottom-4{
    padding-bottom: 4px; 
  }
  .padd-bottom-6{
    padding-bottom: 6px; 
  }
  .padd-bottom-8{
    padding-bottom: 8px; 
  }
  .padd-bottom-10{
    padding-bottom: 10px; 
  }
  .padd-bottom-11{
    padding-bottom: 11px; 
  }
  .padd-bottom-12{
    padding-bottom: 12px; 
  }
  .padd-bottom-14{
    padding-bottom: 14px; 
  }
  .padd-bottom-15{
    padding-bottom: 16px; 
  }
  .padd-bottom-16{
    padding-bottom: 16px; 
  }
  .padd-bottom-18{
    padding-bottom: 18px; 
  }
  .padd-bottom-20{
    padding-bottom: 20px; 
  }

  .padd-left-none{
    padding-left:0;
  }
  .padd-left-1{
    padding-left: 1px; 
  }
  .padd-left-2{
    padding-left: 2px; 
  }
  .padd-left-4{
    padding-left: 4px; 
  }
  .padd-left-5{
    padding-left: 5px; 
  }
  .padd-left-6{
    padding-left: 6px; 
  }
  .padd-left-8{
    padding-left: 8px; 
  }
  .padd-left-10{
    padding-left: 10px; 
  }
  .padd-left-12{
    padding-left: 12px; 
  }
  .padd-left-14{
    padding-left: 14px; 
  }
  .padd-left-15{
    padding-left: 15px; 
  }
  .padd-left-16{
    padding-left: 16px; 
  }
  .padd-left-18{
    padding-left: 18px; 
  }
  .padd-left-20{
    padding-left: 20px; 
  }


  .padd-right-none{
    padding-right: 0;    
  }
  .padd-right-1{
    padding-right: 1px; 
  }
  .padd-right-2{
    padding-right: 2px; 
  }
  .padd-right-4{
    padding-right: 4px; 
  }
  .padd-right-5{
    padding-right: 5px; 
  }
  .padd-right-6{
    padding-right: 6px; 
  }
  .padd-right-8{
    padding-right: 8px; 
  }
  .padd-right-10{
    padding-right: 10px; 
  }
  .padd-right-12{
    padding-right: 12px; 
  }
  .padd-right-14{
    padding-right: 14px; 
  }
  .padd-right-15{
    padding-right: 15px; 
  }
  .padd-right-16{
    padding-right: 16px; 
  }
  .padd-right-18{
    padding-right: 18px; 
  }
  .padd-right-20{
    padding-right: 20px; 
  }


  .padd-xsides-none{
    padding-right: 0 !important;
    padding-left: 0 !important;
  }

  .padd-xsides-1{
    padding-right: 1px;
    padding-left: 1px;
  }
  .padd-xsides-2{
    padding-right: 2px;
    padding-left: 2px;
  }
  .padd-xsides-4{
    padding-right: 4px;
    padding-left: 4px;
  }
  .padd-xsides-5{
    padding-right: 5px;
    padding-left: 5px;
  }
  .padd-xsides-6{
    padding-right: 6px;
    padding-left: 6px;
  }
  .padd-xsides-8{
    padding-right: 8px;
    padding-left: 8px;
  }
  .padd-xsides-10{
    padding-right: 10px;
    padding-left: 10px;
  }
  .padd-xsides-12{
    padding-right: 12px;
    padding-left: 12px;
  }
  .padd-xsides-14{
    padding-right: 14px;
    padding-left: 14px;
  }
  .padd-xsides-15{
    padding-right: 15px;
    padding-left: 15px;
  }
  .padd-xsides-16{
    padding-right: 16px;
    padding-left: 16px;
  }
  .padd-xsides-18{
    padding-right: 18px;
    padding-left: 18px;
  }
  .padd-xsides-20{
    padding-right: 20px;
    padding-left: 20px;
  }


  .padd-ysides-none{
    padding-top: 0px !important;
    padding-bottom: 0px !important;
  }
  .padd-ysides-1{
    padding-top: 1px !important;
    padding-bottom: 1px !important;
  }
  .padd-ysides-2{
    padding-top: 2px;
    padding-bottom: 2px;
  }
  .padd-ysides-4{
    padding-top: 4px;
    padding-bottom: 4px;
  }
  .padd-ysides-5{
    padding-top: 5px;
    padding-bottom: 5px;
  }
  .padd-ysides-6{
    padding-top: 6px;
    padding-bottom: 6px;
  }
  .padd-ysides-8{
    padding-top: 8px;
    padding-bottom: 8px;
  }
  .padd-ysides-10{
    padding-top: 10px;
    padding-bottom: 10px;
  }
  .padd-ysides-12{
    padding-top: 12px;
    padding-bottom: 12px;
  }

  .padd-ysides-14{
    padding-top: 14px;
    padding-bottom: 14px;
  }

  .padd-ysides-15{
    padding-top: 15px;
    padding-bottom: 15px;
  }
  .padd-ysides-16{
    padding-top: 16px;
    padding-bottom: 16px;
  }
  .padd-ysides-18{
    padding-top: 18px;
    padding-bottom: 18px;
  }
  .padd-ysides-20{
    padding-top: 20px;
    padding-bottom: 20px;
  }


  .xpadds{
    padding-top:0.5px;
    padding-bottom:0.5px;
    padding-left:2px;
    padding-right:2px;
    border: solid thin;
    border-color: inherit;
    border-radius: 2px;
    cursor: pointer;
  }
  .xpadds:hover{
    background-color: inherit;
  }
  .padds.search{
    padding-top:1.5px;
    padding-bottom: 0.2px;
    padding-left:1px;
    padding-right: 1px;
    background-color: #efe9d6;
    border: solid thin #aaa;
    border-radius: 25%;
  }

  /*borders ......................................................................*/

  .border-thin{
    border:solid thin inherit !important;
  }
  .border-line{
    border-bottom:solid thin;
  }
  .border-true{
    border:solid 1px rgba(220, 220, 220, 0.5);
  }
  .border-transparent{
    border: solid thin transparent;
  }
  .border-dashed{
    border:dashed thin #aaa;
  }
  .border-dotted{
    border:dotted thin #aaa;
  }
  .border-false{
    border:none;
  }
  .border-transparent{
    border-color: transparent;
  }
  .border-clear{
    border: solid thin transparent;
  }


  .border-left{
    border-left: solid thin;
  }
  .border.border-left-false, .border-left-false{
    border-left: none !important;
  }
  .border-right{
    border-right: solid thin;
  }
  .border.border-right-false, .border-right-false{
    border-right: none !important;
  }
  .border-top{
    border-top: solid thin;
  }
  .border.border-top-false, .border-top-false{
    border-top:  hidden !important;
  }
  .border-bottom{
    border-bottom: solid thin;
  }
  .border.border-bottom-false, .border-bottom-false{
    border-bottom: none !important;
  }

  /* borders and radius .....................................*/
  .radius1{
    border-radius:1px;  
   }
  .radius2{
    border-radius:2px;  
   }
  .radius3{
    border-radius:3px; 
   }
  .radius4{
    border-radius:4px;   
   }
  .radius5{
    border-radius:5px;   
   }
  .radius6{
    border-radius:6px;   
   }
  .radius8{
    border-radius:8px;   
   }
  .radius10{
    border-radius:10px;   
   }
  .radius12{
    border-radius:12px;   
   }
  .radius14{
    border-radius:14px;   
   }
  .radius16{
    border-radius:16px;   
   }
  .radius18{
    border-radius:18px;   
   }
  .radius20{
    border-radius:20px;   
   }
  .radiuspx50, .radius50{
    border-radius:50px;   
   }
  .radiuspx100, .radius100{
    border-radius:100px;   
   }
  .radiusper50{
    border-radius:50%;   
   }

  /* sides radius --------*/
  .radius-ltop-none{
    border-top-left-radius: 0;
   }
  .radius-rtop-none{
    border-top-right-radius: 0;
   }

  .radius-lbtm-none{
    border-bottom-left-radius: 0;
   }

  .radius-rbtm-none{
    border-bottom-right-radius: 0;
   }

  .radius-top-none{
    border-top-right-radius: 0;
    border-top-left-radius: 0;
   }

  .radius-btm-none{
    border-bottom-right-radius: 0;
    border-bottom-left-radius: 0;
   }

  .radius-yrt-none{
    border-top-right-radius: 0;
    border-bottom-right-radius: 0;
   }

  .radius-ylt-none{
    border-top-left-radius: 0;
    border-bottom-left-radius: 0;
   }

  .radius-inherit{
    border-radius: inherit;
   }

  .no-radius, .radius0{
    border-radius:0px;
   }

  .radius-false{
    border-radius: 0px !important;
   }

   /* widths and pixels*/
  .img-px-10, .px-10{
    width:10px !important;
    height:10px !important;
   }

  .img-px-15, .px-15{
    width:15px !important;
    height:15px !important;
   }

  .img-px-20, .px-20{
    width:20px !important;
    height:20px !important;
   }
  .img-px-30, .px-30{
    width:30px !important;
    height:30px !important;
   }
  .img-px-40, .px-40{
    width:40px !important;
    height:40px !important;
   }
  .img-px-60, .px-60{
    width:60px !important;
    height:60px !important;
   }
  .img-px-80, .px-80{
    width:80px !important;
    height:80px !important;
   }
  .img-px-100, .px-100{
    width:100px !important;
    height:100px !important;
   }
   .img-px-110, .px-110{
    width:110px !important;
    height:110px !important;
   }
  .img-px-115, .px-115{
    width:115px !important;
    height:115px !important;
   }
  .img-px-120, .px-120{
    width:120px !important;
    height:120px !important;
   }
  .img-px-130, .px-130{
    width:130px !important;
    height:130px !important;
   }
  .img-px-140, .px-140{
    width:140px !important;
    height:140px !important;
   }
  .img-px-150, .px-150{
    width:150px !important;
    height:150px !important;
   }
  .img-px-150, .px-180{
    width:180px !important;
    height:180px !important;
   }   
  .img-px-200, .px-200{
    width:200px !important;
    height:200px !important;
   }
  .img-px-250, .px-250{
    width:250px !important;
    height:250px !important;
   }
  .img-px-300, .px-300{
    width:300px !important;
    height:300px !important;
   }
  .img-px-350, .px-350{
    width:350px !important;
    height:350px !important;
   }
  .img-px-400, .px-400{
    width:400px !important;
    height:400px !important;
   }
  .img-px-450, .px-450{
    width:450px !important;
    height:450px !important;
   }
  .img-full, .px-full, .full-size{
    width:100% !important;
    height:100% !important;
   }

  .full-width, .width-full{
    width: 100%;
   }

  .wper-50{
    width:50% !important;
   }
   
  /*display items ............................................................................*/

  .disp-block{
    display: block;
   }
  .disp-inline{
    display: inline;
   }
  .disp-inblock{
    display: inline-block;
   }
  .disp-flex{
    display: flex;
   }
  .disp-inflex{
    display: inline-flex;
   }
  .disp-grid{
    display: grid;
   }
  .disp-ingrid{
    display: inline-grid;
   }
  .disp-table{
    display: table;
   }
  .disp-intable{
    display: inline-table;
   }
  .disp-list{
    display: list-item;
   }

  .disp-none{
    display: none;
   }

  .flow-auto{
    overflow: auto;
  }

  .flow-x{
    overflow-x: auto;
    overflow-y: hidden;
  }

  .flow-y{
    overflow-x: hidden;
    overflow-y: auto;
  }

  .flow-hide{
    overflow: hidden;
  }

/*MOBILE TRANSORMS*/
.mobile{
    display: none;
}
.desktop{
    display:inline-block; 
}


  @media screen and (max-width:1000px){
    .desktop{
      display:none; 
     }
    .mobile{
      display:inline-block;
    }

    .mobile-center{
      text-align: center;
    }

    .mobile.mess{
      display:block;
    }
     .deskmob-stretch, .cs-mobile-stretch, .js-mobile-stretch{
        width:100% !important;
     }

     .deskmob-50, .cs-mobile-50, .js-mobile-50{
        width:50% !important;
     } 

     .deskmob-50-stretch, .cs-mobile-50-stretch, .js-mobile-50-stretch{
        width:50% !important;
     } 


     .padd-mobile-none{
       padding:0px !important;   
     }

     .border-mobile-none{
       border:none !important;    
     } 

     .border-mobile-opaq{
       border-color:transparent !important;    
     } 

     .height-automobile{
       height: auto !important;   
      }

     .height-automobile .sp-viewport{
       height: inherit !important;   
      }

     .padd-mobile-none{
       padding:0px !important;  
     }

     .padd-mobile-2{
       padding:2px !important;    
     }

     .padd-mobile-4{
       padding:4px !important;    
     } 

     .padd-xmobile-none{
       padding-left:0px !important;
       padding-right:0px !important;     
     }

     .padd-xmobile-2{
       padding-left:2px !important;
       padding-right:2px !important;     
     }

     .padd-xmobile-4{
       padding-left:4px !important;
       padding-right:4px !important;     
     }             

     .padd-ymobile-none{
       padding-top:0px !important;
       padding-bottom:0px !important;     
     }
     .padd-ymobile-2{
       padding-top:2px !important;
       padding-bottom:2px !important;     
     }
     .padd-ymobile-4{
       padding-top:4px !important;
       padding-bottom:4px !important;     
     }
     .padd-ymobile-6{
       padding-top:6px !important;
       padding-bottom:6px !important;     
     }


    .icon{
      height: 20px;
      width:20px;
    }
    .icon2{
      height: 30px;
      width:25px;
    }
  }

  /*character icons*/

  .ico-middot:before{
      content: "\25cf";
      font-size: 6px;
      position: relative;
      top:-2px;
  } 

</style>
