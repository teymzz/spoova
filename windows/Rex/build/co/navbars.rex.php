
@layout:left-nav 

     @style('build.css.navbars:nav-left')

     <nav class="nav-left fixed">

          <div class="flex pxv-10">
               <div class="flex-icon theme-btn box bd bd-silver rad-r anc-btn-link flow-hide bc-silver ripple relative" style="transition: none">
                    <div class="px-40 b-cover ico-spin" data-src="@mapp('images/icons/favicon.png')" style="transition: none"></div>
                    <div class="font-em-1d5 px-40 flex mid overlay fb-9 calibri" style="top:-2px; left:.4px; z-index: 1; color:#202dd5;">
                         s 
                    </div>
               </div>
               <a href="@Domurl()" class="flex">
                    <div class="flex midv mxl-8 fb-9 font-menu font-em-1d2" style="color: #202dd5">POOVA</div>
               </a>
          </div> <br>

          <ul class="list-square">
               <li> <a href="@DomUrl('docs/installation')" class="@inPath('active')"><span class="ico ico-spin"></span>Installation</a> </li>
               <li> <a href="@DomUrl('docs/wmv')" class="@inPath('active')" ><span class="ico ico-spin"></span><span class="fb-6 pointer" title="Windows Models View">WMV</span> PATTERN</a></li>
               <li> <a href="@DomUrl('docs/live-server')" class="@inPath('active')"><span class="ico ico-spin"></span>Live Server</a></li>
               <li> <a href="@DomUrl('docs/database')" class="@inPath('active')"><span class="ico ico-spin"></span>Database</a> </li>
               <li> <a href="@DomUrl('docs/resource')" class="@inPath('active')"><span class="ico ico-spin"></span>Resource class</a> </li>
               <li> <a href="@DomUrl('docs/routings')" class="@inPath('active')"><span class="ico ico-spin"></span>Routing System</a> </li>
               <li> <a href="@DomUrl('docs/sessions')" class="@inPath('active')"><span class="ico ico-spin"></span>Handling Sessions</a> </li>
               <li> <a href="@DomUrl('docs/forms')" class="@inPath('active')"><span class="ico ico-spin"></span>Handling Forms</a> </li>
               <li> <a href="@DomUrl('docs/useraccounts')" class="@inPath('active')"><span class="ico ico-spin"></span>Handling Users</a> </li>
               <li> <a href="@DomUrl('docs/database/data-model')" class="@inPath('active')"><span class="ico ico-spin"></span>Handling DBModels</a> </li>
               <li> <a href="@DomUrl('docs/database/migrations')" class="@inPath('active')"><span class="ico ico-spin"></span>Handling Migrations</a> </li>
               <li> <a href="@DomUrl('docs/classes')" class="@inPath('active')"><span class="ico ico-spin"></span>Helper Classes</a> </li>
               <li> <a href="@DomUrl('docs/functions')" class="@inPath('active')"><span class="ico ico-spin"></span>Helper Functions</a> </li>
               <li> <a href="@DomUrl('docs/template')" class="@inPath('active')"><span class="ico ico-spin"></span>Template Engine</a> </li>
               <li> <a href="@DomUrl('docs/setters')" class="@inPath('active')"><span class="ico ico-spin"></span>Global Setters</a> </li>
               <li> <a href="@DomUrl('docs/mails')" class="@inPath('active')"><span class="ico ico-spin"></span>Handling Mails</a> </li>
               <li> <a href="@DomUrl('docs/cli')" class="@inPath('active')"><span class="ico ico-spin"></span>Cli Commands</a> </li>         
               <li> <a href="@DomUrl('docs/plugins')" class="@inPath('active')"><span class="ico ico-spin"></span>Composer and Plugins</a></li>
               <li> <a href="@DomUrl('docs/libraries')" class="@inPath('active')"><span class="ico ico-spin"></span>Third-Party Libraries</a> </li>
               <li> <a href="@DomUrl('docs/other-features')" class="@inPath('active')"><span class="ico ico-spin"></span>Other Features</a> </li>
          </ul>
      
     </nav>

@layout;