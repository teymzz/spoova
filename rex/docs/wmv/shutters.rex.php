@template('template.t-doc')

    @lay('build.coords:header')
    
    
      <div class="pxv-20 c-black-ll">
        
        @lay('build.links:tutor_pointer')

        <div class="font-em-1d5 c-orange">Shutter</div> <br>  
        
        <div class="resource-intro">
            <div class="">
                The shutter system was designed to close every window using the <code>Window::close()</code> method.
                By default, when a window file does not exist and the corresponding url is called, the shutter automatically closes.
                unless a usedoor method is defined on the Index window file which tells the system that such url should be left opened 
                for a different kind of handling format. This behaviour is one designed to prevent any access to a non-existing window 
                in which the resulting effect will be a blank page. 

                However, when a window file exists and is called, the shutters are left opened to be manually closed by the respective window class. 
                The closing of windows is a technicality that must be properly understood well in order to be able to close 
                windows especially when using the <a href="@route('.calls')" title="@route('.calls')">call methods</a>. An improper 
                closing of windows can leave some urls opened unknowingly. Hence, developers must have a good knowledge of handling 
                urls to be able to properly close non-existing urls.

                <p>
                  In WinViM, there are two methods specifically designed to close windows. These are the <code>close()</code> and <code>sleep()</code> 
                  methods. The sleep method is only used for development purpose as it only closes a url while monitoring it using the inbuilt live server.
                  When the url becomes alive, then the page is re-routed automatically from a 404 page to the respective page. This method is not applicable on a 
                  live environment. It only keeps development of web pages faster in local environments.
                </p>

                The windows class has some basic structures in place to handle urls which makes the job of handling urls easier to deal with. These control structures
                are the call methods mentioned earlier. They are best positioned to handle url in a specifically designed ways. These methods when used naturally closes 
                any url that does not match supplied lists of acceptable urls. However, they can also be pended to allow for more url permissions. The most important concept 
                here is that when these methods are pended, then developers must employ a great deal of care when closing the urls. These methods are explained <a href="@route('.shutters')">here</a>
                and at the same time listed below:

                <br><br>

                <ul>
                    <li> <a href="@route('.calls')#call">call</a>  </li>
                    <li> <a href="@route('.calls')#rootcall">rootcall</a> </li>
                    <li> <a href="@route('.calls')#basecall">basecall</a> </li>
                    <li> <a href="@route('.calls')#pathcall">pathcall</a> </li>
                </ul>
                
            </div>

      </div>
    
      @lay('build.links:tutor_pointer')
      
    @lay('build.coords:footer')


@template;