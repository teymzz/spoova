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
    if (bool === true || bool === "true") {
      element.style.display = "block";
      var opacity = 0;
      var interval = setInterval(function() {
        opacity += 0.1;
        element.style.opacity = opacity;
        if (opacity >= 1) {
          clearInterval(interval);
          callFunc(callBack);
        }
      }, 50);
    } else {
      var opacity = 1;
      var interval = setInterval(function() {
        opacity -= 0.1;
        element.style.opacity = opacity;
        if (opacity <= 0) {
          element.style.display = "none";
          clearInterval(interval);
          callFunc(callBack);
        }
      }, 50);
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

    elem.addEventListener('click', function() {
        if (attr == null) { attr = 'class'; }
    
        if (attr == 'class') {
            var active = elem.classList.contains(value);
            if (active == true) {
                elem.classList.remove(value);
            } else if (active == false) {
                elem.classList.add(value)
            }
        } else {
            var active = elem.getAttribute(attr);
            if (active == value) {
                elem.removeAttribute(attr);
            } else if (active == false) {
                elem.setAttribute(attr, value)
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
    });

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


/**
 * Show device width or height in console on browser resize
 * @param {*} type (options: all | width | height)
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
 * Works with attribute ('[data-view="morelink"]'). Helps to contract or expand texts
 * The attribute disp-text declares the number of text visible at once e.g disp-text="200";
 * This class is used directly with the text's immediate parent element
 */
function readmore() {
    let ellipsestext = "...";
    let moretext = "more";
    let lesstext = "less";
    let hiderBtn = document.querySelectorAll('.hide-more');
    let moreLink = document.querySelectorAll('[data-view="morelink"]');
    
    hiderBtn.forEach(function(el) {
        var content = el.innerHTML;
        var showChar = el.getAttribute("disp-text");
        if (content.length > showChar) {
            var c = content.substring(0, showChar);
            var h = content.substring(showChar, content.length - showChar);
            var html = c + '<span class="moreellipses">' + ellipsestext + '&nbsp;</span><span class="morecontent"><span>' + h + '</span>&nbsp;&nbsp;<a href="" class="morelink">' + moretext + '</a></span>';
            el.innerHTML = html;
        }
    });
    
    moreLink.querySelectorAll('[data-view="morelink"]').forEach(function(el) {
        el.addEventListener('click', function(e) {
            e.preventDefault();
            if (el.classList.contains("less")) {
                el.classList.remove("less");
                el.innerHTML = moretext;
            } else {
                el.classList.add("less");
                el.innerHTML = lesstext;
            }
            el.parentNode.previousElementSibling.style.display = 'block';
            el.previousElementSibling.style.display = 'none';
        });
    });
    
}

/**
 * VANILLA JS: loops an array of texts supplied into a target element
 * @param {*} element target element selector
 * @param {*} texts array of texts
 * @param {*} interval loop interval
 * @param {*} callBack callback when loop finishes
 */
function animeText(element, texts, interval, callBack) {
    var counter = 0;
    var texts = (texts == undefined) ? [] : texts;
    

    if (element.length != false) {
        
        element = document.querySelector(element);
        if(element.length > 0){
            animeTextWord = setInterval(function() {
                
                element.html(texts[counter]);
                console.log(texts[counter]);
                counter++;
                if (counter === (texts.length)) {
                    clearInterval(animeTextWord);

                    setTimeout(() => {
                        callFunc(callBack);
                    }, interval)

                }
            }, interval);
        }else{
            console.log("no element found for selector: " + element);
        }

    } else {
        clearInterval(animeTextWord);
    }

}