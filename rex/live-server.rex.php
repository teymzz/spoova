
@template('template.t-doc')

@lay('build.coords:header')


<div class="pxv-20 c-black-ll">
    @lay('build.links:tutor_pointer')
    <div class="font-em-1d5 c-orange">Live server implementation</div> <br>         
    <ul>
        <li> 
            Live server is an inbuilt server that runs on javascript language. It enables
            live php development. In order to keep live server efficient, some helper classes or functions
            have been restructured to support live development. Debugging system was attached to php error handlers
            to reduce the KILL EFFECT. However, due to the comprehensive structure which php uses to handle its errors, 
            spoova debug system is still known to have major issues. Hence it is still in a beta phase.
        </li> <br>
        <li>
            Live server was built to support offline and online environments. 
            However, by default, online live server is diasbled
        </li> <br>
        <li> 
            Live server can be initialized through different ways: <br><br>
            
            1. Resource importing systems used for files grouping.<br>
            This is done through a default setup configuration file 
            by setting "RESOURCE_WATCH" to a default value of "true" 
            which tells the resource file handler class to automatically include the live server When
            importing or downloading resource urls. <br><br>

            2. By including the directive <code class="font-em-d9"><?= to_lgts('<?= Res::import("::watch") ?>')?></code>
            in your project file. <br><br>

            3. By including the <code class="font-em-d9"><?= to_lgts('<?= Res::live() ?>')?></code> which is a shorthand for 2 above <br><br>

            4. By including the <code class="font-em-d9"><?= to_lgts('@(live())@')?></code> directive in template engines <br><br>
            
            5. By including the <code class="font-em-d9"><?= to_lgts('@(Res(\'::watch\'))@')?></code> directive in template engines
        </li> <br>

        <li> 
            Live server can be switched off and on <br><br>
            
            1. Turn on.<br>
            By including the <code class="font-em-d9"><?= to_lgts('<?= Res::watch() ?>')?></code> in the head tag of your html code 
             <br><br>

            2. Turn off.<br>
            By including the <code class="font-em-d9"><?= to_lgts('<?= Res::off() ?>')?></code>  in the head tag of your html code
             <br><br>

             <span class="font-i c-silver-dd">
                Note: When live server is turned off either by a KILL EFFECT 
                 or through code, when turned back on, the page must be reloaded for the changes to take effect.
             </span>
           </li>        
    </ul>
</div>

@template;