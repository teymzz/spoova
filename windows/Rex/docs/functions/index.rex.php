
@template('template.t-tut')

  <!-- @lay('build.co.coords:header') -->

  @lay('build.co.navbars:left-nav')

  <div class="box-full pxl-2 bc-white-dd pull-right">
    <section class="pxv-10 tutorial database bc-white">
      <div class="font-em-1d2">

        @lay('build.co.links:tutor_pointer')

        <div class="start font-em-d82"> <br>

          <div class="font-em-1d5 c-orange">Functions</div> <br>  
          
          <div class="resource-intro">
              <div class="">

                  <div class="">
                    Helper functions are predefined custom functions that helps to provide some form of 
                    ease when building web applications. Most of these functions are employed within core 
                    classes that are used to build up the entire framework which makes them essential functions. 
                    These custom function are divided into four categories 
                    (CMLS)
                  </div><br>

                  <ul>
                    <li><a href="@route('::core')" data-scroll-hash="core" data-minus="10">Core Functions</a></li>
                    <li><a href="@route('::modal')" data-scroll-hash="modal" data-minus="10">Modal Functions</a></li>
                    <li><a href="@route('::lite')" data-scroll-hash="lite" data-minus="10">Lite Functions</a></li>
                    <li><a href="@route('::script')" data-scroll-hash="script" data-minus="10">Script Functions</a></li>
                  </ul>
                  
              </div>
          </div>                   
  
          
          <div class="">
            The following are list of the entire functions discussed under this section
          </div> <br>

          <div class="core">
            <div class="c-orange-dd"> 
              <a href="@domurl('docs/functions/core')" class="inherit ch-orange-dd">
                <span class="bi-circle-fill"></span> Core Functions
              </a>
            </div>
            <ul style="color:rgb(12, 131, 131)">
              
                <li style="list-style: square;">
                  <div class="pvt-6 fb-6  font-em-1">Environment/Data Related functions</div>    
                  <ul class="list-disc" style="padding:.5em">
                    <li> <a href="@domurl('docs/functions/core/scheme')"> scheme </a> </li>
                    <li> <a href="@domurl('docs/functions/core/webclass')"> webClass </a> </li>
                    <li> <a href="@domurl('docs/functions/core/env')"> env </a> </li>
                    <li> <a href="@domurl('docs/functions/core/response')"> response </a> </li>
                    <li> <a href="@domurl('docs/functions/core/setvar')"> setVar </a> </li>
                    <li> <a href="@domurl('docs/functions/core/vdump')"> vdump </a> </li>
                  </ul>
                </li>
                <li style="list-style: square;">
                  <div class="pvt-6 fb-6  font-em-1">Window Related functions</div>    
                  <ul class="list-disc" style="padding:.5em">
                    <li> <a href="@domurl('docs/functions/core/window')"> window </a> </li>
                    <li> <a href="@domurl('docs/functions/core/route')"> route </a> </li>
                    <li> <a href="@domurl('docs/functions/core/appexists')"> appExists </a> </li>
                    <li> <a href="@domurl('docs/functions/core/windowexists')"> windowExists </a> </li>
                    <li> <a href="@domurl('docs/functions/core/routeexists')"> routeExists </a> </li>
                    <li> <a href="@domurl('docs/functions/core/inpath')"> inPath </a> </li>
                    <li> <a href="@domurl('docs/functions/core/ispath')"> isPath </a> </li>
                    <li> <a href="@domurl('docs/functions/core/invoked')"> invoked </a> </li>
                    <li> <a href="@domurl('docs/functions/core/lastcall')"> lastcall </a> </li>
                    <li> <a href="@domurl('docs/functions/core/windowincludes')"> windowIncludes </a> </li>
                    <li> <a href="@domurl('docs/functions/core/windowexcludes')"> windowExcludes </a> </li>
                    <li> <a href="@domurl('docs/functions/core/eview')"> eview </a> </li>  
                  </ul>
                </li>
                <li style="list-style: square;">
                  <div class="pvt-6 fb-6  font-em-1">Url Related functions</div>    
                  <ul class="list-disc" style="padding:.5em">
                    <li> <a href="@domurl('docs/functions/core/ishttp')"> isHTTP </a> </li>
                    <li> <a href="@domurl('docs/functions/core/ishttps')"> isHTTPS </a> </li>
                    <li> <a href="@domurl('docs/functions/core/domurl')"> domurl </a> </li>
                    <li> <a href="@domurl('docs/functions/core/domlink')"> domlink </a> </li>
                    <li> <a href="@domurl('docs/functions/core/isabsolutepath')"> isAbsolutePath </a> </li>
                    <li> <a href="@domurl('docs/functions/core/to_backslash')"> to_backslash </a> </li>
                    <li> <a href="@domurl('docs/functions/core/to_frontslash')"> to_frontslash </a> </li>
                    <li> <a href="@domurl('docs/functions/core/to_namespace')"> to_namespace </a> </li>
                    <li> <a href="@domurl('docs/functions/core/to_dotspace')"> to_dotspace </a> </li>
                    <li> <a href="@domurl('docs/functions/core/urlparams')"> urlParams </a> </li>
                    <li> <a href="@domurl('docs/functions/core/url')"> url </a> </li>
                    <li> <a href="@domurl('docs/functions/core/redirect')"> redirect </a> </li>
                  </ul>
                </li>
                <li style="list-style: square;">
                  <div class="pvt-6 fb-6  font-em-1">Session Related functions</div>    
                  <ul class="list-disc" style="padding:.5em">
                    <li> <a href="@domurl('docs/functions/core/isguest')"> isGuest </a> </li>
                    <li> <a href="@domurl('docs/functions/core/isuser')"> isUser </a> </li>
                    <li> <a href="@domurl('docs/functions/core/authdirect')"> authDirect </a> </li>
                    <li> <a href="@domurl('docs/functions/core/guestdirect')"> guestDirect </a> </li>
                    
                  </ul>
                </li>
                <li style="list-style: square;">
                  <div class="pvt-6 fb-6  font-em-1">Resource Related functions</div>    
                  <ul class="list-disc" style="padding:.5em">
                    <li> <a href="@domurl('docs/functions/core/recall')"> recall </a> </li>
                    <li> <a href="@domurl('docs/functions/core/recall')"> ress </a> </li>
                    <li> <a href="@domurl('docs/functions/core/monitor')"> monitor </a> </li>
                    
                  </ul>
                </li>
                <li style="list-style: square;">
                  <div class="pvt-6 fb-6  font-em-1">Template Compiler functions</div>    
                  <ul class="list-disc" style="padding:.5em">
                    <li> <a href="@domUrl('docs/functions/core/compile')"> compile </a> </li> 
                    <li> <a href="@domUrl('docs/functions/core/view')"> view </a> </li> 
                    <li> <a href="@domUrl('docs/functions/core/rex')"> rex </a> </li> 
                    <li> <a href="@domUrl('docs/functions/core/raw')"> raw </a> </li> 
                  </ul>
                </li>
            </ul>
          </div>

          <div class="modals">
            <div class="c-orange-dd"> 
              <a href="@domurl('docs/functions/modal')" class="inherit ch-orange-dd">
                <span class="bi-circle-fill"></span> Modal Functions
              </a>
            </div>
            <ul style="color:rgb(12, 131, 131)">
            <li> <a href="@DomUrl('docs/functions/modal/br')"> br </a> </li>
                <li> <a href="@DomUrl('docs/functions/modal/refil')"> refil </a> </li>
                <li> <a href="@DomUrl('docs/functions/modal/encodeuricomponent')"> encodeURIComponent </a> </li>
                <li> <a href="@DomUrl('docs/functions/modal/inrange')"> inRange </a> </li>
                <li> <a href="@DomUrl('docs/functions/modal/randice')"> randice </a> </li>
                <li> <a href="@DomUrl('docs/functions/modal/is_empty')"> is_empty </a> </li>
                <li> <a href="@DomUrl('docs/functions/modal/not_empty')"> not_empty </a> </li>
                <li> <a href="@DomUrl('docs/functions/modal/combine')"> combine </a> </li>
                <li> <a href="@DomUrl('docs/functions/modal/compare')"> compare </a> </li>
                <li> <a href="@DomUrl('docs/functions/modal/arrinside')"> arrInside </a> </li>
                <li> <a href="@DomUrl('docs/functions/modal/arrvoid')"> arrVoid </a> </li>
                <li> <a href="@DomUrl('docs/functions/modal/arrgetsvoid')"> arrGetsVoid </a> </li>
                <li> <a href="@DomUrl('docs/functions/modal/arrsort')"> arrSort </a> </li>
                <li> <a href="@DomUrl('docs/functions/modal/array_trim')"> array_trim </a> </li>
                <li> <a href="@DomUrl('docs/functions/modal/array_get')"> array_get </a> </li>
                <li> <a href="@DomUrl('docs/functions/modal/array_object')"> array_object </a> </li>
                <li> <a href="@DomUrl('docs/functions/modal/tostdClass')"> tostdClass </a> </li>
                <li> <a href="@DomUrl('docs/functions/modal/array_delete')"> array_delete </a> </li>
                <li> <a href="@DomUrl('docs/functions/modal/array_unset')"> array_unset </a> </li>
                <li> <a href="@DomUrl('docs/functions/modal/reitemize')"> reItemize </a> </li>
            </ul>
          </div>

          <div class="lite">
            <div class="c-orange-dd"> 
              <a href="@domurl('docs/functions/lite')" class="inherit ch-orange-dd">
                <span class="bi-circle-fill"></span> Lite Functions
              </a>
            </div>
            <ul style="color:rgb(12, 131, 131)">
              <li> <a href="@DomUrl('docs/functions/lite/base_encode')"> base_encode </a> </li>
              <li> <a href="@DomUrl('docs/functions/lite/base_decode')"> base_decode </a> </li>
              <li> <a href="@DomUrl('docs/functions/lite/fromjson')"> fromJson </a> </li>
              <li> <a href="@DomUrl('docs/functions/lite/tojson')"> toJson </a> </li>
              <li> <a href="@DomUrl('docs/functions/lite/enplode')"> enplode </a> </li>
              <li> <a href="@DomUrl('docs/functions/lite/tosingular')"> toSingular </a> </li>
              <li> <a href="@DomUrl('docs/functions/lite/inflect')"> inflect </a> </li>
              <li> <a href="@DomUrl('docs/functions/lite/to_lgts')"> to_lgts </a> </li>
              <li> <a href="@DomUrl('docs/functions/lite/href')"> href </a> </li>
              <li> <a href="@DomUrl('docs/functions/lite/scriptname')"> scriptName </a> </li>
              <li> <a href="@DomUrl('docs/functions/lite/striplastslash')"> striplastSlash </a> </li>
              <li> <a href="@DomUrl('docs/functions/lite/redirectto')"> redirectTo </a> </li>
              <li> <a href="@DomUrl('docs/functions/lite/limittext')"> limitText </a> </li>
              <li> <a href="@DomUrl('docs/functions/lite/limitchars')"> limitChars </a> </li>
              <li> <a href="@DomUrl('docs/functions/lite/limitword')"> limitWord </a> </li>
            </ul>
          </div>

          <div class="script">
            <div class="c-orange-dd"> 
              <a href="@domurl('docs/functions/script')" class="inherit ch-orange-dd">
                <span class="bi-circle-fill"></span> Script Functions
              </a>
            </div>
            <ul style="color:rgb(12, 131, 131)">
              <li> <a href="@DomUrl('docs/functions/script/alert')"> alert </a> </li>
              <li> <a href="@DomUrl('docs/functions/script/javaconsole')"> javaconsole </a> </li>
              <li> <a href="@DomUrl('docs/functions/script/script')"> script </a> </li>
            </ul>
          </div>
        
        </div>  
        
        </div>  
        
        
        @lay('build.co.coords:footer')
      </div>
    </section>
  </div>

@template;