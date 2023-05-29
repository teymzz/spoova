
@template('template.t-tut')

  <!-- @lay('build.co.coords:header') -->

  @lay('build.co.navbars:left-nav')

  <div class="box-full pxl-2 bc-white-dd pull-right">
    <section class="pxv-10 tutorial database bc-white">
      <div class="font-em-1d2">

        <div class="start font-em-d85"> <br>

          <div class="font-em-1d5 c-orange">Functions - Script</div> <br>  
          
          <div class="resource-intro">
            <div class="">
              The script helper functions are functions are custom javascipt-dependent functions. 
              These functions may prove useful when handling data types or when doing 
              simple debugging during project development.
            </div> 
          </div> <br>
          
         
          <div class="">
            <div class=" font-em-d9 c-aqua-dd" style="color:rgb(12, 131, 131)">
              <ul class="pxl-14 list-square">                      
                <li> <a href="@DomUrl('docs/functions/script/alert')"> alert </a> </li>
                <li> <a href="@DomUrl('docs/functions/script/javaconsole')"> javaconsole </a> </li>
                <li> <a href="@DomUrl('docs/functions/script/script')"> script </a> </li>
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