@template('template.t-doc')

    @lay('build.coords:header')
    
    
      <div class="pxv-20 c-black-ll">
        
        @lay('build.links:tutor_pointer')

        <div class="font-em-1d5 c-orange">Functions</div> <br>  
        
        <div class="resource-intro">
            <div class="fb-6">Introduction</div>
            <div class="">
                Helper functions are predefined spoova functions that eases building 
                web applications. Spoova helper functions are divided into five categories 
                (CMLS)
                
                <br><br>
                
                <li><a href="#core">Core Functions</a></li>
                <li><a href="#modal">Modal Functions</a></li>
                <li><a href="#lite">Lite Functions</a></li>
                <li><a href="#script">Script Functions</a></li>
                
            </div> 
         </div>
         
        <div id="core" class="core-helpers"> 
            <br>
            <div class="font-menu fb-6 bc-white-dd flex-full rad-4 pxv-8 lacier">
              <div class="flex-full">1. Core Functions</div>
              <div class="flex mid">
                <span class="bi-chevron-double-right"></span>
              </div>
            </div> <br>
            
            <div>The core helper functions are custom functions that are introduced 
            into the core framework itself due to their high level of importance. They 
            sometimes have direct relationships with main classes and just provide an easier         
            means of accessing these classes methods or returns the value of specific methods  
            The removal of any of these methods will most likely result in a broken application. 
            </div> <br>

            <div class="">
                <div class="font-menu font-em-1">
                  <ul>
                    <li> <a href="@DomUrl('tutorial/functions/core#webclass')"> webClass </a> </li>
                    <li> <a href="@DomUrl('tutorial/functions/core#webtool')"> webTool </a> </li>
                    <li> <a href="@DomUrl('tutorial/functions/core#isguest')"> isGuest </a> </li>
                    <li> <a href="@DomUrl('tutorial/functions/core#isuser')"> isUser </a> </li>
                    <li> <a href="@DomUrl('tutorial/functions/core#ishttp')"> isHTTP </a> </li>
                    <li> <a href="@DomUrl('tutorial/functions/core#ishttps')"> isHTTPS </a> </li>
                    <li> <a href="@DomUrl('tutorial/functions/core#isabsolutepath')"> isAbsolutePath </a> </li>
                    <li> <a href="@DomUrl('tutorial/functions/core#authdirect')"> authDirect </a> </li>
                    <li> <a href="@DomUrl('tutorial/functions/core#guestdirect')"> guestDirect </a> </li>
                    <li> <a href="@DomUrl('tutorial/functions/core#redirect')"> redirect </a> </li>
                    <li> <a href="@DomUrl('tutorial/functions/core#response')"> response </a> </li>
                    <li> <a href="@DomUrl('tutorial/functions/core#setvar')"> setVar </a> </li>
                    <li> <a href="@DomUrl('tutorial/functions/core#vdump')"> vdump </a> </li>
                    <li> <a href="@DomUrl('tutorial/functions/core#urlparams')"> urlParams </a> </li>
                    <li> <a href="@DomUrl('tutorial/functions/core')"> url </a> </li>
                    <li style="list-style: square;">
                      <div class="pvt-6 fb-6 font-menu font-em-1">Route functions</div>    
                      <ul class="list-disc" style="padding:.2em">
                        <li> <a href="@DomUrl('tutorial/functions/core#compile')"> compile </a> </li> </li>
                        <li> <a href="@DomUrl('tutorial/functions/core#view')"> view </a> </li> </li>
                      </ul>
                    </li>
                  </ul>
                </div>
            </div>        
        </div>         
         
        <div id="modal" class="modal-helpers">
            <br>
            <div class="font-menu fb-6 bc-white-dd flex-full rad-4 pxv-8 lacier">
              <div class="flex-full">2. Modal Functions</div>
              <div class="flex mid">
                <span class="bi-chevron-double-right"></span>
              </div>
            </div> <br>
            
            <div>
              The modal custom helper functions that are helpful in the framework             
              They help to handle some tedious tasks easily. They have no relationship with 
              higher classes but are cogent in the build-up of spoova frame. The removal of 
              some of these functions may lead to broken applications. Hence are best not 
              removed. 
            </div> <br>

            <div class="">
                <div class="font-menu font-em-1">
                  <ul class="list-square">
                    <li> <a href="@DomUrl('tutorial/functions/modal#br')"> br </a> </li>
                    <li> <a href="@DomUrl('tutorial/functions/modal#myisset')"> myIsset </a> </li>
                    <li> <a href="@DomUrl('tutorial/functions/modal#refil')"> refil </a> </li>
                    <li> <a href="@DomUrl('tutorial/functions/modal#encodeuricomponent')"> encodeURIComponent </a> </li>
                    <li> <a href="@DomUrl('tutorial/functions/modal#inrange')"> inRange </a> </li>
                    <li> <a href="@DomUrl('tutorial/functions/modal#randice')"> randice </a> </li>
                    <li> <a href="@DomUrl('tutorial/functions/modal#is_empty')"> is_empty </a> </li>
                    <li> <a href="@DomUrl('tutorial/functions/modal#not_empty')"> not_empty </a> </li>
                    <li> <a href="@DomUrl('tutorial/functions/modal#combine')"> combine </a> </li>
                    <li> <a href="@DomUrl('tutorial/functions/modal#compare')"> compare </a> </li>
                    <li> <a href="@DomUrl('tutorial/functions/modal#arrinside')"> arrInside </a> </li>
                    <li> <a href="@DomUrl('tutorial/functions/modal#arrvoid')"> arrVoid </a> </li>
                    <li> <a href="@DomUrl('tutorial/functions/modal#arrgetsvoid')"> arrGetsVoid </a> </li>
                    <li> <a href="@DomUrl('tutorial/functions/modal#resortarray')"> arrSort </a> </li>
                    <li> <a href="@DomUrl('tutorial/functions/modal#array_trim')"> array_trim </a> </li>
                    <li> <a href="@DomUrl('tutorial/functions/modal#array_get')"> array_get </a> </li>
                    <li> <a href="@DomUrl('tutorial/functions/modal#array_object')"> array_object </a> </li>
                    <li> <a href="@DomUrl('tutorial/functions/modal#array_count')"> array_count </a> </li>
                    <li> <a href="@DomUrl('tutorial/functions/modal#array_delete')"> array_delete </a> </li>
                    <li> <a href="@DomUrl('tutorial/functions/modal#array_unset')"> array_unset </a> </li>
                    <li> <a href="@DomUrl('tutorial/functions/modal#reitemize')"> reItemize </a> </li>
                  </ul>
                </div> 
            </div>        
        </div>         
         
        <div id="lite" class="lite-helpers">
            <br>
            <div class="font-menu fb-6 bc-white-dd flex-full rad-4 pxv-8 lacier">
              <div class="flex-full">3. Lite Functions</div> 
              <div class="flex mid">
                <span class="bi-chevron-double-right"></span>
              </div>
            </div> <br>
            
            <div>
              The lite helper functions are functions that are either coined 
              from an existing php internal functions or custom functions that are 
              applied on texts. These functions exist to ease building web applications 
              for developers as they can sometimes prove useful.
            </div> <br>

            <div class="">
                <div class="font-menu font-em-1">
                  <ul class="list-square">
                    <li> <a href="@DomUrl('tutorial/functions/lite#base_encode')"> base_encode </a> </li>
                    <li> <a href="@DomUrl('tutorial/functions/lite#base_decode')"> base_decode </a> </li>
                    <li> <a href="@DomUrl('tutorial/functions/lite#tojson')"> toJson </a> </li>
                    <li> <a href="@DomUrl('tutorial/functions/lite#fromjson')"> fromJson </a> </li>
                    <li> <a href="@DomUrl('tutorial/functions/lite#to_lgts')"> to_lgts </a> </li>
                    <li> <a href="@DomUrl('tutorial/functions/lite#href')"> href </a> </li>
                    <li> <a href="@DomUrl('tutorial/functions/lite#scriptname')"> scriptName </a> </li>
                    <li> <a href="@DomUrl('tutorial/functions/lite#striplastslash')"> striplastSlash </a> </li>
                    <li> <a href="@DomUrl('tutorial/functions/lite#redirectto')"> redirectTo </a> </li>
                    <li> <a href="@DomUrl('tutorial/functions/lite#limittext')"> limitText </a> </li>
                    <li> <a href="@DomUrl('tutorial/functions/lite#limitchars')"> limitChars </a> </li>
                    <li> <a href="@DomUrl('tutorial/functions/lite#limitword')"> limitWord </a> </li>
                  </ul>
                </div> <br>
            </div>        
        </div>         
         
        <div id="script" class="script-helpers">
            <br>
            <div class="font-menu fb-6 bc-white-dd flex-full rad-4 pxv-8 lacier">
              <div class="flex-full">4. Script Functions</div> 
              <div class="flex mid">
                <span class="bi-chevron-double-right"></span>
              </div>
            </div> <br>
            
            <div>
              The script helper functions are functions are custom functions that depend on
              javascript to run. These functions may prove useful when handling data types.
            </div> <br>

            <div class="">
                <div class="font-menu font-em-1">
                  <ul class="list-square">
                    <li> <a href="@DomUrl('tutorial/functions/script#alert')"> alert </a> </li>
                    <li> <a href="@DomUrl('tutorial/functions/script#javaconsole')"> javaconsole </a> </li>
                    <li> <a href="@DomUrl('tutorial/functions/script#script')"> script </a> </li>
                  </ul>
                </div> <br>
            </div>        
        </div>         
        
        
      
      </div>  
    
    
    @lay('build.coords:footer')


@template;