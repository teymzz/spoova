

@template('template.t-doc')

    @lay('build.co.coords:header')

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
                        <td> 5.4 + </td> 
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
                        <td> <i class="bi-journal-arrow-down"></i> version <?= SP_VERSION ?> </td> 
                    </tr> 
                
                </tbody>



            </table>

        </div>

    </div>

@template;