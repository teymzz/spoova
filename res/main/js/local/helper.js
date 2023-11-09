
/**
 * Checks if a string supplied is in json format
 * 
 * @param {string} textString a defined string 
 * @return {boolean}
 */
function isJSON(string) {
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
function inRange($value, $min, $max){
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
function hasAttr(elem, attr) {

    elem = toSelectionObject(elem);

    if(elem) {
        elem = elem[0];
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
function cssFormat(arg1, arg2){

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
function rdPage(param, delay = 0) {

    calltime = (delay == null) ? 0 : delay;

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
function copy(id, callback) {  
    const field = document.getElementById(id);
  
    if (!navigator.clipboard) {
      // fallback for browsers that don't support clipboard API
      const range = document.createRange();
      range.selectNode(field);
      window.getSelection().removeAllRanges();
      window.getSelection().addRange(range);
      document.execCommand('copy');
      window.getSelection().removeAllRanges();
    } else {
      navigator.clipboard.writeText(field.value);
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
 function hashRunner($type, $callback) {

    if (window.location.hash) {

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
                            $callback()
                        }
                    } else {
                        selection.click();
                    }
                })

            });
        }
    }

}

/**
 * This function helps to toggle an attribute's value within an element.
 * @param {string} elem element selector
 * @param {string} value value to be toggeled
 * @param {attr} attr attribute which value is expected to be toggled
 * @param {function} callBack a callback function executed with callFunc() which must be an array e.g ['function','param','param',...] 
 */
function toggleAttr(elem, value, attr, callBack) {
    
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
function devMedia(type) {
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
 * @param {string} type optional [year|month|day|hour|min|sec|milli|full]
 *  - If type is not defined, it returns the full date 
 */
function getDate(type) {
    var ref = new Date();
    
    if (type == 'ref') { return ref; } 
    if (type == 'year') { return ref.getFullYear() }
    if (type == 'month') { return ref.getMonth() }
    if (type == 'day') { return ref.getDay() }
    if (type == 'date') { return ref.getDate() }
    if (type == 'hour') { return ref.getHours() }
    if (type == 'min') { return ref.getMinutes() }
    if (type == 'sec') { return ref.getSeconds() }
    if (type == 'milli') { return ref.getMilliseconds() }
    if (type == 'full' || type == null) { return Math.floor(ref.getTime() / 1000) }
}