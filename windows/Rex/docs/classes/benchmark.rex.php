@template('template.t-tut')

    @lay('build.co.navbars:left-nav')

    <div class="box-full pxl-2 bc-white-dd pull-right">
    
        <section class="pxv-10 tutorial bc-white">
            <div class="font-em-1d2">

                <div class="start font-em-d8">

                    @lay('build.co.links:tutor_pointer') <br>

                    <div class="font-em-1d5 c-orange">Benchmark</div> <br>  
                    
                    <div class="helper-classes">
                        <div class="">

                            <div class="">
                                The <code>Benchmark</code> class is a lite cli tool for benchmarking codes. It uses a static method <code>fn</code> 
                                to run series of code lines and then it tries to generate benchmark table for each code group it executes. 
                                An example of this is shown below: <br>
                            </div> <br>

                        </div> 
                    </div>  


                    <div id="initialize" class="">
                        <div class="">
                            <div class=" fb-6 flex-full rad-4 pvs-8 lacier">
                                <div class="flex-full midv c-orange-dd"> 
                                    <span class="mxr-8">
                                        <span class="bi-lightning-fill"></span>
                                    </span> Initializing class
                                </div>
                            </div>

                            <div class="">
                                The benchmark tool can be easily initialized as shown below.
                                <br><br>
                            
                                <div class="pre-area">
                                    <div class="box-full">
                                        <div class="pxv-6 bc-off-white">Sample code: Benchmark</div>
                                        <pre class="pre-code">
    \spoova\mi\core\classes\Benchmark::fn([

        'querie' => function(){
            $Hasher = new \spoova\mi\core\classes\Hasher;
            $Hasher->setHash(['loomars'], '1234');
            $hash = $Hasher->hashify();
        },

        'querier' => function(){
            for($i = 0; $i <= 99999; $i++){
                $Hasher = new \spoova\mi\core\classes\Hasher;
                $Hasher->setHash(['loomars'], '1234');
                $hash = $Hasher->hashify();
            }
        }
        
    ])
                                        </pre>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>


                    <div class="foot-note pvs-10"> 
                        The code above is an example of a benchmark code structure. In order to run this code in the command line, the following process should be followed: 

                        <ul>
                            <li>Copy the benchmark code from above.</li>
                            <li>Run the cli command <code>php mi :wiz</code></li>
                            <li>Paste the copied code to the cli.</li>
                            <li>Add a semicolon delimiter to a new line to declare the end of code.</li>
                            <li>Lastly, press enter to process the code.</li>
                        </ul>

                        Once the process above is executed, a benchmark table will be generated for each of the array keys "querie" and "querier".
                    </div>
                </div>
            </div>
        </section>

    </div>
    @lay('build.co.coords:footer')


@template;