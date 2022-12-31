
/**
 * This file contains custom helper functions
 * which are mostly jquery dependent. 
 */

//reduces autocomplete of forms
function hardFormFill(){
  setTimeout(() => {
    var inputs = $('form[autocomplete="off"]').find(':input:not(:button)')
      inputs.on('input copy paste', function(e){
          e.preventDefault(); 
          return false;
      })
      
    //   inputs.attr({'readonly':'readonly'});
      $('.flex-ico, div.i-flex-full').click(function(){
        let parent = $(this).closest('.i-flex-full')
        parent.find(':input:not([data-read="false"])').removeAttr('readonly').focusout(function(){
        //   $(this).attr({'readonly':'readonly'});
        })
      })    
  })
}

/**
 * converts plain css format to an object format
 * adds style to selector element
 * @param {*} arg1 css text string (or element selector when arg2 is supplied)
 * @param {*} arg2 css text string when both arguments are supplied
 */
function cssFormat(arg1, arg2){

    let cssText = (arg2 === undefined)? arg1 : arg2;
    
    let cssObj = cssText.split(";");
    let css = {};
    cssObj.forEach(obj => {
        prop = obj.split(":");
        if (prop.length == 2){
            css[prop[0].trim()] = prop[1].trim();            
        }
    })
    
    if(arg2 !== undefined && arg1 != null){
        setTimeout(()=>{
            element = document.querySelector(arg1);
            
            if(element != null){
                Object.assign(element.style, css);
            }            
        })
    }

    if(css) return css;
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


/**
 * This function helps to toggle an attribute's value within an element.
 * 
 * @param {*} elem element selector
 * @param {*} value value to be toggled
 * @param {*} attr attribute which value is expected to be toggled
 * @param {*} callBack a callback function executed with callFunc() which must be an array e.g ['function','param','param',...]
 */
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

//This function is a typeWriter animation for texts
function typeWrite(selector,settings){
        
    let i = 0;
    let field = document.querySelector(selector);
    let txt = field.innerHTML;
    field.innerHTML = "";
    let speed, attributes, init, final;
    let styleAttr = "";

    if(typeof settings === "object"){
        speed = settings.speed;
        init = settings.init || 0;
        final = settings.final  || txt.length
        if(final >= txt.length) final = txt.length - 1; 

        delete settings.speed;
        delete settings.init;
        delete settings.final;

        let color = settings.color;
        let bgcolor = settings.bgcolor;
        let style = settings.style;

        if(style == undefined){
            if(color != undefined || bgcolor != undefined){
                if(color != undefined){
                    styleAttr += "color:"+color+";"
                }
                if(bgcolor != undefined){
                    styleAttr += "background-color:"+bgcolor+";"
                }                   
            }
        }else{
            styleAttr = style;
        }

        if(styleAttr != ""){
            styleAttr = " style=\""+styleAttr+"\" "; 
        }

        //other attributes
        if(settings.color) delete settings.color;
        if(settings.bgcolor) delete settings.bgcolor;
        if(settings.style) delete settings.style;
        
        for(let [key, value] of Object.entries(settings)){
            attributes += " "+key+"=\""+value+"\""
        }

        attributes += styleAttr;
        

    }

    speed = speed || 50;
    let item = "";
    
    function type() { 
      
      if (i < txt.length) {
        if(attributes != undefined){
          if(init === i){
            item += "<span "+attributes+">"; 
          }
        }
        item += txt.charAt(i);

        if(attributes != undefined){
            field.innerHTML += "</span>"; 
        }

        field.innerHTML  = item;      

        i++;
        setTimeout(type, speed);
      }
    }

    type();
  
}


//This function works along with any element having the attribute of id="page".
//It prevents the visibility of a page until it is successfully loaded 
function showPage() {
    (function() {
        setTimeout(function() { $(".web-hide").css({ "visibility": "visible" }); }, 100);
        setTimeout(function() { $(".onload-visible").css({ "visibility": "visible" }); }, 200);
    })();
}


/**
 * Show device width or height in console on browser resize
 * @param {*} type (options: all | width | height)
 */
function devMedia(type) {
    type = type || 'width'

    $(window).on('resize', function() {
        type == "all" ? console.log("width: " + $(window).width(), "height: " + $(window).height()) : '';
        type == "width" ? console.log("width: " + $(window).width()) : '';
        type == "height" ? console.log("height: " + $(window).height()) : '';
    })
}

/**
 * JQuery Dependent: Works with attribute ('[data-view="morelink"]'). Helps to contract or expand texts
 * The attribute disp-text declares the number of text visible at once e.g disp-text="200";
 * This class is used directly with the text's immediate parent element
 */
function readmore() {

    var ellipsestext = "...";
    var moretext = "more";
    var lesstext = "less";

    $('.hide-more').each(function() {
        var content = $(this).html();
        var showChar = $(this).attr("disp-text");
        if (content.length > showChar) {
            var c = content.substr(0, showChar);
            var h = content.substr(showChar, content.length - showChar);
            var html = c + '<span class="moreellipses">' + ellipsestext + '&nbsp;</span><span class="morecontent"><span>' + h + '</span>&nbsp;&nbsp;<a href="" class="morelink">' + moretext + '</a></span>';
            $(this).html(html);
        }
    });

    $('[data-view="morelink"]').click(function() {
        if ($(this).hasClass("less")) {
            $(this).removeClass("less");
            $(this).html(moretext);
        } else {
            $(this).addClass("less");
            $(this).html(lesstext);
        }
        $(this).parent().prev().toggle();
        $(this).prev().toggle();
        return false;
    });
}


/**
 * Copy a text
 */
function copy(id, callback) {  
  /* Get the text field */
  var field = document.getElementById(id);

  /* Select the text field */
  field.select();
  field.setSelectionRange(0, 99999); /* For mobile devices */

   /* Copy the text inside the text field */
  navigator.clipboard.writeText(field.value);
  document.execCommand('copy')
  
  window[callback](field) 
  /* Alert the copied text */

}