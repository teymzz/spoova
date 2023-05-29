
@template('template.t-tut')

  @lay('build.co.navbars:left-nav')

  <div class="box-full pxl-2 bc-white pull-right">
    
    <section class="pxv-10 tutorial mails bc-white">
      <div class="font-em-1d2">

        @lay('build.co.links:tutor_pointer') <br>

        <div class="start font-em-d8">

          <div class="font-em-1d5 c-orange">Resource Commands</div> <br>  
          
          <div class="resource-intro">
            <div class="">
              The <code>mkFile()</code> method is the main method that helps in creating files with 
              structurally predefined expected content code format. <br><br>
              
              <div class="font-em-d9">
                  Syntax: <code>Res::mkFile(type, args)</code> where: <br>
                  <div class="pxs-10">
                      type : main command directive <br>
                      args : arguments supplied on main command,
                  </div>
              </div>
            </div> 
          </div><br>
          
          <div id="core" class="core-helpers">     
            <div>
                This command is used for creating Window, Routes, Frames, Models and API and Rex template files. Example of usage is 
                shown below.
            </div> <br>
          </div>         
          
          <div id="add-window"> 
            
            <div>
              
              <div class="pre-area shadow">
<div class="pxv-6 bc-silver">Sample - creating window file</div>
                <pre class="pre-code">
  Res::mkFile('window', ['name', 'path']);
  php spoova add:controller &lt;name&gt; &lt;path&gt;
  <span class="comment">
    where: 

      window => command access key
      name => name of window file
      path => path of window file
  </span>
                </pre>

              </div>
            </div> 
          </div> 

          <div class="foot-note">
            <span class="head">Footnote 1:</span>
            When creating files, the live server should be turned off to prevent creating unintented files.
            <br>
            <span class="head">Footnote 2:</span>
            When creating files, the shell command <code>php spoova add:</code> is replaced with 
            <code>Res::mkFile()</code>. For example, <code>php spoova add:winmodel</code> becomes <code>Res::mkFile('winmodel')</code>. 
            The arguments are then supplied as second argument using array values. 
          </div><br>
          
          <div id="add-model"> 
            
            <div>
              <div class="pre-area shadow">
                <div class="pxv-6 bc-silver">Sample - create model file</div>
                <pre class="pre-code">
  Res::mkFile('model', ['name', 'path'];
  <span class="comment">
    where: 

      name => name of window file
      path => optional path to contoller file
  </span>
                </pre>
              </div>
            </div> 
          </div> <br>
          
          <div id="add-winmodel"> 
            
            <div>

              <div class="pre-area shadow">
                <div class="pxv-6 bc-silver">Sample - add model into windows directory</div>
                <pre class="pre-code">
  Res::mkFile('winmodel', ['name', 'path'];
  <span class="comment">
    where: 

      name => name of model file
      path => optional path to contoller file
  </span>
                </pre>
              </div>
            </div> 
          </div> <br>
          
          <div id="add-rex"> 
            
            <div>
              <div class="pre-area shadow">
                <div class="pxv-6 bc-silver">Sample - add a rex template file</div>
                <pre class="pre-code">
  Res::mkFile('rex', ['pathname', 'filename'];
  <span class="comment">
    where: 

      pathname => optional path to contoller file
      filename => name of rex file
  </span>
                </pre>
              </div>
            </div> 
          </div>     

          <div class="font-em-d87 mvt-10">
            In these formats, files can be created in a predefined structures. Check the 
            <a href="@domurl('docs/cli')"><span class="calbri hyperlink fb-6 c-blue">Cli</span></a> add
            directives for more commands.
          </div>
          
        </div>
      </div>
    </section>

  </div>

  @lay('build.co.coords:footer')

@template;
