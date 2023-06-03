/**
 * This file contains helper core functions, used
 * in the development of this framework some of which are jquery dependent
 */


/**
 * This function allows safe loading of function
 * functions that does not exists can be loaded without
 * returning an error. When they exist, they will be initialized
 * 
 * @param callback (a string having no arguments or) an array with 
 * the first value as the function name and the other values (optional) as arguments
 */
 function initFunc(callback) {
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
    //sample function safe load
    //initFunc(['func_name',param,param,...]) //args
    //initFunc(['func_name']) //no args
}

/**
 * This function depends on initFunc to load multiple functions 
 * @param array array of functions or function names that can be loaded
 * by initFunc. 
 * 
 * note: timeout suppied will be applied to all functions loaded
 */
function loadFuncs(array, timeout) {
    timeout = timeout || 0

    setTimeout(() => {
        for (var i = 0; i < array.length; i++) {
            initFunc(array[i]);
        }
    }, timeout)

    //sample
    //loadFuncs(['func_1','func_2']); //funcs no args
    //loadFuncs([['func_1', 'arg'],'func_2']); //funcs with and without args
}

/**
 * This function performs a global scope event calling
 * Works with dynamically generated elements
 * @param {*} event eventListener name 
 * @param {*} selector element selector
 * @param {*} callback callback function
 */
 function superCall(event, selector, callback) {

    if (!selector) { console.error('no selector defined'); }
    if (!callback) { console.error('no callback defined'); }

    document.addEventListener(event, e => {
        if (e.target.matches(selector)) callback(e);
    })

}

/**
 * This function is used to call other functions
 * syntax is callFunc(['function_name','function_param','function_param',...])
 * @param {Array} callback callback Array ['func', 'param', 'param', ...]: "func" as function name, "param" as function's parameters
 * @param {int} timeout delay time for function to be executed
 */
function callFunc(callback, timeout) {

    //var callBack = (callBack === undefined)? null : callBack;
    if (Array.isArray(callback)) {
        var callfunc = callback[0];
        var fn = window[callfunc];

        if (typeof fn === 'function') {
            if (callback[1] != undefined) {
                var callParams = callback[1];

                if (timeout != undefined) {
                    setTimeout(function() {
                        window[callfunc](...callParams);
                    });
                } else {
                    window[callfunc](...callParams);
                }

            } else {
                if (timeout != undefined) {
                    setTimeout(function() {
                        window[callfunc]();
                    });
                } else {
                    window[callfunc]();
                }
            }
        }
    }
}

/**
 * Checks if a string supplied is in json format
 * 
 * @param {string} textString a defined string 
 * @return {boolean}
 */
 function isJSON(textString) {
    var is_json = true;
    try {
        $.parseJSON(textString);
    } catch (err) {
        is_json = false;
    }
    return is_json;
}

/**
 * This function is used by ajaxUri to map urls function.
 * It is required by core functions and should not be removed
 * @param {*} $url http(s) protocol url (domain url)
 */
 function urlenv($url) {

    let $urlext, $sp, $spl;

    if (typeof EXT == 'undefined') {
        EXT = '';
    }

    $urlext = EXT.toLowerCase();
    $url = $url.toString();
    $url = $url.split('?')[0].split("#")[0];
    $sp = $url.split('.');
    $spl = $sp.length;

    if (($spl === 1 || ($sp[0] === '' && $spl === 2)) && $urlext !== '') {
        $lastpop = $sp[0].split('/').pop() == '' ? 'index' : '';
        $url = $url + $lastpop + '.' + $urlext;
    }

    return $url;
}

/**
 * This function returns the date
 * 
 * @param {*} type string (types: year, month, day, hour, min, sec, milli, full)
 * @param {*} type undefined: return the full date
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


/**
 * This converts ajax complete method's response to json format 
 * having success, error and message keys. The "complete" response returned 
 * is stored in json "message" key as either string or json format.
 * 
 * @param {*} response - xmlHttpRequest complete method's response
 */
 function ajaxResponder(response) {
    var data = [];

    if (response.status === 200) {
        if (isJSON(response.responseText)) {
            data = { "success": "true", "type": "200", "message": JSON.parse(response.responseText) };
        } else {
            data = { "error": "parse error", "type": "response", "message": response.responseText };
        }
    } else {
        data = { "error": response.status+" error", "type": response.status, "message": response.responseText };
    }

    return data;
}


/**
 * This function is used to reformat a url supplied
 * 
 * @param {*} url The supplied url address
 */
function ajaxUri(url) {

    let online = (location.hostname != "localhost");
    let proUrl = window.location.pathname
    let proSplit = proUrl.split('/');
    let proBase = proSplit[1];
    let proBase2 = (proSplit.length > 2) ? proSplit[2] : '';
  
    proBase2 = (proBase2 != '') ? '/' + proBase2 : '';
    proBase += proBase2;
  
    let http = online ? 'https://' : 'http://' + location.host + '/';
  
    url = url || '';
    if (url != '') {
        url = urlenv(url);
        let newUrl = window.decodeURIComponent(url);
        newUrl = newUrl.trim().replace(/\s/g, '');
  
        if (/^(f|ht)tps?:\/\//i.test(newUrl)) {
            return `${newUrl}`;
        } else {
            if (online) {
                newUrl = newUrl.split('/')[1];
            }
            if (newUrl.charAt(0) == "/") newUrl = string.substring(1);
            return http + proBase + `/${newUrl}`;
        }
    }
    return false;
  
  }


/**
 * 
 * @param {*} param [:this|url]
 *          - ':this' => redirect to the current page
 *          - 'url'  => redirect to a custom url
 *          - undefined => use current page url
 * @param {*} delay timeout to execution
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
 * check if a value is in range of two numbers
 * 
 * @param {*} $value test value
 * @param {*} $min minimum value
 * @param {*} $max maximum value
 * 
 * @returns {boolean}
 */
function inRange($value, $min, $max){
    return (($min <= $value) && ($value <= $max)); 
}

/* JQUERY DEPENDENT CORE FUNCTIONS */

//CLASS FUNCTIONS: THESE FUNCTIONS DEPENDS ON USE OF CLASSES TO MANIPULATE DOM ELEMENTS
        
/**
 * Check if an element has an attribute
 * 
 * @param {*} elem element selector
 * @param {*} attr name of attribute to be checked
 */
function hasAttr(elem, attr) {

    elem = toSelectionObject(elem);

    if(elem) {
        elem = elem[0];
        return elem.hasAttribute(attr)
    }

}


/**
 * Copy a text
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
 * This function is a page url's hash controller
 * 
 * @param {*} $type 
 *   - $type = ":get" => get the current hash in your url
 *   - $type = "id" => click the element having the relative id of the hash in your url 
 *   - $type = "class" => click the element having the relative class of the hash in your url 
 *   - $type = "data-id" => click any element having the attibute of data-id with the value of the hash in your url

* @returns 
*/
function hashRunner($type) {

    if (window.location.hash) {

        let $selector;
        let hashItem = window.location.hash.substring(1);

        if ($type == ":get") {
            
            return hashItem;
            
        } else {
            if ($type == "class" || $type == "id") {
                $selector = $type == "class" ? "." : "#";
                $selector = $selector + hashItem;
            } else {
                $selector = '[' + $type + '="' + hashItem + '"]';
            }
            setTimeout(() => { 

                let selections = document.querySelectorAll($selector);

                selections.forEach(selection => {
                    selection.click();
                })

            });
        }
    }

}