

@template('template.t-tut')

    @lay('build.co.coords:header')
    @style('build.css.navbars:nav-left')
    <style>
        /* table{ 
            border-spacing: 1em;
            border-collapse: separate;
        } */
        table tr td, table tr th{
            padding: 10px 0;
        }
        table tr td{
            font-family: calibri;
            font: menu;
            font-size: 14px;
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
        header {
            position: fixed;
            z-index: 2;
        }
        .nav-left{
            padding-top: 80px;
        }
        .features{
            padding-top: 60px;
        }
        a:hover{
            color: inherit;
        }
    </style>

    <nav class="nav-left fixed">

        <ul class="list-square">
            <li> <a href="@DomUrl('docs/')"><span class="ico ico-spin"></span>Home</a> </li>
            <li> <a href="@DomUrl('about')" class="@inPath('active')" ><span class="ico ico-spin"></span>About</a></li>
            <li> <a href="@DomUrl('docs/')" class="@inPath('active')"><span class="ico ico-spin"></span>Documentation</a></li>
            <li> <a href="@DomUrl('docs/installation')" class="@inPath('active')"><span class="ico ico-spin"></span>Installation</a> </li>
            <li> <a href="@DomUrl('features')" class="@inPath('active')"><span class="ico ico-spin"></span>Features</a> </li>
            <li> <a href="@DomUrl('version')" class="@inPath('active')"><span class="ico ico-spin"></span>Releases</a> </li>
        </ul>

    </nav>

    <div class="box-full pxl-2 bc-white pull-right features">
       <section class="pxs-10 tutorial bc-white">
           <div class="font-em-1d2">

                <div class="c-black-ll font-em-1d2">

                    <div class="pxv-20 pvb-2">
                        <div class=" c-orange font-em-1d5"> <span class="bi-window font-em-d85"></span> <span class="font-em-d82">Project Pack</span></div>
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
                                    <td>  8.0+</td> 
                                </tr>    

                                <tr> 
                                    <td>MySQL Version Support</td> 
                                    <td> 5.4+ </td> 
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
                                    <td>Stable</td> 
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
                                    <td>Bootstrap Font Icons (v1.10.0)</td>
                                </tr>

                                <tr> 
                                    <td>Javascript Library</td> 
                                    <td>JQuery (3.5.6)</td> 
                                </tr>

                                <tr> 
                                    <td>Third-party Mailer Libraries (Required)</td> 
                                    <td>Emogrifier, PHPMailer</td> 
                                </tr>        

                                <tr> 
                                    <td>Documentation</td> 
                                    <td> <span class="bi-journal-text"></span> <a href="docs" class="c-teal rule-dotted">offline</a> </td> 
                                </tr>     

                                <tr> 
                                    <td class="i"><i class="bi-app-indicator"></i> Version</td> 
                                    <td> <i class="bi-journal-arrow-down"></i> version <?= SP_VERSION ?> </td> 
                                </tr> 
                            
                            </tbody>



                        </table>

                    </div>

                </div>
           </div>
       </section>
    </div>
@template;