import SSRegistry from "./SSRegistry.js";

/**
 * Sppova's SSDom class provides some of smart utilty methods for selecting and modifying elements along with few extended features. 
 *  - Methods: selections, exists, get, val, attr, removeAttr, hasAttr 
 *    hasClass, hasClassAt, addClass, removeClass, data, css, closest, parent, 
 *    find (or select), on (or event), off, click, prop, toggleClass, toggleAttr, append,
 *    remove, keepOnly, outline, html, text, load, onReady, each, some, map, every, filter, 
 *    eq, timedLoad, index and length.
 */
class SSDom {

    static #listenersMap = new WeakMap();
    #dataOverrides = new WeakMap();

    /** Select an element */
    /**
     * Selects an element 
     * @param {string|object} selector a selector object or string
     * @param {*} context optional [window|document|object instance]
     *   - This determines the context of selection
     */
    constructor(selector, context = document) {
      
      if (typeof selector === 'string') {
        if(selector.startsWith('<') && selector.endsWith('>') && selector.length > 2){
          selector = selector.substring(1, selector.length - 1);
          this.elements = [document.createElement(selector)];
        }else{
          selector = SSDom.expandQuery(selector);
          this.elements = Array.from((context || document).querySelectorAll(selector));
        }
      } else if (selector instanceof SSDom) {
        this.elements = selector.elements;
      } else if (selector instanceof NodeList || Array.isArray(selector)) {
        this.elements = Array.from(selector);
      } else if (selector instanceof Element || selector === window || selector === document) {
        this.elements = [selector];
      } else {
        this.elements = [];
      }

      this.elements.forEach(el => {
        if (!this.#dataOverrides.has(el)) {
          this.#dataOverrides.set(el, {});
        }
      });

    }

    static expandQuery(query) {
      const softInputs = ':where(' +
        [
          'input',
          'select',
          'textarea',
          'button'
        ].join(',') +
      ')';

      const cleanInputs = ':where(' +
        [
          'input[type="text"]',
          'input[type="password"]',
          'input[type="email"]',
          'input[type="tel"]',
          'input[type="url"]',
          'input[type="number"]',
          'input[type="date"]',
          'input[type="datetime-local"]',
          'input[type="file"]',
          'input[type="checkbox"]',
          'input[type="radio"]',
          'input:not([type])',
          'div[input][contenteditable]',
          'textarea',
          'select'
        ].join(',') +
      ')';

      const buttonsQuery = ':where(input[type="button"],input[type="submit"],button)';
      const buttonsQuery2 = ':where([type="button"],[type="submit"],button)';
      const buttonsQuery3 = ':where([type="button"],[type="submit"],button)';

      return query
        .replace(/::input\b/g, cleanInputs)   // your modern version
        .replace(/:input\b/g, softInputs)   // jQuery-compatible
        .replace(/::button\b/g, buttonsQuery2) // support all elements with [type="button"]
        .replace(/::submit\b/g, buttonsQuery3) // support all elements with [type="submit"]
        .replace(/:submit\b/g, buttonsQuery)
        .replace(/:button\b/g, buttonsQuery);
    }

    /**
     * Returns array of selected elements
     * @returns array
     */
    selections() {
      return this.elements || [];
    }

    /**
     * checks if a selected element exists
     * @returns boolean
     */
    exists() {
      return this.elements.length > 0;
    }

    /**
     * Gets a selected element directly out of SSDom object selections 
     * @param {int} index direct index of element to be retrieved
     * @returns int|undefined
     */
    get(index = 0) {
      return this.elements[index];
    }

    /**
     * Sets or Gets the value of a form element (e.g input tag)
     * @param {*} value if defined, sets the value else current value will be returned.
     * @returns SSDom object instance
     */
    val(value) {
      if (value === undefined) return this.get()?.value || '';
      this.elements.forEach(el => el.value = value);
      return this;
    }

    /**
     * Gets or Sets the attribute of html elements using different argument formats: 
     *  - attr(attribute, value) => sets object of attribute and value
     *  - attr(string, func(attrs)) =>  sets object of attribute and callback function's returned value
     *  - attr([attribute,...]) => return object with specified attributes & their corresponding values
     *  - attr(attribute) => return value of attribute
     *  - attr({attribute:value,...}) => the value of each attributes specified is overwritten using the new corresponding value defined.
     * @param {string|array} attrs defined attributes to be fetched or set.
     * @param {Function} value if defined, determines the value to be set for attributes.
     * @returns 
     */
    attr(attrs, value) {

      // attr(attribute, value) => set object of attribute and value
      if(typeof attrs === 'string' && (arguments.length > 1) && !(['function','object'].includes(typeof value))){
        attrs = {[attrs]:value};
      }

      // attr(string, func()) =>  set object of attribute and callback function's returned value
      if((typeof attrs === 'string') && (typeof value === 'function')){
        attrs = {[attrs]:value(this.get()?.getAttribute(attrs))};
      }

      // attr([attribute,...]) => return object with attributes & corresponding values
      if (Array.isArray(attrs) && (value === undefined)) {
        let attributes = {};
        attrs.forEach(attr => {
          attributes[attr] = this.get()?.getAttribute(attr)
        })
        return attributes;
      }

      // attr(attribute) => return value of attribute
      if (typeof attrs === 'string') {
        return this.get()?.getAttribute(attrs);
      }
      // if(value !== undefined){
        this.elements.forEach(el => {
          for (const [key, value] of Object.entries(attrs)) {
            if(value !== undefined) el.setAttribute(key, value);
          }
        });
      // }
      return this;
    }

    /**
     * Removes the attribute of an element
     * @param  {...any} attrs 
     * @returns 
     */
    removeAttr(...attrs) {
      this.elements.forEach(el => attrs.forEach(attr => el.removeAttribute(attr)));
      return this;
    }
    
    /**
     * Checks if an elements has an attribute
     * @param {string|array} attr 
     * @param {Function} callback if defined, callback will be executed always 
     *  - callback function will be returns if defined. 
     *  - callback function's argument will either be boolean if attr is string or an object if attr argument is an array
     * @returns {*}
     *  boolean: if only attr argument is defined 
     *  any: if callback is defined
     */
    hasAttr(attr, callback) {
      if (typeof attr === 'string') {
        if (callback === undefined) return this.elements.some(el => el.hasAttribute(attr));
        if (typeof callback !== 'function') throw new Error('argument 2 of SSDom.hasAttr() must be a callback function');
        return callback(this.elements.some(el => el.hasAttribute(attr)));
      }

      if (Array.isArray(attr)) {
        if (callback !== undefined && typeof callback !== 'function') throw new Error('argument 2 of SSDom.hasAttr() must be a callback function');
        let attributes = {};
        attr.forEach(a => {
          attributes[a] = this.elements.some(el => el.hasAttribute(a));
        });
        return callback ? callback(attributes) : attributes;
      }

      return false;
    }

        
    /**
     * Checks if an element is checked
     * @param {*} callback 
     * @returns 
     */
    checked(callback) {
      if (callback === undefined) {
        return this.elements.some(el => el.tagName === 'INPUT' && el.checked);
      }
      if (typeof callback !== 'function') throw new Error('argument 1 of SSDom.checked() must be a callback function');
      return callback(this.elements.some(el => el.tagName === 'INPUT' && el.checked));
    }

    /**
     * Checks if at least one of a selected element group has the class name value specified. 
     *  - This function can check for multiple values but they have to be within the same individual element object for it to return true.
     * @param {string} className 
     * @param {int} element index 
     * @returns boolean
     */
    hasClass(className) {
      
      let classes = className.trim().split(/\s+/);
      let result;

      return this.elements.some(el => {
        let classValues = el.getAttribute('class')?.trim().split(/\s+/) || [];
        return classes.every(val => classValues.includes(val));
      });

    }

    /**
     * Checks if an element at specified index has a classList value.
     * @param {string} className 
     * @param {int} element index 
     * @returns SSDom object
     */
    hasClassAt(className, index = 0) {
      let elem = this.get(index);
      if(!elem) return undefined;
      if(!elem.hasAttribute('class')) return false;
      
      let classes = className.trim().split(/\s+/);
      const classValues = elem.getAttribute('class').trim().split(/\s+/);

      let result, checker;

      classes.forEach(classItem => {
        checker = true;
        if(!classValues.includes(classItem)) {
          result = false;
        }
      })

      return (checker && (result === undefined))
    }

    /**
     * Add class names into the classList of an element
     * @param {string} className 
     * @returns SSDom object
     */
    addClass(className) {
      const classes = className.trim().split(/\s+/);
      this.elements.forEach(el => el.classList.add(...classes));
      return this;
    }

    /**
     * Removes class names from the classList of an element
     * @param {string} className 
     * @returns SSDom object
     */
    removeClass(className) {
      const classes = className.trim().split(/\s+/);
      this.elements.forEach(el => el.classList.remove(...classes));
      return this;
    }

    /**
     * Returns or modifies the data attribute of html elemnts
     * @param {string} key attribute to be fetched or updated
     * @param {value} value an attribute's value to be set or callback function to be applied on attribute value retrieved before it is returned.
     * @returns 
     */
    data(key, value = undefined) {
      let val = this.elements.map(el => {
        const orig = SSRegistry.get(el); // pulled from snapshot
        const overrides = this.#dataOverrides.get(el);

        if (value === undefined) {
          if (key === undefined) return { ...orig, ...overrides };
          return key in overrides ? overrides[key] : orig[key];
        } else {
          if(typeof value === 'function'){
            return key in overrides ? overrides[key] : orig[key];
          }
          overrides[key] = value;
          el.setAttribute('data-' + this.#toKebab(key), value);
          return value;
        }
      })[0];
      return val = (typeof value === 'function')? value(val, this) : val;
    }

    /**
     * Attaches css style to a selected html element
     * @param {*} selector 
     * @returns SSDom object
     */ 
    css(styles, value) {
      if(typeof styles === 'string' && typeof value === 'string') styles = {[styles]:value};

      if (typeof styles !== 'object' || styles === null) return this;

      this.elements.forEach(el => {
        for (const key in styles) {
          if (Object.prototype.hasOwnProperty.call(styles, key)) {
            try {
              el.style[key] = styles[key];
            } catch (err) {
              console.warn(`Invalid CSS key: ${key}`, err);
            }
          }
        }
      });
      return this;
    }

    #toKebab(str) {
      return str.replace(/([a-z])([A-Z])/g, "$1-$2").toLowerCase();
    }

    /**
     * Finds the closest element to an element
     * @param {*} selector 
     * @returns SSDom object
     */
    closest(selector) {
      return new SSDom(this.elements.map(el => el.closest(selector)).filter(Boolean));
    }

    /**
     * Finds the parent element to an html element
     * @returns SSDom object
     */    
    parent() {
      return new SSDom(this.elements.map(el => el.parentElement).filter(Boolean));
    }

    /**
     * Finds a child element within an html element
     * @param {*} selector 
     * @returns SSDom object
     */ 
    find(selector) {
      if(!selector) return false;
      selector = SSDom.expandQuery(selector);
      return new SSDom(this.elements.flatMap(el => Array.from(el.querySelectorAll(selector))));
    }

    /**
     * Finds a child element within an html element and returns boolean response
     * @param {*} selector 
     * @returns SSDom object
     */ 
    has(selector) {
      if(!selector) return false;
      selector = SSDom.expandQuery(selector);
      return (new SSDom(this.elements.flatMap(el => Array.from(el.querySelectorAll(selector))))).exists();
    }

    /**
     * Finds a child element within an html element
     *  - Alias for find
     * @param {*} selector 
     * @returns SSDom object
     */ 
    select(selector) {
      if(!selector) return false;
      selector = SSDom.expandQuery(selector);
      return new SSDom(this.elements.flatMap(el => Array.from(el.querySelectorAll(selector))));
    }
    
    /**
     * Attaches an event to element within an html dom
     *  - Alias for on
     * @param {*} selector 
     * @returns SSDom object
     */ 
    event(e, handler, option = {}) {
      return this.on(e, handler, option);
    }
        
    /**
     * Attaches an event to element within an html dom
     * @param {*} selector 
     * @returns SSDom object
     */ 
    on(event, handler, option = {}) {
      const events = (Array.isArray(event) ? event : String(event))
        .toString()
        .replace(':write', 'input,keypress')
        .split(/[\s,]+/)
        .map(eventName => eventName.trim())
        .filter(Boolean);

      this.elements.forEach(el => {
        events.forEach(eventName => {
          el.addEventListener(eventName, handler, option);

          // track in listenersMap
          if (!SSDom.#listenersMap.has(el)) {
            SSDom.#listenersMap.set(el, {});
          }
          const elListeners = SSDom.#listenersMap.get(el);
          if (!elListeners[eventName]) {
            elListeners[eventName] = new Set();
          }
          elListeners[eventName].add(handler);
        });
      });
      return this;
    }
    
    /**
     * Removes a previously attached event from an element within an html dom
     * @param {*} selector 
     * @returns SSDom object
     */ 
    off(event, handler) {
      const events = (Array.isArray(event) ? event : String(event))
        .toString()
        .replace(':write', 'input,keypress')
        .split(/[\s,]+/)
        .map(eventName => eventName.trim())
        .filter(Boolean);

      this.elements.forEach(el => {
        events.forEach(eventName => {
          const elListeners = SSDom.#listenersMap.get(el);
          if (!elListeners || !elListeners[eventName]) return;

          if (handler) {
            // remove specific handler
            el.removeEventListener(eventName, handler);
            elListeners[eventName].delete(handler);
          } else {
            // remove all handlers for this event
            for (let h of elListeners[eventName]) {
              el.removeEventListener(eventName, h);
            }
            elListeners[eventName].clear();
          }

          // clean up empty records
          if (elListeners[eventName] && elListeners[eventName].size === 0) {
            delete elListeners[eventName];
          }
          if (Object.keys(elListeners).length === 0) {
            SSDom.#listenersMap.delete(el);
          }
        });
      });
      return this;
    }

    /**
     * Attaches a click event to element within an html dom
     * @param {*} selector 
     * @returns SSDom object
     */ 
    click() {
      this.elements.forEach(el => el.click());
      return this;
    }

    /**
     * Fecthes or sets the attribute property of a selected html element
     * @param {*} selector 
     * @returns SSDom object
     */ 
    prop(name, value) {
      if (value === undefined) {
        return this.get()?.[name];
      }
      this.elements.forEach(el => el[name] = value);
      return this;
    }

    toggleClass(className) {
      const classes = className.trim().split(/\s+/);
      this.elements.forEach(el => classes.forEach(cls => el.classList.toggle(cls)));
      return this;
    }

    toggleAttr(className) {
      const classes = className.trim().split(/\s+/);
      this.elements.forEach(el => classes.forEach(cls => {
        if(el.hasAttribute(cls)){
          el.removeAttribute(cls)
        }else{
          el.setAttribute(cls, '')
        }

      }));
      return this;
    }

    append(content) {
      let toAppend;

      if (typeof content === 'string') {
        // Parse HTML string into real nodes
        const temp = document.createElement('div');
        temp.innerHTML = content;
        toAppend = Array.from(temp.childNodes);
      } else if (content instanceof SSDom) {
        // Unwrap custom wrapper
        toAppend = content.elements;
      } else if (content instanceof Element || content instanceof Node) {
        toAppend = [content];
      } else if (Array.isArray(content)) {
        toAppend = content.filter(n => n instanceof Node);
      } else {
        return this;
      }

      this.elements.forEach(parent => {
        toAppend.forEach(node => {
          parent.appendChild(node.cloneNode(true));
        });
      });

      return this;
    }

    /**
     * Removes a selected element from the dom
     * @returns 
     */
    remove() {
      this.elements.forEach(el => {
        if (el.parentNode) {
          el.parentNode.removeChild(el);
        }
      });
      this.elements = []; // Optionally clear internal reference
      return this;
    }

    /**
     * Removes all selected element from the dom except the last element in the group.
     * @param {string|int} type optional ['first'|'last'|int]
     *  - string 'first' : keep only the first element in the group
     *  - string 'last' : keep only the last element in the group
     *  - int : keep only element at specified index where the least index is 1.
     * @returns 
     */
    keepOnly(type) {
      let index;

      if (type === 'first') {
        index = 0;
      }else if(type === 'last'){
        index = (+this.elements.length - 1) || 0;
      }else{
        index = +type;
      }

      if(index > -1){
        this.elements.forEach((el, i) => {
          if((i) !== index){
            if (el.parentNode) {
              el.parentNode.removeChild(el);
            }
          }
        });
        this.elements = []; // Optionally clear internal reference
      }
      return this;
    }

    /**
     * Helper function to quickly spot selected items on a screen
     * @param {*} color 
     * @returns 
     */
    outline(color = 'red', timeout) {

      this.elements.forEach((el, i) => {
        let outline = el.style.outline;
        let outlineOffset = el.style.outlineOffset;
        el.style.outline = 'dashed 1px '+color
        el.style.outlineOffset = '2px';
        if(timeout){
          setTimeout(() => {
            el.style.outline = outline
            el.style.outlineOffset = outlineOffset;
          }, timeout)
        }
      });

    }

    /**
     * Sets innerHTML for a selected group or returns the inner html of the index element.
     * @param {*} msg 
     * @returns 
     */
    html(msg) {
      if(msg !== undefined) {
        this.elements.forEach(el => el.innerHTML = msg)
      }else{
        return this.elements[0]?.innerHTML;
      }
    }
    /**
     * Sets innerText for a selected group or returns the inner html of the index element.
     * @param {*} msg 
     * @returns 
     */
    text(msg) {
      if(msg !== undefined) {
        this.elements.forEach(el => el.innerText = msg)
      }else{
        return this.elements[0]?.innerText;
      }
    }

    /**
     * This method is designed for loading media when applied on elements that supports the native load function. 
     * However if a url string is supplied, it tries to fetch the content of the URL and if successful, triggers the callback 
     * function (if supplied).
     * request was successful. 
     * @param {string} arg optional
     * @param {*} callback optional
     * @returns 
     */
    load(arg, callback) {
      if (!arg) {
        // Native load
        this.elements.forEach(el => typeof el.load === 'function' && el.load());
      } else if (typeof arg === 'string') {
        // URL-based content loader
        fetch(arg)
          .then(res => {
            if (!res.ok) throw new Error(`Failed to load: ${arg}`);
            return res.text();
          })
          .then(html => {
            let elem;
            this.elements.forEach(el => {
              (el.innerHTML = html)
              elem = el;
            });
            if (typeof callback === 'function') {
              let tool = {
                loadScripts: () => {

                  let temp = document.createElement('div');
                  temp.innerHTML = html;

                  // Append non-script nodes first
                  [...temp.childNodes].forEach(node =>{
                    if(node.tagName !== 'SCRIPT'){
                      elem.appendChild(node);
                    }
                  });

                  temp.querySelectorAll('script').forEach(oldScript => {
                    let newScript = document.createElement('script');

                    // copy attributes
                    for(let attr of oldScript.attributes){
                      
                      newScript.setAttribute(attr.name, attr.value);
  
                      if(oldScript.src){
                        newScript.src = oldScript.src;
                        newScript.async = false; // preserve order
                      }else{
                        newScript.textContent = oldScript.textContent
                      }
                      console.log(attr)
                      oldScript.replaceWith(newScript);
                    }
                  })
                  
                  let scripts = elem.querySelectorAll('script');

                  scripts.forEach(oldScript => {
                    
                    let newScript = document.createElement('script');
                    for(let attr of oldScript.attributes){
                      
                      newScript.setAttribute(attr.name, attr.value);
                      // newScript.async = false;
                      if(oldScript.textContent){
                        newScript.textContent = oldScript.textContent;
                      }
                      console.log(attr)
                      oldScript.replaceWith(newScript);
                    }
                  })
                }
              }
              callback(html, tool);
            }
          })
          .catch(err => console.error(err));
      }
      return this;
    }

    /**
     * Executes a function only when the DOM loading has been completed or 
     * a selected element has been successfully loaded into the DOM.
     * @param {*} callback 
     * @returns 
     */
    onReady(callback) {
      if (typeof callback !== 'function') return this;

      this.elements.forEach(el => {
        const tag = el.tagName?.toLowerCase?.();

        if (!tag) return;

        // For media elements like <video> or <audio>
        if (tag === 'video' || tag === 'audio') {
          if (el.readyState >= 3) {
            callback.call(el); // already ready
          } else {
            el.addEventListener('loadeddata', () => callback.call(el), { once: true });
          }

        // For iframe, embed, object
        } else if (tag === 'iframe' || tag === 'embed' || tag === 'object') {
          el.addEventListener('load', () => callback.call(el), { once: true });

        // For images
        } else if (tag === 'img') {
          if (el.complete && el.naturalWidth > 0) {
            callback.call(el);
          } else {
            el.addEventListener('load', () => callback.call(el), { once: true });
          }

        // For everything else — run immediately
        } else {
          if (document.readyState === 'complete') {
            callback.call(el);
          } else {
            window.addEventListener('load', () => callback.call(el), { once: true });
          }
        }
      });

      return this;
    }

    /**
     * Run a foreach loop on each selected element
     * @param {*} callback 
     */
    each(callback){
      return this.elements.forEach((el, index, elements) => {
        callback(miDom(el), index, elements);
      })
    }
    
    /**
     * Some loop on each selected element which returns true when at least 
     * one test returns true.
     * @param {*} callback 
     */
    some(callback){
      return this.elements.some((el, index, list) => {
        return callback(miDom(el), index, list);
      })
    }

    /**
     * Run a map loop on each selected element
     * @param {*} callback 
     */
    map(callback){
      return this.elements.map((el, index, elements) => {
        return callback(miDom(el), index, elements);
      })
    }

    /**
     * Run an every loop on each selected element
     * @param {*} callback 
     */
    every(callback){
      return this.elements.every((el, index, elements) => {
        return callback(miDom(el), index, elements);
      })
    }

    /**
     * Run an filter loop on each selected element
     * @param {*} callback 
     */
    filter(callback){
      return this.elements.filter((el, index, elements) => {
        return callback(miDom(el), index, elements);
      })
    }

    /**
     * Resolves a criteria into the set of currently selected elements it targets.
     *  - Element/Node : the element itself
     *  - SSDom        : its selected elements
     *  - string       : selected elements matching the css selector
     *  - function     : selected elements for which predicate(miDom(el), i) is truthy
     *  - array        : the union of each entry resolved
     *  - plain object  : the union of each of its values resolved (enables {choice} shorthand)
     * @param {*} criteria
     * @returns {Set<Element>}
     */
    #resolveTargets(criteria) {
      const targets = new Set();
      if (criteria == null) return targets;

      if (typeof criteria === 'function') {
        this.elements.forEach((el, i) => { if (criteria(miDom(el), i, this.elements)) targets.add(el); });
      } else if (criteria instanceof SSDom) {
        criteria.elements.forEach(el => this.elements.includes(el) && targets.add(el));
      } else if (criteria instanceof Element || criteria instanceof Node) {
        if (this.elements.includes(criteria)) targets.add(criteria);
      } else if (typeof criteria === 'string') {
        this.elements.forEach(el => { if (el.matches?.(SSDom.expandQuery(criteria))) targets.add(el); });
      } else if (Array.isArray(criteria)) {
        criteria.forEach(c => this.#resolveTargets(c).forEach(el => targets.add(el)));
      } else if (typeof criteria === 'object') {
        Object.values(criteria).forEach(c => this.#resolveTargets(c).forEach(el => targets.add(el)));
      }

      return targets;
    }

    /**
     * Runs a callback for every selected element EXCEPT those matched by the criteria.
     *  - The matched elements are the "excluded" ones; the callback fires on the rest.
     *  - e.g. options.excludes({choice}, (option) => { ... }) skips `choice` and
     *    runs the callback on the remaining options.
     * @param {*} criteria element|SSDom|selector|function|array|object identifying what to exclude
     * @param {Function} callback optional, receives (miDom(el), index, elements) for each remaining element
     * @returns {SSDom} a new SSDom of the remaining (non-excluded) elements, for chaining
     */
    excludes(criteria, callback) {
      const excluded = this.#resolveTargets(criteria);
      const remaining = this.elements.filter(el => !excluded.has(el));

      if (typeof callback === 'function') {
        remaining.forEach((el, index) => callback(miDom(el), index, remaining));
      }

      return new this.constructor(remaining);
    }

    /**
     * Runs a callback for every selected element that IS matched by the criteria.
     *  - The inverse of excludes(): the callback fires only on the matched elements.
     *  - e.g. options.includes({choice}, (option) => { ... }) runs the callback on `choice`.
     * @param {*} criteria element|SSDom|selector|function|array|object identifying what to include
     * @param {Function} callback optional, receives (miDom(el), index, elements) for each matched element
     * @returns {SSDom} a new SSDom of the matched (included) elements, for chaining
     */
    includes(criteria, callback) {
      const included = this.#resolveTargets(criteria);
      const matched = this.elements.filter(el => included.has(el));

      if (typeof callback === 'function') {
        matched.forEach((el, index) => callback(miDom(el), index, matched));
      }

      return new this.constructor(matched);
    }

    /**
     * Plucks the SSDom object of a specifed element.
     * @param {*} index
     * @returns
     */
    eq(index) {
      if (typeof index !== 'number') return new this.constructor([]);
      const el = this.elements[index];
      return new this.constructor(el ? [el] : []);
    }


    /**
     * Specifies a maximum time for which an element must be completely loaded 
     * and a callback function that runs if after the elapsed time or if the element was loaded
     */
    timedLoad(timeout, callback) {
      if (typeof callback !== 'function' || typeof timeout !== 'number') return this;
      this.elements.forEach(el => {
        let resolved = false;

        const timer = setTimeout(() => {
          if (!resolved) {
            resolved = true;
            callback.call(el, false); // Not ready within timeout
          }
        }, timeout);
        
        // Use .onReady() method (wrap per element)
        new this.constructor([el]).onReady(() => {
          if (!resolved) {
            resolved = true;
            clearTimeout(timer);
           callback.call(el, true); // Ready within timeout
          }
        });
      });

      return this;
    }

    /**
     * Retrieves the index of an element from the SSDom object list
     * @param {*} elem 
     * @returns 
     */
    index(elem) {
      if (!elem) return -1;
      const target = elem instanceof Element ? elem : elem instanceof this.constructor ? elem.elements[0] : null;
      if (!target) return -1;

      return this.elements.findIndex(el => el === target);
    }

    /**
     * Returns the total length of selected objects.
     *  - This will return undefined if no element is found.
     */
    get length() {
      return this.elements.length;
    }
}
export function miDom(selector, context = document){
  return new SSDom(...arguments);
}
export default SSDom;