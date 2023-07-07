
/**
 * Loops through an array of texts supplied into a target element in animated format.
 * 
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

/**
 * This function renders an animation where each letter of a text is displayed respectively.
 * @param {string} selector 
 * @param {object} settings 
 */
function typeWrite(selector, settings){
        
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
 * Switches an element display type based on boolean value supplied
 * @param {string} element 
 * @param {boolean} bool a true value sets an element's display to "block"
 * @param {function} callBack a function called when an element's display type changes.
 */
function popbox(element, bool, callBack) {      
    
    let elements = toSelectionArray(element);

    elements.forEach(element => {

        if (bool === true || bool === "true") {
            element.style.display = "block";
            let opacity = 0;
            let interval = setInterval(function() {
                opacity += 0.1;
                element.style.opacity = opacity;
                if (opacity >= 1) {
                clearInterval(interval);
                callFunc(callBack);
                }
            }, 50);
        } else {
            let opacity = 1;
            let interval = setInterval(function() {
                opacity -= 0.1;
                element.style.opacity = opacity;
                if (opacity <= 0) {
                element.style.display = "none";
                clearInterval(interval);
                callFunc(callBack);
                }
            }, 50);
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