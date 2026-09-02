@style('@root::core.custom.templates._metrics.metrics:metrics')
@load('intervalJS')
<style>
    body {
        font-family: Arial;
        background-color: #3452b2ff;
        color: white;
    }
    table {
        border: hidden;
        width: 90%; 
        margin: auto;
        text-align: left;
        white-space: wordwrap;
    }
    th, td {
        white-space: wordwrap; 
        font-size: .75em;
        width: 120px;
    }
    button {
        padding: 5px 10px;
        font-style: calibri;
        border: hidden;
        border-radius: 2px;
    }
</style>
@if($overlay):
<style>
    [\:\:sensor].sensor {
        z-index: {{ $overlay? }};
    }
</style>
@endif;
@ss(':headers','selector', 'switcher', 'checkBox', 'itemDragger')
@uses('core.classes.Sensor.SensorBase')
@uses('core.tools.BytesConverter')
@uses('core.classes.DB')
@uses('core.classes.Init')
@uses('core.classes.Livescript')
<div class="sensor vhm-50 moveable" ::sensor hidden>
    <div class="banner gap-4">
        <div class="sensor-metrics f-col wid-full">
            <div class="font-em-1d5 sensor-header poppins">Sensor metrics</div>
            <div class="calibri flex-col wid-full">
                <div class="flex gap-1 rb midv web-route no-wrap"> 
                    <span class="route-button"><i class="bi-globe"></i> Route</span> 
                    <div class="route-path no-wrap xvh-scroll">@navico($route.':bi-chevron-compact-right bi-nav')</div>
                </div>
            </div> <br>
            <div class="flex midv pxs-6 sense-route gap-2 poppins">
                {{: 
                  $state404 = '404 Page not found!';
                  $state200 = '200 Page resolved';
                  $ico = Window::isShut()? 'bi-exclamation-triangle' : 'bi-window-dock bi-error';
                  $state = Window::isShut()? $state404 : $state200;
                }}
                {{ "<i class='$ico'></i> $state" }}
                <!-- {{ Window::isShut()? '<i class="bi-exclamation-triangle"></i> '.$state404 : '<i class="bi-window-dock bi-error"></i> '.$state200 }} -->
            </div><br>
            <div class="flex-col gap-2">
                <div class="flex-col trackers-pane">
                    <div class="font-em-d85">
                        <details open class="trackers">
                            <summary class="firacode text-upps">
                                <span class="">Controllers (Routes)</span>
                            </summary>
                            <div class="font-em-d85 pxs-12 mvt-6">
                                @loop($x: 0 -> count($controllers)-1):
                                    {{: $ico = $x == 0 ? ' bi-square-fill ' : ' bi-circle-fill ' }}
                                    {{: $ico = $controllers[$x] === 'closure()' ? ' bi-arrow-right-short ' : $ico }}
                                    <div class="fira flex midv gap-1 pxs-4 pxl-{{ $controllers[$x] === 'closure()' ? 16 : 4 }} ">
                                        <span class="flex mid"> <i class="controllers-icon{{ $ico }}font-em-d7"></i> </span>
                                        {{: 
                                            $controller = $controllers[$x]; $scheme = scheme('Windows\Routes', false); 
                                        }}
                                        <span class="flex mid">{{ ltrim(str_ireplace($scheme, '', $controller),'\\') }}</span>
                                    </div>
                                @endloop;
                            </div>
                        </details>
                    </div>
                </div>
                                                    
                <div class="flex-col trackers-pane">
                    <div class="font-em-d85">
                        <details class="trackers shutters">
                            <summary class="firacode">
                                <span>
                                    SHUTTERS <span class="in-flex mid tracker-count">{{ count($shutters); }}</span>
                                </span>
                            </summary>
                            <div class="font-em-d85 pxl-14 fira">
                                {{: $shutter['total'] = 0 }}
                                @for($x = 0; $x <= count($shutters)-1; $x++):
                                    <details class="mvt-6 f-col gap-1">  
                                        <summary class="text-uppercase">
                                             {{: $shutter['methods'] = count($shutters) }}
                                             {{ $shutters[$x][0]; }}<i class="bi-hash"></i>{{ count($shutters[$x][1]); }} <br>
                                             {{: $shutter['total'] += count($shutters[$x][1]) }}
                                        </summary>
                                        <div class="trackers-list-pane">
                                            <div class="flex-col pxs-10 gap-1">
                                                @loop($y: 0 < count($shutters[$x][1])):
                                                    <div class="fira trackers-list pxl-6 no-wrap flex midv gap-1 flow-hide">
                                                        {{: $rname = array_keys($shutters[$x][1])[$y] }}
                                                        <i class="bi-dot font-em-d9"></i> {{ trim($rname)? $rname : '[:main]' }}
                                                    </div>
                                                @endloop;
                                            </div>
                                        </div>
                                    </details>
                                @endfor;
                            </div>
                        </details>
                    </div>
                </div>
                <div class="flex-col trackers-pane">
                    <div class="font-em-d85">
                        <details class="trackers shutters">
                            <summary class="firacode">
                                <span>APP CONFIGURATION</span>
                            </summary>
                            <div class="font-em-d85 pxs-10">
                                <div class="init-config-list">
                                    <table>
                                        <tr>
                                            <td>LIVE SERVER MODE</td>
                                            <td>{{ Livescript::key('CONTROLS') ?? '--NIL--' }}</td>
                                        </tr>
                                        <tr>
                                            <td>RESOURCE HANDLER</td>
                                            <td>{{ Init::key('RESOURCE_HANDLER') ?? '--NIL--' }}</td>
                                        </tr>
                                        <tr>
                                            <td>LIVE STATE RUNTIME</td>
                                            <td>
                                                {{: $LiveTime = Init::key('LIVE_STATE_RUNTIME') ?? 0 }}
                                                {{ toSuffix($LiveTime, 'millisecs', '0', $LiveTime) }}
                                            </td>
                                        </tr>
                                    </table>
                                </div>
                                <!-- @if($metrics_mode === 0):
                                <div class="metrics-code-help-header pxv-10">
                                    Database metrics is not enabled yet. Information 
                                    about database queries will not be available.
                                </div>
                                @endif; -->
                                <!-- @loop($x: 0 -> count($shutters)-1):
                                    ::{{ $shutters[$x][0]; }} <br>
                                @endloop; -->
                            </div>
                        </details>
                    </div>
                </div>
            </div>
        </div>
        <div class="pro-analysis-pane">
            <div class="primary-header sensor-metrics-2">
                <div class="">
                    <i class="bi-speedometer"></i> Sensor metrics
                </div>
                <div class="flex">
                    <div class="flex gap-1 rb midv web-route tracker-2 no-wrap"> 
                        <span class="route-button"><i class="bi-globe"></i> Route</span> 
                        <div class="route-path no-wrap xvh-scroll">@navico($route.':bi-chevron-compact-right bi-nav')</div>
                    </div>
                    <div class="flex-full gap-1 flex-r">
                        <span class="runtime-btn flex f-col font-12">
                            <span class="flex mid gap-1"> Runtime <i class="bi-x runtime-btx-2 flex mid px-15"></i></span>
                            <span class="font-10 flex midv">{{ $runtime? }}</span>
                        </span>  
                        <span hidden class="runtime-btn metrics-live flex f-col font-12" ::metrics-live>
                            <span class="flex midv gap-1"> Live <i class="bi-play" ctrl-ico></i></span>
                            <span class="font-10 flex midv">mode: {{ Livescript::key('CONTROLS') ?? 'default' }}</span>
                        </span>  
                    </div>
                </div>
            </div>
            <div id="primary-menu" class="pro-analysis-header flex text-uppercase" data-role="checkbox-list" data-bind="radio">
                <div class="flex" data-role="checkbox" active>
                    <div menu-list>
                        <i class="bi-person-fill-gear"></i> Controllers
                    </div>
                    <input type="checkbox" checked="true">
                </div>
                <div class="flex" data-role="checkbox">
                    <div menu-list>
                        <i class="bi-database-gear"></i> Queries
                    </div>
                    <input type="checkbox" checked="false">
                </div>
                <div class="flex" data-role="checkbox">
                    <div menu-list>
                        <i class="bi-sd-card"></i>  Memory
                    </div>
                    <input type="checkbox" checked="false">
                </div>
                <div class="flex" data-role="checkbox">
                    <div menu-list>
                        <i class="bi-cpu"></i> CPU
                    </div>
                    <input type="checkbox" checked="false">
                </div>
            </div>
            <div class="pro-analysis">

                <!-- project indicator header -->
                <div class="flex pxv-4 indicator-header-pane">
                    <div class="flex midv indicator-pane">
                        <div class="flex mid gap-2 pxl-10 pxr-5">
                            <div class="note-box project-pane grid-center">
                                
                            </div>
                            <div class="note-title font-em-d7">Project :</div>
                        </div>
                        <div class="font-em-d7">{{ $logic; }}</div>
                    </div>
                    <div class="flex midv indicator-pane">
                        <div class="flex mid gap-2 pxl-10 pxr-5">
                            <div class="note-box map-pane grid-center">
                                <i class="bi-braces-asterisk flex mid"></i>
                            </div>
                            <div class="note-title font-em-d7">Map :</div>
                        </div>
                        <div class="font-em-d7">{{ \spoova\mi\core\server\Serve::mapped() ? 'mapped' : 'unmapped' }}</div>
                    </div>
                    <div class="flex midv indicator-pane">
                        <div class="flex mid gap-2 pxl-10 pxr-5">
                            <div class="note-box db-pane grid-center"{{ $dbstatus? ' active': ''; }}>
                                @if($dbstatus):
                                    <i class="bi-database-check flex mid"></i>
                                @else:
                                    <i class="bi-database-x flex mid"></i>
                                @endif;
                            </div>
                            <div class="note-title font-em-d7">DB :</div>
                        </div>
                        <div class="font-em-d7">{{ $dbstatus; }}</div>
                    </div>
                    <div class="flex midv indicator-pane">
                        {{: 
                            $calls = round($shutter['methods'] / $shutter['total'] * 100, 2);
                        }}
                        <div class="flex mid gap-2 pxl-10 pxr-5">
                            <div class="note-box shutter-pane grid-center">
                                @if($dbstatus):
                                    <i class="bi-shield-lock flex mid"></i>
                                @else:
                                    <i class="bi-x flex mid"></i>
                                @endif;
                            </div>
                            <div class="note-title font-em-d7">Shutters :</div>
                        </div>
                        <div class="font-em-d7">{{ $calls }}%</div>
                    </div>
                    <div class="">
                        <div class="flex-full flex-rt pxs-6 font-em-d65 controllers-indicator">
                            <div class="shutter-level pxs-4">
                                <div class="flex mid gap-1">Best{{ ($calls > 55) ? '<i class="flex mid bi-patch-check"></i>' : ''}}</div>
                            </div>
                            <div class="shutter-level pxs-4">
                                <div class="flex mid gap-1">Average
                                    {{ (($calls < 55) && ($calls > 30)) ? '<i class="flex mid bi-patch-check"></i>' : ''}}
                                </div>
                            </div>
                            <div class="shutter-level pxs-4">
                                <div class="flex mid gap-1">Poor
                                    {{ ($calls < 30) ? '<i class="flex mid bi-patch-check"></i>' : ''}}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="trackers-field route-controllers trackers-list-pane">
                    <div class="pxv-6">
                        @if($calls < 50):
                            <div class="shutter-info font-em-d7 pxv-10">
                                <i class="bi-exclamation-triangle"></i> Project shutters are running low at <code class="">{{ $calls; }}%</code>. Consider using 
                                <code>trunk()</code> to keep this above 50% for a better performance.
                            </div>
                        @elseif($calls <= 55):
                            <div class="shutter-info font-em-d7 pxv-10">
                                <i class="bi-exclamation-circle"></i> Project shutters are running averagely at <code>{{ $calls; }}%</code>. You can improve this performance through <code>trunk()</code>. Learn more.
                            </div>
                        @else: 
                            <div class="shutter-info font-em-d7 pxv-10">
                                <i class="bi-exclamation-circle"></i> Project shutters seems to be running fine.  
                                @if(count($controllers) > 5):
                                    However calling multiple controllers may still impact your project performance.
                                @endif;
                            </div>
                        @endif;
                    </div>
                    <div class="flex-col fira pxs-6 gap-1">
                        {{: $h = -1; }}
                        @each($trackers as $tracker => $shutters):
                            {{: $i = 1; $h++; }}
                            <div class="tracked-shutter-pane"> 
                                <div class="tracked-controller flex gap-1">
                                    <div class="view-contoller flex gap-1" >
                                        <i view-controller class="bi-{{ $h ? 'circle-fill' : 'circle'}}" source="bi-circle|bi-circle" data-assign="checked|source|class"></i> 
                                        <input type="checkbox" checked="false">
                                    </div>
                                    {{ unscheme(to_namespace($tracker, false)); }} [{{ count($shutters) }}] <br>
                                </div>
                                <div hidden class="tracked-shutter caller-list-pane">
                                    <div class="flex gap-1" data-role="checkbox-list" data-bind="radio">
                                        @each($shutters as $shutter):
                                            @each($shutter as $call => $handler):
                                                <div id="track-{{ $i }}"  checked="{{$i === 1 ? 'checked' : 'unchecked'}}" class="tracked-shutter shutter-buttons" data-role="checkbox">
                                                    <div class="flex gap-1" checkbox data-color="@white|#fa27ed" data-flip="true">
                                                        <i class="bi-play flex mid" marker></i>
                                                        <i class="bi-play-fill flex mid" marker></i>
                                                        {{ $call }}
                                                    </div>
                                                    <input type="checkbox" checked="{{$i === 1 ? 'true' : 'false'}}">
                                                </div>
                                                {{: $tracked['track-field-'.$i] = is_string($handler)? str_replace('-','_',$handler) : $handler; $i++ }}
                                            @endeach;
                                        @endeach;
                                    </div>
                                    <div class="flex-col">
                                        @loop($t: 1 -> count($tracked)):
                                            
                                            <div {{$t !== 1 ? 'hidden' : ''}} track-id="track-field-{{ $t }}" class="tracked-shutter route-list-pane">
                                            @each($tracked['track-field-'.$t] as $route => $routeHandler):
                                                <div class="route-list">
                                                    <i class="bi-dot"></i> 
                                                    {{ $route?: '[:main]' }} -> {{ is_closure($routeHandler)? 'closure()' : (is_object($routeHandler)? get_class($routeHandler) : $routeHandler ) }}
                                                </div>
                                            @endeach;
                                            {{ $tracked['track-field-'.$t] ? '' : '[:pending]' }}
                                            </div>
    
                                        @endloop;
                                    </div>
                                </div>
                            </div>
                        @endeach;
                    </div>
                </div>
                <div hidden class="trackers-field queries pxv-6 flex-col gap-1">
                    @use('spoova\mi\core\classes\Enums\inflect')
                    @if($queries ?? ''):
                        
                        <div class="shutter-info font-em-d7 pxv-10 flex midv">
                            <div class="s-info flex-full midv">
                                <span>
                                    <i class="bi-exclamation-circle"></i> Page loaded with <code class="pxs-6">{{ count($queries) }}</code> detected sql {{ inflect(['query','queries'], count($queries), inflect::smart) }}
                                </span>
                            </div>
                            <div class="flex mid">
                                <code class="pxs-6 dbcon flex gap-1 midv"><i class="bi-server"></i>{{ join(',',DB::DBCON()) }}</code>
                            </div>
                        </div>
                        @each($queries as $query => $info):
                            <div class="font-em-d7 tracked-shutter">
                                <div class="pvs-10">
                                    <div class="sql-info">
                                        <span class="sql-icon">
                                            <i class="bi-server"></i> 
                                        </span>
                                        <span>
                                            {{ $info['query'] }}
                                        </span>
                                    </div>
                                </div>
                                <div class="flex midv gap-1">
                                    <div class="">
                                       {{ $info['response'] }}
                                    </div>
                                </div>
                                <div class="flex flex-r f-col">
                                    <div class="text-right">
                                       {{ $info['status'] }}
                                    </div>
                                    <div class="text-right font-em-d8"> 
                                    {{ $info['conName'] }} | Time: {{ $info['timeframe'] }}secs
                                    </div>
                                </div>
                            </div>
                        @endeach;
                    @else:
                        <div class="pxv-6">
                            No database queries currently detected!
                        </div>
                        @if($metrics_mode === 0):
                        <div class="font-em-d8 metrics-disabled flow-hide">
                            <div class="metrics-code-help-header flex midv gap-1 pxv-10">
                                <i class="bi-exclamation-circle flex mid"></i> Database metrics is not enabled in your project application.
                            </div>
                            <div class="metrics-code-help font-em-d9">
                                <div class=" pxv-20">
                                    You can enable this through your code or globally through init configuration file. 
                                    <span class="rule-dotted c-orange" style="color: #d563df;">Learn more</span>
                                </div>
                            </div>
                        </div>
                        @endif;
                    @endif;
                </div>
                <div hidden class="trackers-field flex-col gap-1 memory pxv-6">
                    @if($processes):
                        <div class="shutter-info font-em-d7 pxv-10">
                            <i class="bi-exclamation-circle"></i> You are currently using <code class="pxs-6">{{ $memory['percent-used']; }}%</code> memory on your device. 
                            @if($memory['percent-used'] > 70):
                                Too high usage will impact your project application's performance.
                            @elseif($memory['percent-used'] > 55):
                                High usage may impact your project application's performance.
                            @elseif($memory['percent-used'] >= 40):
                                This performance is good for your project application.
                            @endif;
                        </div>
                        <div class="shutter-info memory-analysis font-em-d7 pxv-10">
                            <div class="pxv-10">
                                <div class="">
                                    <div class="flex-col gap-1">
                                        <div class="flex" style="width: 100%">
                                            <div class="flex-col flex-full gap-2">
                                                <div class="">Allocated memory</div>
                                                <div class="">Total <code>{{ $memory['total']; }}</code></div>
                                            </div>
                                            <div class="flex-col flex-full gap-2">
                                                <div class="">Percent allocation</div>
                                                <div class="">100%</div>
                                            </div>
                                            <div class="flex-col flex-full gap-2">
                                                <div class="">Ratings</div>
                                                <div class=""><i>Not available</i></div>
                                            </div>
                                        </div>
                                        <div class="flex stretch" style="width: 100%">
                                            <div class="flex midv flex-full gap-1">
                                                <div class="">Used</div>
                                                <div class=""><code>{{ $memory['used']; }}</code></div>
                                            </div>
                                            <div class="flex-col flex-full">
                                                <div class="">{{ $memory['percent-used']; }}%</div>
                                            </div>
                                            <div class="flex-col flex-full">
                                                <div class="">{{ $memstat($memory['percent-used']); }}</div>
                                            </div>
                                        </div>
                                        <div class="flex stretch" style="width: 100%">
                                            <div class="flex midv flex-full gap-1">
                                                <div class="">Free</div>
                                                <div class=""><code>{{ $memory['free']; }}</code></div>
                                            </div>
                                            <div class="flex-col flex-full">
                                                <div class="">{{ $memory['percent-free']; }}%</div>
                                            </div>
                                            <div class="flex-col flex-full">
                                                <div class="">{{ $memstat($memory['percent-free']); }}</div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @else:
                        <div class="shutter-info font-em-d7 pxv-10">
                            <i class="bi-exclamation-circle"></i> Sensor cannot retrieve memory information of this device. Ensure you are 
                            running on windows operating system or you have essential permission to retrieve device information on your {{ getOs() }} device.
                        </div>
                    @endif;
                </div>
                <div hidden class="trackers-field flex-col gap-1 cpu pxv-6">
                    @if($processes):
                        <div class="shutter-info font-em-d7 pxv-10">
                            <i class="bi-exclamation-circle"></i> {{ count($processes) }} apps are running processes above <code class="pxs-6">{{ $procs_scale }}</code> on your device.  
                            This may impact your application's performance.
                        </div>
                        <div class="shutter-info font-em-d7 pxv-10">
                            <div class="pxv-10">
                                @each($processes as $p => $v):
                                    <div class="">
                                        <div class="flex gap-1">
                                            <div class="" style="width: 50%">{{ $p; }}</div>
                                            <div class="" style="width: 50%">{{ $v; }}</div>
                                            <div class="no-wrap" style="width: 50%">
                                                <!-- {{ $procs_map[$p] }}  -->
                                                Processes id <i class="bi-arrow-right"></i>
                                                [{{ implode(', ',$procs_id[$p]) }}]
                                            </div>
                                            <div class="no-wrap" style="width: 50%"></div>
                                        </div>
                                    </div>
                                @endeach;
                            </div>
                        </div>
                    @else:
                        <div class="shutter-info font-em-d7 pxv-10">
                            <i class="bi-exclamation-circle"></i> Sensor cannot retrieve os information on this device. Ensure you are 
                            running on windows operating system or you have essential permission to retrieve device information on your {{ getOs() }} device.
                        </div>
                    @endif;
                </div>
            </div>
        </div>
        <div class="pro-runtime-pane">
            <div class="flex flex-lt app-runtime-pane flow-hide relative">
                <div class="upper-section">
                    <span id="x" type="checkbox" class="bi-arrows-move mover relative" style="left:90%; top:-20px"></span>
                    <div class="rad-r app-runtime relative flow-hide"  style="z-index: 2;">
                        <div class="">
                            <div class="grid-center text-center relative time-box">
                                <div class="center">
                                    <span class="text-uppercase">RUNTIME</span>
                                    <span class="runtime">{{ $runtime? }}</span>  
                                </div>
                            </div>
                        </div>
                        <div class="runtime-btx">
                            <i class="bi bi-x"></i>
                        </div>
                    </div>
                    <div class="runtime-circle"></div>
                </div>
                <!-- <div class="">
                    Hey there...
                </div> -->
                <!-- <div class="">
                    <div class="px-100 grid-center">
                        <div class="">
                            <div class="">Device memory</div>
                            <div class="flex">
                                <span class="total">total {{ $memory['total'] }}</span>
                                <span class="free">free {{ $memory['free'] }}</span>
                                <span class="used">used {{ $memory['used'] }}</span>
                            </div>
                        </div>
                    </div>
                </div> -->
                <div class="dock" ::sp-dock=""></div>
            </div>
            <div class="processes">
                <div class="">
                    <div class="process-items-header">
                        <div class="">High Processes</div>
                            <div class="gap-1"><div class="square px-20 relative rad-r bd-2 flex mid">
                                    <div class="spinner-dot"></div>
                                    <div class="spinner"></div>
                            </div>
                            <button class="free-memory">Free memory</button>
                        </div>
                    </div>
                    <div class="process-items-list">
                        <table id="processTable" class="process-item wid-full">
                            <!-- {{: $processes = SensorBase::senseProcesses(); }} -->
                             <tbody>
                                {{: $processes = null }}

                                <!-- @if($processes):
                                    @each($processes['apps'] as $process):
                                        <tr class="flex">
                                            <td><button class="process-name">{{ str_replace('.exe', '', $process['name']) }}</button></td>
                                            <td><button>{{ $process['total_memory_kb'] }}</button></td>
                                        </tr>
                                    @endeach;
                                @endif; -->

                                @if(!$processes):
                                    <tr class="no-process">
                                     <td><i class="bi-exclamation-circle"></i> NO PROCESSES FOUND</td> 
                                    </tr>
                                @endif;
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@if(!$processes):
    <script>

        // defined variables to prevent long polls for memory state.
        let mem_poll_max = 5;
        let mem_poll_count = 0;
        
        let fm = document.querySelector('.free-memory'); 
        let trim = false;

        // defined to trim memory cache
        async function trimMemory(pid, type) {
            trim = true;
            let xuri = "{{uri}}";
            xuri = xuri.replace(/\?.*/,'');
            xuri = xuri+'?ssmetrix='+xuri+'&ssmetrim=true';
            const res = await fetch(xuri, {headers: {'X-Requested-With':'XMLHttpRequest'}});

            if(res.headers.get('content-type') === 'application/json'){
                const data = await res.json();
                if (data.status === 'ok') {
                    fm.closest('.process-items-header').querySelector('.square').classList.remove('active');
                    fm.closest('.process-items-header').querySelector('.square').classList.add('success');
                    setTimeout(()=>{
                        fm.closest('.process-items-header').querySelector('.square').classList.remove('success');
                    },2000)
                    fetchProcesses(); // Refresh after trimming
                } else {
                    // failed to trim memory
                    fm.closest('.process-items-header').querySelector('.square').classList.remove('active');
                }
            }
            trim = false;
        }
        
        // button event to trim memory
        fm.addEventListener('click',function(element){
            if(!trim){
                fm.closest('.process-items-header').querySelector('.square').classList.add('active');
                trimMemory();
                if(mem_poll_count > mem_poll_max){
                    mem_poll_count = 0;
                    memory_poll();
                }
            }
        })
        let action = 'list'; let termination = false;

        // defined function to fetch memory processes
        async function fetchProcesses() {
            let xuri = "{{uri}}";
            xuri = xuri.replace(/\?.*/,'');
            xuri = xuri+'?ssmetrix='+xuri;
            const res = await fetch(xuri, {headers: {'X-Requested-With':'XMLHttpRequest'}});
            const responseType = res.headers.get('content-type');
            const responseText = await res.text();
            
            if(responseType === 'application/json'){
                // const data = await res.json();

                try{
                    const data = JSON.parse(responseText);
                    const tbody = document.querySelector('#processTable tbody');
                    tbody.innerHTML = '';
        
                    if(data.apps){
                        data.apps.forEach(p => {
                            const tr = document.createElement('tr');
                            tr.setAttribute('class','flex');
                            if(action === 'list'){
                                tr.innerHTML = `
                                    <td><button class="process-name">${p.name}</button></td>
                                    <td><button>${p.total_memory_kb}</button></td>
                                `;
                                tbody.appendChild(tr);
                            }else{
                                tr.innerHTML = `
                                    <td><button class="process-name">${p.name}>/button></td>
                                    <td><button>${p.total_memory_kb}</button></td>
                                `;
                                tbody.appendChild(tr);
                            }
                        });
                    }else{
                        const tr = document.createElement('tr');
                            tr.setAttribute('class','flex');
                            tr.innerHTML = `
                                    <td>No processes detected.</td>
                                `;
                            tbody.appendChild(tr);
                    }
                }catch{
                    console.error('JSON response format expected.')
                    termination = true;
                }

                
            } else{
                termination = true;
                console.error('Memory response data error')
            }

        }
    </script>
    <script type="module">
        let interval = ss.interval(), timeout;
        window.memory_poll = () => {
            timeout = interval.start(() => {
                fetchProcesses();
                if(!termination) {
                    if(mem_poll_count <= mem_poll_max) timeout.recall(10000);
                } 
                mem_poll_count++;
            });
        }
        memory_poll()
    </script>
@endif;

<script>

window.addEventListener('load', function(){ 
    let spoova_sensor_menu_toggler = ss.checkBox(false);
    let spoova_sensor_selector = '['+CSS.escape('::sensor')+']';

    spoova_sensor_menu_toggler.check({

        target: spoova_sensor_selector + ' [checkbox]', //custom box selector,
        toggle: (props) => {

            if(props.checked){
                
                $trackedItem = `[track-id="track-field-${props.listId}"]`;
                $parent = props.checkList;
                $field = $parent.closest('.tracked-shutter');
                $($field).find('[track-id]').attr({'hidden':'hidden'});
                $($field).find($trackedItem).removeAttr('hidden');

            }

        }

    });

    spoova_sensor_menu_toggler.check({

        target: spoova_sensor_selector + ' [view-controller]', //custom box selector,
        toggle: (props) => {

            $trackedItem = `.caller-list-pane`;
            $checkbox = props.custom;
            $field = $checkbox.closest('.tracked-shutter-pane');

            if(props.checked){

                $($field).find($trackedItem).removeAttr('hidden');
                
            }else{
                $($field).find($trackedItem).attr({'hidden':'hidden'});
            }

        }

    });

    spoova_sensor_menu_toggler.check({

        target: spoova_sensor_selector + ' [menu-list]', //custom box selector,
        init: (props) => {
            if(props.checked){  
                $('.controllers-indicator').removeAttr('hidden')
            }
        },
        toggle: (props) => {

            id = props.listId;

            if(props.checked){
                $('.trackers-field').attr({hidden : 'hidden'})
                fields = {
                    1: 'route-controllers',
                    2: 'queries',
                    3: 'memory',
                    4: 'cpu',
                }

                $('.trackers-field.'+fields[id]).removeAttr('hidden')

                if(id === 1) {
                    $('.controllers-indicator').removeAttr('hidden')
                }else{
                    $('.controllers-indicator').attr({'hidden':'hidden'})
                }

            }
        }


    });

    function calibrateSensor(sensor){
        const app_runtime = sensor.querySelector('.app-runtime-pane')
        if(!app_runtime) return;

        // Collapsed, the sensor is pinned by CSS at left:90%, which only fits when
        // the box is narrower than a tenth of the viewport. Jumping to a hardcoded
        // 85% was still a guess, so a wider box stayed over the right edge and took
        // the drag handle with it. Shift by the overflow actually measured instead.
        const gap = 8; // keeps the handle clear of the very edge, so it stays grabbable
        const computed = window.getComputedStyle(sensor);
        const rect = app_runtime.getBoundingClientRect();

        const overflowRight = rect.right - (window.innerWidth - gap);
        const overflowBottom = rect.bottom - (window.innerHeight - gap);

        if (overflowRight > 0) {
            // read the resolved position: sensor.style.left is empty until it has been
            // set inline, and parseInt("") is NaN, which writes an ignored "NaNpx"
            const left = (parseFloat(computed.left) || 0) - overflowRight;
            sensor.style.left = Math.max(left, gap) + "px";
        }
        if (overflowBottom > 0) {
            const top = (parseFloat(computed.top) || 0) - overflowBottom;
            sensor.style.top = Math.max(top, gap) + "px";
        }
    }

    let selector = ss.selector();
    let runtimeBtx = selector.select('.runtime-btx');
    let runtimeBtx2 = document.querySelector('.runtime-btx-2');
    runtimeBtx2.addEventListener('click', function(){
        document.querySelector('.runtime-btx').click();
    })

    let body = document.querySelector('body'); 
    body.setAttribute('::sensor-open', true)

    runtimeBtx.forEach(btx => {
        btx.addEventListener('click', function(){
            selector.select(spoova_sensor_selector).forEach(sensor => {
                let body = document.querySelector('body'); 
                if(sensor.classList.contains('minimized')){
                    sensor.classList.remove('minimized')
                    body.setAttribute('::sensor-open', true)
                } else {
                    body.removeAttribute('::sensor-open')
                    sensor.classList.add('minimized') 

                    let computes = window.getComputedStyle(sensor)

                    calibrateSensor(sensor)
                }
                
            })
        })
    })

    let itemDragger = ss.itemDragger();
    itemDragger.select('.mover','.moveable').drag(function(e){
        e.started(function(item, count){
    
            if(count === 1) {
                let sensor = item.closest('['+CSS.escape('::sensor')+']'); 
                let banner = item.querySelector('.banner'); 
    
                item.style.position = "absolute";
                sensor.style.position = "absolute"; 
                sensor.style.right = 'initial';
            }
    
        })
    });

    let isDocked = false;

    let docker = setInterval(() => {
        let remoteSelector = '[id="'+CSS.escape('::')+'sp-control"]';
        let sensor = ss.select(spoova_sensor_selector);
        let dock = sensor.find('.dock').get();
        docked = dock.querySelector(remoteSelector)
        idDocked = docked ? true : false;
        if(!isDocked){
            let undocked = ss.select(remoteSelector);
            if(undocked.exists()){
              let zIndex = getComputedStyle(sensor.get()).zIndex;
              dock.appendChild(undocked.get())
              docked = undocked;
              setTimeout(() => {
                  calibrateSensor(sensor.get())
              },200)
              docked.css({'z-index': parseInt(zIndex) + 1, right: '5px'});
            //   dock.html(spLive.get().outerHTML);
            }
        }else{
            clearInterval(docker)
        }
    }, 2000)

    // display sensor only after page is loaded
    ss.select(spoova_sensor_selector).removeAttr('hidden')

    setTimeout(()=>{

        // define queries to select elements
        let liveDockQuery = '['+CSS.escape('::')+'sp-dock]';
        let remoteSelector = '[id="'+CSS.escape('::')+'sp-control"]';

        // apply queries to select elements
        let sensor = ss.select(spoova_sensor_selector);
        let remote = document.querySelector(remoteSelector)
        let liveDock = ss.select(liveDockQuery)
        let sensorLive = sensor.find('['+CSS.escape('::')+'metrics-live]');
        let sensorControl = sensorLive.find('[ctrl-ico]');
        let controlIconState = '';
       
        // use selected elements to render behaviour
        if(liveDock.exists() && sensor.exists() && remote){
            let spControl = liveDock.find('[spoova-role]');
            let liveControl = remote.querySelector('[live-control]');
            let sensorControlx = controlIconState = sensorControl.get();
            let controlClass = ss.select(liveControl).attr('class');
            remote.addEventListener('dblclick', function(){
                let controlClass = ss.select(liveControl).attr('class');
                controlClass = controlClass.replace('bi-play-circle', 'bi-play');
                sensorControl.attr({class: controlClass});
            });
            sensorControl.addClass(controlClass);
            let currentClass = controlClass;
            sensorLive.removeAttr('hidden')

            sensorControlx.addEventListener('dblclick',function(){
                const event = new MouseEvent('dblclick', {
                    bubbles: true,
                    cancelable: true,
                    view: window
                });
                liveControl.click();
                liveControl.dispatchEvent(event)
                // setTimeout(()=> {
                //     sensorControl.removeClass(currentClass);
                //     currentClass = ss.select(liveControl).attr('class');
                //     sensorControl.addClass(currentClass);
                // }, 200);
            })
        }else{
            sensorLive.remove();
        }

    },1000)

})

</script>