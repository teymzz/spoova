@template('template.t-tut')

    @lay('build.co.navbars:left-nav')

        <div class="box-full pxl-2 bc-white-dd pull-right">
        
            <section class="pxv-20 tutorial bc-white">
                <div class="font-em-1d2">

                    @lay('build.co.links:tutor_pointer')

                    <div class="start font-em-d8">

                        <div class="font-em-1d5 c-orange">Cli Class</div> <br>  
                        
                        <div class="helper-classes">
                            <div class="fb-6">Introduction</div> <br>
                            <div class="">

                                <div class="">
                                    The <code>cli</code> class is a command line tool for displaying contents on the command line. This class does not in any way 
                                    run or process commands. It only makes it easier to perform tasks like clearing lines, coloring texts, setting up prompts or 
                                    running some simple animations. There are several methods that can be applied based on preference.
                                    These methods have been categorized under different subheadings.
                                </div> <br>

                                <div>
                                    <div>
                                        <div class="font-em-1d2 c-orange-dd"> Cli texts</div>
                                        <div class="">
                                            Most of the methods that fall under this category are designed to define a particular way or position in which 
                                            a text must be displayed. These method deals mostly with the position of console pointer by either shifting the position 
                                            or utilizing its current position. The following are method that are grouped under this category. <br><br>
                                            <ul>
                                                <li><a href="@route('::texts#textIndent')" class="c-i">textIndent</a></li>
                                                <li><a href="@route('::texts#textView')" class="c-i">textView</a></li>
                                                <li><a href="@route('::texts#dots')" class="c-i">dots</a></li>
                                                <li><a href="@route('::texts#backspace')" class="c-i">backspace</a></li>
                                                <li><a href="@route('::texts#cls')" class="c-i">cls</a></li>
                                                <li><a href="@route('::texts#clearLine')" class="c-i">clearLine</a></li>
                                                <li><a href="@route('::texts#clearUp')" class="c-i">clearUp</a></li>
                                                <li><a href="@route('::texts#upLine')" class="c-i">upLine</a></li>
                                                <li><a href="@route('::texts#br')" class="c-i">br</a></li>
                                                <li><a href="@route('::texts#break')" class="c-i">break</a></li>
                                            </ul>
                                        </div>
                                    </div>

                                    <div>
                                        <div class="font-em-1d2 c-orange-dd"> Cli colors</div>
                                        <div class="">
                                            There are certain color related methods that are used to apply colors on console text. 
                                            These colors can be applied on the text itself or as a text background. The cli colors method 
                                            are designed to makes it easier to add colors to texts. The methods below fall under this category<br><br>
                                            <ul>
                                                <li><a href="@route('::colors#color')" class="c-i">color</a></li>
                                                <li><a href="@route('::colors#danger')" class="c-i">danger</a></li>
                                                <li><a href="@route('::colors#warn')" class="c-i">warn</a></li>
                                                <li><a href="@route('::colors#alert')" class="c-i">alert</a></li>
                                                <li><a href="@route('::colors#valid')" class="c-i">valid</a></li>
                                                <li><a href="@route('::colors#bgColor')" class="c-i">bgColor</a></li>
                                                <li><a href="@route('::colors#bgDanger')" class="c-i">bgDanger</a></li>
                                                <li><a href="@route('::colors#bgWarn')" class="c-i">bgWarn</a></li>
                                                <li><a href="@route('::colors#bgAlert')" class="c-i">bgAlert</a></li>
                                                <li><a href="@route('::colors#'bgValid)" class="c-i">bgValid</a></li>
                                            </ul>
                                        </div>
                                    </div>

                                    <div>
                                        <div class="font-em-1d2 c-orange-dd"> Cli notifications</div>
                                        <div class="">
                                            Notifications are mostly needed in cases where we need the developer's terminal to notify and call the attention of a console user 
                                            to a particular response. These method prefixes messages with special key words that makes it easier to understand the purpose or reason 
                                            why a message is displayed. <br><br>
                                            <ul>
                                                <li><a href="@route('::notifications#error')">error</a></li>
                                                <li><a href="@route('::notifications#warning')">warning</a></li>
                                                <li><a href="@route('::notifications#caution')">caution</a></li>
                                                <li><a href="@route('::notifications#notice')">notice</a></li>
                                                <li><a href="@route('::notifications#success')">success</a></li>
                                            </ul>
                                        </div>
                                    </div>

                                    <div>
                                        <div class="font-em-1d2 c-orange-dd"> Cli Animations</div>
                                        <div class="">
                                            The cli loading animation system are used in certain situations to reflect that a process is ongoing. While they mostly do not provide information 
                                            about the current process execution state, they are pretty useful when it comes to helping console user understand that some actions are currently 
                                            taking effect. Animation methods include: <br><br>
                                            <ul> 
                                                <li><a href="@route('::animations#textYield')">textYield</a></li>
                                                <li><a href="@route('::animations#animeTest')">animeTest</a></li>
                                                <li><a href="@route('::animations#play')">play</a></li>
                                                <li><a href="@route('::animations#pause')">pause</a></li>
                                                <li><a href="@route('::animations#animeType')">animeType</a></li>
                                                <li><a href="@route('::animations#animate')">animate</a></li>
                                                <li><a href="@route('::animations#loadTime')">loadTime</a></li>
                                                <li><a href="@route('::animations#endAnime')">endAnime</a></li>
                                                <li><a href="@route('::animations#runAnime')">runAnime</a></li>
                                            </ul>
                                        </div>
                                    </div>

                                    <div>
                                        <div class="font-em-1d2 c-orange-dd"> Cli prompts</div>
                                        <div class="">
                                            <div class="pvt-6 pvb-10">
                                                The console or terminal's prompts are used to obtain inputs from a console user. These methods not only make it possible to obtain inputs 
                                                but it also makes it easier to set up a response validation system. There are only two major methods for fetching user inputs while each of these 
                                                two methods has its own child methods responsible for authenticating responses. 
                                            </div>
                                            <ul>
                                                <li><a href="@route('::prompts#prompt')">prompt</a></li>
                                                <li><a href="@route('::prompts#prompt')">promptIsMax</a></li>
                                                <li><a href="@route('::prompts#prompt')">promptInvalid</a></li>
                                                <li><a href="@route('::prompts#q')">q</a></li>
                                                <li><a href="@route('::prompts#q')">qFailed</a></li>
                                                <li><a href="@route('::prompts#q')">qValid</a></li>
                                                <li><a href="@route('::prompts#q')">qmax</a></li>
                                            </ul>
                                        </div>
                                    </div>

                                    <div>
                                        <div class="font-em-1d2 c-orange-dd"> Cli storage</div>
                                        <div class="">
                                            <div class="pvt-6 pvb-10">
                                                The Cli class has a keeps track of reusable items making is possible to store and reuse functions or texts. Usually, 
                                                functions or strings are stored with an identifier name to be used later. This makes it easier to recall values across the cli system.
                                                The methods that fall under this category are:
                                            </div>
                                            <ul>
                                                <li><a href="@route('::storage#save')">save</a></li>
                                                <li><a href="@route('::storage#fn')">fn</a></li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                                
                            </div> 
                        </div>  


                    @lay('build.co.links:tutor_pointer')

                    </div>
                </div>
            </section>
        </div>

    @lay('build.co.coords:footer')

@template;