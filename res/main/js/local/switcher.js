
/**
 * @author Akinola Saheed <teymss@gmail.com>

 * 
 * This function is used to display or hide fields using localStorage 
 * class is used as group key and to make css styling easy
 * 
 * @param elem selector
 * @param bool handlecontent 
 *            - true extends function for handling relative fields
 *            - false extends function for handling relative fields
 * @return void. 
 * 
 *        Button Attrs     Field Attrs   Description 
 *        - data-switch => id            (element id) 
 *        - data-class  => class         (session key)
 *        - data-rel    => data-rel      (connector key)
 */
function switcher(elem){
  
  let Controller  = (typeof elem === 'string')? document.querySelectorAll(elem) : elem; //button selector 
  if(elem.length = 1){
    Controller = [elem];
  } else if(elem.length = 0) {
    Controller = [];
  } 

  let switchBox = new Switcher;
  let storageKey = switchBox.storageKey;

  Controller.forEach(Control => {

    let callBack    = Control.dataset.callback; //button selector 
  
    //data-switch points to the id of the element to be controlled          
    let field_id = Control.getAttribute('data-switch'); 
    
    //data-class, points to the class group (name) of the element to be controlled (also used as session storage key)                   
    let field_class  = Control.getAttribute('data-class');  
   
    //data-rel, contains shared value by controller and element to be controlled
    let field_rel = Control.getAttribute('data-rel');   
  
    //select the corresponding field to the controller item 
    let field_to_show  = document.querySelectorAll('.'+field_class+'#'+field_id+'[data-rel="'+field_rel+'"]');
    
    //select non corresponding fields sharing the same class with the controller item
    let fields_to_hide = document.querySelectorAll('.'+field_class+':not(#'+field_id+')'+'[data-rel="'+field_rel+'"]');
    
    // check if the storage class value points to the controller switch 
    let storageData = switchBox.get(field_class)


    if(field_id === storageData){
      setTimeout(function(){
        //add active to the controller's class
        Control.classList.add("active");
      },500)
    } else {
        
        //remove active from other relative controllers (a new click event was called)
        let removals = document.querySelectorAll("[data-switch][data-class="+field_class+"]"); 
        if(removals) {
          removals.forEach(removal => {
            removal.classList.remove("active")
          })
        }

        //store currently selected id into group's class
        switchBox.set(field_class, field_id)

        Control.click();
        return;
        // //add active to the controller's class
        // Controller.addClass("active");
    }
    //store currently selected id into group's class
    switchBox.set(field_class, field_id);
    
    //Create a stoppage point for controllers if necessary
    if(fields_to_hide.length < 1){
      if(callBack){
        window[callBack](Controller);
      }
      return;
    } 

    let $this = this;

    
  let fadeOut = function(elem, duration, callback) {
    elem.style.opacity = 1;
    duration = duration || 0;
  
    (function fade() {
      if ((elem.style.opacity -= 0.1) < 0) {
        elem.style.display = 'none';
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


          field_to_show.forEach(field => {

             fadeIn(field);

          })

          Control.classList.add("active")
          if(callBack){
            window[callBack](Control);
          }       

      })

    });


  });
  
    
}


/**
 * loadSwitcher function is used to automatically 
 * click on controllers. 
 * Storage keys supplied as argument will be triggered 
 * with click event 
 * 
 * @param string|array items data-class value of switcher controllers   
 * @return void
 *      example
 *       <button data-switch="box" data-class="boxes" data-rel="box1" > switch </button>
 *       .  
 */
class Switcher{

   storageKey = 'switcherJs';

   loadSwitcher(...items) {

    let storedItem;

    for(var i=0; i < items.length; i++){
     
      let item = items[i]; let itemCalled;
      storedItem = this.get(item);
     
      if(storedItem){

        let active = storedItem;

        itemCalled = document.querySelectorAll("[data-class='"+item+"'][data-switch='"+active+"']");

        itemCalled.forEach(calledItem => {
          
          calledItem.click();

        })

      }else{

        itemCalled = document.querySelector("[data-class='"+item+"']")
        if(itemCalled) itemCalled.click();

      }

    }

   }
   
   /**
    * This will silently update localStorage without any form of auto clicking
    * 
    * @param string field_id as switch id
    * @param string field_class as switch class or group
    */
   silentUpdate(field_id, field_class) { 

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

   set(key, value) {

        let storageKey  = this.storageKey;
        let storageData = localStorage.getItem(storageKey); 
        let data = this.toObject(storageData);
        data[key] = value;
        localStorage.setItem(storageKey, JSON.stringify(data));

   }

   get(key) {
    let storageKey  = this.storageKey;
    let storageData = localStorage.getItem(storageKey);        
    let data = this.toObject(storageData);
    return data[key];
   }

   bind(key, callBack) {

      if(this.get(key) !== undefined) {
          callBack(this.get(key), key);
      }

   }

   /**
    * Run a single switcher on a single item with a callback function
    * @param string item 
    * @param object callback 
    */
   loadCall(item, callback) {

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

   reset() {

     localStorage.setItem(this.storageKey, []);

   }

   toObject(item) {

      if( (!item) || (typeof item !== 'string')){
        item = '{}'
      }
    
      return JSON.parse(item);

   }

}