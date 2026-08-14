/**
 * This file contains core helper in-built functions, used
 * in the development of this framework.
 */

// /**
//  * This function helps to blend Jquery selector with the native javascript selector.
//  * 
//  * @param {string|object} selector converts a selector or Jquery object to array format.
//  * 
//  * @returns 
//  */
// function toSelectionArray(selector){
//     let element = typeof selector;
//     let voidlists = false;
//     if(element === 'object'){
//         selector = selector
//     }else if(element === 'string'){
//         selector = document.querySelectorAll(selector)
//         if(selector.length === 0) voidlists = true;
//     }
//     if(selector){
//         if(!selector.length){
//            if(!voidlists) selector = [selector];
//         }else if(!Array.isArray(selector)){
//             let selects = [] 
//             for(const key in selector){
//                 if(selector.hasOwnProperty(key)){
//                     if(selector[key].childNodes){
//                         selects.push(selector[key]);
//                     }
//                 }
//             }
//             selector = selects;
//         }
//     }  
//     return selector;
// }
