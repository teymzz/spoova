import { SPAuto } from "./autoload/SPAuto.js";
import { SScripts } from "./autoload/SScripts.js";

class AjaxController {
    constructor() {
        SScripts.requires(['Interval', 'Selector', 'Helper'], 'AjaxController');

        this.urlContents = {};
        this.loadingMap = new WeakMap();

        const ajaxElements = SScripts.Selector().select('[' + CSS.escape('@ajax') + ']');

        ajaxElements.forEach((element, index) => {
            const keys = this.getKeys(element);
            if (!this.urlContents[keys.ajaxUrl]) {
                this.urlContents[keys.ajaxUrl] = {};
            }
            this.urlContents[keys.ajaxUrl][index] = keys;
        });

        for (const url in this.urlContents) {
            this.autoload(this.urlContents[url]);
        }
    }

    getKeys(element) {
        const keys = {
            ajaxItemSelector: '@ajax',
            ajaxConfig: '@ajaxConfig',
            ajaxItemEvent: '@ajaxEvent',
            ajaxForm: '@ajaxForm',
            ajaxType: '@ajaxType',
            ajaxDump: '@ajaxDump',
            ajaxSeparator: '|',
            ajaxTrigger: element,
            ajaxHandler: undefined,
            ajaxUrl: undefined,
            ajaxID: undefined,
            ajaxDelay: 0,
            pageID: undefined,
            autoID: true,
            url: {}
        };

        const isJson = val => {
            try { return JSON.parse(val); } catch { return null; }
        };

        const ajax = element.getAttribute(keys.ajaxItemSelector);
        let ajaxConfig = element.getAttribute(keys.ajaxConfig); // for setting ajax event, form (data) and type. Config can be a JSON string or a function that returns an object
        let ajaxEvent; // @jaxEvent=<event|Handler?|delay?>
        let ajaxForm;  // @ajaxForm="{id:(Element's id attribute if not defined)}". Other form request data may be include
        let ajaxType; // @ajaxType="json:this" , @ajaxType="json" or even @ajaxType=":this".
        let ajaxHandler;

        if (ajaxConfig) {
            // @ajaxConfig: {event:?, form:?, type:?} or a function that returns such an object. The values of event, form and type can also be set using the respective attributes. The precedence is given to the values obtained from the ajaxConfig function or JSON string.
              // event : "event|Handler:handle|delay" where Handler is optional and can be either "response" or "content" (default is content) and handle is the name of the function to handle the response or content.
              // form  : JSON string or a function that returns an object (e.g @ajax)
              // type  : "type[:this]" where type is the responseType of the XMLHttpRequest and ":this" indicates that the element itself should be used as the ajaxDump.
            ajaxConfig = window[ajaxConfig](element); 
            if (typeof ajaxConfig === 'object') {
                ajaxEvent = ajaxConfig.event; // e.g 'click|Handler:handle|delay'
                ajaxForm = ajaxConfig.form; 
                ajaxType = ajaxConfig.type; // response data type e.g 'json', 'text', 'blob', etc.
            }
        }

        if (element.getAttribute(keys.ajaxForm)) ajaxForm = element.getAttribute(keys.ajaxForm);
        if (element.getAttribute(keys.ajaxType)) ajaxType = element.getAttribute(keys.ajaxType);

        if (!ajaxEvent || element.getAttribute(keys.ajaxItemEvent)) {
            ajaxEvent = element.getAttribute(keys.ajaxItemEvent) || 'click';
        }

        if (ajaxEvent) {
            // @ajaxEvent="event|Handler:callback|delay"
            const parts = ajaxEvent.split(keys.ajaxSeparator);
            const eventListener = parts[0] || 'click';
            let handlerName = parts[1];
            let delay = parts[2] ? parseInt(parts[2]) : 0;

            if (parts.length === 2 && isNaN(parseInt(parts[1]))) {
                delay = 0;
            }

            if (handlerName) {
                // Handler can be specified as "Handler:handle" where "Handler" is control method while "handle" is the name of the function to handle the response or content. 
                // If "Handler:" is not specified, it defaults to "content" which automatically means that the content of the element is used as the ajaxDump. 
                // If the colon is defined, it expectes a callback function to handle response content which if not provide prevents direct dumping of ajax content.
                // The handler function can be defined globally and should be designed to accept the response or content as an argument. This allows for custom processing of 
                // the ajax response before it is rendered in the DOM.
                const handlerParts = handlerName.split(':'); 
                ajaxHandler = handlerParts.length > 1
                    ? { type: "response", handle: handlerParts[0] }
                    : { type: "content", handle: handlerParts[0] };
            }

            keys.ajaxEvent = eventListener;
            keys.ajaxDelay = delay;
            keys.ajaxHandler = ajaxHandler;
        }

        if (ajaxForm) {
            const parsed = isJson(ajaxForm);
            if (parsed) {
                keys.ajaxForm = parsed;
            } else if (typeof window[ajaxForm] === 'function') {
                const result = window[ajaxForm]();
                if (typeof result === 'object') keys.ajaxForm = result;
            }
        }

        if (element.getAttribute('id')) {
            // Ensure that ajax form has an id property for identification of controller element.
            if (!ajaxForm) {
                keys.ajaxForm = { id: element.getAttribute('id') };
            } else if (!ajaxForm.hasOwnProperty('id')) {
                keys.ajaxForm.id = element.getAttribute('id');
            }
        }

        if (ajaxType) {
            // Check if ajaxType has ':this' suffix to determine if the element itself should be used as the ajaxDump.  
            // This allows for dynamic assignment of the ajaxDump based on the element's attributes, providing flexibility in how the response is handled and displayed. 
            // If ':this' is present, the element's id is used as the pageID and the element itself is set as the ajaxDump. 
            // Sample usage: @ajaxType="json:this" or @ajaxType="text:this"
            const typeParts = ajaxType.split(':this');
            keys.autoID = typeParts.length === 2;
            if (keys.autoID) {
                keys.pageID = element.getAttribute('id');
                keys.ajaxDump = element;
            }
            keys.ajaxType = typeParts[0];
        }

        if (ajax) {
            const ajaxURL = new URL(ajax);
            const ajaxID = ajaxURL.hash?.substring(1);
            ajaxURL.hash = '';

            keys.ajaxUrl = ajaxURL.toString();
            if (ajaxID) keys.ajaxID = ajaxID;
            if (!keys.pageID && keys.autoID) keys.pageID = keys.ajaxID;
            keys.url[keys.ajaxUrl] = {};
        } else {
            console.error('@ajax attribute must have at least one value');
            return false;
        }

        if (!keys.ajaxDump) keys.ajaxDump = element;
        return keys;
    }

    autoload(keysGroup) {
        Object.values(keysGroup).forEach(item => {
            const triggerRequest = () => {
                if (this.loadingMap.get(item.ajaxTrigger)) return;
                this.loadingMap.set(item.ajaxTrigger, true);

                let handler;
                const ajaxHandler = item.ajaxHandler;

                if (ajaxHandler && ajaxHandler.type === 'response') {
                    handler = xhr => {
                        this.loadingMap.set(item.ajaxTrigger, false);
                        if (xhr.status === 200 && typeof window[ajaxHandler.handle] === 'function') {
                            window[ajaxHandler.handle](xhr);
                        }
                    };
                } else {
                    handler = xhr => {
                        this.loadingMap.set(item.ajaxTrigger, false);
                        if (xhr.status === 200) {
                            const content = this.render(xhr, item.ajaxID);
                            this.resolve(item, content);
                        }
                    };
                }

                setTimeout(() => this.request(item, handler), item.ajaxDelay);
            };

            if (item.ajaxEvent === 'load') {
                const interval = SScripts.interval();
                interval.start(triggerRequest);
            } else {
                item.ajaxTrigger.addEventListener(item.ajaxEvent, triggerRequest);
            }
        });
    }

    request(item, callback) {
        const xhr = new XMLHttpRequest();
        xhr.open('POST', item.ajaxUrl);

        this.setHeaders(xhr, {
            'X-Requested-With': 'XMLHttpRequest',
            'Content-Type': 'application/x-www-form-urlencoded',
            'X-Data-Controller': 'AjaxBtn',
            'X-Data-ID': item.ajaxID
        });

        if (item.ajaxType) xhr.responseType = item.ajaxType;

        xhr.onload = () => callback(xhr);

        xhr.onerror = () => {
            this.loadingMap.set(item.ajaxTrigger, false);
            console.error('ajax controller request failed:', xhr);
        };

        xhr.ontimeout = () => {
            this.loadingMap.set(item.ajaxTrigger, false);
            console.warn('ajax controller request timed out.');
        };

        xhr.timeout = 10000;

        if (item.ajaxForm) {
            xhr.send(new URLSearchParams(item.ajaxForm).toString());
        } else {
            xhr.send();
        }
    }

    resolve(item, content) {
        item.content = content;

        const props = {
            autoLoad: callback => {
                if (item.ajaxDump.innerHTML !== content) {
                    item.ajaxDump.innerHTML = content;
                }
                if (callback) callback(item, content);
            },
            showStatus: () => {
                item.ajaxDump.innerHTML = xhr.status;
            },
            process: callback => {
                const info = {
                    item,
                    ajaxDump: item.ajaxDump,
                    responseField: item.ajaxDump,
                    oldHtml: item.ajaxDump.innerHTML,
                    newHtml: content,
                    modified: item.ajaxDump.innerHTML !== content,
                    loadHtml: (field = item.ajaxDump, cb) => {
                        if (info.modified) field.innerHTML = content;
                        if (cb) cb(field);
                    }
                };
                callback(info);
            }
        };

        if (item.ajaxHandler?.type === 'content' && typeof window[item.ajaxHandler.handle] === 'function') {
            window[item.ajaxHandler.handle](props);
        }
    }

    render(xhr, id) {
        if (xhr.status === 200) {
            try {
                const parser = new DOMParser();
                const doc = parser.parseFromString(xhr.responseText, 'text/html');
                const el = doc.querySelector('#' + id);
                return el ? el.outerHTML : 'content id repressed!';
            } catch {
                return 'content id repressed';
            }
        } else if (xhr.status === 404) {
            return xhr.responseText;
        } else {
            return xhr.status;
        }
    }

    setHeaders(xhr, headers) {
        for (const [key, value] of Object.entries(headers)) {
            xhr.setRequestHeader(key, value);
        }
    }
}

export default SPAuto(AjaxController);
document.addEventListener('DOMContentLoaded', () => new AjaxController());
