@template('template.t-tut')

@lay('build.co.navbars:left-nav')

   <div class="box-full pxl-2 bc-white pull-right">
       <section class="pxs-10 tutorial bc-white">
           <div class="font-em-1d2">

               @lay('build.co.links:tutor_pointer')

               <div class="start">

                    <div class="pvs-20">
                        <div class=" c-orange font-em-2 fb-6 c-dry-blue-d"> 
                          <span class="bi-wrench-adjustable-circle font-em-d85"></span>
                          <span class="c-deep-blue fb-9 fira">S</span><span class="c-dry-blue-dd boxigen">poova 2.1!</span>
                        </div>
                    
                        <div class="font-em-d8">
                            This version release is focused on improving some code syntaxes and fixing some minor bugs 
                            in the previous release. This is coming as a step towards reaching a stable version release in 
                            the upcoming <code class="">version 2.5.0</code>. The improvements on this version are discussed below:
                        </div> <br>
                    </div>

                    <div class="bc-white-dd rad-4 flow-hide">
                        <div class="bc-dry-blue-dd c-white-d pxv-10 font-em-d8">
    
                            <div class="bi"> <span class="bi-speedometer"></span> Live server update </div>  
    
                        </div>
                        <div class="pxv-20 pvb-1  font-em-d8">

                            <p>
                                Countdown was introduced to spoova's live server in the <code class="">version 2.0.0</code>  
                                of the framework. However, it was noticed that an error was returned after the live server terminates 
                                when a resource it not found and the countdown is reached. This error has been fixed in the current version.
                            </p>
                            
                        </div>
                    </div> <br>
                    
                    <div class="bc-white-dd rad-4 flow-hide">
                        <div class="bc-dry-blue-dd c-white-d pxv-10 font-em-d8">
    
                            <div class="bi"> <span class="bi-terminal"></span> Command-line Backup </div>  
    
                        </div>
                        <div class="pxv-20 pvb-1  font-em-d8">

                            <p>
                                The command-line <code>php mi backup</code> command was used to create project backups. In the previous version, 
                                it requires specifying the backup folder where the backup files are stored at every instance when a backup 
                                is to be created. Since naturally, the <code>backup/</code> directory is reserved for backups, the cli has now 
                                been updated to use only that directory when storing or clearing backups. This means that developers will not be required 
                                to specify their backup directory any longer when running this command. 
                            </p>
                            
                        </div>
                    </div> <br>  

                    <div class="bc-white-dd rad-4 flow-hide">
                        <div class="bc-dry-blue-dd c-white-d pxv-10 font-em-d8">
    
                            <div class="bi"> <span class="bi-plugin"></span> Intersect.js </div>  
    
                        </div>
                        <div class="pxv-20 pvb-1  font-em-d8">

                            <p>
                                The <code>IntersectJS</code> plugin documentation was missing in the previous version. 
                                This version sees to it that the documentation is added while the 
                                javascript plugin have also been improved. However, note that the documentation does not provide any information on the improved changes
                                but it only provides required information on the newly improved version. You can find the documentation 
                                <a href="@domurl('docs/other-features/javascript/intersect.js')">here</a>.
                            </p>
                            
                        </div>
                    </div> <br> 

                    <div class="bc-white-dd rad-4 flow-hide">
                        <div class="bc-dry-blue-dd c-white-d pxv-10 font-em-d8">
    
                            <div class="bi"> <span class="bi-layers"></span> Template Directive : @(@styles)@ </div>  
    
                        </div>

                        <div class="pxv-20 pvb-1  font-em-d8">
                            <div class="bc-white">
                                <div class="pxv-10 bc-silver">@(@styles)@</div>
                                <div class="pxv-10">
                                    The template directive <code>@(@styles)@</code> is used to pull css layout template files to a specific position of the html content of 
                                    a web page usually the top of the page. A bug was found in the previous version that affects styles loaded from external php layout files through the 
                                    <code>@(@lay())@</code> directive which prevented the styles from the imported layout from being pulled to the declared postion 
                                    of the html content. This bug has been addressed in this version which means that all styles loaded from styles layout will 
                                    now be pulled to the position where <code>@(@styles)@</code> is declared.
                                </div>
                            </div> <br>
                            <div class="bc-white">
                                <div class="pxv-10 bc-silver">@(@head())@</div>
                                <div class="pxv-10">
                                    The new directive <code>@(@head())@</code> is a newly introduced directive. 
                                    It ensures that the title of a page can be set in a main template file which 
                                    can later be updated in child templates using the <code>@(@title())@</code> directive. 
                                    Assuming we have a main template file as shown below 
                                    <div class="pre-area">
                                        <pre class="pre-code">
  &lt;html&gt;

    &lt;head&gt;
        &#64;head('default page title')
    &lt;/head&gt;

    &lt;body&gt;
        &#64;yield()
    &lt;/body&gt;

  &lt;/html&gt;
                                        </pre>
                                    </div>
                                    <div class="pvs-10">
                                        Using <code>main.rex.php</code> as the sample name of the template file above, we can easily rename the page 
                                        with the <code>@(@title())@</code> directive as shown below: 
                                    </div>
                                    <div class="pre-area">
                                        <pre class="pre-code">
  &#64;template('main')

    &#64;title('new page title')

  &#64;template;
                                        </pre>
                                    </div>
                                    <div class="pvs-10">
                                        The child template will remember to overide the default name set in the main template file. For more template directives 
                                        visit  <a href="@domurl('docs/template/directives')" class="rule-dotted c-olive ch-olive-dd">here</a>
                                    </div>                                    
                                </div>
                            </div> <br>
                        </div>
                    </div> <br> 

                    <div class="bc-white-dd rad-4 flow-hide">
                        <div class="bc-dry-blue-dd c-white-d pxv-10 font-em-d8">
    
                            <div class="bi"> <span class="bi-exclamation-circle"></span> Boostrap Icons </div>  
    
                        </div>
                        <div class="pxv-20 pvb-1  font-em-d8">

                            <p>
                                After the release of the previous version, it was noticed that the bootstrap icons were missing 
                                due to an accidental removal from the previous release. These icons have not only been added back into the framework 
                                but they have been updated. Check <a href="@domurl('features')" class="c-dodger-blue c-dodger-blue-dd">features</a> to see the new version.
                            </p>
                            
                        </div>
                    </div> <br> 

                    <div class="font-em-d8 pvs-10">
                        For more details on spoova versions, you can track the spoova version updates from <a href="@domurl('version')" class="c-olive ch-dodger-blue-d">here</a>.
                    </div> <br> 

                </div>
           </div>
       </section>
   </div>

@template;