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
        this.scriptsAnchor = [];
        this.executedScripts = new Set(); // scripts already run, so a re-render cannot repeat them
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
        this.emitTrack = new WeakMap(); // per element emit counts, so triggers without an id stay apart
        /* morphing keeps the existing elements alive, so their listeners survive a re-render
           and binding the same element twice would fire one request per listener */
        this.bound = new WeakSet();
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

    /**
     * Collects the elements inside a bond that belong to it rather than to a nested bond.
     *
     * A nested component has a root of its own and is bound separately, so selecting
     * straight through the subtree gave its elements a listener from each root and fired
     * one request per listener.
     */
    own(root, selector) {
        let rootSelector = '[' + CSS.escape('bond:root') + ']';
        return Array.from(root.querySelectorAll(selector))
                    .filter(item => item.closest(rootSelector) === root);
    }

    bind(root) {
        let $this = this;
        let bondEvents = this.own(root, '[bond\\:event]');
        let avertedForms = this.own(root, 'form[bond\\:action="avert"]');
        let rootIndex = root.getAttribute('bond:root');

        function preventDefaultAction(buttons){
            buttons.forEach(button => {
                if($this.bound.has(button)) return;
                $this.bound.add(button);
                button.addEventListener('click', e => e.preventDefault());
            });
        }

        avertedForms.forEach(avertedForm => {
            let buttons = $this.getBtns(avertedForm);
            preventDefaultAction(buttons);
        });

        bondEvents.forEach((item, itemIndex) => {
            if($this.bound.has(item)) return; // already carries its listener from an earlier bind
            $this.bound.add(item);

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
            let count = this.emitTrack.get(item) || 0;
            if(count >= parseInt(emitLimit)) return;
            this.emitTrack.set(item, count + 1);
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

        /* which bond this call is for, and the token proving it came from a page that was
           able to read the bond. Both are read off the root at request time rather than at
           bind time, so a re-rendered root supplies the current values. */
        params.append('bondId', config.rootIndex);
        params.append('bondToken', config.rootElement.getAttribute('bond:csrf') || '');

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
            window[sentTrigger](this.triggerRef(rootItem, item));
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
                    let incoming = document.createElement('div');
                    incoming.innerHTML = $this.stripScripts(target.innerHTML);

                    setTimeout(()=>{

                        /* The subtree is updated in place instead of being reassigned through
                           innerHTML. Replacing it discarded and rebuilt every node, which threw
                           away the caret and focus of whatever field was being typed in, the
                           scroll position of anything scrollable, running CSS transitions and
                           the state of any widget another script had set up. */
                        $this.morphChildren(contentField, incoming);

                        $this.runScriptBlock();

                        if(item.isConnected) item.setAttribute('bond-status', 'closed');

                        $this.bind(contentField);

                        if(doneTrigger && typeof window[doneTrigger] === 'function') {
                            window[doneTrigger]($this.triggerRef(contentField, item));
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

    /**
     * Builds the {bond, item} object handed to a trigger callback.
     *
     * An element without an id used to produce the selector "#undefined", which is invalid
     * and throws before the callback is ever reached.
     */
    triggerRef(root, item) {
        let id = item && item.id;
        return {
            bond: root,
            item: id? root.querySelectorAll('#' + CSS.escape(id)) : (item? [item] : [])
        };
    }

    /**
     * Identifies a child across renders, so an element keeps its place in the DOM even when
     * the ones around it are added or removed. An author supplied bond:key wins over an id.
     */
    morphKey(node) {
        if(node.nodeType !== Node.ELEMENT_NODE) return null;
        return node.getAttribute('bond:key') || node.getAttribute('id') || null;
    }

    /**
     * Brings the children of "from" in line with the children of "to", reusing the nodes
     * already in the page wherever they correspond.
     */
    morphChildren(from, to) {
        let keyed = new Map();

        Array.from(from.childNodes).forEach(child => {
            let key = this.morphKey(child);
            if(key !== null) keyed.set(key, child);
        });

        let existing = from.firstChild;

        Array.from(to.childNodes).forEach(incoming => {
            let key = this.morphKey(incoming);
            let match = null;

            if(key !== null && keyed.has(key)){
                match = keyed.get(key);
                keyed.delete(key);
            } else if(existing && this.morphable(existing, incoming) && this.morphKey(existing) === null){
                match = existing;
            }

            if(match){
                if(match !== existing) from.insertBefore(match, existing);
                if(match === existing) existing = existing.nextSibling;
                this.morphNode(match, incoming);
            } else {
                from.insertBefore(incoming.cloneNode(true), existing);
            }
        });

        // whatever the response no longer contains is dropped
        while(existing){
            let next = existing.nextSibling;
            from.removeChild(existing);
            existing = next;
        }

        keyed.forEach(node => { if(node.parentNode === from) from.removeChild(node); });
    }

    /** TRUE when two nodes are alike enough to be updated into one another */
    morphable(a, b) {
        return a.nodeType === b.nodeType && a.nodeName === b.nodeName;
    }

    /** Updates a single node in place from its counterpart in the response */
    morphNode(from, to) {
        if(from.nodeType !== Node.ELEMENT_NODE){
            if(from.nodeValue !== to.nodeValue) from.nodeValue = to.nodeValue;
            return;
        }

        this.morphAttributes(from, to);

        // a field's live state is a property, not an attribute, so it is carried over separately
        this.morphFieldState(from, to);

        this.morphChildren(from, to);
    }

    morphAttributes(from, to) {
        Array.from(to.attributes).forEach(attribute => {
            if(from.getAttribute(attribute.name) !== attribute.value){
                from.setAttribute(attribute.name, attribute.value);
            }
        });

        Array.from(from.attributes).forEach(attribute => {
            if(!to.hasAttribute(attribute.name)) from.removeAttribute(attribute.name);
        });
    }

    /**
     * Carries a field's value across a re-render.
     *
     * The field the visitor is presently in is left untouched: overwriting it would drop
     * whatever was typed between the request being sent and the response arriving.
     */
    morphFieldState(from, to) {
        let tag = from.tagName;

        if(tag !== 'INPUT' && tag !== 'TEXTAREA' && tag !== 'SELECT') return;
        if(from === document.activeElement) return;

        let type = (from.type || '').toLowerCase();

        if(type === 'checkbox' || type === 'radio'){
            from.checked = to.hasAttribute('checked');
            return;
        }

        if(tag === 'SELECT'){
            let selected = to.querySelector('option[selected]');
            if(selected) from.value = selected.hasAttribute('value')? selected.getAttribute('value') : selected.textContent;
            return;
        }

        if(tag === 'TEXTAREA'){
            if(from.value !== to.textContent) from.value = to.textContent;
            return;
        }

        let value = to.getAttribute('value');
        if(value !== null && from.value !== value) from.value = value;
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
            /* the same script arrives again with every re-render, and running it each time
               stacked up duplicate listeners, timers and re-fetched external files */
            let signature = JSON.stringify(scriptObj);
            if(this.executedScripts.has(signature)) return;
            this.executedScripts.add(signature);

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