/* 
This class was created to support dynamic php and php content control. 
It is strongly advised that this class should only be used in development mode. 
PHP has different ways of displaying errors, this means that error debugger may not work successfully on all php server applications. 
There will not be any critical changes to the code structure, so developers may use in on live apps. Again, it is strongly advise to avoid this. 
*/

if(typeof Res == 'undefined'){

    class Res {

        constructor(url, responseField, settings = {}){

            //default variables anchor
            let defaults = {}, loc, uri, xdefualts;

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
            uri = this.getLocation(loc); 
           
            //set url address
            defaults.currentLoc = uri.loc;
            defaults.currentUri = uri.base;
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
                res.defaults.setinterval = function setinterval(func, time){
                    data[id] = {
                        nativeID: setInterval(func, time),
                        func: func,
                        time: time
                    } 
                    return id++;
                }

                res.defaults.clearinterval = function clearinterval(func, time){
                    if(data[id]) {
                        clearInterval(data[id].nativeID);
                        delete data[id];
                    }
                    res.defaults.terminated  = true;
                    return id++;
                }  
                
                document.addEventListener('visibilitychange', function(){
                    if(document.visibilityState == 'visible'){
                        for(var id in data)
                            data[id].nativeID = setInterval(data[id].func, data[id].time);
                    } else {
                        for(var id in data) clearInterval(data[id].nativeID);
                    }
                })

            }

            this.defaults.controller(this);

            //controller assets
            this.defaults.assets = {
                'root': './',
                'base': 'res/main/',
                'css' : 'css/base.css',
                'js'  : 'js/debug.js'
            }

        }

        /**
         * 
         * Reformat the supplied url / location
         */
        getLocation(loc){
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
            //if no address is found use ~index~ (note:use current page(not index) as address) or current address
            //uri.addr = (loc.trim() == '') ? "index" : this.urlenv(location);
            uri.addr = (loc.trim() == '') ? urx : this.urlenv(location);

            return uri;
        }

        /**
         * Update an old data with a new date
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
            this.defaults.appUrl = url;

            //set/initialize current environment
            this.defaults.isOnline  = isOnline;
            this.defaults.isOffline = !isOnline;            

            //store current environment
            this.defaults.environment = isOnline? 'online' : 'offline';

            //re-initialize environment debugging
            this.defaults.Online  = 'uiconsole'; // [uiconsole|pop|console|off]
            this.defaults.Offline = 'uiconsole'; // [uiconsole|pop|console|off]
            this.defaults.ops     = settings;

            if(settings == "::console" || settings == "<<console"){
                this.defaults.show = true;
                return this.defaults;
            }

            if(settings == 'online') {
                //enable all environments debugging
                return this.defaults
            } 

            if(settings == '::lock' || settings == '<<lock') {
                //enable all environments debugging
                return this.defaults;
            }  

            if(settings == '::watch' || settings == '<<watch') {
                //enable all environments debugging
                return this.defaults;
            }  
            

            if(settings == 'offline') {
                //allow only offline environment debugging
                this.defaults.Online  = false;
                return this.defaults;
            } 

            if(settings == 'on:offline') {
                //allow only offline environment debugging
                this.defaults.Online  = false;

                //fake environment as if currently online
                this.defaults.enviromodal = 'online';
                return this.defaults;
            }  
            
            if(typeof settings == 'integer') {
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
        monitor(settings = {}, appUrl){

            settings = this.monitorInit(settings, appUrl);

            //monitor's internal variables
            let mobi = settings, rex, url, view, params, initContent;

            //initialize few internal variables
            mobi.errlog = 0; mobi.notice = 0; mobi.counter = 0;
            mobi.oldError = ''; mobi.newError = ''; mobi.newTable = '';
            mobi.loading  = false; mobi.pause = false; rex = this;
            mobi.status = {}, mobi.serverError = 0; mobi.propeller = 0;

            setTimeout( () => {
                
                url = this.defaults.currentUrl;
                view = (settings.currentLoc == '')? ':' : `>> ${settings.currentUrl} `;
                params = this.defaults.params = window.location.search;
                
                //set the watch word
                mobi.watchword = `watching ${view} `;

                //store mobi data
                rex.mobi = mobi;

                //initialize first request (get the baseContent)
                fetch(url + params).then(response => response.text()).then(data => {initContent = this.filterScript(data) });

                // initialize live request
                rex.live = mobi.setinterval( () => {
                    let divide = mobi.interval / 1000;
                    if(mobi.propeller == divide){
                        this.runner(initContent) 
                        mobi.propeller = 1;
                    }else{
                        mobi.propeller++;
                    }
                }, mobi.interval);

               

            });



        }

        /**
         * Run live request
         * @param {*} content base content
         * @param {*} mobi dynamic object
         */
        runner(content) {
            if(res.defaults.terminated) return;
            //core variables
            let defaults, mobi, debug, rex = this, offline;

            //declare debug variables
            let allowPop = false, allowConsole = false;
            
            //set configuration objects
            defaults = this.defaults;
            mobi     = this.mobi;

            mobi.counter++;
            
            //get debug type
            offline = (mobi.enviromodal == "offline");
            debug = offline ? mobi.Offline : mobi.Online;

            //set debug variables
            allowPop = (debug == 'uiconsole' || debug == 'pop');
            allowConsole = (debug == 'uiconsole' || debug == 'console');
            
            //reformat console logger
            if(!console) allowConsole = false;

            /* initialize content monitoring */
            if(content != undefined) {

                //display a starting message
                if(mobi.counter == 1 && content != undefined){
                    //rex.console(mobi.watchword);
                    //delete mobi.watchword;
                    rex.cleanDebugs();
                }

                //create default variables
                let xhttp, url, params, status, rawcontent, newcontent;
                
                url = defaults.currentUrl,
                params = window.location.search;

                //Handle missing file (terminate request)
                if(mobi.once){ 
                    // Handle missing file
                    if(mobi.status.isFileError){
                        rex.console('missing file ... live server terminated');
                        mobi.clearinterval(rex.live);
                        return ;
                    }                    
                }

                //if(mobi.loading) rex.console('loading ...');

                //send unamibiguous request
                if(!mobi.loading){
                    
                    //create http request
                    xhttp = new XMLHttpRequest();
                    xhttp.onreadystatechange = function(){
                        
                        status = rex.status(this);
                        
                        mobi.once = true;

                        if(status.isReady){
                            
                            rawcontent = this.responseText;
                            newcontent = rex.filterScript(this.responseText);
                            status = rex.status(this, newcontent);
                            mobi.status = status;
                            mobi.newcontent = newcontent;
                        
                            //* Handle server error (500)
                            if(status.isServerError){
                                rex.console(mobi.watchword, offline);

                                if(allowPop && mobi.serverError == 0) {

                                    let widget = `
                                        <div class="widget spoova-e-widget box relative px-100">
                                            <div class="relative box rad-r" style="z-index:1000">
                                                <div class="roller-circle absolute box rad-r grid-center" style="z-index:11">
                                                    <div class="roller rad-r ov-d4 absolute ico-spin"></div>
                                                    <div class="roller-text rad-r absolute flow-hide ov-l1 c-grey anc-btn-link">
                                                        <div class="box px-full grid-center font-em-d6">
                                                            &#9888
                                                        </div>    
                                                    </div>        
                                                </div>            
                                            </div>
                                        </div>
                                    `;
                                    let notice = `
                                        <span style="margin-right: .25em;">&#9432</span> 
                                        <span style="width:100%"> notice : please fix your code or server</span>`;
                                    let cssText = rex.cssTexts('server');
                                    //Note: replace notice with detected parse errors if any is found & watch for ...
                                    //... parse error updates too.
                                    rex.pop(rex.makeDiv(widget, cssText, 'spoova-notice-err e-widget'));
                                }
                                if(mobi.serverError == 0){
                                    if(console) console.clear();
                                    rex.console('server error : please fix your code or server', offline);
                                }else{
                                    rex.console(mobi.watchword, offline, 'clear');
                                }
                                mobi.serverError = 1; mobi.loading = false; //interval mode
                                mobi.interval = 3000;

                                /* Handling Server Error's Parse Errors  (Window Rex files - eval functions)
                                Note: when server error occurs, this may occur in windows file or template engines
                                To fix parse errors within server error, parse errors should be detected from content received
                                from requests and handled within it (i.e within this code block). Handling this in success will 
                                cause an unwanted error. 
                                */
                            }

                            //* Handle successful requests (200)
                            else if(status.success){

                                // Handle server error
                                //detect a previous server error & nullify it
                                if(mobi.serverError){ 
                                    if(allowConsole) {
                                        rex.console(mobi.watchword, offline, 'clear');
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

                                if(!mobi.pause && stopped) 
                                    {
                                        setTimeout(() => rex.mobi.reload() , 200);}

                                if((mobi.newcontent !== content) && (!mobi.pause)) {
                                    console.clear(); 
                                    
                                    if(mobi.show){
                                       rex.console(mobi.newcontent); 
                                    } else { 
                                        setTimeout(() => rex.mobi.reload() , 200); 
                                    }
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
                                                    let cssText = rex.cssTexts('error');
                                                    let notice = `${error} <span class="fb-6"><span class="bi-file-code"></span> ${(mobi.currentUrl)}</span> <br> fixed <span class="bi-check-circle"></span>`;
                                                    rex.pop(rex.makeDiv(notice, cssText, 'spoova-notice-fix'));
                                                }
                                                rex.console('>> fixed', offline, 'clear')
                                            }

                                            setTimeout(() => {
                                                rex.clearDebugs();
                                                rex.console(mobi.watchword, offline)
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
                                            rex.console(error + " >> watch paused until resolved...", offline, 'clear');
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
                                        
                                        if(mobi.errlog != 1){ //if no console error is previously displayed
                                            rex.console(rex.unstack(mobi.newError), offline, 'clear');
                                            mobi.errlog = 1;
                                        }

                                        if(mobi.oldError != mobi.newError){
                                            if(offline){
                                                if(allowPop){
                                                    if(oldNotice) oldNotice.remove();
                                                    
                                                    let cssText = rex.cssTexts('notice');
                                                    
                                                    rex.pop(rex.makeDiv(`${mobi.newTable || mobi.newError}`, cssText, 'spoova-notice'));

                                                    callScripts(document.body);                                         
                                                }
                                                
                                                rex.console(error + " >> watch paused until resolved...", offline, 'clear');
                                                rex.console(rex.unstack(mobi.newError), offline);    
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

                                        let cssText = "position:fixed; top:.25em; right:.25em; display:inline-block; border:solid 2px; color:red; background:white; z-index:100000; padding: .25em; border-radius:.25em; font-size: .95em";
                                        rex.pop(rex.makeDiv('...', cssText, 'res-notice'));

                                    }
                                    rex.console("server error: unknown request error occured, please check your server.", offline);
                                }
                            }

                        }



                    }
                    


                    //send http request
                    if(!mobi.loading){
                        xhttp.open("GET", url + params, true);
                        xhttp.send();
                    }
                    
                    //flag request status
                    mobi.loading = true; 
                }

            }
        }

        /**
         * strip off resource scripts
         */
        filterScript(body){
            let appUrl, resUrl;
            if(appUrl = this.defaults.appUrl){
                resUrl = appUrl+'res/res.js';
                body = body.replace('<script src="'+resUrl+'"></script>','');
                body = body.replace(/<script>res\.monitor\(["<',\w+:/]+\)<\/script>/, '');
            }
            return body;
        }

        /**
         * check resource scripts
         */
        addedScript(body){
            let appUrl, resUrl;
            if(appUrl = this.defaults.appUrl){
                resUrl = appUrl+'res/res.js';
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
            response.isServerError = (state === 4 && status >= 500);
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

        console(message, offline = true, clear = false){
            if(message && typeof message === 'string'){
                message = message.replaceAll('&lt;', "<").replaceAll('&gt;','>');
            }
            if(offline && console) {
                if(clear === 'clear') console.clear();
                console.log(message);
            }
        }

        pop(message) {
            if(!message) return;
            document.body.appendChild(message);
        }

        makeDiv(content, cssText, eclass){
            let html, div, message;

            html = document.body.innerHTML;
            div = document.createElement("div");
            div.id = "::notice";
            div.setAttribute('data-err','x-debug');
            div.setAttribute('class', (eclass || ''));

            message = new DOMParser().parseFromString(content, "text/html");
            message = message.querySelector('script[x-debug]')
            if(message){
                console.log(message);
                message = message.parentElement;
                message = message.innerHTML;
                //if(html.indexOf(content)) div.setAttribute('data-resview','none');
                if((html).indexOf(message) > -1) return;                
            }

            // div.cssText = cssText;
            div.innerHTML = content || '';
            //console.log('...', content, '\n<<...>>\n', html);
            
            return div;
        }

        clearDebugs(){

            let xDebugs = document.querySelectorAll('[data-err="x-debug"]')          
            let xScripts = document.querySelectorAll('script[x-debug]');
            let xLinks   = document.querySelectorAll('link[x-debug="res-css"]');
            
            for(const xDebug of xDebugs){
                xDebug.remove();
            }

            //remove script
            for(const xScript of xScripts){
                xScript.remove();
            }

            // remove base css 
            console.log(xLinks.length);
            let i = 0;
            for(const xLink of xLinks){
                i++;
                if(i == xLinks.length) break;
                if(document.querySelectorAll('link[x-debug="res-css"]').length > 1) xLink.remove();
            } 

        }

        cleanDebugs(){
            let iDebugs = document.querySelectorAll('.custom-error-pane');
            for(const iDebug of iDebugs){
                iDebug.remove();
            }            
        }


        cssTexts(name = ''){

            let baseCss = `
                position: fixed;                 
                top: 0.25em; 
                right: 0.25em; 
                font-size: 1.1em;
                font-family: calibri;
                z-index: 100000;
                padding: 0.5em; 
                box-shadow: rgb(223, 223, 223) 0px 0px 1px 1px;
                color: #aa0c5e;  
                display: inline-flex;
                border-radius: 0.25em;
                border: 4px solid rgb(255, 255, 255);
            `;
            
            let serverCss = baseCss;

            let errorCss = `
                ${baseCss}
                color: rgb(71, 196, 90);
                background: rgb(255, 255, 255) none repeat scroll 0% 0%; 
                min-width: 10em;`;

            let noticeCss = `
                ${baseCss}
                max-height: 95vh; overflow: hidden hidden; `;

            if(name == 'server') return serverCss;
            if(name == 'error') return errorCss;
            if(name == 'notice') return noticeCss;
        }

        

    }

    var res = new Res;

}