@template('template.t-doc')

    @lay('build.coords:header')
    <style>
        ul > li > a{
            color:inherit;
        }   

        ul > li > a:hover{
            color:inherit;
        }   

        ul > li a:hover{
        color: var(--orange-dd);
        cursor:pointer;
        }

        .olist {
            font-family: calibri;
            color: burlywood;
        }
    </style>

    <div class="pxv-20 c-black-ll">
        
        @lay('build.links:tutor_pointer')

        <div class="font-em-1d5 c-orange">Resource</div> <br>
        
        <div class="resource-intro">
            <div class="fb-6">Introduction</div>
            <div class="">
                Spoova uses the resource class <code>Res</code> to handle a lot of directives. These directives 
                are listed below <br><br>
                
                <li>Resource Grouping</li>
                <li>Resource Routing</li>
                <li>Resource Flashes</li>
                <li>Resource Commands</li>
                
            </div> 
        </div> <br>

        <div class="resource-grouping">
            <div class="font-menu fb-6 bc-white-dd mox-full rad-4 pxv-8">
                1. Resource Grouping
            </div> <br><br>


            <div class="">
                <div class="font-menu font-em-1">
                Static urls are controlled through the use of Resource class that supports the grouping 
                and importation of static urls. The urls supplied are either validated (local urls) or unvalidated 
                (protocol urls) and then resolved into an http protocol format that is recognizable by the development system.
                In this way, local urls becomes responsive in both offline and online enviroments. As a general rule, all static urls 
                are are placed into the global resource folder <code>res</code> . This enables the Resource class to locate and 
                import them from their respective directories within that <code>res</code> folder. <a href="@Domurl('tutorial/resource/grouping')">Learn more.</a>
                </div> <br>
            </div>        
        </div>

        <div class="resource-routing">
            <div class="font-menu fb-6 bc-white-dd mox-full rad-4 pxv-8">
                2. Resource Routing
            </div> <br><br>


            <div class="">
                <div class="font-menu font-em-1">
                Routing is done by the use of routing directives. These are <code>Res::load()</code>
                <code>Res::get()</code> and <code>Res::post()</code> directives. The <code>Res::load()</code> 
                is specific to wvm routing while the other two are used for mvc routing. You can learn more about this from 
                <a href="@DomUrl('tutorials/routings')">routing</a>.
                </div> <br>
            </div>        
        </div>

        <div class="resource-flashes">
            <div class="font-menu fb-6 bc-white-dd mox-full rad-4 pxv-8">
                3. Resource Flashes
            </div> <br><br>


            <div class="">
                <div class="font-menu font-em-1">
                Flashes are coined from the notice class. The help to set flash messages which are only displayed once. 
                However, the resource class uses shortand helper method to access some of the basic methods of the Notice (Flash)
                class. These methods are <code>Res::setFlash()</code> which sets a flash and <code>Res::Flash()</code> which reveals 
                a flash message when it exists <a href="@DomUrl('tutorial/resource/flash')">Learn more.</a>
                </div> <br>
            </div>        
        </div>    

        <div class="resource-comman">
            <div class="font-menu fb-6 bc-white-dd mox-full rad-4 pxv-8">
                3. Resource Commands
            </div> <br><br>


            <div class="">
                <div class="font-menu font-em-1">
                For mobile support, the resource class has been built with few helper commands. which can be use as directives to 
                create an action. These commands are only shell commands which are redefined for mobile systems that do not support running cli commands.
                <a href="@DomUrl('tutorial/resource/commands')">Learn more.</a>
                </div> <br>
            </div>        
        </div>    
    
        @lay('build.links:tutor_pointer')
    </div>

@template;