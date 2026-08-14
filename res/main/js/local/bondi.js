class Bond {

    constructor() {
        
        this.url = window.location.href;
        this.events = ['click','load','keydown','hover'];
        this.scriptsAnchor = []; 
        this.sequentials = {}; 
        this.defaults = {};
        this.iroot = '';
        this.defaults.bind = {

            onloaded: function(){}, 
            onevoked: function(){},
            onupdate: function(){},
            onended: function(){},
            onfailed: function(){},
            onsuccess: function(){},

        }
    }

    request() {

        let $this = this;

        window.addEventListener('load', function(){
            
            let body = document.querySelector('body');

            //component initialized
            $this.call('onload', body);

            //select all root elements ... 
            let bond_roots = document.querySelectorAll('['+CSS.escape('bond:root')+']');

            bond_roots.forEach((root) => { 
                $this.bind(root);
            })
        })

    }

    /**
     * Resolve each root element
     */
    bind(root) {
        let $this, bondEvents, rootIndex, bondForms, avertedForms, avertedFormBtn;

        $this = this;
        bondEvents = root.querySelectorAll('['+CSS.escape('bond:event')+']');

        bondForms = root.querySelectorAll('form');      
        avertedForms = root.querySelectorAll('form['+CSS.escape('bond:action')+'="avert"]');      
        
        rootIndex = root.getAttribute('bond:root');

        //prevent activity function
        function preventDefaultAction(buttons){
            buttons.forEach(button => {
                button.addEventListener('click', function(e){
                    e.preventDefault();
                })
            })
        }        
        //averted forms button prevention
        avertedForms.forEach(avertedForm => {

            let buttons = $this.getBtns(avertedForm);

            preventDefaultAction(buttons);

        });

        //process bond events that are within bond root
        bondEvents.forEach((item, itemIndex) => {
            //attribute nodes
            let config = {}, bit; 
            
            config.event = item.getAttribute('bond:event');        
            config.bond  = item.getAttribute('bind');
            config.id    = item.getAttribute('id');
            config.bondTrigger = item.getAttribute('trigger');
            //config.url   = item.getAttribute('rex-url');
            config.url   = $this.url;
            bit = item.getAttribute('bit');
            if(bit){
                bit = $this.bitVal(bit);
                config.timed = bit.name;
                config.time  = bit.time;
            }
            config.bondAction = item.getAttribute(':action') 
            config.itemIndex = itemIndex;
            //root element object node
            config.rootElement = root;
            //root element bond-root id
            config.rootIndex  = root.getAttribute('bond:root');
            $this.resolveEvent(item, config);
        }) 


    }

    call(func, arg) {

        if(typeof this.defaults.bind[func] === 'function'){
            this.defaults.bind[func](arg);
        }

    }

    bitVal(val){
        let match = val.toString().match(/^([a-zA-Z]+)-(stop|\d+)$/);
        if(match){
            return {
                name: match[1],
                time: parseInt(match[2]),
            }
        }
        return {
            name: null,
            time: parseInt(val)
        }
    }

    ajax(item, config, iterated){
        
        if(item.getAttribute('bond-status')){
            if(item.getAttribute('bond-status') !== 'closed') return;
        }

        let $this = this;
        let defaults, root, rootIndex, bond, bondAction, bondTrigger, 
            method, url, data, map, formInputs, formData;

        defaults = {};        
        formData = {};
        bond = config.bond;
        url  = config.url;
        root = config.root;
        rootIndex = config.rootIndex;
        bondAction = config.bondAction;
        bondTrigger = config.bondTrigger;

        // alert(rootIndex)

        item.setAttribute('bond-status', 'live');

        //initialize object container for root element
        formData[rootIndex] = {};
        
        //select all root element input fields
        formInputs = $this.getInputs(config.rootElement);

        formInputs.forEach((formInput, inputIndex) =>{
            formData[rootIndex][inputIndex] = {
                name: formInput.getAttribute('name'),
                value: formInput.value,
            }
        });

        defaults.mode  = 'bond';
        defaults.state = 'live';
        defaults.event = 'click';
        defaults.bond = url;
        defaults.call = bond;


        //element initialized
        $this.call('evoked', item);  
        let rootElement = `bond:root`;

        method = 'post';
        data = {};

        //add all attributes defined to map
        map = {...defaults, ...data}
        const xhr = new XMLHttpRequest();
        xhr.open(method, url);

        this.setHeaders(xhr, {
            'X-Requested-With': 'xmlHttpRequest',
            'Content-Type': 'application/x-www-form-urlencoded'
        })

        //initialize forwarded parameters holder
        const params = new URLSearchParams();

        //append all required (map) keys to parameters holder
        for (const [key, value] of Object.entries(map)) {
            params.append(key, value);
        }

        //updating ... 

        function callScripts(scripts, scriptwrap) {
            let scriptLen = scripts.length;
            setTimeout(() => {
                if (scriptLen > 0) {
                    for (let key of Object.keys(scriptwrap)) {
                        const scriptEl = scriptwrap[key];
                        if (scriptEl.src) {
                            let clone = document.createElement('script');
                            clone.src = scriptEl.src;
                            document.head.appendChild(clone);
                        } else {
                            item.appendChild(scriptEl);
                        }
                    }
                }
            }, 200);
        }         

        let cookie, eparams;
        cookie = document.cookie;  

        cookie = cookie.match(new RegExp('(^| )bondJS=([^;]+)'));
        
        if(cookie === null) cookie = [];

        cookie = cookie[2] ?? '';
        let obj = {};
        obj.argument = cookie;

        //append other parameters to 
        params.append('data', JSON.stringify(formData[rootIndex]));
        params.append('action', JSON.stringify(bondAction));
        params.append('CSRF_TOKEN', config.post['CSRF_TOKEN']);
        if(config.post) params.append('postdata', JSON.stringify(config.post));

        xhr.onload = function () {

            if (xhr.readyState === 4 && xhr.status === 200) {

                let text, newbody;

                text =  xhr.responseText;
                let itemSelector = '['+CSS.escape('bond:root')+`="${rootIndex}"`+']';
                
                newbody = document.createElement('div');
                newbody.innerHTML = text;
                $this.scriptsAnchor = []; // reset scripts container
                
                let target = newbody.querySelector(itemSelector);

                //@note: remove bond-status attribute to match document content will response text.
                let contentField = document.querySelector(itemSelector);
                contentField.querySelectorAll('[bond-status]').forEach(live => {
                    live.removeAttribute('bond-status');
                })
                let oldHTML = contentField.innerHTML;
                if(target) {

                    if($this.iroot === false){
                        console.clear()
                        console.info('root element added!');
                    }

                    $this.iroot = true;

                    let targetHtml =  $this.stripScripts(target.innerHTML)//; strip and save scripts
                    
                    let scripts = $this.scriptsAnchor; // get saved scripts
                    scripts.forEach(script => {
                        console.log(scripts.length);
                    })
                    let scriptwrap = {};
    
                    if(scripts.length > 0){
        
                        scripts.forEach((func, index) => {
                            let newscript = document.createElement('script');
                            if(func['script'] != undefined){
                                let scriptText = document.createTextNode(func['script']);
                                newscript.appendChild(scriptText)
                                delete func['script'];
                            }
    
                            if(typeof func === 'object'){
                                for(let funckey of Object.keys(func)){
                                    newscript.setAttribute(funckey, func[funckey]); 
                                } 
                            }
    
                            scriptwrap[index] = newscript;
                        })
                
                    }
                    if(targetHtml !== oldHTML){ 
                        contentField.innerHTML = targetHtml;
                        item.setAttribute('bond-status', 'closed');
                        callScripts(scripts, scriptwrap);
                        //prevent recursive request for load events
                        // if(iterated !== false) 
                        $this.bind(contentField, config.rootIndex);
                        if(bondTrigger) window[bondTrigger](contentField)
                    }else{
                        callScripts(scripts, scriptwrap);
                        if(bondTrigger) window[bondTrigger](false)
                    }

                } else {

                    if($this.iroot !== false){
                        $this.iroot = false;
                        console.error('root element removed!')
                    }

                }

            }
        };

        xhr.send(params);

    }

    setHeaders(xhr, headers) {
        for(const [key, value] of Object.entries(headers)) {
            xhr.setRequestHeader(key, value)
        }
    }

    stripScripts(s) {

        let div = document.createElement("div");
        div.innerHTML = s;

        let scripts = div.getElementsByTagName("script");
        let i = scripts.length;
        while (i--) {
           this.saveScripts(scripts, i);
           scripts[i].parentNode.removeChild(scripts[i]);
        }
        this.scriptsAnchor.reverse();
        return div.innerHTML;
    }

    saveScripts(scripts, i){

        let nodes = {};
        for (var att, j = 0, atts = scripts[i].attributes, n = atts.length; j < n; j++){
            att = atts[j];
            nodes[att.nodeName] = att.nodeValue;
        }                                    
                                    
        if(scripts[i].text != ''){
            nodes['script'] = scripts[i].text;
        }
        this.scriptsAnchor.push(nodes);

    }

    /**
     * Resolve each event element within a bond root
     * @param {object} item 
     * @param {object} config 
     */
    resolveEvent(item, config){

        let $this = this, bit;
        let resolve = function(data) {
            config.post = data || false;

            bit = $this.bitVal(item.getAttribute('bit') || '');

            if(config.timed || (bit.name === 'stop')) {
                
                let interval, loop;
                interval = new Interval;

                if(bit.name !== 'stop'){
                    loop = interval.start(() => {
                        $this.ajax(item, config)
                        loop.recall();
                    }, config.time)
                }
                
                if(bit.name){
                    let beats = $this.sequentials[bit.name]; 
                    if(beats === undefined){
                        beats = [];
                    }else{
                        for (let i = beats.length - 1; i >= 0; i--){
                            beats[i].stop();
                            beats.splice(i, 1);
                        }
                    }
                    if(loop !== undefined){
                        beats.push(loop);
                        $this.sequentials[bit.name] = beats;
                    }
                }
            } else {
                if(item.getAttribute('bond-status') !== 'live'){
                    $this.ajax(item, config, false);                    
                }
            }
        }

        if(config.event === 'load'){
            resolve(); 
        }else{
            
            item.addEventListener(config.event, (e) => {

                let action, inputs, escape, FormObject = false;

                action = config.bondAction;

                escape = ['halt', 'reset', 'push'];

                if(escape.includes(action)){ 
                    e.preventDefault();

                    if((action === 'reset') || (action === 'push')){

                        inputs = item.closest('form').querySelectorAll('input:not([type="button"]):not([type="submit"]):not([type="reset"]):not([type="image"]), textarea, select');

                        if(action === 'push'){

                            FormObject = {};

                            inputs.forEach(input => {
                                if(input.name) {
                                    FormObject[input.name] = input.value; 
                                }
                            })

                            inputs.forEach(input => {
    
                                let type = input.getAttribute('type') || '';
    
                              if(type.toLowerCase() !== 'hidden') input.value = '';
    
                            })                        
                        } else {
                            
                            inputs.forEach(input => {
    
                                let type = input.getAttribute('type') || '';
    
                                if(type.toLowerCase() !== 'hidden') input.value = '';
    
                            })                        
                        }

                    }
                }

                if(action !== 'reset') resolve(FormObject);
                
            });                    
        }

    }

    isBtn(item) {

       return (
        (item.tagName === 'button') || (item.tagName === 'input' && (item.getAttribute('type') === 'button'))
        );

    }

    getBtns(item) {
       return item.querySelectorAll('input[type="button"], input[type="submit"], button');
    }

    getInputs(item) {
        return item.querySelectorAll('input:not([type="submit"]):not([type="button"]):not([type="image"]), select, textarea');
    }
    
}
let bond;
bond = new Bond();
bond.request(); 