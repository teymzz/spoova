class Bond {

    constructor() {
        
        this.url = window.location.href;
        this.events = ['click','load','keydown','hover'];
        this.scriptsAnchor = []; 
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

        window.onload = function() {
            
            let body = document.querySelector('body');

            //component initialized
            $this.call('onload', body);

            //select all root elements ... 
            let bond_roots = document.querySelectorAll('[bond-root]');

            bond_roots.forEach((root) => { 

                $this.bind(root);
                
            })

        }

    }

    bind(root) {

        let $this, bondEvents, rootIndex, bondForms, avertedForms, avertedFormBtn;

        $this = this;
        bondEvents = root.querySelectorAll('[bond-event]');

        bondForms = root.querySelectorAll('form');      
        avertedForms = root.querySelectorAll('form[bond-action="avert"]');      
        
        rootIndex = root.getAttribute('bond-root');

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

        bondEvents.forEach((item, itemIndex) => {

            //attribute nodes
            let config = {};

            config.event = item.getAttribute('bond-event');        
            config.bond  = item.getAttribute('bind');
            config.id    = item.getAttribute('id');
            //config.url   = item.getAttribute('rex-url');
            config.url   = $this.url;
            config.timed = item.getAttribute('bit');
            config.time  = parseInt(config.timed);
            config.bondAction = item.getAttribute('bond-action')
            config.itemIndex = itemIndex;

            //root element object node
            config.rootElement = root;
            //root element bond-root id
            config.rootIndex  = root.getAttribute('bond-root');

            $this.resolveEvent(item, config);

        }) 


    }

    call(func, arg) {

        if(typeof this.defaults.bind[func] === 'function'){
            this.defaults.bind.func(arg);
        }

    }

    ajax(item, config){

        if(item.getAttribute('bond-status')){
            if(item.getAttribute('bond-status') !== 'closed') return;
        }

        let $this = this;
        let defaults, root, rootIndex, bond, bondAction, 
            method, url, data, map, formInputs, formData;

        defaults = {};        
        formData = {};
        bond = config.bond;
        //id   = config.id;
        url  = config.url;
        root = config.root;
        rootIndex = config.rootIndex;
        bondAction = config.bondAction;

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
        let rootElement = `[bond-root="${rootIndex}"]`;

        method = 'post';
        data = {};
        map = {...defaults, ...data}

        const xhr = new XMLHttpRequest();
        xhr.open(method, url);

        this.setHeaders(xhr, {
            'X-Requested-With': 'xmlHttpRequest',
            'Content-Type': 'application/x-www-form-urlencoded'
        })

        const params = new URLSearchParams();

        for (const [key, value] of Object.entries(map)) {
            params.append(key, value);
        }

        console.log(params);

        //updating ... 

        function callScripts(scripts, scriptwrap){ 
            let scriptLen = scripts.length
            setTimeout(() => { 
                if(scriptLen > 0) {
                    for(let key of Object.keys(scriptwrap)){
                        item.appendChild(scriptwrap[key]); 
                    }
                }                                             
            },200)
        }  

        let cookie, eparams;
        cookie = document.cookie;  

        cookie = cookie.match(new RegExp('(^| )bondJS=([^;]+)'));
        
        if(cookie === null) cookie = [];

        cookie = cookie[2] ?? '';
        let obj = {};
        obj.argument = cookie;

        params.append('data', JSON.stringify(formData[rootIndex]));
        params.append('action', JSON.stringify(bondAction));
        params.append('CSRF_TOKEN', config.post['CSRF_TOKEN']);

        if(config.post) params.append('postdata', JSON.stringify(config.post));

        xhr.onload = function () {

            if (xhr.readyState === 4 && xhr.status === 200) {

                let text, newbody;

                text =  xhr.responseText;

                console.log(text)
    
                newbody = document.createElement('div');
                newbody.innerHTML = text;
                $this.scriptsAnchor = [];

                let target = newbody.querySelector(rootElement);
                let contentField = document.querySelector(rootElement);
                let oldHTML = contentField.innerHTML;

                if(target) {

                    if($this.iroot === false){
                        console.clear()
                        console.info('root element added!');
                    }

                    $this.iroot = true;

                    let targetHtml =  $this.stripScripts(target.innerHTML)//; target.innerHTML
    
                    let scripts = $this.scriptsAnchor;
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

                    if(targetHtml != oldHTML){
                        contentField.innerHTML = targetHtml;
                    }

                    item.setAttribute('bond-status', 'closed');
                    callScripts(scripts, scriptwrap);
                    
                    $this.bind(contentField, config.rootIndex);

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

    resolveEvent(item, config){

        let $this = this;

        let resolve = function(data) {
            config.post = data || false;
            if(config.timed) {
                setInterval(() => {
                    $this.ajax(item, config)
                }, config.time)
            } else {
                if(item.getAttribute('bond-status') !== 'live'){
                    $this.ajax(item, config);                    
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
                        inputs = item.closest('form').querySelectorAll('input, textarea, select');

                        if(action === 'push'){

                            FormObject = {};

                            inputs.forEach(input => {
                                if(input.name) {
                                    FormObject[input.name] = input.value; 
                                }
                            })

                        }

                        inputs.forEach(input => {

                            let type = input.getAttribute('type') || '';

                          if(type.toLowerCase() !== 'hidden') input.value = '';

                        })                        
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

let Bonde = new Bond();
Bonde.request(); 