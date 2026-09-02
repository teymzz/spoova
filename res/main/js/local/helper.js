import { SPAuto } from "./autoload/SPAuto.js";

class Helper {

    constructor(type) {

        if(type === 'list'){
            return Object.getOwnPropertyNames(Helper.prototype).filter(name => name !== 'constructor');
        }

    }

    /**
     * Checks if a string supplied is in json format
     * 
     * @param {string} textString a defined string 
     * @return {boolean}
     */
    static isJSON(string) {
        let is_json = true;
        try {
            JSON.parse(string);
        } catch (err) {
            is_json = false;
        }
        return is_json;
    }

    /**
     * check if a value is in range of two numbers
     * 
     * @param {number} $value test value
     * @param {number} $min minimum value
     * @param {number} $max maximum value
     * 
     * @returns {boolean}
     */
    static inRange($value, $min, $max){
        return (($min <= $value) && ($value <= $max)); 
    }



    //CLASS FUNCTIONS: THESE FUNCTIONS DEPENDS ON USE OF ATTRIBUTES SELECTOR TO MANIPULATE DOM ELEMENTS
            
    /**
     * Check if an element has an attribute
     * 
     * @param {string} elem element selector
     * @param {string} attr name of attribute to be checked
     * 
     * @returns {boolean}
     */
    static hasAttr(elem, attr) {

        elem = toSelectionArray(elem); 

        if(elem.length === 0){
            console.error('hasAttr: no selected element found')
            return false;
        }
        if(elem.length > 1){
            console.error('hasAttr: function can only be applied on a single element')
            return false;
        }
        
        for(let i = 0; i <= 0; i++){
            elem = elem[i];
            return elem.hasAttribute(attr)
        }


        return false;

    }


    /**
     * converts plain css format to an object format
     * adds style to selector element.
     * 
     * @param {string} arg1 css text string or selector 
     *  - If arg1 only is supplied, use as element selector
     *  - If arg2 is supplied arg1 is used as element selector
     * @param {string} arg2 css text string when both arguments are supplied
     */
    static cssFormat(arg1, arg2){

        let css; // css object container
        
        if((typeof arg1 === 'string' && arg2 === undefined) || 
            (typeof(arg2) === 'string')
        ){
            let cssText = (arg2 === undefined)? arg1 : arg2;
            let cssObj  = cssText.split(";"); 
            css = {};

            cssObj.forEach(obj => {
                prop = obj.split(":");
                if (prop.length == 2){
                    css[prop[0].trim()] = prop[1].trim();            
                }
            })
        } else if (typeof arg2 === 'object') {
            css = arg2;
        }
        
        if((arg2 !== undefined) && (arg1 != null) && (css)){
            setTimeout(()=>{
                let element;

                if(typeof arg1 === 'object'){
                    element = arg1;
                }else if(typeof arg1 === 'string'){
                    element = document.querySelector(arg1);
                }
                
                if(element != null){
                    Object.assign(element.style, css);
                }            
            })
        }

        if(css) return css;
    }

    /**
     * Redirects a page to another 
     * 
     * @param {string} param optional [:this|url]
     *          - ':this' => redirect to the current page
     *          - 'url'  => redirect to a custom url
     *          - undefined => use current page url
     * @param {number} delay timeout to execution
     */
    static rdPage(param, delay = 0) {

        let calltime = (delay == null) ? 0 : delay;

        setTimeout(function() {
            if (param == ":this" || param == undefined || param == null) {
                window.location.reload();
            } else {

                window.location.href = param;

            }
        }, delay);

    }

    /**
     * 
     * @param {string} id id of element to be copied
     * @param {function} callback 
     */
    static copy(id, callback) {  
        let field;

        if(typeof id === 'object'){
            field = id
        }else{
            field = document.getElementById(id);
        }
    
        if (!navigator.clipboard) {
            // fallback for browsers that don't support clipboard API
            const range = document.createRange();
            range.selectNode(field);
            window.getSelection().removeAllRanges();
            window.getSelection().addRange(range);
            document.execCommand('copy');
            window.getSelection().removeAllRanges();
        } else {
            navigator.clipboard.writeText(field.value || field.innerText);
        }
        
        if (typeof callback === 'function') {
            callback(field);
        }
    }

    /**
     * This function depends on attribute selector. 
     * It either fetches the current url's hash value or 
     * performs a click event on an element that contains a value 
     * that is equivalent to the current url's hash value
     * 
     * 
     * @param {boolean|string} $type defines the value returned
     * 
     *   - When set as true or ":get", it returns the current hash value. 
     *   - When an attribute name is supplied, it performs click event on any element having such 
     *     attribute and a value that is equialent to the current url's hash value.
     * @param {function} $callback if defined the callback will overide the default click event
     * @returns 
     */
    static hashRunner($type, $callback, timeout = 0) {

        if (window.location.hash) {

            setTimeout(() => {

                let $selector;
                let hashItem = window.location.hash.substring(1);
    
                if ($type === ":get" || $type === true) {
                    
                    return hashItem;
                    
                } else {
                    $selector = '[' + $type + '~="' + hashItem + '"]';
    
                    setTimeout(() => { 
    
                        let selections = document.querySelectorAll($selector);
    
                        selections.forEach(selection => {
                            if($callback){
                                if(typeof $callback === 'function'){
                                    $callback({
                                        get: () => selection, // return selection
                                        scrollTop: (margin = 0, behavior = 'smooth') => {
                                            let top = selection.offsetTop - margin;
                                            window.scrollTo({top, behavior})
                                        },
                                        scrollLeft: (margin = 0, behavior = 'smooth') => {
                                            let left = selection.offsetLeft - margin;
                                            window.scrollTo({left, behavior})
                                        },
                                        scroll: (margin, behavior = 'smooth') => {
                                            let marginLeft = (typeof margin === 'object')? (margin['left'] || 0) : 0;
                                            let marginTop = (typeof margin === 'object')? (margin['top'] || 0) : 0;

                                            let left = selection.offsetLeft - marginLeft;
                                            let top = selection.offsetTop - marginTop;
                                            window.scrollTo({left, top, behavior})
                                        },
                                        scrollItem: (callback) => {
                                            callback({
                                                scrollTop: (margin = 0, behavior = 'smooth') => {
                                                    let top = selection.scrollTop + margin;
                                                    selection.scrollTo({top, behavior})
                                                },
                                                scrollLeft: (margin = 0, behavior = 'smooth') => {
                                                    let left = selection.scrollLeft + margin;
                                                    selection.scrollTo({left, behavior})
                                                },
                                                scroll: (margin, behavior = 'smooth') => {
                                                    let marginLeft = (typeof margin === 'object')? (margin['left'] || 0) : 0;
                                                    let marginTop = (typeof margin === 'object')? (margin['top'] || 0) : 0;

                                                    let left = selection.scrollLeft + marginLeft;
                                                    let top = selection.offsetTop + marginTop;
                                                    selection.scrollTo({left, top, behavior})
                                                }
                                            })
                                        }
                                    })
                                }
                            } else {
                                selection.click();
                            }
                        })
    
                    });
                }
            }, timeout)
        }

    }



    /**
     * This function enables elements with data-scroll attibutes 
     * to control the vertical scroll position of a web page using predefined 
     * attributes for controlling the scroll positional increase or decrease 
     * @returns void
     */
    static dataScroll(callback) {
        // Check if there are any elements with the data-scroll attribute
        if (document.querySelectorAll('[data-scroll]').length < 1) { 
            return false; 
        }

        // Add click event listeners to elements with the data-scroll attribute
        document.querySelectorAll('[data-scroll]').forEach(function(element) {
            element.addEventListener('click', function(e) {
                var point = element.getAttribute("data-scroll");
                var dataPlus = element.getAttribute("data-plus");
                var dataMinus = element.getAttribute("data-minus");
                var dataDelay = parseInt(element.getAttribute("data-delay") || 50, 10);

                e.preventDefault();
                
                var scrollIncrease = isNaN(parseFloat(dataPlus)) ? 0 : parseFloat(dataPlus);
                var scrollDecrease = isNaN(parseFloat(dataMinus)) ? 0 : parseFloat(dataMinus);
                var scrollOffset = 0;

                var targetElement = document.getElementById(point);
                if (targetElement) {
                    scrollOffset = targetElement.getBoundingClientRect().top + window.scrollY;
                }

                var newTarget = scrollOffset + scrollIncrease - scrollDecrease;

                if (scrollOffset !== 0) {
                    // Smooth scroll function with callback
                    var startPosition = window.scrollY;
                    var distance = newTarget - startPosition;
                    var duration = dataDelay; // duration in milliseconds
                    var startTime = null;

                    function animation(currentTime) {
                        if (startTime === null) startTime = currentTime;
                        var timeElapsed = currentTime - startTime;
                        var run = easeInOutQuad(timeElapsed, startPosition, distance, duration);
                        window.scrollTo(0, run);
                        if (timeElapsed < duration) {
                            requestAnimationFrame(animation);
                        } else {
                            if (callback) callback(); // Execute callback function if provided
                        }
                    }

                    function easeInOutQuad(t, b, c, d) {
                        t /= d / 2;
                        if (t < 1) return c / 2 * t * t + b;
                        t--;
                        return -c / 2 * (t * (t - 2) - 1) + b;
                    }

                    requestAnimationFrame(animation);
                }
            });
        });
    }

    /**
     * This function is mostly used along with the html "a" tags having the 
     * data-scroll-hash attribute. It is used to scroll to the html element whose id attribute 
     * is equivalent to the current or updated hashstring of a web page's url address.
     *  - This function is also capable of being used as an alternative for the dataScroll() helper function.
     * 
     * @param {function} callback triggers when animation is complete
     * @returns 
     */
    static dataScrollHash(callback) {
        if (document.querySelectorAll('[data-scroll-hash]').length < 1) {
            return false;
        }

        document.querySelectorAll('[data-scroll-hash]').forEach(function(element) {
            element.addEventListener('click', function(e) {
                var dataPlus = element.getAttribute("data-plus");
                var dataMinus = element.getAttribute("data-minus");
                var scrollOffset = 0;

                if (window.scrollY != 0) {
                    setTimeout(function() {
                        window.scrollTo(0, 0);
                    }, 1);
                }

                var dataDelay, point;
                if (element.getAttribute("href")) {
                    if (window.location.hash.substring(1) == element.getAttribute("href").substring(1)) {
                        e.preventDefault();
                    }

                    dataDelay = parseInt(element.getAttribute("data-delay") || 2000, 10);
                    point = element.getAttribute("href").split("#")[1];
                } else {
                    e.preventDefault();
                    dataDelay = parseInt(element.getAttribute("data-delay") || 50, 10);
                    point = element.getAttribute("data-scroll-hash");
                }

                var scrollIncrease = isNaN(parseFloat(dataPlus)) ? 0 : parseFloat(dataPlus);
                var scrollDecrease = isNaN(parseFloat(dataMinus)) ? 0 : parseFloat(dataMinus);

                var targetElement = document.getElementById(point);
                if (targetElement) {
                    scrollOffset = targetElement.getBoundingClientRect().top + window.scrollY;
                }

                var newTarget = scrollOffset + scrollIncrease - scrollDecrease;

                // Smooth scroll function with callback
                var startPosition = window.scrollY;
                var distance = newTarget - startPosition;
                var duration = dataDelay; // duration in milliseconds
                var startTime = null;

                function animation(currentTime) {
                    if (startTime === null) startTime = currentTime;
                    var timeElapsed = currentTime - startTime;
                    var run = easeInOutQuad(timeElapsed, startPosition, distance, duration);
                    window.scrollTo(0, run);
                    if (timeElapsed < duration) {
                        requestAnimationFrame(animation);
                    } else {
                        if (callback) callback(); // Execute callback function if provided
                    }
                }

                function easeInOutQuad(t, b, c, d) {
                    t /= d / 2;
                    if (t < 1) return c / 2 * t * t + b;
                    t--;
                    return -c / 2 * (t * (t - 2) - 1) + b;
                }

                requestAnimationFrame(animation);
            });
        });
    }

    /**
     * This function helps to toggle an attribute's value within an element.
     * @param {string} elem element selector
     * @param {string} value value to be toggeled
     * @param {string} attr attribute which value is expected to be toggled
     * @param {function} callBack a callback function executed with callFunc() which must be an array e.g ['function','param','param',...] 
     */
    static toggleAttr(elem, value, attr, callBack) {
        
        elem = toSelectionArray(elem);

        if(elem){

            elem.forEach(selection => {  

                selection.addEventListener('click', function(){

                    if (attr == null) { attr = 'class'; }

                    if (attr == 'class') {
                        var active = selection.classList.contains(value);
                        if (active == true) {
                            selection.classList.remove(value);
                        } else if (active == false) {
                            selection.classList.add(value)
                        }
                    } else {
                        var active = selection.getAttribute(attr);
                        if (active == value) {
                            selection.setAttribute(attr, '');
                        } else if (active == false) {
                            selection.setAttribute(attr, value);
                        }
                    }

                    if (Array.isArray(callBack)) {
                        const allparams = [...callBack];
                        var func = allparams.splice(0, 1);
                        func = func[0];
                        var isActive = (active) ? false : true;
                        var actv = [isActive];
                        var params = [...actv, ...allparams];

                        var newCallBack = [func, params];
                        callFunc(newCallBack);
                    }
                    
                })

            })

        }

    }


    /**
     * Show device width or height in console on browser resize
     * 
     * @param {string} type optional [all|width|height)
     *  - all: displays both the width and height
     *  - width: displays only the width
     *  - height: displays only the height
     */
    static devMedia(type) {
        type = type || 'width'

        $(window).on('resize', function() {
            switch (type) {
                case "all":
                console.log(`width: ${window.innerWidth}px, height: ${window.innerHeight}px`);
                break;
                case "width":
                console.log(`width: ${window.innerWidth}px`);
                break;
                case "height":
                console.log(`height: ${window.innerHeight}px`);
                break;
                default:
                console.error("Invalid type");
            }
            
        })
    }

    /**
     * This function returns the date
     * 
     * @param {string} type optional [year|month|day|hour|min|sec|milli|time|full]
     *  - If type is not defined, it returns the full date 
     */
    static getDate(type) {
        var ref = new Date();
        
        if (type === 'ref') { return ref; } 
        if (type === 'year') { return ref.getFullYear() }
        if (type === 'month') { return ref.getMonth() }
        if (type === 'day') { return ref.getDay() }
        if (type === 'date') { return ref.getDate() }
        if (type === 'hour') { return ref.getHours() }
        if (type === 'min') { return ref.getMinutes() }
        if (type === 'sec') { return ref.getSeconds() }
        if (type === 'milli') { return ref.getMilliseconds() }
        if (type === 'full' || (type === undefined)) { 
            return parseInt(ref.getFullYear()
                +''+ref.getMonth()
                +''+ref.getDay()
                +''+ref.getDate()
                +''+ref.getHours()
                +''+ref.getMinutes()
                +''+ref.getSeconds()
                +''+ref.getMilliseconds(), 10);
        }
        if (type == 'time') { return Math.floor(ref.getTime() / 1000) }
    }

    /**
     * This function is used to call other functions.
     * 
     * @param {Array} callback callback array list of functions to be called 
     *  - Syntax: Array ['func', 'param', 'param', ...]. Where "func" as function name, "param" as parameters
     * 
     * @param {number} timeout delay time for function to be executed
     */
    static callFunc(callback, timeout) {

        if (Array.isArray(callback)) {
            let callfunc = callback[0];
            let fn = window[callfunc];
            let value;

            if (typeof fn === 'function') {
                if (callback[1] != undefined) {
                    let callParams = callback[1];

                    if (timeout != undefined) {
                        setTimeout(function() {
                        value = window[callfunc](...callParams);
                        });
                    } else {
                    value = window[callfunc](...callParams);
                    }

                } else {
                    if (timeout != undefined) {
                        setTimeout(function() {
                        value = window[callfunc]();
                        });
                    } else {
                    value = window[callfunc]();
                    }
                }
                return value;
            }
        }
    }
    /**
     * This function allows safe loading of function
     * functions that does not exists without
     * returning an error. When they exist, they will be initialized
     * 
     * @param {function} callback (a string having no arguments or) an array with 
     * the first value as the function name and the other values (optional) as arguments 
     *  - Syntax: initFunc(['func_name', arg, arg,...])
     */
    static initFunc(callback) {
        var isArray = Array.isArray(callback);
        var callfunc, fn, callParams;

        if (isArray) {
            callfunc = callback[0];
            fn = window[callfunc];
            if (callback[1] != undefined) { callParams = callback[1]; }
        } else {
            fn = window[callback];
        }

        if (typeof fn === 'function') {
            (callParams != undefined) ? window[callfunc](...callParams): window[callback]();
        }
    }

    /**
     * This function uses the custom initFunc load multiple functions.
     *  
     * @param array array of functions or function names to be loaded.
     *  - Syntax: loadFuncs([ ['func_1', 'arg'], 'func_2', ['func_3','arg'], ...])
     * 
     * @param {number} timeout delay before all specified functions are executed.
     *
     */
    static loadFuncs(array, timeout) {
        timeout = timeout || 0

        setTimeout(() => {
            for (var i = 0; i < array.length; i++) {
                initFunc(array[i]);
            }
        }, timeout)
    }

    /**
     * This function performs a global scope event calling
     * Works with dynamically generated elements
     * @param {string} event eventListener name 
     * @param {string} selector element selector
     * @param {function} callback callback function
     */
    static superCall(event, selector, callback) {

        let value;
        if (!selector) { console.error('no selector defined'); }
        if (!callback) { console.error('no callback defined'); }

        document.addEventListener(event, e => {
            if (e.target.matches(selector)) value = callback(e);
        })

        return value;

    }
}

export default SPAuto(Helper);