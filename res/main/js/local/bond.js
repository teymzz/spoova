import { SPAuto } from "./autoload/SPAuto.js";
import { SScripts } from "./autoload/SScripts.js";

export class Bond {

    /**
     * The fields a bond collects and clears.
     *
     * Kept identical to BondComponent::FIELDS on the server, so the set sent up and the
     * set written back are always the same. Buttons carry no user input, and a file input
     * cannot be assigned a value on the way back.
     */
    static FIELDS = 'input:not([type="submit"]):not([type="button"])'
                  + ':not([type="reset"]):not([type="image"]):not([type="file"])'
                  + ', textarea, select';

    constructor() {
        SScripts.requires(['Interval']);
        this.url = window.location.href;
        this.events = ['click','load','keydown','hover'];
        this.scriptsAnchor = []; 
        this.sequentials = {}; 
        this.defaults = {
            bind: {
                onloaded() {}, 
                onevoked() {},
                onupdate() {},
                onended() {},
                onfailed() {},
                onsuccess() {},
            }
        };
        this.iroot = '';
        this.emitTrack = {}; // To track emit states
    }

    request() {
        let $this = this;
        window.addEventListener('load', function(){
            let body = document.querySelector('body');
            $this.call('onload', body);

            let bond_roots = document.querySelectorAll('[bond\\:root]');
            bond_roots.forEach((root) => { 
                $this.bind(root);
            });
        });
    }

    bind(root) {
        let $this = this;
        let bondEvents = root.querySelectorAll('[bond\\:event]');
        let bondForms = root.querySelectorAll('form');      
        let avertedForms = root.querySelectorAll('form[bond\\:action="avert"]');      
        let rootIndex = root.getAttribute('bond:root');

        function preventDefaultAction(buttons){
            buttons.forEach(button => {
                button.addEventListener('click', e => e.preventDefault());
            });
        }

        avertedForms.forEach(avertedForm => {
            let buttons = $this.getBtns(avertedForm);
            preventDefaultAction(buttons);
        });

        bondEvents.forEach((item, itemIndex) => {
            let config = {
                event: item.getAttribute('bond:event'),
                bond: item.getAttribute('bind'),
                id: item.getAttribute('id'),
                bondTrigger: item.getAttribute('trigger'),
                url: $this.url,
                bondAction: item.getAttribute(':action'),
                itemIndex: itemIndex,
                rootElement: root,
                rootIndex: rootIndex
            };
            let bit = item.getAttribute('bit');
            if(bit){
                bit = $this.bitVal(bit);
                config.timed = bit.name;
                config.time  = bit.time;
            }

            $this.resolveEvent(item, config);
        });
    }

    call(func, arg) {
        if(typeof this.defaults.bind[func] === 'function'){
            this.defaults.bind[func](arg);
        }
    }

    bitVal(val){
        let match = val.toString().match(/^([a-zA-Z]+)-(stop|\d+)$/);
        if(match){
            return { name: match[1], time: parseInt(match[2]) };
        }
        return { name: null, time: parseInt(val) };
    }

    ajax(item, config, iterated){
        if(item.getAttribute('bond-status') === 'live') return;
        const emitLimit = item.getAttribute('emit');
        if(emitLimit) {
            let count = this.emitTrack[config.id] || 0;
            if(count >= parseInt(emitLimit)) return;
            this.emitTrack[config.id] = count + 1;
        }

        let $this = this;
        let delay = item.getAttribute('delay') || 0;
        let defaults = {
            mode: 'bond',
            state: 'live',
            event: 'click',
            bond: config.url,
            call: config.bond
        };
        let formInputs = this.getInputs(config.rootElement);
        let formData = { [config.rootIndex]: {} };
        formInputs.forEach((input, i) => {
            let entry = {
                name: input.getAttribute('name'),
                value: input.value,
            };

            // a checkbox reports its value attribute whether ticked or not, so without
            // this the server cannot tell the two apart and the state is lost on re-render
            let type = (input.type || '').toLowerCase();
            if(type === 'checkbox' || type === 'radio') entry.checked = input.checked;

            formData[config.rootIndex][i] = entry;
        });

        item.setAttribute('bond-status', 'live');
        $this.call('evoked', item);

        const xhr = new XMLHttpRequest();
        xhr.open('post', config.url);

        this.setHeaders(xhr, {
            'X-Requested-With': 'xmlHttpRequest',
            'Content-Type': 'application/x-www-form-urlencoded'
        });

        const params = new URLSearchParams();
        Object.entries(defaults).forEach(([k, v]) => params.append(k, v));
        params.append('data', JSON.stringify(formData[config.rootIndex]));
        params.append('action', JSON.stringify(config.bondAction));
        params.append('CSRF_TOKEN', config.post?.CSRF_TOKEN || '');
        if(config.post) params.append('postdata', JSON.stringify(config.post));

        // --- Trigger 'sent' callback if specified ---
        let triggers = config.bondTrigger;
        let sentTrigger, doneTrigger;
        if(triggers){
            triggers = triggers.split("|");
            if(triggers.length === 2){
                sentTrigger = triggers[0];
                doneTrigger = triggers[1];
            }else{
                sentTrigger = triggers[0];
            }
        }

        if(sentTrigger && typeof window[sentTrigger] === 'function') {
            let rootItem = item.closest('['+CSS.escape('bond:root')+']');
            window[sentTrigger]({bond : rootItem, item : rootItem.querySelectorAll(`#${item.id}`)});
        }

        xhr.onload = () => {
            if (xhr.status === 200) {
                let text = xhr.responseText;
                let itemSelector = '[bond\\:root="' + config.rootIndex + '"]';
                let contentField = document.querySelector(itemSelector);

                let tempDiv = document.createElement('div');
                tempDiv.innerHTML = text;
                let target = tempDiv.querySelector(itemSelector);

                $this.scriptsAnchor = [];

                if (target) {
                    let strippedHtml = $this.stripScripts(target.innerHTML);
                    let oldHTML = contentField.innerHTML;

                    setTimeout(()=>{

                        if(strippedHtml !== oldHTML) {
                            contentField.innerHTML = strippedHtml; //content field updated, item lost
                            $this.runScriptBlock();
                            item.setAttribute('bond-status', 'closed');
                            $this.bind(contentField, config.rootIndex);
                        } else {
                            $this.runScriptBlock();
                        }
    
                        if(sentTrigger && typeof window[doneTrigger] === 'function') {
                            let obj = {bond : contentField, item : contentField.querySelectorAll(`#${item.id}`)}
                            window[doneTrigger](obj);
                        }

                    }, delay)

                } else {
                    console.warn('Root not found in AJAX response.');
                }
            }
        };

        xhr.send(params);
    }

    setHeaders(xhr, headers) {
        for(const [key, value] of Object.entries(headers)) {
            xhr.setRequestHeader(key, value);
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
        return div.innerHTML;
    }

    saveScripts(scripts, i){
        let nodes = {};
        for (let att of scripts[i].attributes){
            nodes[att.nodeName] = att.nodeValue;
        }                                    
        if(scripts[i].text) {
            nodes['script'] = scripts[i].text;
        }
        this.scriptsAnchor.push(nodes);
    }

    runScriptBlock() {
        this.scriptsAnchor.forEach(scriptObj => {
            let script = document.createElement('script');
            Object.entries(scriptObj).forEach(([key, value]) => {
                if(key === 'script') {
                    script.text = value;
                } else {
                    script.setAttribute(key, value);
                }
            });
            document.body.appendChild(script);
            document.body.removeChild(script); // Clean up
        });
        this.scriptsAnchor = []; // clear after injection
    }

    resolveEvent(item, config){
        let $this = this;
        let resolve = data => {
            
            if (!$this.checkEmitLimit(item, config.emitLimit)) return;

            config.post = data || false;

            let bit = $this.bitVal(item.getAttribute('bit') || '');

            if(config.timed || (bit.name === 'stop')) {
                console.log(SScripts.scripts());
                let interval = ss.interval();
                if(bit.name !== 'stop'){
                    let loop = interval.start(() => {
                        $this.ajax(item, config);
                        loop.recall();
                    }, config.time);

                    if(bit.name){
                        let beats = $this.sequentials[bit.name] || [];
                        beats.forEach(beat => beat.stop());
                        beats = [loop];
                        $this.sequentials[bit.name] = beats;
                    }
                }
            } else {
                if(item.getAttribute('bond-status') !== 'live'){
                    $this.ajax(item, config, false);
                }
            }
        };

        if(config.event === 'load'){
            resolve(); 
        } else {
            item.addEventListener(config.event, (e) => {
                let action = config.bondAction;
                let escape = ['halt', 'reset', 'push'];
                let inputs = [], FormObject = false;

                if(escape.includes(action)){
                    e.preventDefault();
                    let form = item.closest('form');
                    if(!form) return;

                    inputs = $this.getInputs(form);

                    if(action === 'push'){
                        FormObject = {};
                        inputs.forEach(input => {
                            let type = (input.type || '').toLowerCase();

                            if(input.name){
                                // an unticked box must not submit its value as though it were ticked
                                if(type === 'checkbox' || type === 'radio'){
                                    if(input.checked) FormObject[input.name] = input.value;
                                } else {
                                    FormObject[input.name] = input.value;
                                }
                            }

                            $this.clearInput(input);
                        });
                    } else {
                        inputs.forEach(input => $this.clearInput(input));
                    }
                }

                if(action !== 'reset') resolve(FormObject);
            });
        }
    }

    checkEmitLimit(item, max) {
        if (!max) return true;
        let count = this.emitTracker.get(item) || 0;
        if (count >= max) return false;
        this.emitTracker.set(item, count + 1);
        return true;
    }

    isBtn(item) {
        return (item.tagName === 'BUTTON') || (item.tagName === 'INPUT' && item.getAttribute('type') === 'button');
    }

    getBtns(item) {
        return item.querySelectorAll('input[type="button"], input[type="submit"], button');
    }

    getInputs(item) {
        return item.querySelectorAll(Bond.FIELDS);
    }

    /**
     * Clears a field for :action="push" and :action="reset".
     *
     * Each type holds its state differently, so assigning value = '' only works for
     * text-like inputs: it leaves a checkbox ticked and blanks what a select submits.
     * Hidden fields are left alone so that tokens survive a clear.
     */
    clearInput(input) {
        let type = (input.type || '').toLowerCase();

        if(type === 'hidden') return;

        if(type === 'checkbox' || type === 'radio'){
            input.checked = false;
            return;
        }

        if(input.tagName === 'SELECT'){
            let preset = input.querySelector('option[selected]');
            input.selectedIndex = preset? preset.index : 0;
            return;
        }

        input.value = '';
    }
}

export default SPAuto(Bond);
(new Bond()).request();