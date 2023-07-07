/**
 * This file contains core helper in-built functions, used
 * in the development of this framework.
 */

/**
 * This function helps to blend Jquery selector with the native javascript selector.
 * 
 * @param {string|object} selector converts a selector or Jquery object to array format.
 * 
 * @returns 
 */
function toSelectionArray(selector){
    let element = typeof selector;
    if(element === 'object'){
        selector = selector
    }else if(element === 'string'){
        selector = document.querySelectorAll(selector)
    }
    if(selector){
        if(!selector.length){
            selector = [selector];
        }else if(!Array.isArray(selector)){
            let selects = [] 
            for(const key in selector){
                if(selector.hasOwnProperty(key)){
                    if(selector[key].childNodes){
                        selects.push(selector[key]);
                    }
                }
            }
            selector = selects;
        }
    }  
    return selector;
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
function loadFuncs(array, timeout) {
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
 function superCall(event, selector, callback) {

    let value;
    if (!selector) { console.error('no selector defined'); }
    if (!callback) { console.error('no callback defined'); }

    document.addEventListener(event, e => {
        if (e.target.matches(selector)) value = callback(e);
    })

    return value;

}

/**
 * This function is used to call other functions.
 * 
 * @param {Array} callback callback array list of functions to be called 
 *  - Syntax: Array ['func', 'param', 'param', ...]. Where "func" as function name, "param" as parameters
 * 
 * @param {number} timeout delay time for function to be executed
 */
function callFunc(callback, timeout) {

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