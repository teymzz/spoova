

@template('template.t-doc')

@lay('build.coords:header')
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

    <div class="pxv-20">
        <div class=" c-orange font-em-2"> <span class="bi-stack"></span> Pack Download</div>
    
        <div class="">
            The spoova pack can be downloaded as a zip file. There are different packs of spoova 
            frame. Select your desired project pack and click the download option. The installation 
            of these pack files are similar. Extract the zipped pack and install into your root server.
        </div>
    </div>


    <div class="bc-orange c-white pxs-10">

        <div class="bi"> <span class="bi-app"></span> Project Packs </div>  

    </div>

    <div class="pxv-20">
        
        <table class="wid-full">

            <thead>
                <tr class="c-silver-dd"> 
                    <th>Features</th>
                    <th> <i class="bi-vinyl c-gold-dd"></i> Lite</th> 
                    <th> <i class="bi-star c-gold-dd"></i> Pro</th> 
                    <th> <i class="bi-patch-check c-gold-dd"></i> Ultra</th> 
                </tr>
            </thead>

            <tbody>

                
                <tr> 
                    <td>PHP 7.4</td> 
                    <td> <span class="bi-check"></span> </td> 
                    <td> <span class="bi-check"></span> </td> 
                    <td> <span class="bi-check"></span> </td> 
                </tr>    

                <tr> 
                    <td>MySQL 5.4</td> 
                    <td> <span class="bi-check"></span> </td> 
                    <td> <span class="bi-check"></span> </td> 
                    <td> <span class="bi-check"></span> </td> 
                </tr>    

                <tr> 
                    <td>Android KWS Server</td> 
                    <td> <span class="bi-check"></span> </td> 
                    <td> <span class="bi-check"></span> </td> 
                    <td> <span class="bi-check"></span> </td> 
                </tr> 

                <tr> 
                    <td>WVM Support</td> 
                    <td><span class="bi-check"></span></td> 
                    <td><span class="bi-check"></span></td> 
                    <td><span class="bi-check"></span></td> 
                </tr>

                <tr> 
                    <td>MVC Support</td> 
                    <td><span class="bi-check"></span></td> 
                    <td><span class="bi-check"></span></td> 
                    <td><span class="bi-check"></span></td> 
                </tr>

                <tr> 
                    <td>Meta Tool</td> 
                    <td><span class="bi-check"></span></td> 
                    <td><span class="bi-check"></span></td> 
                    <td><span class="bi-check"></span></td> 
                </tr>

                <tr> 
                    <td>FileManager</td> 
                    <td><span class="bi-check"></span></td> 
                    <td><span class="bi-check"></span></td> 
                    <td><span class="bi-check"></span></td> 
                </tr>

                <tr> 
                    <td>Live server</td> 
                    <td><span class="bi-check"></span></td> 
                    <td><span class="bi-check"></span></td> 
                    <td><span class="bi-check"></span></td> 
                </tr>

                <tr> 
                    <td>Fileuploader Tool</td> 
                    <td><span class="bi-x"></span></td> 
                    <td><span class="bi-check"></span></td> 
                    <td><span class="bi-check"></span></td> 
                </tr>

                <tr> 
                    <td>JWSToken</td> 
                    <td><span class="bi-x"></span></td> 
                    <td><span class="bi-check"></span></td> 
                    <td><span class="bi-check"></span></td> 
                </tr>

                <tr> 
                    <td>Jsonfy</td> 
                    <td><span class="bi-x"></span></td> 
                    <td><span class="bi-check"></span></td> 
                    <td><span class="bi-check"></span></td> 
                </tr> 

                <tr> 
                    <td>Hasher</td> 
                    <td><span class="bi-x"></span></td> 
                    <td><span class="bi-x"></span></td> 
                    <td><span class="bi-check"></span></td> 
                </tr>

                <tr> 
                    <td>Inbuilt Mailer <br> (Emogrifier + PHPMailer)</td> 
                    <td><span class="bi-x"></span></td> 
                    <td><span class="bi-x"></span></td> 
                    <td><span class="bi-check"></span></td> 
                </tr>     

                <tr> 
                    <td> DomPDF </td> 
                    <td><span class="bi-x"></span></td> 
                    <td><span class="bi-x"></span></td> 
                    <td><span class="bi-check"></span></td> 
                </tr>        

                <tr> 
                    <td> Bootstrap </td> 
                    <td><span class="bi-check"></span></td> 
                    <td><span class="bi-check"></span></td> 
                    <td><span class="bi-check"></span></td> 
                </tr>        

                <tr> 
                    <td> Bootstrap Icons </td> 
                    <td><span class="bi-check"></span></td> 
                    <td><span class="bi-check"></span></td> 
                    <td><span class="bi-check"></span></td> 
                </tr>        

                <tr> 
                    <td> Jquery Pack (3.5.6) </td> 
                    <td><span class="bi-check"></span></td> 
                    <td><span class="bi-check"></span></td> 
                    <td><span class="bi-check"></span></td> 
                </tr>        

                <tr> 
                    <td> loadFile.js (Jquery depedent) </td> 
                    <td><span class="bi-x"></span></td> 
                    <td><span class="bi-check"></span></td> 
                    <td><span class="bi-check"></span></td> 
                </tr>        

                <tr> 
                    <td>Tutorial</td> 
                    <td> <span class="bi-link-45deg"></span> <a href="">visit link</a> </td> 
                    <td> <span class="bi-link-45deg"></span> <a href="">visit link</a> </td> 
                    <td><span class="bi-check"></span></td> 
                </tr>     

                <tr> 
                    <td class="i"><i class="bi-download"></i> Download</td> 
                    <td> <i class="bi-journal-arrow-down"></i> <a href="packs/spoova-lite.zip">version <?= SP_VERSION ?> L</a> </td> 
                    <td> <i class="bi-journal-arrow-down"></i> <a href="packs/spoova-lite.zip">version <?= SP_VERSION ?> P</a> </td> 
                    <td> <i class="bi-journal-arrow-down"></i> <a href="packs/spoova-lite.zip">version <?= SP_VERSION ?> U</a> </td>  
                </tr> 
               
            </tbody>



        </table>

    </div>

    <div class="bc-orange c-white pxs-10">

        <div class="bi"> <span class="bi-cpu"></span> Installation </div>  

    </div>

    <div class="pxv-20 font-menu font-em-d85">
        The following steps defines how to install your project pack on PC. <br> <br>

        <ul>
            <li>Extract project pack folder</li>
            <li>Place spoova pack folder into your server root</li>
            <li>From the spoova folder open cli and run php spoova project &lt;project_name&gt; where "project_name" is your new project name.</li> 
            <li>After successful creation, open your new project link</li> 
        </ul>
    </div>

    <div class="bc-orange c-white pxs-10">

        <div class="bi"> <span class="bi-phone"></span> Android Installation </div>  

    </div>

    <div class="pxv-20 font-menu font-em-d85">
        The following steps defines how to install your project pack. <br> <br>

        <ul>
            <li>Install Pro KWS server from the android playstore</li>
            <li>Install suggested web editor (Acode) from playstore.</li>
            <li>Extract your downloaded project pack folder</li>
            <li>Copy spoova pack folder into the phone's server root</li>
            <li>Rename the copied folder to your desired project folder name</li> 
            <li>Ensure that your server is active and accessible</li> 
            <li>Visit your new folder from your device's local server address</li> 
            <li>Navigate to the install path to complete installation (e.g http://localhost/app/install)</li> 
            <li>Configure essential database parameters</li> 
            <li>Enjoy!!!</li> 
        </ul>
    </div>

</div>

@template;