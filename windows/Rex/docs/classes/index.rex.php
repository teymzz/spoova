
@template('template.t-tut')

  @lay('build.co.navbars:left-nav')

  <div class="box-full pxl-2 bc-white-dd pull-right">
    
    <section class="pxv-10 tutorial mails bc-white">
      <div class="font-em-1d2">

        @lay('build.co.links:tutor_pointer')

        <div class="start font-em-d8">

          <div class="font-em-1d5 c-orange">Helper Classes</div> <br>  
          
          <div class="helper-classes">
            <div class="fb-6">Introduction</div> <br>
            <div class="">

              <div class="">
                The helper classes are designed to provide assistance when building web 
                apps. These classes are divided into two parts 
                which are the <span class="fb-6">core classes</span> and 
                <span class="fb-6">core tools</span>. Some of these classes have been previously 
                explained under other subheadings. Hence, we will only be focusing on other related 
                classes and their functions which are listed below.
              </div> <br>

                <ul class="c-sea-green">
                  <li> <a href="@route('::meta')"> Meta </a> </li>
                  <li> <a href="@route('::ajax')"> Ajax </a> </li>
                  <li> <a href="@route('::input')"> Input </a> </li>
                  <li> <a href="@route('::fileuploader')"> FileUploader </a> </li>
                  <li> <a href="@route('::imageclass')"> ImageClass </a> </li>
                  <li> <a href="@route('::filemanager')"> FileManager </a> </li>
                  <li> <a href="@route('::jwstoken')"> JWSToken </a> </li>
                  <li> <a href="@route('::jsonfy')"> Jsonfy </a> </li>
                  <li> <a href="@route('::hasher')"> Hasher </a> </li>
                  <li> <a href="@route('::notice')"> Notice </a> </li>
                  <li> <a href="@route('::forms')"> Form </a> </li>
                  <li> <a href="@route('::url')"> Url </a> </li>
                  <li> <a href="@route('::urlmapper')"> UrlMapper </a> </li>
                  <li> <a href="@route('::cli')"> Cli </a> </li>
                  <li> <a href="@route('::benchmark')"> Benchmark </a> </li>
                </ul>
                
            </div> 
          </div>

          @lay('build.co.links:tutor_pointer')

        </div>
      </div>
    </section>

  </div>
    
  @lay('build.co.coords:footer')

@template;