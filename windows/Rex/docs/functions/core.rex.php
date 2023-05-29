
@template('template.t-tut')

  <!-- @lay('build.co.coords:header') -->

  @lay('build.co.navbars:left-nav')

  <div class="box-full pxl-2 bc-white-dd pull-right">
    <section class="pxv-10 tutorial database bc-white">
      <div class="font-em-1d2">

        @lay('build.co.links:tutor_pointer')

        <div class="start font-em-d82"> <br>

          <div class="font-em-1d5 c-orange">Functions - Core</div> <br>  
          
          <div class="resource-intro">
            <div class="">
                Core functions have a higher level of importance because they are mostly 
                required in the framework's architecture. They sometimes have direct relationships 
                with classes and just provide an easier means of accessing some classes methods 
                or helps to return the value of specific methods. The following are the core functions 
                within the framework classified under different groups.
            </div> 
          </div> <br>
          
         
          <div class="">
            <div class=" font-em-d9 c-aqua-dd" style="color:rgb(12, 131, 131)">
            <ul class="pxl-14">

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
          </div> 
          
          @lay('build.co.links:tutor_pointer')
      
        </div> <br>  


      </div> <br>  

    </section>
  </div> <br>    
  
  @lay('build.co.coords:footer')
  
@template;