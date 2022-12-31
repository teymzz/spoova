



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/png" href="http://localhost/spoova/res/main/images/icons/favicon.png">
    <title>Download</title>
    <meta name="viewport" content="width=device-width, initial-scale=.9, maximum-scale=1.0, user-scalable=1" />
<meta name="description" content="website_description" />
<link rel="icon" href="http://localhost/spoova/res/main/images/icons/favicon.png" />
    <link  rel="stylesheet" type="text/css" href="http://localhost/spoova/res/main/css/res.css" x-debug="res-css"><script src='http://localhost/spoova/res/main/js/jquery-3.6.0.js'></script><script src='http://localhost/spoova/res/main/css/bootstrap/js/bootstrap.min.js'></script><link  rel="stylesheet" type="text/css" href="http://localhost/spoova/res/main/css/mdb5/css/mdb.min.css"><script src='http://localhost/spoova/res/main/js/config.js'></script><script src='http://localhost/spoova/res/main/js/core.js'></script><script src='http://localhost/spoova/res/main/js/onLoaded.js'></script><script src='http://localhost/spoova/res/main/js/custom.js'></script><script src='http://localhost/spoova/res/main/js/device.js'></script><script src='http://localhost/spoova/res/main/js/loadImages.js'></script><script src='http://localhost/spoova/res/main/js/formValidator.js'></script><script src='http://localhost/spoova/res/main/js/jquery.mousewheel.js'></script><script src='http://localhost/spoova/res/main/js/anime.js'></script><script src='http://localhost/spoova/res/main/js/init.js'></script>
</head>
<body>

    <section class="box-2s">
        <div class="shadow vhm-100">
            

    
 
 <style rel="build.css.headers"> 
.--theme-dark > * {
   --white-dd: 11, 10, 28;
   --white:  21, 15, 39;
   --off-white: 22, 23, 62;
   --black-ll: 179, 179, 179; 
   --silver: 23, 28, 56;       
   --silver-d: 21, 25, 49;       
   --silver-dd: 23, 28, 56;       
}

.--theme-dark .--theme-esc{
   --white-dd: 240, 240, 240;
   --white:  255, 255, 255;
   --black-ll: 79, 79, 79;
}

.--theme-dark .bc-white-d.--theme-esc{
    --white-d: 21, 24, 51;
    --white-dd: 23, 28, 56;
    --silver-d: var(--white-dd);
    color: rgb(203, 198, 198);
}

.--theme-dark .bc-white-d.--theme-esc .flex-full > *{
    --white: 255, 255, 255;
    --white-d: 250, 250, 250;
    --white-dd: 240, 240, 240;
    --black-ll: 79, 79, 79;
    --silver: 230, 230, 230;
    --silver-d: 220, 220, 220;
    --silver-dd: 200, 200, 200;
}

body.--theme-dark{
    background-color : rgba(21, 15, 39);
}
 </style>
 <script> 
    

     $(document).ready(function(){
          function runHash(){
          $('.lacier').removeClass('active');
          $hash = hashRunner(':get');       
          $('#'+$hash).on('click',function(){
               let el = '#'+$hash+' .lacier';
               $('.lacier').removeClass('active');
               $(el).addClass('active');
          })
          hashRunner('id');             
          }
          runHash();
          $(window).on('hashchange', function() { runHash(); })
     })

 
</script>

 <header class="bc-white-dd flex-full pxv-10">

    <div class="flex text-caps midv font-em-1d2">
        <div class="">
            <a href="<?= DomUrl('/') ?>">
                <div class="px-40 rad-r b-cover ico-spin" data-src="<?= DomUrl('res/main/images/icons/favicon.png') ?>">
    
                </div>
            </a>
        </div>
        <div class="no-wrap fb-6 c-blue-dd">SPOOVA FRAME</div>
    </div>

    <div class="flex-full flex-r midv c-blue-dd hide"> 
        <span class="mxr-4"> <span class="bi-house"></span>  Home</span>
    </div>
    
 </header>



    <style>
        
        ul > li > a{
            color:inherit;
        }   

        ul > li > a:hover{
            color:inherit;
        }   

        ul > li:hover{
        color: var(--orange-dd);
        cursor:pointer;
        }
        table td { 
            border-spacing: 1em;
            border-collapse: separate;
        }
        table tr td, table tr th{
        padding: 10px 0;
        }
        table tr td{
            font-family: calibri;
            font: menu;
        }
        table .bi-check {
            font-weight: 900;
            font-size: 2.5em;
            color: var(--lime-dd);
        }

        table .bi-x {
            font-weight: 900;
            font-size: 2.5em;
            color: var(--red-dd);
        }
    </style>

    <div class="c-black-ll font-em-1d2">

        <div class="pxv-20 pvb-2">
            <div class=" c-orange font-em-1d5"> <span class="bi-stack font-em-d85"></span> Project Pack Features</div>
        </div>

        <div class="pxv-20">
            
            <table class="wid-full">

                <thead>
                    <tr class="c-slate-grey"> 
                        <th>Features</th>
                        <th> <i class="bi-vinyl"></i> Details</th> 
                    </tr>
                </thead>

                <tbody>

                    
                    <tr> 
                        <td>PHP Version Support</td> 
                        <td>  8.0, 8.1</td> 
                    </tr>    

                    <tr> 
                        <td>MySQL Version Support</td> 
                        <td> 5.4 </td> 
                    </tr>    

                    <tr> 
                        <td>Mobile Web Server Support</td> 
                        <td> Android KWS Server (No root) </td> 
                    </tr> 

                    <tr> 
                        <td>MVC Architecture</td> 
                        <td>Windows-View-Model (WVM)</td> 
                    </tr>

                    <tr> 
                        <td>Routing Support</td> 
                        <td>Port(8080)</td> 
                    </tr>

                    <tr> 
                        <td>Live Server Support</td> 
                        <td>Beta</td> 
                    </tr>

                    <tr> 
                        <td>Inbuilt Helper Tools</td> 
                        <td>Meta, FileUploader, Mailer</td> 
                    </tr>

                    <tr> 
                        <td>Inbuilt Helper Classes</td> 
                        <td>JWSToken, Jsonfy, Hasher</td> 
                    </tr>

                    <tr> 
                        <td>Css Library</td> 
                        <td>Bootstrap, MD5 Bootstrap (lite), Local Library</td>
                    </tr>

                    <tr> 
                        <td>Css Icons</td> 
                        <td>Bootstrap 5 icons (lite)</td>
                    </tr>

                    <tr> 
                        <td>Javascript Library</td> 
                        <td>JQuery (3.5.6)</td> 
                    </tr>

                    <tr> 
                        <td>Third-party Mailer Libraries</td> 
                        <td>Emogrifier, PHPMailer</td> 
                    </tr>        

                    <tr> 
                        <td>Documentation</td> 
                        <td> <span class="bi-link-45deg"></span> <a href="docs">visit link</a> </td> 
                    </tr>     

                    <tr> 
                        <td class="i"><i class="bi-download"></i> Version</td> 
                        <td> <i class="bi-journal-arrow-down"></i> version 0.0.1 </td> 
                    </tr> 
                
                </tbody>



            </table>

        </div>

    </div>


        </div>
    </section>

</body>
</html>