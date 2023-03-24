/**
 * This file contains jquery dependent functions
 * The core functions are listed above the non-essential functions
 */

/**
 * Jquery Dependent: Check if an element has an attribute
 * @param {*} elem element selector
 * @param {*} attr name of attribute to be checked
 */
 function hasAttr(elem, attr) {
    var attrb = $(elem).attr(attr);
    if (typeof attrb !== typeof undefined && attr != false) {
        return true;
    } else {
        return false;
    }
}


/*The following custom functions are important functions for manipulating some dom elements*/

//This function helps to close a form.
//@param element: element selector
//@param bool 'false': close element
//@param bool 'true': show element 
function popbox(element, bool, callBack) {
    if (bool == true || bool == "true") {
        $(element).fadeIn(500, function() { callFunc(callBack); });
    } else {
        $(element).fadeOut(500, function() { callFunc(callBack); });
    }
}

//This function helps to toggle an attribute's value within an element.
//@param elem: element selector
//@param value: value to be toggled
//@param attr: attribute which value is expected to be toggled
//@param callback: a callback function executed with callFunc() which must be an array e.g ['function','param','param',...]
function toggleAttr(elem, value, attr, callBack) {
    $(elem).on('click', function() {
        if (attr == null) { attr = 'class'; }

        if (attr == 'class') {
            var active = $(elem).hasClass(value);
            if (active == true) {
                $(elem).removeClass(value);
            } else if (active == false) {
                $(elem).addClass(value)
            }
        } else {
            var active = $(elem).attr(attr);
            if (active == value) {
                $(elem).attr({ attr: '' });
            } else if (active == false) {
                $(elem).attr({ attr: value })
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

}