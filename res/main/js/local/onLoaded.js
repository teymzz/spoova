
/**
 * This function is used for html element "onloaded" attribute
 */
setTimeout(() => {
    let onLoaded = document.querySelectorAll('[onloaded]');
    
    onLoaded.forEach(function(key){
        let onLoadedAttr = key.getAttribute('onloaded');
        let newObject = {};
        newObject[0] = key;
        newObject.length = onLoaded.length | 0;
    
        ss.helper.callFunc([onLoadedAttr, [newObject]])
    })
})