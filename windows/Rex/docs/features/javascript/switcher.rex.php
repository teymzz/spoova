
@template('template.t-tut')

<!-- @lay('build.co.coords:header') -->

@lay('build.co.navbars:left-nav')

<div class="box-full pxl-2 bc-white-dd pull-right">
    <section class="pxv-20 tutorial database bc-white">
        <div class="font-em-1d2">

            @lay('build.co.links:tutor_pointer')

            <div class="start font-em-d8">

                <div class="font-em-1d5 c-orange">Switcher.js</div> <br>
                
                <div class="db-connection">
                    <div class="fb-6">Introduction</div>
                   This plugin (jquery dependent) is used to track selected options, fields, menu lists e.t.c. For example, when a menu option is selected, 
                   it is tracked in a way that if the page is reloaded, the selected option remains. This feature makes it easy to hide fields, 
                   show fields or perform even more advanced operations. In order to use this plugin, certain attributes must be configures
                </div> <br>
                
                <div class="">
                    <div class="font-em-1 c-orange"><span class="bi-circle-fill c-silver-d mxr-6"></span>Switcher attributes</div>
                    Switcher comes with certain attributes that enables elements to be tracked.

    <!-- code begin  -->
                    <div class="pre-area">
    <pre class="pre-code">
  data-switch : <span class="comment no-select">This is usually used to refer to the target element id</span>
  data-class  : <span class="comment no-select">This is class to which the target element belongs</span>
  data-rel    : <span class="comment no-select">This is used to point to another element item.</span>
    </pre>    
    <!-- code ends -->

                    </div>
                     
                </div> <br>
                
                <div class="">
                    <div class="font-em-1 c-orange"><span class="bi-circle-fill c-silver-d mxr-6"></span>Switcher Application</div>
                    In order to apply the <code>"switcher"</code> plugin, we must learn about its application first. The example below is a practical 
                    example of it usage:
                    <div class="field">
                        <div class="example pxv-10 bc-silver-d">Example 1</div>
                        <div class="bc-silver pxv-10 flex-full f-col">
                            <div class="flex-full">
                                <button class="flex-btn bc-orange-dd c-white mxr-10" data-switch="field1" data-class="toggle" data-rel="toggler" data-callback="switchColor" onclick="switcher(this)">Show Field 1</button>
                                <button class="flex-btn bc-orange-d c-white" data-switch="field2" data-class="toggle" data-rel="toggler" data-callback="switchColor" onclick="switcher(this)">Show Field 2</button>
                            </div>
                            <div class="field mvt-10 flex">
                                <div id="field1" class="bc-white-d shadow flex-full toggle pxv-10" data-rel="toggler">
                                    This is field 1
                                </div>
                                <div id="field2" class="bc-white-d shadow flex-full toggle pxv-10" data-rel="toggler">
                                    This is field 2
                                </div>
                            </div>
                        </div>

                        <div class="font-em-d85 mvt-10">
                            In the above, there is a binding relationship between the buttons and the fields below them such that when one button is clicked, its relative field is displayed while the other field becomes hidden.
                            Also, the clicked button changes its color. The code structure is displayed below:
                        </div><br>

                        <div>

                            <div class="pre-area">
                                <pre class="pre-code pxv-10">
  <span class="c-silver-dd">{{ to_lgts('<div class="bc-silver pxv-10 flex-full f-col">') }}<span>
    <span class="c-olive-d">
    {{ to_lgts('
    <div class="CHILD-1 flex-full">
        <button data-switch="field1" data-class="toggle" data-rel="toggler" data-callback="switchColor" onclick="switcher(this)" class="flex-btn bc-orange-dd c-white mxr-10">Click to Hide Field</button>
        <button data-switch="field2" data-class="toggle" data-rel="toggler" data-callback="switchColor" onclick="switcher(this)" class="flex-btn bc-orange-d c-white">Click to Show Field</button>
    </div>


    <div class="CHILD-2 field mvt-10 flex">

        <div id="field1" class="bc-white-d shadow flex-full toggle pxv-10 mxr-10" data-rel="toggler">
            This is field 1
        </div>

        <div id="field2" class="bc-white-d shadow flex-full toggle pxv-10" data-rel="toggler">
            This is field 2
        </div>

    </div>') 
    }}

    {{
        to_lgts('
    <script>

        function switchColor(elem) {

            $("[data-class]").removeClass("bc-orange-dd").addClass("bc-orange-d")
            $(elem).removeClass("bc-orange-d").addClass("bc-orange-dd")

        }

        $(document).ready(()=>{
            let switchBtn = new Switcher();
            switchBtn.loadSwitcher("toggle");
        })

    </script>        
        ')
    }}
      </span>
      
  <span class="c-silver-dd">{{ to_lgts('</div>') }}</span>

                                </pre>
                            </div>                        

                        </div>

                        <div class="mvt-10">
                            <div class="font-em-d85">
                                The code above best explain how the <code>switcher</code> relationship is set up. In the div with <code>CHILD-1</code> class above, 
    
                                <ul>
                                    <li>The <code>data-switch</code> of the first button element points to the id attribute of the target element <code>field1</code> found in <code>CHILD-2</code></li>
                                    <li>The <code>data-class="toggle"</code> of the first and second button elements point to the <code>class</code> attributes of the target elements of the same group 
                                    <li>The <code>data-rel</code> attribute is used to connect all fields and buttons in the same group. 
                                </ul>
                                <br> 
                                The <code>"active"</code> value is usually added by the javascript to the <code>class</code> attribute of the switch button. It denotes the currently selected switch 
                                button. Switch buttons can be identified by the attribute <code>"data-switch"</code> which they use to point to the <code>"id"</code> attribute of the element they are expected to control. 
                                In order to set up a proper relationship between two or more switch buttons, the <code>"data-class"</code> attribute of the button must be the same as shown below:
                            </div>
            <div class="pre-area mvt-6">
                <pre class="pre-code" style="color:var(--olive)">
  &lt;button data-switch="box1" data-class="boxes"&gt;&lt;/button&gt;

  &lt;button data-switch="box2" data-class="boxes"&gt;&lt;/button&gt;
                </pre>
            </div>
                            <div class="font-em-d85">
                                In the relationship above, the <code>data-class</code> attribute connects the two switch boxes. By default, the first button of the same <code>data-class</code> is usually the primary 
                                button. Once the page loads, primary button will have a class value of 
                                <code>"active"</code> being the first primary element. If the user clicks the second button, this leadership will be passed to the second button such that when the page reloads, the second 
                                button will become the primary element and the <code>"active"</code> class will belong to it rather than the first button. The <code>"active"</code> class can be helpful when designing by simply 
                                using the class selector (i.e <code>.active</code>) to select the currently selected element.

                                <p>
                                    The main purpose of the switcher class is to toggle fields. Hence we can continue to set up our relationship by connecting buttons to fields. Just as below:
                                </p>
                            </div>
            <div class="pre-area mvt-6">
                <pre class="pre-code" style="color:var(--olive)">
  &lt;button data-switch="box1" data-class="boxes"&gt;&lt;/button&gt;

  &lt;button data-switch="box2" data-class="boxes"&gt;&lt;/button&gt;

  &lt;div id="box1" class="boxes"&gt;&lt;/div&gt;

  &lt;div id="box2" class="boxes"&gt;&lt;/div&gt;  
                </pre>
            </div>                            
                            <div class="font-em-d85">
                                The code above is one that represent a true relationship between buttons and their respective fields. From the above, we can notice that the <code>"data-switch"</code>
                                attribute of first <code>button</code> points to the <code>"id"</code> attribute of the first <code>div</code> element. Regardless of the order, When a switch button "AButton" uses the 
                                <code>"data-switch"</code> attribute to point to the <code>"id"</code> of another element "AField", then the button "AButton" becomes the controller of that element. In order to keep the 
                                relationship connected, the <code>"data-class"</code> value of button "AButton" must match the exist in the class attribute value of "AField". In this way, the buttons and the fields will be 
                                mutually connected. Although, the switch buttons may be connected to each other by <code>data-class</code> attribute and each button may connect to its own field by using both the 
                                <code>id ~ data-id</code> and <code>class ~ data-class</code> connectors, yet the relationship is not yet complete as they all need to have a grouping or referenced relationship. 
                                Elements of the same group needs to be uniquely referenced. This makes it easier for the switcher class to sort them and execute them together as a group. In order to do this, the 
                                <code>data-rel</code> attribute must connect all fields uniquely. This means that the value of the <code>data-rel</code> attribute must be the same for all elements in the same group and the 
                                value cannot be assigned to another group. This is shown below:
                            </div>

            <div class="pre-area mvt-6">
                <pre class="pre-code" style="color:var(--olive)">
  &lt;button data-switch="box1" data-class="boxes" data-rel="box-group"&gt;&lt;/button&gt;

  &lt;button data-switch="box2" data-class="boxes" data-rel="box-group"&gt;&lt;/button&gt;

  &lt;div id="box1" class="boxes" data-rel="box-group"&gt;&lt;/div&gt;

  &lt;div id="box2" class="boxes" data-rel="box-group"&gt;&lt;/div&gt;  
                </pre>
            </div>                            
                            
                            <div class="font-em-d85">
                               By adding the <code>data-rel</code> attribute to all fields above, the relationship will be complete as the switcher class will be able to map all buttons to their fields. However, this 
                               will trigger an internal feature. Since the primary button if not clicked will be the first button, then the page will hide the second field (or div) and display the first one. However, if the 
                               second button is the primary (or active) button, then the second field will be displayed while the first remains hidden. In any given relationship, the relationship do not necessarily need to be 
                               complete but it has to be true. This means that it is essential that buttons of the same group must be connected even if not with a field. By default, no event will occur unless two activities are performed. 
                               The first activity is that all switch button must have an <code>onlick="switcher(this)"</code> attribute. Secondly, all buttons must be loaded using their <code>data-class</code> value.
                               This means that the code above should rather be written as: 
                            </div>

            <div class="pre-area mvt-6">
                <pre class="pre-code" style="color:var(--olive)">
  &lt;button data-switch="box1" data-class="boxes" data-rel="box-group" onclick="switcher(this)"&gt;&lt;/button&gt;

  &lt;button data-switch="box2" data-class="boxes" data-rel="box-group" onclick="switcher(this)"&gt;&lt;/button&gt;

  &lt;div id="box1" class="boxes" data-rel="box-group"&gt;&lt;/div&gt;

  &lt;div id="box2" class="boxes" data-rel="box-group"&gt;&lt;/div&gt;  


  &lt;script&gt;

    let switchBox = new Switcher;
    switchBox.loadSwither('boxes')

  &lt;/script&gt;
                </pre>
            </div>    
                            <div class="font-em-d85">
                               In the code above, once the <code>onclick</code> event attribute is added to the switch buttons, then the <code>Switcher</code> class is also used to load the <code>data-class</code> attribute. 
                               If there are several different switch buttons of different <code>data-class</code> value, then the values can be supplied as an array into the <code>loadSwitcher()</code> method.
                            </div>
                        </div>
                      
                    </div>
                   
                </div> <br>
                
                <div class="">
                    <div class="font-em-1 c-orange"><span class="bi-circle-fill c-silver-d mxr-6"></span>Handling Callbacks</div>
                   Callbacks can be made on switch buttons. This is done by adding the attribute <code>data-callback</code> and supplying the callback function name. The callback function will 
                   only be executed once the button is active. Since the <code>data-callback</code> function name cannot allow argument, by default switcher ensures that an function name passed 
                   into any <code>data-callback</code> attribute has access to the element itself. Hence, the first argument on any callback function name provides is 
                   always the target element object itself. For example: <br><br> 

            <div class="pre-area mvt-6">
                <div class="pxv-10 bc-silver">Callback: Example using Attributes</div>
                <pre class="pre-code" style="color:var(--olive)">
  &lt;button data-switch="box1" data-class="boxes" data-rel="box-group" onclick="switcher(this)" data-callback="open"&gt;&lt;/button&gt;

  &lt;button data-switch="box2" data-class="boxes" data-rel="box-group" onclick="switcher(this)"&gt;&lt;/button&gt;


  &lt;script&gt;

    function open(element) {

        $(element).addClass('selected');

    }

    let switchBox = new Switcher;
    switchBox.loadSwither('boxes')

  &lt;/script&gt;
                </pre>
            </div>
                    <div class="font-em-d9 mvt-6">
                        In the code above, the <code>element</code> argument represents the first button called. When the first button is active, then the function <code>"open"</code>
                        will be called and the class <code>selected</code> will be added to it.<br><br> 
                    </div>
                    Another way to initialize callbacks is through javascript, This can be done through 
                    the <code>loadCall()</code> method. However, any element in which the <code>loadCall()</code> function is applied will have the click event <code>executed</code> on it.       
            <div class="pre-area mvt-6">
                <div class="pxv-10 bc-silver">Callback: Example using Scripts</div>
                <pre class="pre-code" style="color:var(--olive)">
  &lt;button data-switch="box1" data-class="boxes" data-rel="box-group" onclick="switcher(this)" data-callback="open"&gt;&lt;/button&gt;

  &lt;button data-switch="box2" data-class="boxes" data-rel="box-group" onclick="switcher(this)"&gt;&lt;/button&gt;


  &lt;script&gt;

    function open(element) {

        $(element).addClass('selected');

    }

    let switchBox = new Switcher;
    switchBox.loadSwither('boxes')

    switchBox.loadCall('box1', 'open')

  &lt;/script&gt;
                </pre>
            </div>
                   <div class="font-em-d9 mvt-6">
                       In the code above, the <code>loadCall()</code> method is used to select and track the <code>data-switch="box1"</code> button. A callback function <code>open()</code> is also assigned for when the button 
                       is active. Once the element becomes active, then a class of <code>"selected"</code> will be added to it. <br><br>
                   </div>

                    <div class="silent-update">
                        <div class="font-em-d95 c-orange-dd">Silent update</div>       
                        <div class="font-em-d9">
                            The switcher method uses the onclick event to update sessionStorageItem key and value pairs. However, there may be situations in which the click event is not 
                            nedeed. In order to update the sessionStorage item, the key <code>"data-switch"</code> and the <code>"data-class"</code> must be updated manually using javascript. This 
                            is done through the method <code>silentUpdate()</code> which takes the first argument as the id (or data-switch) value, and the second argument as the class or (data-class) 
                            value. Example is below:
                        </div>

<div class="pre-area shadow shadow-1-strong mvt-6">
    <pre class="pre-code" style="color:var(--olive)">
  &lt;button data-switch="box1" data-class="boxes" data-rel="box-group" onclick="switcher(this)" data-callback="open"&gt;&lt;/button&gt;

  &lt;button data-switch="box2" data-class="boxes" data-rel="box-group" onclick="switcher(this)"&gt;&lt;/button&gt;

  
  &lt;script&gt;

    $(document).ready(function() {

        let switchBox = new Switcher;
        switchBox.silentUpdate('box2', 'boxes')

    })

    switchBox.loadSwither('boxes')

  &lt;/script&gt;
    </pre>
  </div>
                        <div class="font-em-d9 mvt-6">
                            In the code above, once the page is loaded, the <code>silentUpdate</code> will set the primary element as the second button with the attribute <code>data-switch="box2"</code>.   
                        </div>

                    </div><br>
                    
                </div>

            </div>

        </div>
    </section>
</div>
 <script>

    function switchColor(elem) {

        $('[data-class]').removeClass('bc-orange-dd').addClass('bc-orange-d')
        $(elem).removeClass('bc-orange-d').addClass('bc-orange-dd')
 
    }

    $(document).ready(()=>{
        let switchBtn = new Switcher();
        switchBtn.loadSwitcher('toggle');
    })

 </script>
@template;