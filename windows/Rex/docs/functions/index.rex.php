
@template('template.t-tut')

  <!-- @lay('build.co.coords:header') -->

  @lay('build.co.navbars:left-nav')

  <div class="box-full pxl-2 bc-white-dd pull-right">
    <section class="pxv-10 tutorial database bc-white">
      <div class="font-em-1d2">

        @lay('build.co.links:tutor_pointer')

        <div class="start font-em-d8">

          <div class="font-em-1d5 c-orange">Functions</div> <br>  
          
          <div class="resource-intro">
              <div class="fb-6 c-olive">Introduction</div>
              <div class="">

                  <div class="">
                    Helper functions are predefined spoova functions that eases building 
                    web applications. Spoova helper functions are divided into five categories 
                    (CMLS)
                  </div><br>

                  <ul>
                    <li><a href="#core" data-scroll-hash="core" data-minus="10">Core Functions</a></li>
                    <li><a href="#modal" data-scroll-hash="modal" data-minus="10">Modal Functions</a></li>
                    <li><a href="#lite" data-scroll-hash="lite" data-minus="10">Lite Functions</a></li>
                    <li><a href="#script" data-scroll-hash="script" data-minus="10">Script Functions</a></li>
                  </ul>
                  
              </div>
          </div>
          
          <div id="core" class="core-helpers"> 
              <div class="font-menu fb-6 bc-white-dd flex-full rad-4 pxv-8 lacier">
                <div class="flex-full c-olive">1. Core Functions</div>
              </div> <br>
              
              <div>The core helper functions are custom functions that are introduced 
              into the core framework itself due to their high level of importance. They 
              sometimes have direct relationships with main classes and just provide an easier         
              means of accessing these classes methods or returns the value of specific methods  
              The removal of any of these methods will most likely result in a broken application. 
              </div> <br>

              <div class="">
                  <div class="font-menu font-em-d9 c-aqua-dd" style="color:rgb(12, 131, 131)">
                    <ul>
                      <li> <a href="@route('::core#webclass')"> webClass </a> </li>
                      <li> <a href="@route('::core#isguest')"> isGuest </a> </li>
                      <li> <a href="@route('::core#isuser')"> isUser </a> </li>
                      <li> <a href="@route('::core#ishttp')"> isHTTP </a> </li>
                      <li> <a href="@route('::core#ishttps')"> isHTTPS </a> </li>
                      <li> <a href="@route('::core#isabsolutepath')"> isAbsolutePath </a> </li>
                      <li> <a href="@route('::core#invoked')"> invoked </a> </li>
                      <li> <a href="@route('::core#windowincludes')"> windowIncludes </a> </li>
                      <li> <a href="@route('::core#windowexcludes')"> windowExcludes </a> </li>
                      <li> <a href="@route('::core#authdirect')"> authDirect </a> </li>
                      <li> <a href="@route('::core#guestdirect')"> guestDirect </a> </li>
                      <li> <a href="@route('::core#redirect')"> redirect </a> </li>
                      <li> <a href="@route('::core#response')"> response </a> </li>
                      <li> <a href="@route('::core#setvar')"> setVar </a> </li>
                      <li> <a href="@route('::core#vdump')"> vdump </a> </li>
                      <li> <a href="@route('::core#env')"> env </a> </li>
                      <li> <a href="@route('::core#urlparams')"> urlParams </a> </li>
                      <li> <a href="@route('::core#url')"> url </a> </li>
                      <li style="list-style: square;">
                        <div class="pvt-6 fb-6 font-menu font-em-1">Template Compiler functions</div>    
                        <ul class="list-disc" style="padding:.5em">
                          <li> <a href="@DomUrl('docs/functions/core#compile')"> compile </a> </li> </li>
                          <li> <a href="@DomUrl('docs/functions/core#view')"> view </a> </li> </li>
                        </ul>
                      </li>
                    </ul>
                  </div>
              </div>        
          </div>         
          
          <div id="modal" class="modal-helpers">
              <div class="font-menu fb-6 bc-white-dd flex-full rad-4 pxv-8 lacier">
                <div class="flex-full c-olive">2. Modal Functions</div>
              </div> <br>
              
              <div>
                The modal custom helper functions are functions that help to handle some tedious 
                tasks easily. They have no relationship with 
                higher classes but are cogent in the build-up of spoova frame. The removal of 
                some of these functions may lead to broken applications. Hence are best not 
                removed. 
              </div> <br>

              <div class="">
                  <div class="font-menu font-em-d9" style="color:rgb(12, 131, 131)">
                    <ul class="list-square">
                      <li> <a href="@DomUrl('docs/functions/modal#br')"> br </a> </li>
                      <li> <a href="@DomUrl('docs/functions/modal#refil')"> refil </a> </li>
                      <li> <a href="@DomUrl('docs/functions/modal#encodeuricomponent')"> encodeURIComponent </a> </li>
                      <li> <a href="@DomUrl('docs/functions/modal#inrange')"> inRange </a> </li>
                      <li> <a href="@DomUrl('docs/functions/modal#randice')"> randice </a> </li>
                      <li> <a href="@DomUrl('docs/functions/modal#is_empty')"> is_empty </a> </li>
                      <li> <a href="@DomUrl('docs/functions/modal#not_empty')"> not_empty </a> </li>
                      <li> <a href="@DomUrl('docs/functions/modal#combine')"> combine </a> </li>
                      <li> <a href="@DomUrl('docs/functions/modal#compare')"> compare </a> </li>
                      <li> <a href="@DomUrl('docs/functions/modal#arrinside')"> arrInside </a> </li>
                      <li> <a href="@DomUrl('docs/functions/modal#arrvoid')"> arrVoid </a> </li>
                      <li> <a href="@DomUrl('docs/functions/modal#arrgetsvoid')"> arrGetsVoid </a> </li>
                      <li> <a href="@DomUrl('docs/functions/modal#arrsort')"> arrSort </a> </li>
                      <li> <a href="@DomUrl('docs/functions/modal#array_trim')"> array_trim </a> </li>
                      <li> <a href="@DomUrl('docs/functions/modal#array_get')"> array_get </a> </li>
                      <li> <a href="@DomUrl('docs/functions/modal#array_object')"> array_object </a> </li>
                      <li> <a href="@DomUrl('docs/functions/modal#array_delete')"> array_delete </a> </li>
                      <li> <a href="@DomUrl('docs/functions/modal#array_unset')"> array_unset </a> </li>
                      <li> <a href="@DomUrl('docs/functions/modal#reitemize')"> reItemize </a> </li>
                    </ul>
                  </div> 
              </div>        
          </div>         
          
          <div id="lite" class="lite-helpers">
              <div class="font-menu fb-6 bc-white-dd flex-full rad-4 pxv-8 lacier">
                <div class="flex-full c-olive">3. Lite Functions</div> 
              </div> <br>
              
              <div>
                The lite helper functions are functions that are either coined 
                from an existing php internal functions or custom functions that are 
                applied on texts. These functions exist to ease building web applications 
                for developers as they can sometimes prove useful.
              </div> <br>

              <div class="">
                  <div class="font-menu font-em-d9" style="color:rgb(12, 131, 131);">
                    <ul class="list-square">
                      <li> <a href="@DomUrl('docs/functions/lite#base_encode')"> base_encode </a> </li>
                      <li> <a href="@DomUrl('docs/functions/lite#base_decode')"> base_decode </a> </li>
                      <li> <a href="@DomUrl('docs/functions/lite#tojson')"> toJson </a> </li>
                      <li> <a href="@DomUrl('docs/functions/lite#fromjson')"> fromJson </a> </li>
                      <li> <a href="@DomUrl('docs/functions/lite#enplode')"> enplode </a> </li>
                      <li> <a href="@DomUrl('docs/functions/lite#tosingular')"> toSingular </a> </li>
                      <li> <a href="@DomUrl('docs/functions/lite#inflect')"> inflect </a> </li>
                      <li> <a href="@DomUrl('docs/functions/lite#to_lgts')"> to_lgts </a> </li>
                      <li> <a href="@DomUrl('docs/functions/lite#href')"> href </a> </li>
                      <li> <a href="@DomUrl('docs/functions/lite#scriptname')"> scriptName </a> </li>
                      <li> <a href="@DomUrl('docs/functions/lite#striplastslash')"> striplastSlash </a> </li>
                      <li> <a href="@DomUrl('docs/functions/lite#redirectto')"> redirectTo </a> </li>
                      <li> <a href="@DomUrl('docs/functions/lite#limittext')"> limitText </a> </li>
                      <li> <a href="@DomUrl('docs/functions/lite#limitchars')"> limitChars </a> </li>
                      <li> <a href="@DomUrl('docs/functions/lite#limitword')"> limitWord </a> </li>
                    </ul>
                  </div>
              </div>        
          </div>         
          
          <div id="script" class="script-helpers">
              <div class="font-menu fb-6 bc-white-dd flex-full rad-4 pxv-8 lacier">
                <div class="flex-full c-olive">4. Script Functions</div> 
              </div> <br>
              
              <div>
                The script helper functions are functions are custom functions that depend on
                javascript to run. These functions may prove useful when handling data types or when doing 
                simple debugging.
              </div> <br>

              <div class="">
                  <div class="font-menu font-em-d9" style="color:rgb(12, 131, 131)">
                    <ul class="list-square">
                      <li> <a href="@DomUrl('docs/functions/script#alert')"> alert </a> </li>
                      <li> <a href="@DomUrl('docs/functions/script#javaconsole')"> javaconsole </a> </li>
                      <li> <a href="@DomUrl('docs/functions/script#script')"> script </a> </li>
                    </ul>
                  </div> <br>
              </div>        
          </div> 
          
          <div class="">
            There are other functions which are not discussed within this page. Some are discussed under other subheadings where  
            they are neccessary or required to be discussed.
          </div>
        
        </div>  
        
        
        @lay('build.co.coords:footer')
      </div>
    </section>
  </div>

@template;