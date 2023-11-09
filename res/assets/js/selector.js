/**
 * The selector class provides a simplified way of handling selected html elements. 
 * This converts selected items to an array that can be iterated over 
 */
class Selector { 

    /**
     * 
     * @param {string|object} selector 
     * @returns array
     */
    toSelectionArray(selector) {
        let type = typeof selector;
        let selection = [];

        if(type === 'object'){
            if(selector.length){
                selection = selector
            }else if(selector.tagName){
                selection = [selector];
            }
        }else if(type === 'string'){
            selection = document.querySelectorAll(selector)
        }

        let selects = [] 
        for(const key in selection){
            if(selection.hasOwnProperty(key)){
                if(selection[key].childNodes){
                    selects.push(selection[key]);
                }
            }
        }

        return selects;
    }

    /**
     * 
     * @param {string|object} selector 
     * @returns array
     */
    select(selector) {
        return this.toSelectionArray(selector)
    }

}