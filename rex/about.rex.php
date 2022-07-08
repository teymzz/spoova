

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

        @lay('build.links:tutor_pointer')

        <div class=" c-orange font-em-2"> <span class="bi-stack"></span> About</div>
    
        <div class="">
            Spoova was built to emulate mobile compatibility and enable faster web development 
            through the use of live server. This application has been tested across different server 
            such as cpanel, heroku and android kws server. The concept behind its creation is to provide 
            a synergy between online and offline development. It also uses a windows-frame mvc pattern 
            which makes is easier to load pages.
        </div>
    </div>

    <div class="bc-orange c-white pxs-10">

        <div class="bi"> <span class="bi-cpu"></span> How it works </div>  

    </div>

    <div class="pxv-20 font-menu font-em-d85">
        The spoova window system can be likened to a real house. Every house has a door and a window. 
        In WVM, there is only one main entry point which can either be active or passive depending on the 
        availability of a root window entry points that leads to a view. A window is only generated when the 
        particular url supplied does not exist. Such url will be handled using a window file. Window files 
        are located within the "windows" directory. When a window is not handled (using a window file), when such 
        window is visited or called, it automatically becomes an entry point handled by a base window file "Index" if it exists. 
        The Index (base window entry point) uses its method "usedoor" as an entry point to handle all non-existing windows. The entire relationship between a window and its view, using the model as 
        its structure is what forms the WVM or WinViM sytem which is just a system built on MVC architecture. Although the 
        process may sound complex, it is much easier to implement.
    </div>

    <div class="bc-orange c-white pxs-10">

        <div class="bi"> <span class="bi-lock"></span> Security </div>  

    </div>

    <div class="pxv-20 font-menu font-em-d85">
        Although great care has be taken to enable building secure apps, developers should trend 
        carefully with form inputs. Great care must be taken to validate form inputs as improper 
        validation may lead to undesired responses. <br><br>
    </div>

    <div class="bc-orange c-white pxs-10">

        <div class="bi"> <span class="bi-hdd-stack"></span> Deploying Application</div>  

    </div>

    <div class="pxv-20 font-menu font-em-d85">
        It is very easy to deploy project apps online. Once a project application has been sucessfully deployed, 
        it must be mapped to the online enviroment. This is achieved by visiting the domain url index page 
        which in turn activates the project app for online view. The root htaccess file is a key feature and 
        backbone in WinViM system, hence it should not be tampered with. If there is any reason to re-upload 
        the htaccess file or project folder name, the mapping process must be revisited as it is important to keep
        the project application properly mapped to its contents.
    </div>

    <div class="bc-orange c-white pxs-10">

        <div class="bi"> <span class="bi-vinyl"></span> Why Spoova?</div>  

    </div>

    <div class="pxv-20 font-menu font-em-d85">
        <p>
            The idea concept of spoova is to provide a portable development structure. Portability here means the use of both 
            desktop PC's and mobile devices to develop solid applications on the go without having to worry about which environment 
            was used to develop such application. This idea will make it easier to run projects and switch between mobiles and PC's 
            easily. With the right use of this framework, if a project is properly saved or stored into an accessible environment, 
            both devices (Mobile and PC) can equally make considerable changes such as code editing or uprading at any point in time. 
        </p>
        
        <p>
            Also, spoova enables faster development by switching connection paramters based on environment. This may not be true for 
            all enviroment, however, this is a benefit for most systems. The architectural design of the code structure makes the entire 
            process of future upgrades an easy possibility. 
        </p>
    </div>

</div>

@template;