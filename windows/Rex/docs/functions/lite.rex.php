
@template('template.t-tut')

  <!-- @lay('build.co.coords:header') -->

  @lay('build.co.navbars:left-nav')

  <div class="box-full pxl-2 bc-white-dd pull-right">
    <section class="pxv-10 tutorial database bc-white">
      <div class="font-em-1d2">

        @lay('build.co.links:tutor_pointer')

        <div class="start font-em-d8"> <br>

          <div class="font-em-1d5 c-orange">Functions - Lite</div> <br>  
          
          <div class="resource-intro">
            <div class="">
              The lite helper functions are functions that are either coined 
              from an existing php internal functions or custom functions to produce 
              a new added functionality which in most cases are applied on texts. 
              Due to their extended functionailty, these functions help to ease 
              building web applications as they can sometimes prove useful.
            </div> 
          </div> <br>
          
         
          <div class="">
            <div class=" font-em-d9 c-aqua-dd" style="color:rgb(12, 131, 131)">
              <ul class="pxl-14 list-square">                      
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
          </div> 
          
          @lay('build.co.links:tutor_pointer')
      
        </div> <br>  


      </div> <br>  

    </section>
  </div> <br>    
  
  @lay('build.co.coords:footer')
  
@template;