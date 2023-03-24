/**
 * This function is used for core debugging. 
 * This should not be tampered with
 * 
 */
function stack(element){

    let stackTrace = element.closest('.stack-trace');

    let stackDebug = stackTrace.querySelector(".stack-debug");
    let scrollHeight = `${stackDebug.scrollHeight}px`;

    if(stackDebug.classList.contains('opened')){
        scrollHeight = 0;
        stackDebug.classList.remove('opened')
        stackTrace.classList.remove('opened');
    } else {
        stackDebug.classList.add('opened')
        stackTrace.classList.add('opened')
    }

    let cssBuild = function(arg1, arg2){

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

    let css = cssBuild(`height: ${scrollHeight};`);
    Object.assign(stackDebug.style, css);

}