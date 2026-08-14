import { SPAuto } from "./autoload/SPAuto.js";

/**
 * @author Akinola Saheed <akinolasaheed001@gmail.com>
 * 
 * This is an helper plugin for tracking navigational state of element's on webpages. 
 *  - This class is globally assigned to the window.Switcher method due to high usage of navigational switch buttons
 */
class Switcher{

   static storageKey = 'switcherJs';

  /**
   * This function is used to automatically click on the currently active controller elements. 
   * 
   * @param string|array items data-class (i.e storage key) value of switcher controllers   
   * @param bool auto FALSE prevents auto clicking of switcher controller element if storage value is empty  
   * @return void
   */
   static load(items, auto = true) {

    let storedItem;
    if(typeof items === 'string'){
      items = items.split(',');
    }

    for(var i=0; i < items.length; i++){
     
      let item = items[i]; let itemCalled;
      storedItem = this.get(item);
     
      if(storedItem){

        let active = storedItem;

        itemCalled = document.querySelectorAll("[data-class='"+item+"'][data-switch='"+active+"']");

        if(itemCalled.length === 0) {
          // Reset active switcher when relatively active controller element been removed from controller list 
          let activeSwitch = document.querySelector("[data-class='"+item+"'][data-switch]"); //select first element in group 
          if(active) {
            active = activeSwitch.getAttribute('data-switch');
            if(active) itemCalled = document.querySelectorAll("[data-class='"+item+"'][data-switch='"+active+"']");
          }
        }

        itemCalled.forEach(calledItem => {
          calledItem.click();
        })


      }else if(auto){

        // select the first data-class (unique group) item discovered if storage is empty
        itemCalled = document.querySelector("[data-class='"+item+"']")
        if(itemCalled) {
          console.log("[data-class='"+item+"']", itemCalled)
          itemCalled.click();
        }

      }

    }

   }

   /**
    * Fetches the entire properties of a specified group and runs a callback  
    * function if the group name exists.
    * 
    * @param {string} group the class or group name
    * @param {function} callback function to be called if group exists
    * @returns 
    */
   static fetch(group, callback){

    let activeElementID = this.get(group);

    if(activeElementID){

      let handler = {};
      handler.members = [];
      handler.switches = [];
      handler.activeSwitches = [];
      handler.id = undefined;
      handler.activeSwitch = undefined;
      handler.name = group;

      let activeElement = document.getElementById(activeElementID);

      let switches = document.querySelectorAll(`[data-switch][data-class="${group}"]`);
      
      if(switches.length > 0){
        
        //get data-rel attribute 
        let data_rel = switches[0].getAttribute('data-rel');
        
        //detect all members 
        let membersQuery = `.${group}[id][data-rel="${data_rel}"]`;
        handler.switches = switches;

        handler.members = document.querySelectorAll(membersQuery);
        handler.activeSwitches = document.querySelectorAll(`[data-switch="${activeElementID}"][data-class="${group}"][data-rel="${data_rel}"]`);
        handler.activeSwitch = handler.activeSwitches[0];
        handler.activeMember = activeElement;
        handler.id = activeElementID;
        if(callback) callback(handler);
      }
      
      return handler;

    } else {
      console.error('Switcher: unknown "'+group+'" group cannot be fetched');
      return false;
    }

   }
   
   /**
    * This will silently update localStorage without any form of auto clicking
    * 
    * @param string field_id as switch id
    * @param string field_class as switch class or group
    */
   static silentUpdate(field_id, field_class) { 

      if(this.get(field_class)) { 
        
        //Remove active from other relative class 
        let toRemoves = document.querySelectorAll("[data-switch][data-class="+field_class+"]"); 
        toRemoves.forEach(toRemove => {    
          toRemove.classList.remove("active")
        })
        
        //Add active to item
        let toAdds = document.querySelectorAll("[data-switch="+field_id+"][data-class="+field_class+"]");
        toAdds.forEach(toAdd => {    
          toAdd.classList.add("active")
        })        
        
        //update localStorage
        this.set(field_class, field_id);
        
      }
      
   }

   static set(key, value) {

        let storageKey  = this.storageKey;
        let storageData = localStorage.getItem(storageKey); 
        let data = this.toObject(storageData);
        data[key] = value;
        localStorage.setItem(storageKey, JSON.stringify(data));

   }

   static get(key, callback) {
    let storageKey  = this.storageKey;
    let storageData = localStorage.getItem(storageKey);        
    let data = this.toObject(storageData);

    if(typeof callback === 'function'){
      return callback(data[key], key);
    }
    return data[key];
   }

   /**
    * Run a single switcher on a single item with a callback function
    * @param string item 
    * @param object callback 
    */
   static loadCall(item, callback) {

    let itemCalled;        
    let itemSaved = this.get(item);

    if(itemSaved){

      var active = itemSaved;

      itemCalled = document.querySelectorAll("[data-class='"+item+"'][data-switch='"+active+"']");
      itemCalled.forEach(calledItem => {
        calledItem.click()
      })

    }else{

      itemCalled = document.querySelector("[data-class='"+item+"']");
      if(itemCalled) itemCalled.click();

    }

    if(callback){
      setTimeout(()=>{ window[callback](itemCalled); }, 200);
    }

   }

   static bind(key, callBack) {
    
      key = Array.isArray(key)? key : [key];

      key.forEach(item => {
        let storedValue = this.get(item);
        if(storedValue !== undefined) {
            callBack(storedValue, item); // runs only if key is not undefined in storage
        }
      })

   }

   static check(key, callBack) {
      key = Array.isArray(key)? key : [key];

      key.forEach(item => {
        // callback will always run
        callBack(this.get(item), item);
      });
   }

   static unset(key) {
    
      if(typeof key === 'object'){
        key = key.getAttribute('data-class');
        if(!key){
          return false;
        }
      }
      
      let storage = this.toObject(localStorage.getItem(this.storageKey));
      let item = storage[key];

      if(item !== undefined) {
        delete storage[key];
        localStorage.setItem(this.storageKey, JSON.stringify(storage));
      }

   }

   static reset(key) {

      if(typeof key === 'object'){
        key = key.getAttribute('data-class');
        if(!key){
          return false;
        }
      }

      let storage = this.toObject(localStorage.getItem(this.storageKey));
      
      if(storage.hasOwnProperty(key)){
        storage[key] = '';
        localStorage.setItem(this.storageKey, JSON.stringify(storage));
      }else{

      }

      // if(typeof storage === 'object') {
      // //   // delete storage[key];
      // // } else {
      // //   localStorage.setItem(this.storageKey, []);
      // }else{
      //   if(item !== undefined) console.error('Switcher: reset key is not a valid string')
      // }   

   }

   static toObject(item) {

      if( (!item) || (typeof item !== 'string')){
        item = '{}'
      }
      try{
        return JSON.parse(item);
      }catch{
        return {}
      }

   }

   /**
    * 
    * @param {object} element 
    * @param {function} callback 
    */
   static map(element, callback){
    
      let group = element.getAttribute('data-class');
      let value = element.getAttribute('data-switch');
      this.set(group, value);
      let data = this.fetch(group);

      if(data.activeSwitch){
        if(callback) callback(data);
      }

   }

   static on(group, events, callback){

    let info, switches;

    info = Switcher.fetch(group);

    events = events.split(',');
    switches = info.switches

    if(switches){
      
      switches.forEach(item => {
        events.forEach(eventName => {
  
          if(eventName === 'load'){
            let ref = Switcher.fetch(group)
            if(item === ref.activeSwitch){
              callback(ref);
            }  
          }else{
            item.addEventListener(eventName, function(event){
              let ref = Switcher.fetch(group)
              if(item === ref.activeSwitch){
                callback(ref);
              }  
            });
          }
        })
      })

    }


   }

  /**
   * 
   * @param {string|object} elem refers to a querySelector or an object of element to be activated
   * @param {boolean} animated enables or disables animation for elements relatively binded to controllers within a switch group.  
   */
  static switch(elem, animated = true){
    
    let Controller  = (typeof elem === 'string')? document.querySelectorAll(elem) : elem; //button selector 

    if(elem.length = 1){
      Controller = [elem];
    } else if(elem.length = 0) {
      Controller = [];
    } 

    Controller.forEach(Control => {

      //data-switch points to the id of the element to be controlled          
      let field_id = Control.getAttribute('data-switch'); 

      let callBack    = Control.dataset.callback; //button selector 
      
      //data-class, points to the class group (name) of the element to be controlled (also used as session storage key)                   
      let field_class  = Control.getAttribute('data-class');  
    
      //data-rel, contains shared value by controller and element to be controlled
      let field_rel = Control.getAttribute('data-rel');   
    
      //select the corresponding field to the controller item 
      let fields_to_show = document.querySelectorAll('.'+field_class+'#'+field_id+'[data-rel="'+field_rel+'"]');
      
      //select non corresponding fields sharing the same class with the controller item
      let fields_to_hide = document.querySelectorAll('.'+field_class+':not(#'+field_id+')'+'[data-rel="'+field_rel+'"]');
      
      // check if the storage class value points to the controller switch 
      let storageData = this.get(field_class)


      if(field_id === storageData){
        setTimeout(function(){
          //add active to the controller's class
          Control.classList.add("active");
        },500);

        //store currently selected id into group's class
        Switcher.set(field_class, field_id);

      } else {
          //remove active from other relative controllers (a new click event was called)
          let removals = document.querySelectorAll("[data-switch][data-class="+field_class+"]"); 
          if(removals) {
            removals.forEach(removal => {
              removal.classList.remove("active")
            })
          }

          //store currently selected id into group's class
          Switcher.set(field_class, field_id)
          // let exists =  false;
          Switcher.check(field_class, function(props, id){
            if(id === field_id) Control.classList.add("active");
            // exists = true;
          });
      }
      
      //Create a stoppage point for controllers if necessary
      if(fields_to_hide.length < 1){
        if(callBack){
          window[callBack](Controller);
        }
        return;
      } 

      if(!animated) {
        let fields_to_hide_count = fields_to_hide.length;
        let fields_to_show_count = fields_to_show.length;

        fields_to_hide.forEach((field_to_hide, index) => {
          field_to_hide.classList.remove('active');

          if((index + 1) === fields_to_hide_count){

            fields_to_show.forEach((field_to_show, index) => {
              field_to_show.classList.add('active');
              if((index + 1) === fields_to_show_count){
                Control.classList.add("active")
                if(callBack) window[callBack](Controller);
              }
            })

          }

        });
        return;
      }
      
      // Resolve display animations for fields relatively binded to controller elements.
      let fadeOut = function(elem, duration, callback) {
        elem.style.opacity = 1;
        duration = duration || 0;
      
        (function fade() {
          if ((elem.style.opacity -= 0.1) < 0) {
            elem.style.display = 'none';
            elem.classList.remove('active');
            if (callback) callback();
          } else {
            setTimeout(fade, duration);
          }
        })();
      }  

      let fadeIn = function(elem, duration, callback) {
        elem.style.opacity = 0;
        elem.style.display = 'block';
        duration = duration || 0;
      
        (function fade() {
          let val = parseFloat(elem.style.opacity);
          if (!((val += 0.1) > 1)) {
            elem.style.opacity = val;
            elem.classList.add('active');
            setTimeout(fade, duration);
          } else {
            if (callback) callback();
          }
        })();
      }
      
    
      //Remove active from all related fields only
      fields_to_hide.forEach(field_to_hide => {
        
        field_to_hide.classList.remove('active');
        field_to_hide.style.display = 'none';

        fadeOut(field_to_hide, 0, function(){


            fields_to_show.forEach(field => {

              fadeIn(field);

            })

            Control.classList.add("active")

            if(typeof window[callBack] !== 'undefined'){
              window[callBack](Control);
            }       

        })

      });


    });
      
  }

}

export default SPAuto(Switcher);

window.Switcher = Switcher;