/**
 * This class was created to support dynamic php and php content control.
 * PHP has different ways of displaying errors, this means that error debugger may not work successfully on all php server applications. 
 * This algorithm may be subjected to future changes and updates as at when necessary to further improve its performace.
 */
if(typeof Res === 'undefined'){

    class Res {

        constructor(){

            //default variables anchor
            let defaults = {}, loc, uri, xdefaults;

            //url default extension (should be updated)
            this.defaults = defaults;
            defaults.extension = '';

            //set internal default variables
            defaults.phperrors = 
                ["parse error", 
                 "fatal error", 
                 "notice", 
                 "warning", 
                 "core error"
                ];
            
            //environment debug variables
            defaults.Online   = false;
            defaults.Offline  = 'uiconsole';
            defaults.isOnline = false;

            //current environment
            defaults.environment = '';

            //fake enviroment mode
            defaults.enviromodal = 'offline';

            //set default interval
            defaults.interval   = 1000;

            //interlock / error logging
            defaults.interlock  = true;
            defaults.Onlinelog  = false;
            defaults.Offlinelog = true;

            //set default current environment
            loc = document.location.href.match(/[^\/]+$/) || '';
            uri = this.reformatUrl(loc); 
           
            //set url address
            defaults.currentLoc = uri.loc;
            defaults.currentUri = uri.base; //basename
            defaults.currentUrl = uri.addr; 
            defaults.appUrl     = uri.appurl;

            //set interval controller
            defaults.interval   = 1000;
            
            //set defaults
            this.defaults = defaults;
            this.mobi = {};

            //reload function
            this.defaults.reload = function(){ 
                window.location.reload();
            }

            var data = Object.create(null), id = 0; 

            this.defaults.controller = function(res){
        
                res.defaults.startServer = function(func, time){
                    data[id] = {
                        nativeID: setTimeout(func, time),
                        func: func,
                        time: time
                    } 
                    return id++;
                }

                res.defaults.stopServer = function(){
                    if(data[id]) {
                        clearTimeout(data[id].nativeID);
                        delete data[id];
                    }
                
                    res.defaults.terminated  = true;
                    return id++;
                }  

                res.defaults.pauseServer = function(bool) {
                    if(bool){
                        res.defaults.stopServer();
                    }else{
                        if(res.boot) {
                            res.boot(true) //start server
                        }else{
                            res.stream(res.baseStream)
                        }
                    }
                }

                res.defaults.pauseActivity = function(bool, callback) {
                    res.defaults.pauseServer(bool)
                    if(callback) callback(bool);
                }
                
                document.addEventListener('visibilitychange', function(){
                    if(res.boot){
                        if(document.visibilityState == 'visible'){
                            if(res.defaults.remotePause !== true){
                                res.defaults.terminated = false;
                                res.boot(true) //start
                                res.timerBox().resume();
                            }
                        } else {
                            res.defaults.stopServer();
                        }
                    }
                })

            }

            this.defaults.controller(this);

            //controller assets
            this.assets = {
                'root'    : '',
                'base'    : 'res/main/',
                'corecss' : 'css/local/core.css',

                'Debug'   : 'js/local/debug/debug.js',
                'Livejs'  : 'js/local/debug/live.js',
                'Livecss' : 'css/local/debug/res.css',
            }
                
            if(!this.resources('css').exists){
                this.resources('css').add();
            }

        }

        /**
         * 
         * Reformat the supplied url / location
         */
        reformatUrl(loc){
            let uri = {}, url, urx;

            //get or use supplied location
            loc = Array.isArray(loc)? loc[0] : loc;
            url = loc + ' ';

            //* base url path
            uri.loc = loc;

            //* name with index or defined base address
            urx = (loc == '')? window.location.href : loc;
            urx = urx.trim().replace(/\/$/,"")

            uri.base = urx; 

            //if no address is found use current address
            uri.addr = (loc.trim() == '') ? urx : this.urlenv(location);

            return uri;
        }

        /**
         * Update an old data with a new data
         */
        update(target, newdata){
            if(newdata == undefined) return target;
            const res = {};
            Object.keys(target).forEach(k => res[k] = (newdata.hasOwnProperty(k)? newdata[k] : target[k]));
            return res;
        }

        /**
         * Reconfigure url supplied
         * 
         * @returns string
         */
        urlenv(url) {
    
            let ext, split, splen, lastpop;

            //access defined file extension
            ext = this.defaults.extension || '';

            url = url.toString();
            url = url.split("?")[0]
            url = url.split("#")[0];

            split = url.split(".");
            splen = split.length;
        
            if ((splen === 1 || (split[0] === "/" && splen === 2)) && ext !== "") {
                lastpop = (split[0].split("/").pop() == "") ? "index" : "/";
                url = url + lastpop + "." + urlext;
            }
            
            return url;
        }
        
        /**
         * Strip off html script tags
         * 
         * @returns string
         */
        stripScripts(html){
            var div = document.createElement("div");
            div.innerHTML = html;
            var scripts = div.getElementsByTagName("script");
            var i = scripts.length;
            while (i--) {
                scripts[i].parentNode.removeChild(scripts[i]);
            }
            return div.innerHTML;
        }

        /**
         * Reconfigure arguments supplied
         * into monitor function
         */
        monitorInit(settings, url){

            //detect current environment
            let isOnline = (location.hostname !== "localhost" && location.hostname !== "127.0.0.1");

            //set appurl
            this.assets.root = url;
            this.defaults.appUrl = url;

            //set/initialize current environment
            this.defaults.isOnline  = isOnline;
            this.defaults.isOffline = !isOnline;            

            //store current environment
            this.defaults.environment = isOnline? 'online' : 'offline';


            //reconfigure settings
            let json = this.jsonval(settings);
            let configs = json.object;
            let mode = configs.mode;
            let controls;
            
            if(configs.controls !== 'false' && configs.controls !== ''){ 
                controls = configs.controls;
            }

            //validate runtime 
            let runtime = configs.runtime || 600; //allows 30 seconds minimum time 
            runtime = parseInt(runtime); 

            if(!runtime || runtime < 60){
                if(runtime < 60) {
                    console.error('Live server config error >> runtime('+runtime+') less than min of 60secs.');
                }else{
                    console.error('Live server config error >> runtime using default.');
                }
                console.info('Live server (runtime) >> '+runtime+' secs.');
                runtime = 600;
            }

            //re-initialize environment debugging
            this.defaults.Online  = 'uiconsole'; // [uiconsole|pop|console|off]
            this.defaults.Offline = 'uiconsole'; // [uiconsole|pop|console|off]
            this.defaults.ops     = mode;
            this.defaults.runtime = runtime;
            this.defaults.controls = controls;
            this.defaults.remoteIcons = {
                review: configs.review || 'bi-arrow-clockwise',
                pauser: configs.pauser || 'bi-pause-circle',
                player: configs.player || 'bi-play-circle',
                position: configs.position
            };

            if(mode === "::console" || mode === "<<console"){
                this.defaults.show = true;
                return this.defaults;
            }

            if(mode === 'online') {
                //enable all environments debugging
                return this.defaults
            } 

            if(mode === '::lock' || mode ==='<<lock') {
                //enable all environments debugging
                return this.defaults;
            }  

            if(mode === '::watch' || mode === '<<watch') {
                //enable all environments debugging
                return this.defaults;
            }  

            if(mode === 'offline') {
                //allow only offline environment debugging
                this.defaults.Online  = false;
                return this.defaults;
            } 

            if(mode === 'on:offline') {
                //allow only offline environment debugging
                this.defaults.Online  = false;

                //fake environment as if currently online
                this.defaults.enviromodal = 'online';
                return this.defaults;
            }  
            
            if(typeof mode === 'integer') {
                settings.interlock = false;
                settings.interval  = settings;
                return this.update(this.defaults, settings);
            }   

            if(typeof settings == 'object') {
                if(settings.interlock == '::lock') {
                    settings.interlock = true;
                }
                return this.update(this.defaults, settings);
            }

        }

        /**
         * 
         * special built-in function for live error notification 
         */
        monitor(settings = {}, appUrl = ''){

            settings = this.monitorInit(settings, appUrl);

            //monitor's internal variables
            let mobi = settings, rex, url, view, params, base, runtime;

            //initialize few internal variables
            mobi.errlog = 0; mobi.notice = 0; mobi.counter = 0;
            mobi.oldError = ''; mobi.newError = ''; mobi.newTable = '';
            mobi.loading  = false; mobi.pause = false; rex = this;
            mobi.status = {}, mobi.serverError = 0; mobi.propeller = 0;
            mobi.timer = 21;
                                    
            //get debug type
            mobi.offline = (mobi.enviromodal === "offline");
            mobi.debug = mobi.offline ? mobi.Offline : mobi.Online;

            if(!mobi.offline) return ;

            setTimeout( () => {
                
                url = this.defaults.currentUrl;
                runtime = this.defaults.runtime;
                view = (settings.currentLoc == '')? ':' : `>> ${settings.currentUrl} `;
                params = this.defaults.params = window.location.search;
                
                //set the watch word
                mobi.watchword = `watching ${view} `;

                //store mobi data
                rex.mobi = mobi;

                rex.xhttp(url+params, function(response){

                    mobi.loading = false;

                    if(response.readyState == 4){

                        if(response.status === 200 || response.status === 423){

                            base = {
                                url: url + params,
                                htmlContent : response.responseText,
                                htmlRefined : rex.filterScript(response.responseText),
                                instance   : 0,
                                status     : response.status,
                                terminate  : 0,
                                cycle    : 0
                            };

                            rex.info('Live server (mode) >> online for '+runtime+' seconds');

                            document.addEventListener('visibilitychange', function(){
                                if(document.visibilityState == 'visible' && !res.defaults.remotePause){
                                    base.cycle = 0;
                                }
                            })

                            if(rex.defaults.controls && ['poll','seek'].includes(rex.defaults.controls)){
                                rex.addRemoteControl();
                            }

                            rex.baseStream = base;
                            rex.stream(base);

                        }else{
                            
                            rex.clear(function(){
                                rex.error('Live server (error) >> failed to fetch resource');
                            })

                        }

                    }

                })

            });

        }

        stream(base) {
            
            let defaults, content, mobi, debug, rex = this, offline;

            //declare debug variables
            let allowPop = false, allowConsole = false;

            //set configuration objects
            content  = base.htmlRefined;
            defaults = this.defaults;
            mobi     = this.mobi;

            mobi.counter++;
            
            offline = mobi.offline;
            debug = mobi.debug;

            //set debug variables
            allowPop = (debug == 'uiconsole' || debug == 'pop');
            allowConsole = (debug == 'uiconsole' || debug == 'console');
            
            //reformat console logger
            if(!console) allowConsole = false;

            /* initialize content monitoring */
            if(content != undefined) {

                //display a starting message
                if(mobi.counter == 1 && content != undefined){
                    rex.cleanDebugs();
                }

                //create default variables
                let url, params, status, rawcontent, newcontent;
                
                url = defaults.currentUrl,
                params = window.location.search;

                //send unamibiguous request
                if(!mobi.loading){

                    rex.xhttp(url + params, function(response){
                        status = rex.status(response);
               
                        mobi.started = true;
                            
                        rawcontent = response.responseText;

                        if(status.isReady){

                            newcontent = rex.filterScript(response.responseText);
                            mobi.status = status;
                            mobi.newcontent = newcontent;
                            mobi.loading = false;

                            if(mobi.started && mobi.status.isFileError){ 

                                mobi.timer--;
                                
                                rex.clear(function(){
                                    rex.error('Live server (error) >> failed to fetch resource');
                                    rex.log('Live server (terminates) : ' + mobi.timer)
                                    
                                    if(mobi.timer < 1) {
                                        rex.clear(function(){
                                            rex.error('Live server (terminated) >> failed to fetch resource');
                                        })
                                        rex.defaults.stopServer(rex.live);
                                        return ;                  
                                    }
                                    
                                })


                            }else{
                                if(mobi.timer && mobi.timer < 21){
                                    rex.clear(function(){
                                        rex.info('Live server (mode) >> online');
                                    })                        
                                }
                                mobi.timer = 21;
                            }

                        
                            //* Handle server error (500)
                            if(status.isServerError){
                                rex.error(mobi.watchword, offline);

                                if(allowPop && mobi.serverError == 0) {

                                    //remove any previous error ... 
                                    rex.box('::notice').remove();

                                    let widget = `
                                        <div class="widget spoova-e-widget box relative px-full">
                                            <div class="box relative rad-r">
                                                <div class="roller-circle absolute box rad-r">
                                                    <div class="roller rad-r ov-d4 absolute ico-spin"></div>
                                                    <div class="roller-text rad-r absolute flow-hide ov-l1 c-grey anc-btn-link">
                                                        <div class="px-full grid-center font-em-d6">
                                                            &#9888
                                                        </div>    
                                                    </div>        
                                                </div>            
                                            </div>
                                        </div>
                                    `;
                                    //fix code or server error notice was replaced with roller widget
                                    rex.pop(rex.makeDiv(widget, 'spoova-notice-err e-widget'), true);
                                }
                                if(mobi.serverError == 0){
                                    rex.clear(function(){
                                        rex.error('Live server (error) >> please fix your code or server');
                                    })
                                }else{
                                    rex.clear(function(){
                                        rex.info(mobi.watchword);
                                    })
                                }

                                mobi.serverError = 1; 
                                mobi.loading = false; //interval mode
                                mobi.interval = 3000;

                            }

                            //* Handle successful requests (200)
                            else if(status.success){

                                // Handle server error
                                //detect a previous server error & nullify it
                                if(mobi.serverError){ 
                                    if(allowConsole) {
                                        rex.clear(function(){
                                            rex.info(mobi.watchword);
                                        })
                                        rex.clearDebugs();
                                        mobi.oldError = false;
                                    }
                                    mobi.serverError = 0;
                                    mobi.interval = 1000;
                                }

                                //declare dynamic variables
                                let contentObj, errTable, errDiv, errorTable, errBox,
                                errAttrs = '', errAttributes = '', errmess = 0, roll,
                                errFound = false, isTableErr = false;

                                //set variables for needed script(s)
                                let scriptwrap = {}, scriptLen;

                                contentObj = new DOMParser().parseFromString(newcontent, "text/html");
                                errTable = contentObj.querySelector("table.xdebug-error") || "";
                                errDiv   = contentObj.querySelector("div.xdebug-error") || "";

                                //store detected error field
                                errBox = (errTable != "")? errTable : errDiv;
                                errFound = (errBox != "")? true : false;
                                isTableErr = errTable ? true : false;

                                if(errFound){
                                    errAttrs = errBox.attributes;
                                    
                                    for(let i = 0; i < errAttrs.length; i++){
                                        errAttributes += (errAttrs[i].nodeName != "border")? errAttrs[i].nodeName+`="`+errAttrs[i].nodeValue+`" ` : "";
                                    }

                                    let tableContents = errBox.innerHTML;

                                    if(tableContents.indexOf("( ! )")){
                                        let e_Parse = (tableContents.indexOf("Parse error") > -1)? 'Parse error' : false;
                                        let e_Notice = (tableContents.indexOf("Notice error") > -1)? 'Notice error' : false;
                                        let e_Error  = e_Parse || e_Notice;

                                        if(e_Error){

                                            let errTitle, errInfo, errObj;

                                            errTitle = '<div class=""> <span class="err-name"> <span class="bi-info-circle"></span> '+e_Error+' </span> </div>';
                                            tableContents = tableContents.replace(">( ! )<", '>'+errTitle+'<');
                                            tableContents = tableContents.replace(/bgcolor="[#A-Za-z0-9\.,\(\)]*"/g,"");
                                            tableContents = tableContents.replace(/style="[#-A-Za-z0-9\.,:;\(\)\s]*"/g," ");
                                            tableContents = tableContents.replace(/x-large/,"inherit")

                                            if(isTableErr){
                                                errObj = new DOMParser().parseFromString('<table>'+tableContents+'</table>', 'text/html')
                                                errInfo = errObj.querySelector(".err-name").closest('th');
                                                
                                                if(errInfo){
                                                    errInfo = errInfo.innerHTML;
                                                    errInfo = errInfo.replace(errTitle, "");
                                                    errInfo = errInfo.replace(/<[^/>[^>]*><\/[^>]+>/, "");
                                                    tableContents = tableContents.replace(errInfo, '<span class="tb-message">'+errInfo+'</span>')
                                                }                                                
                                            }

                                            //create a new style for the custom table
                                            let newStyle  = `
                                                <style>
                                                    table[class="xdebug-error xe-parse-error"] 
                                                            > tbody:first-child 
                                                            > tr:first-child 
                                                            > th:first-child 
                                                        {
                                                            background-color: rgb(115, 177, 202);
                                                            padding: 1em;
                                                            color: white;
                                                            font-family: calibri;
                                                            border-radius: 0.25em;
                                                    }

                                                    table[class="xdebug-error xe-parse-error"] 
                                                    .tb-message
                                                        {   
                                                            display: block;
                                                            padding: .5em;
                                                    }
                                                    
                                                    
                                                    table[class="xdebug-error xe-parse-error"] span.err-name{
                                                        display:inline-block;
                                                        padding: .5em;
                                                        background-color: white;
                                                        color:rgb(213, 30, 47);
                                                        border-radius: 100vh;
                                                        font-weight: normal;
                                                    }
                                                </style>
                                            `;

                                            tableContents += newStyle; 
                                        }

                                    }       
                                    
                                    if(isTableErr){
                                        //* build error notice from core response table
                                        tableContents = tableContents.replace('>( ! )<','><');
                                        errorTable = "<table "+errAttributes+" data-err=\"x-debug\" style=\"color:inherit; border-collapse:separate; border-spacing:.5em; float:right;\" class=\"spoova-notice\">"+tableContents+"</table>"
                                    }else{
                                        //* build error notice from customized error field
                                        errorTable = "<div "+errAttributes+" data-err=\"x-debug\" style=\"color:inherit; padding: .5em; font-size:16px;\" class=\"spoova-notice\">"+tableContents+"</div>";
                                    }

                                    //* Handle all scripts within error table
                                    let funcs = []; let scriptsAnchor = [];
                                    let div = document.createElement('div');
                                    div.innerHTML = errorTable;
                                    let scripts = div.getElementsByTagName('script');
                                    let i = scripts.length;

                                    div.setAttribute('id',"auto_new_html");
                                    div.innerHTML = tableContents;
                                    
                                    scriptLen = scripts.length;

                                    while (i--){
                                        //push all scripts to scriptAnchor
                                        let nodes = {};
                                        for (var att, j = 0, atts = scripts[i].attributes, n = atts.length; j < n; j++){
                                            att = atts[j];
                                            nodes[att.nodeName] = att.nodeValue;
                                        }                                    
                                                                    
                                        if(scripts[i].text != ''){
                                            nodes[':text'] = scripts[i].text;
                                        }
                                        scriptsAnchor.push(nodes);
                                        
                                        scripts[i].parentNode.removeChild(scripts[i]);
                                    } 
                                    scriptsAnchor = scriptsAnchor.reverse();

                                    if(scriptLen > 0){

                                        scriptsAnchor.forEach((nodes, index) => {
                                            let newscript = document.createElement('script');
                                            if(nodes[':text'] != undefined){
                                                let scriptText = document.createTextNode(nodes[':text']);
                                                newscript.appendChild(scriptText)
                                                delete nodes[':text'];
                                            }

                                            if(typeof nodes === 'object'){
                                                for(let nodekey of Object.keys(nodes)){
                                                    
                                                    newscript.setAttribute(nodekey, nodes[nodekey]); 
                                                } 
                                            }

                                            scriptwrap[index] = newscript;
                                        })
                                
                                    }
                                }
                                
                                let newmod = newcontent;
                                let mbuild = newcontent;
                            
                                newmod = newmod.replace(/<\/?[^>]+(>|$)/g," ").trim();
                                newmod = newmod.replace(/\s\s+/g," ");
        
                                mbuild = rex.stripScripts(mbuild);
                                mbuild = mbuild.replace(/<\/?[^>]+(>|$)/g," ").trim();
                                mbuild = mbuild.replace(/\s\s+/g," ");

                                function callScripts(element){ 
                                    setTimeout(() => { 
                                        if(scriptLen > 0) {
                                            for(let key of Object.keys(scriptwrap)){
                                                element.appendChild(scriptwrap[key]); 
                                            }
                                        }                                             
                                    },200)
                                }  

                                //sort out errors in content
                                let sortErrors = rex.sortErrors(newmod);  
            
                                mobi.pause = sortErrors.pause; 
                                let error   = sortErrors.error;
                                let stopped = !rex.addedScript(rawcontent);
                                
                                if(!mobi.pause) mobi.newcontent = newcontent;

                                if(!mobi.pause && stopped) {
                                    setTimeout(() => rex.mobi.reload() , 200);
                                }

                                if((mobi.newcontent !== content) && (!mobi.pause)) {
                 
                                    rex.clear(function(){
                                        if(mobi.show){
                                           rex.log(mobi.newcontent); 
                                        } else { 
                                            setTimeout(() => rex.mobi.reload() , 200); 
                                        }
                                    })

                                }
                                
                                mobi.reloadTime = mobi.interval / 10;
                                mobi.reloadTime = (mobi.reloadTime < 50)? 50 : mobi.reloadTime;

                                roll = (!(mobi.counter > mobi.reloadTime && mobi.pause !== true && !mobi.interlock));

                                if(roll){
                                    
                                    //this block code section is set as main default 
                                    let oldNotice = document.getElementById("::notice");

                                    if(mobi.pause === false){
                                                        
                                        if (oldNotice != null) oldNotice.remove();

                                        if (mobi.notice == 1) {
                                            
                                            if(offline){
                                                if(allowPop){

                                                    if(!['poll','seek'].includes(rex.mobi.controls)){
                                                        let notice = `${error} fixed <span class="bi-check-circle"></span>`;
                                                        rex.pop(rex.makeDiv(notice, 'spoova-notice-fix'));
                                                    }else{
                                                        let spControl = rex.box('::sp-control').get();
                                                        let spNotice = spControl.querySelector('[sp-notice]');

                                                        spNotice.setAttribute ('view', true);
                                                        
                                                        setTimeout(() => {
                                                            spNotice.removeAttribute('view');
                                                        }, 2000)
                                                    }
                                                }
                                                rex.clear(function(){
                                                    
                                                    base.cycle = 0;
                                                    rex.info('Live server (watch) >> resumed')

                                                })
                                            }
                                            
                                            setTimeout(() => {
                                                rex.clearDebugs();
                                                rex.clear().info('Live server (mode) >> online')
                                            }, 1500);

                                            errmess = 0;
                                            mobi.notice = 0;
                                            mobi.oldError = false;
                                        }

                                    } 

                                    // if no error is currently displayed
                                    else if(errmess < 1) {

                                        let emess = "", cmess;
                                        
                                        //remove any previous notice
                                        if (oldNotice != undefined) {
                                            if(mobi.oldError != mobi.newError){
                                                oldNotice.remove();
                                            }
                                        }

                                        if(mobi.notice == 0){
                                            errmess = 1;
                                            rex.clear(function(){
                                                rex.error("Live server (error) >> watch paused until resolved...");
                                            })
                                        }
            
                                        emess = mbuild;
                                        emess = emess.split(" ( ! )");
                                        if(emess.length > 1){
                                            cmess = emess[0]
                                            emess = emess[1];
                                        }else{
                                            emess = emess[0];
                                        }
            
                                        emess = emess.replace("\n"," <br> ");
                                            
                                        if(error === "warning" || error === "notice"){
                                            emess = emess.split(".php on line ");
                                            let newErrn = emess.length;
                                            if(newErrn > 0){
                                            emess = emess[0]+".php on line " + (emess[1] ? emess[1].trim().split(" ")[0] : "") ;
                                            }else{
                                            emess = emess[0];
                                            } 
                                        }

                                        emess = cmess || emess;
                                        emess = emess.replace("( ! ) ", "\n"); 

                                        //* split stack traces
                                        let callsplit = emess.split(" call stack # ");
                                        emess = callsplit[0].split("stack trace")[0];
                                        emess = emess.replace('.php:','.php on line')
                                        
                                        if((emess != mobi.newError) && (emess.trim() != "")){
                                            mobi.newError = emess;
                                            mobi.newTable = errorTable;
                                        }
                                        
                                        //* Handle new error
                                        if(mobi.newError){
                                            
                                            let error1 = error.charAt(0).toUpperCase() + error.slice(1);
                                            let error2 = error; let realError;
                                            let split1, split2;
                                            
                                            if(split1 = rex.splitError(mobi.newError, error1)){
                                                mobi.newError = error1 + split1.end;
                                            }else{
                                                if(split2 = rex.splitError(mobi.newError, error2)) {
                                                    mobi.newError = error2 + split2.end;
                                                }
                                            }

                                        }
                                        
                                        if(mobi.errlog != 1){ 
                                            //if no console error is previously displayed
                                            rex.clear(function(){
                                                rex.error(rex.unstack(mobi.newError));
                                            })
                                            mobi.errlog = 1;
                                        }

                                        if(mobi.oldError != mobi.newError){

                                            rex.timerBox(base).remove();

                                            if(offline){
                                                if(allowPop){
                                                    if(oldNotice) oldNotice.remove();
                                                    
                                                    rex.pop(rex.makeDiv(`${mobi.newTable || mobi.newError}`, 'spoova-notice'));

                                                    callScripts(document.body);                                         
                                                }

                                                rex.clear(function(){
                                                    rex.error("Live server (error) >> watch paused until resolved...");
                                                    rex.error(rex.unstack(mobi.newError));    
                                                })
                                            }
                                        }
                                    
                                        if((mobi.newError != mobi.oldError) &&  mobi.newError){
                                            mobi.oldError = mobi.newError;
                                        }
            
                                        mobi.notice = 1;

                                    }

                                }

                                setTimeout(() => mobi.loading = false);
                            }     
                            
                            //* Handle server error
                            else if(mobi.status.isServerError){
                                mobi.serverError = 1;
                                if(offline){
                                    if(allowPop){

                                        rex.pop(rex.makeDiv('...', 'res-notice'));

                                    }
                                    res.clear(function(){
                                        rex.error("Live server (error) >> unknown server request error");
                                    })
                                }
                            }  

                            if(rex.mobi.controls !== 'seek'){
                                // add a timer box
                                rex.timerBox(base).timed(20);
    
                                res.boot = function(start){
                                    if(!rex.mobi.terminated || start){
    
                                        rex.mobi.stopServer();
                                        rex.mobi.terminated = false;
    
                                        rex.mobi.startServer(() => {
                                            base.cycle++;
                                            rex.stream(base)
                                        }, 1000);                            
    
                                    }
                                }
                                res.boot();
                            }
                            
                            
                        }

                    });
                }
            }
            
        }

        
        xhttp(url, callback){

            let xhttp, mobi = this.mobi; 

            xhttp = new XMLHttpRequest();

            xhttp.onreadystatechange = function(){
                callback(this)
            }
            
            //send http request
            if(!mobi.loading){
                xhttp.open("GET", url, true);
                xhttp.send();
                mobi.loading = true;
            }
            

        }

        /**
         * strip off resource scripts
         */
        filterScript(body){
            let resUrl, assets = this.assets;
            if(assets.root){
                resUrl = assets.root+assets.base+assets.Livejs;
                body = body.replace('<script src="'+resUrl+'"></script>','');
                body = body.replace(/<script>res\.monitor\(["<',\w+:/]+\)<\/script>/, '');
            }
            return body;
        }

        /**
         * check resource scripts
         */
        addedScript(body){
            let resUrl, assets = this.assets; 
            if(assets.root){
                resUrl = assets.root+assets.base+assets.Livejs;
                return body.includes('<script src="'+resUrl+'"></script>');
            }
            return false;
        }


        sortErrors(content){
            let error = '', pause = false;
            let phperrors = this.defaults.phperrors;
            content = content.toLowerCase();
            for(let i = 0; i < phperrors.length; i++){
                let matcherr1 = content.match(phperrors[i]);
                let matcherr2 = content.match(".php"+""+" on line");
                let matcherr3 = content.match('trigger notice') && content.match('()');

                if(matcherr1 != null && ((matcherr2 != null) || matcherr3)){
                    //error most likely occurred prevent reload...
                    error = phperrors[i];
                    pause = true;
                    break;
                }
            }
            return {error:error, pause: pause};
        }

        splitError(text, divider){
            var splitted = text.split(divider);
            if(splitted.length > 1){
                var start = splitted.shift();
                var end = splitted.join(' ');
                return {start: start, end: end}
            }
            return false;
        }

        /**
         * Test monitor request
         * @param {*} test 
         * @returns 
         */
        status(request, content){

            let response = {};
            let state  = request.readyState;
            let status = request.status; 

            response.isReady       = (state === 4);
            response.isServerError = (state === 4 && (status >= 500 || status === 423));
            response.isFileError   = (state === 4 && status === 404);
            response.success       = (state === 4 && status === 200);

            if(content){
                if(
                    (content.includes('Parse Error') || content.includes('Parse error')) &&
                    content.includes('Stack Trace') && content.includes('syntax error, unexpected') 
                    && /unexpected [.]+ in [a-zA-Z0-9]+.php on line [0-9]+/.test('content')
                ){
                    response.isFileError = false;
                    response.isServerError = true;
                    response.serverPaused = true;
                }
            }
            
            return response;

        }

        /**
         * Remove stack traces from messages
         * @param {*} message 
         */
        unstack(message){
            return message.split("Stack Trace")[0]
        }

        clear(callback){
            if(this.mobi.offline && console) console.clear();
            if(typeof callback === 'function') callback();
            return this;
        }

        log(message){
            let response = this.messageController(message);
            if(response) console.log(response)            
            return this;
        }

        info(message){
            let response = this.messageController(message);
            if(response) console.info(response)            
            return this;
        }

        error(message){
            let response = this.messageController(message);
            if(response) console.error(response)            
            return this;
        }

        messageController(message){
            if(message && typeof message === 'string'){
                message = message.replaceAll('&lt;', "<").replaceAll('&gt;','>');
            }            
            
            if(this.mobi.offline && console) return message;

            return false;          
        }

        pop(message, isDraggable = false) {
            if(!message) return;
            document.body.appendChild(message);
            if(isDraggable){
                this.isDraggable(message);
            }
        }

        makeDiv(content, eclass){
            let html, div, message, fatal, warning, rex = this;

            html = document.body.innerHTML;
            div = document.createElement("div");
            div.id = "::notice";
            div.setAttribute('data-err','x-debug');
            div.setAttribute('class', (eclass || ''));

            message = new DOMParser().parseFromString(content, "text/html");
            message = message.querySelector(rex.resources('js').query)
            fatal = document.querySelector('[class="xdebug-error xe-fatal-error"]')
            warning = document.querySelector('[class="xdebug-error xe-warning"]')
            
            if (fatal) fatal.remove();
            if (warning) warning.remove();
                
            if(!rex.resources('css').exists){
                rex.resources('css').add();
            }

            if(message){
                // display message
                console.log(message);
                message = message.parentElement;
                message = message.innerHTML;
                if((html).indexOf(message) > -1) return;                
            }

            div.innerHTML = content || '';

            let errBox = div.querySelectorAll('div, table').length;

            if(errBox === 0){
                div.classList.add('lite');
            }else{
                div.classList.remove('lite');
            }
            
            if(rex.resources('css').exists){
                if(div.querySelector(rex.resources('css').query)){
                    div.querySelector(rex.resources('css').query).remove()
                }
            }
            
            if(rex.resources('js').exists){
                if(div.querySelector(rex.resources('js').query)){
                    div.querySelector(rex.resources('js').query).remove()
                }
            }
            
            return div;
        }

        clearDebugs(){

            let xDebugs  = this.resources('error-boxes').links          
            let xScripts = this.resources('js').links;
            let xLinks   = this.resources('css').links;
            
            for(const xDebug of xDebugs){
                xDebug.remove();
            }

            //remove script
            for(const xScript of xScripts){
                xScript.remove();
            }

            // remove ambiguous base css 
            let i = 0;
            for(const xLink of xLinks){
                i++;
                if(i == xLinks.length) break;
                if(this.resources('css').length > 1) xLink.remove();
            } 

        }

        cleanDebugs(){
            let iDebugs = this.resources('.custom-error-pane').links;
            for(const iDebug of iDebugs){
                iDebug.remove();
            }            
        }

        box(id, cacheName) {

            let div, uiBox, rex = this;

            return uiBox = {

                add: function(content) {
                    div = document.createElement('div');
                    div.id = id;
                    div.innerHTML = content || '';
                    document.body.appendChild(div);
                    return this;
                },

                get: function(){
                    div = document.getElementById(id);
                    return div;
                },

                addCss(style) {
                    div = document.getElementById(id);
                    rex.element(div).style(style)
                    // rex.addCss(div, style);
                    return this;
                },

                remove : function() {
                    div = document.getElementById(id);
                    if(div) div.remove();
                    return this;
                },

                isDraggable: function() {
                    rex.isDraggable(uiBox.get(), cacheName);
                    return this;
                },

                setAttributes: (attributes) => {
                    rex.element(uiBox.get()).setAttributes(attributes);
                    return this;
                }

            }

        }

        timerBox(base) {

            let rex =  this;

            let obj = {

                timed: (time = 20) => {
                    let maxCycle, timerCycle, timeLeft;
                    maxCycle = rex.defaults.runtime; // 30 minutes maximum
                    timerCycle = maxCycle - 20;
                    timeLeft   = maxCycle - base.cycle;
                    
                    if(base.cycle > timerCycle){
                        let resetBase = function(){
                             rex.timerBox(base).resume();
                             document.removeEventListener('mousemove', resetBase);
                        }
                        if(timeLeft < 1){

                            rex.timerBox().terminate(base);

                        }else{

                            document.addEventListener('mousemove', resetBase)
                            rex.timerBox().add(timeLeft);
                            //live server will resume when you move mouse on browser ...
                        }
                    }
                },

                add : (timeLeft) => {
                    rex.box('::sp-timer').remove().add(
                        `
                        <div class="sp-live-notice" rel="live-secs" style="position:fixed; padding:10px; font-size: 14px; z-index:1; right:0; top:0; background-color:#8a213a; color:white">
                            <div>Live server terminates in:</div>
                            <div>${timeLeft} seconds</div>
                        </div>
                        `
                    )
                    rex.clear().info(`Live server pausing in ${timeLeft} seconds.`);
                },

                resume: () => {
                    rex.box('::sp-timer').remove().add(
                        `
                        <div class="sp-live-notice" rel="live-resm" style="position:fixed; padding:10px; font-size: 14px; z-index:1; right:0; top:0; background-color:#2e8a21; color:white">
                            <div>Live server resumed</div>
                        </div>
                        `
                    );
                    
                    setTimeout(() => {
                        rex.box('::sp-timer').remove();
                    }, 1500)
                    
                    rex.clear().info('Live server (resumed)');

                    if(base) base.cycle = 0;

                },

                //silent removal
                remove(){
                    base.cycle = 0;
                    rex.box('::sp-timer').remove()
                },

                terminate: (base) => {

                    rex.box('::sp-timer').remove().add(
                        `
                        <div style="position:fixed; font-size: 14px; padding:10px; z-index:1; right:0; top:0; background-color:#8a213a; color:white">
                            <div>Live server terminated:</div>
                            <div>resumes on browser mouse activity</div>
                        </div>
                        `
                    )
                    rex.clear().info(`Live server (terminated) >> resumes on browser activity.`);
                    
                    rex.mobi.pauseActivity(true, function(){
                        let selector = document.querySelector('body');
                        var userActivity = function(){
                            base.cycle = 0;
                            rex.mobi.pauseActivity(false);
                            obj.resume();
                            selector.removeEventListener('mousemove', userActivity, false);
                        } 
                        selector.addEventListener('mousemove', userActivity, false);
                    });

                }

            }

            return obj;

        }

        addRemoteControl() {
            let liveRemote, liveControl, controls, remote, rex = this;
            let remoteColor, remoteBtn, remoteIcons = rex.mobi.remoteIcons;

            liveRemote = rex.box('::sp-control', 'spoovaLiveBtn');

            controls = rex.mobi.controls;

            let pauser, player, review, activeColor, inactiveColor;

            review = remoteIcons.review || 'bi-arrow-clockwise';
            pauser = remoteIcons.pauser || 'bi-pause-circle';
            player = remoteIcons.player || 'bi-play-circle';

            activeColor = '#197563';
            inactiveColor = 'red';
            
            let remotePositions = rex.remotePositions('spoovaLiveBtn', {
              top: remoteIcons.position.top, 
              right: remoteIcons.position.right, 
            })

            if(controls === 'seek') {
                remoteBtn = review; 
            }else{
                remoteBtn = pauser;
            }

            liveRemote.add(`
            
                <div sp-rel="sp-box">
                    <div sp-control>
                        <div style="user-select:none">Live</div>
                        <span live-control="control" class="${remoteBtn}"></span>
                    </div>
                    <div sp-notice>
                        <span style="padding:0 .2em">Fixed <span class="bi bi-check-circle"></span></span>
                    </div>
                </div>

            `).addCss({
              top: remotePositions.top,
              right: remotePositions.right
            }).isDraggable();
            
            remote = liveRemote.get();
            remote.setAttribute('spoova-role','live-control');  

            //pausing activity
            liveControl = remote.querySelector('[live-control]');
            liveControl.addEventListener('click', function(e){ 

                this.addEventListener('touchstart', function (e) {
                  e.stopPropagation(); // Prevent the touch event from propagating to the parent
                });
                if(liveControl.classList.contains(review)){
                    rex.defaults.remotePause = false;
                    rex.mobi.pauseActivity(false, function(){  
                        remote.style.backgroundColor = inactiveColor;
                    });
                    if(!rex.boot){
                        liveControl.classList.add('cycle')
                        setTimeout(() => {

                            liveControl.classList.remove('cycle')
                            remote.style.backgroundColor = activeColor;  

                        }, 200)
                    }
                } else {

                    if(liveControl.classList.contains(pauser)){
                        rex.defaults.remotePause = true;
                        rex.mobi.pauseActivity(true, function(){      
                            liveControl.classList.remove(pauser)
                            liveControl.classList.add(player)
                            remote.style.backgroundColor = 'red';                         
                        });
                    }else{
                        rex.defaults.remotePause = false;
                        rex.mobi.pauseActivity(false, function(){                               
                            liveControl.classList.remove(player)
                            liveControl.classList.add(pauser)
                            remote.style.backgroundColor = '#197563';
                        });
                        if(!rex.boot){
                            setTimeout(() => {
    
                                liveControl.classList.remove(pauser)
                                liveControl.classList.add(player)
                                remote.style.backgroundColor = 'red';  
    
                            }, 200)
                        }
                    }

                }

            })
        }

        element(selection){

            let rex = this;

            return {

                setAttributes : (object) => {
                    if(typeof selection !== 'object'){
                        rex.error('invalid object supplied for element');
                        return false;
                    }
                    if(typeof object !== 'object'){
                        rex.error('invalid object supplied for attributes');
                        return false;
                    }

                    for(let i in object){
                        selection.setAttribute(i, object[i]);
                    }
                },

                style(arg1) {
                    
                    let css; //css object container
                    
                    if((typeof arg1 === 'string')){
                        let cssObj  = arg1.split(";"); 
                        css = {};

                        cssObj.forEach(obj => {
                            prop = obj.split(":");
                            if (prop.length == 2){
                                css[prop[0].trim()] = prop[1].trim();            
                            }
                        })
                    } else if (typeof arg1 === 'object') {
                        css = arg1;
                    }
                    
                    if(css){
                        setTimeout(()=>{

                            if(typeof selection === 'string'){
                                selection = document.querySelector(selection);
                            }
                            
                            if(typeof selection === 'object'){
                                Object.assign(selection.style, css);
                            }            
                        })
                    }
                }

            }

        }

        resources(option) {

           let info = {}, rex = this;

           if(option === 'css') {

               let cssSelector = 'link[x-debug="res-css"]';

               info = {
                query: cssSelector,
                links: document.querySelectorAll(cssSelector),
                exists: document.querySelector(cssSelector),
                add: function() {
                    setTimeout(() => {
                        if(!info.exists) {
                            let debugCss = document.createElement('link');
        
                            let style = rex.element(debugCss).setAttributes({
                                rel:  'stylesheet',
                                type: 'text/css',
                                href: rex.assets.root+rex.assets.base+rex.assets.Livecss,
                                'x-debug': 'res-css'
                            });
        
                            document.getElementsByTagName("head")[0].appendChild(debugCss);
                        }
                    })
                }
               }
               info.length = info.links.length
               return info;
           }

           if(option === 'js') {

               let jsSelector = 'script[x-debug]';

               info = {
                query: jsSelector,
                links: document.querySelectorAll(jsSelector),
                exists: document.querySelector(jsSelector),
               }
                info.length = info.links.length

                return info;
           }

           if(option === 'error-boxes') {

               let errorSelector = '[data-err="x-debug"]';

               info = {
                query: errorSelector,
                links: document.querySelectorAll(errorSelector),
                exists: document.querySelector(errorSelector)
               }
               info.length = info.links.length
               return info;
           }

           if(option) {

               let selector = option;

               info = {
                query: selector,
                links: document.querySelectorAll(selector),
                exists: document.querySelector(selector)
               }
               info.length = info.links.length

           }

           return info;

        }

        /**
         * 
         * @param {object} uiBox 
         * @returns 
         */
        isDraggable(uiBox, cacheName) {
            
            if(typeof uiBox !== 'object') return false;
            if(!uiBox.tagName) return false;
            
            let rex = this;
            let remote = uiBox;
            let isDragging = false;
            let initialX, offsetX, offsetY;
            let maxX, maxY;

            let control = {
                start : (e) => {
                    isDragging = true;  
                    let target = e.target;
                    if (target.getAttribute('live-control')) {
                        return false;
                    }
                    e.preventDefault()
                    
                    let touch;

                    if(e.touches){
                        touch = e.touches[0] || e.changedTouches[0];
                    } else {
                        touch = e;
                    }

                    let computes = window.getComputedStyle(remote)

                    initialX = touch.clientX - parseFloat(remote.style.right || computes.getPropertyValue('right') || 0);

                    //set initial offset x in percentage
                    offsetX = (window.innerWidth - touch.clientX) / window.innerWidth * 100;
                    
                    //set initial offset y in pixels
                    offsetY = touch.clientY - remote.getBoundingClientRect().top;
                    document.body.style.userSelect = 'none';
                    document.body.classList.add('no-select');
                    remote.style.cursor = 'grabbing';
                },

                move: (e) => {
                    if(!isDragging) return;

                    let touch;
                    
                    if(e.touches){
                        touch = e.touches[0] || e.changedTouches[0];
                    } else {
                        touch = e;
                    }

                    const x = ((window.innerWidth - touch.clientX) / window.innerWidth * 100); // percentage
                    const y = touch.clientY - offsetY; // pixels

                    maxX = 100 - remote.clientWidth / window.innerWidth * 100;
                    maxY = window.innerHeight - remote.clientHeight;

                    //limit box position    
                    const constrainedX = Math.min(Math.max(x, 0), maxX)
                    const constrainedY = Math.min(Math.max(y, 0), maxY)
                    
                    remote.style.right = constrainedX + '%'
                    remote.style.top  = constrainedY + 'px'
                    if(cacheName) {
                      
                      rex.remotePositions(cacheName, {
                        top: remote.style.top, 
                        right: remote.style.right, 
                      }, true)
                    } 
                },

                stop: (e) => {
                    isDragging = false;
                    remote.style.cursor = 'pointer';
                    document.body.style.userSelect = 'auto';
                    document.body.classList.remove('no-select');
                }
            }

            
            remote.addEventListener('mousedown', control.start)
            remote.addEventListener('touchstart', control.start, {passive:false})
            
            document.addEventListener('mousemove', control.move)
            document.addEventListener('touchmove', control.move)
            
            document.addEventListener('mouseup', control.stop)
            document.addEventListener('touchend', control.stop)

            // //keep in screen range
            window.addEventListener('resize', (e) => {

                //calculate the maximum allowable position to keep the box within screen
                const maxX = 100 - remote.clientWidth / window.innerWidth * 100
                const maxY = window.innerHeight - remote.clientHeight

                //limit box position
                const currentX = parseFloat(remote.style.left)
                const currentY = parseFloat(remote.style.top)

                if(currentX > maxX){
                    remote.style.right = maxX + '%'
                }

                if(currentY > maxY){
                    remote.style.top = maxY + 'px'
                }
                
                if(cacheName) {
                  rex.remotePositions(cacheName, {
                    top: remote.style.top, 
                    right: remote.style.right, 
                  }, true)
                } 
            })

            remote.addEventListener('mouseup', () => {
                isDragging = false;
                remote.style.cursor = 'pointer';
            })
            return this;
        }
        
        /**
         * Test a json string
         */
        jsonval(string) {

            let is_json = true, object = {};

            try {
               object = JSON.parse(string);
            } catch (err) {
                is_json = false;
                object = {
                    mode: string
                }
            }

            return {
                isJSON : is_json,
                object : object
            }

        }
        
        remotePositions(key, posit = {}, update = false) {
          let settings, cache, positions;
          
          //posit = this.jsonval(posit).object; //root
          if(update || (!sessionStorage.getItem(key))) {
            positions = JSON.stringify(posit);
            sessionStorage.setItem(key, positions);
          }
          
          cache = sessionStorage.getItem(key);
          cache = this.jsonval(cache).object;
          return cache;
        }

    }

    var res = new Res;

}