
@template('template.t-tut')

  <!-- @lay('build.co.coords:header') -->

  @lay('build.co.navbars:left-nav')

  <div class="box-full pxl-2 bc-white-dd pull-right">
    <section class="pxv-10 tutorial database bc-white">
      <div class="font-em-1d2">

        @lay('build.co.links:tutor_pointer')

        <div class="start font-em-d8"> <br>

          <div class="font-em-1d5 c-orange">Functions - Modal</div> <br>  
          
          <div class="resource-intro">
            <div class="">
              The modal custom helper functions are functions that help to handle some tedious 
              tasks easily. They have no relationship with higher classes but they provide great support within the application. Hence, they 
              are required for the functionality of the application.
            </div> 
          </div> <br>
          
         
          <div class="">
            <div class=" font-em-d9 c-aqua-dd" style="color:rgb(12, 131, 131)">
              <ul class="pxl-14 list-square">
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
          </div> 
          
          @lay('build.co.links:tutor_pointer')
      
        </div> <br>  


      </div> <br>  

    </section>
  </div> <br>    
  
  @lay('build.co.coords:footer')
  
@template;