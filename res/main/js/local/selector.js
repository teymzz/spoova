/**
 * The selector class provides a simplified way of handling selected html elements. 
 * This converts selected items to an array that can be iterated over 
 */
import { SPAuto } from "./autoload/SPAuto.js";

export class Selector { 

    /**
     * 
     * @param {string|object} selector 
     * @returns array
     */
    toSelectionArray(selector) {
        let type, selection = [];
        
        type = typeof selector;

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

    static fetch(element) {
        let selector = new Selector;
        return selector.select(element);
    }

    static first(element) {
        let selector = new Selector;
        return selector.select(element)[0] ?? false;
    }

}

export default SPAuto(Selector);

// window.Selector  = Selector