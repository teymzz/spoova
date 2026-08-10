@style('@root::core.storage._metricss.metrics:metrics')
@ss('headers','selector', 'checkBox', 'itemDragger')
<div class="sensor vhm-50 moveable"  ::sensor>
    <div class="banner gap-4">
        <div class="sensor-metrics f-col wid-full">
            <div class="font-em-1d5 sensor-header poppins">Sensor metricsk</div>
            <div class="calibri wid-full">
                <div class="flex gap-1 rb midv web-route"> <span class="route-button"><i class="bi-globe"></i> Route</span> <div>@navico($route.':bi-chevron-compact-right bi-nav')</div></div>
            </div> <br>
            <div class="flex-col gap-2">
                <div class="flex-col trackers-pane">
                    <div class="font-em-d85">
                        <details open class="trackers">
                            <summary class="text-uppercase">
                                Controllers
                            </summary>
                            <div class="font-em-d85 pxs-12 mvt-6">
                                @loop($x: 0 -> count($controllers)-1):
                                    {{: $ico = $x == 0 ? ' bi-square-fill ' : ' bi-circle-fill ' }}
                                    {{: $ico = $controllers[$x] === 'closure()' ? ' bi-arrow-right-short ' : $ico }}
                                    <div class="fira flex midv gap-1 pxs-4 pxl-{{ $controllers[$x] === 'closure()' ? 16 : 4 }} ">
                                        <span class="flex mid"> <i class="controllers-icon{{ $ico }}font-em-d7"></i> </span>
                                        <span class="flex mid">{{ $controllers[$x] }}</span>
                                    </div>
                                @endloop;
                            </div>
                        </details>
                    </div>
                </div>
                                                    
                <div class="flex-col trackers-pane">
                    <div class="font-em-d85">
                        <details class="trackers shutters">
                            <summary class="">
                                SHUTTERS <span class="in-flex mid tracker-count">{{ count($shutters); }}</span>
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
                                                        <i class="bi-dot font-em-d9"></i> {{ trim($rname)? $rname : '[:entry]' }}
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
                            <summary class="">
                                DB QUERIES
                            </summary>
                            <div class="font-em-d85 pxs-14">
                                @loop($x: 0 -> count($shutters)-1):
                                    ::{{ $shutters[$x][0]; }} <br>
                                @endloop;
                            </div>
                        </details>
                    </div>
                </div>
            </div>
        </div>
        <div class="pro-analysis-pane">
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
                <div class="flex pxv-4">
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
                    <div hidden class="flex-full flex-rt pxs-6 font-em-d65 controllers-indicator">
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

                <div class="trackers-field route-controllers trackers-list-pane">
                    <div class="pxv-6">
                        @if($calls < 50):
                            <div class="shutter-info font-em-d7 pxv-10">
                                <i class="bi-exclamation-triangle"></i> Project shutters are running low at <code class="">{{ $calls; }}%</code>. Consider using 
                                <code>trunk()</code> to keep this above 50% for a better performance.
                            </div>
                        @elseif($calls <= 55):
                            <div class="shutter-info font-em-d7 pxv-10">
                                <i class="bi-exclamation-circle"></i> Project shutters are running averagely <code>{{ $calls; }}%</code>. You can improve this performance through <code>trunk()</code>. Learn more.
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
                                            {{ $tracked['track-field-'.$t] ? '' : '=> {:pended}' }}
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
                        
                        <div class="shutter-info font-em-d7 pxv-10">
                            <i class="bi-exclamation-circle"></i> Page loaded with <code class="pxs-6">{{ count($queries) }}</code> detected sql {{ inflect(['query','queries'], count($queries), inflect::smart) }}
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
                                      Time: {{ $info['timeframe'] }}secs
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
                    @elseif($calls <= 55):
                        <div class="shutter-info font-em-d7 pxv-10">
                            <i class="bi-exclamation-circle"></i> Your shutters are running averagely <code class="">{{ $calls; }}%</code>. You can improve 
                            this performance through <code>trunk()</code>. Learn more.
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
                    @elseif($calls <= 55):
                        <div class="shutter-info font-em-d7 pxv-10">
                            <i class="bi-exclamation-circle"></i> Your shutters are running averagely <code class="">{{ $calls; }}%</code>. You can improve 
                            this performance through <code>trunk()</code>. Learn more.
                        </div>
                    @endif;
                </div>
            </div>
        </div>
        <div class="flex flex-lt app-runtime-pane flow-hide relative">
            <div class="">
                <span id="x" type="checkbox" class="bi-arrows-move mover relative" style="left:90%; top:-20px"></span>
                <div class="rad-r app-runtime relative flow-hide"  style="z-index: 2;">
                    <div class="">
                        <div class="grid-center text-center relative time-box">
                            <div class="center">
                                <span class="text-uppercase">RUNTIME</span>
                                <span>{{ $runtime? }}</span>  
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
        </div>
    </div>
</div>

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


            // $trackedItem = `.caller-list-pane`;
            // $checkbox = props.custom;
            // $field = $checkbox.closest('.tracked-shutter-pane');

            // if(props.checked){

            //     $($field).find($trackedItem).removeAttr('hidden');
                
            // }else{
            //     $($field).find($trackedItem).attr({'hidden':'hidden'});
            // }

        }


    });

    let selector = ss.selector();
    let runtimeBtx = selector.select('.runtime-btx');
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
})

</script>