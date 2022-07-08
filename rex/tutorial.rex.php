

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
 </style>

 <div class="pxv-20 c-black-ll">
     <ul class="list-square">
         <li> <a href="@DomUrl('tutorial/installation')">Installation</a> </li>
         <li> <a href="@DomUrl('tutorial/live-server')">Live Server</a></li>
         <li> <a href="@DomUrl('tutorial/database')">Database</a> </li>
         <li> <a href="@DomUrl('tutorial/routings')">Routing</a> </li>
         <li> <a href="@DomUrl('tutorial/resource')">Resource class</a> </li>
         <li> <a href="@DomUrl('tutorial/sessions')">Handling Sessions</a> </li>
         <li> <a href="@DomUrl('tutorial/functions')">Helper Functions</a> </li>
         <li> <a href="@DomUrl('tutorial/classes')">Helper Classes</a> </li>
         <li> <a href="@DomUrl('tutorial/directives')">Helper Directives</a> </li>
         <li> <a href="@DomUrl('tutorial/mails')">Handling Mails</a> </li>
         <li> <a href="@DomUrl('tutorial/cli')">Cli Commands</a> </li>

         <li> <a href="@DomUrl('tutorial/plugins')">Composer and Plugins</a></li>
         <li> <a href="@DomUrl('tutorial/wmv')" >The <span class="fb-6 pointer" title="Windows Models View">WMV</span> FRAME</a></li>
     </ul>
 </div>

@template;