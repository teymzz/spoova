
/**
 * @author Akinola Saheed <teymss@gmail.com>
 * @package switcher
 * 
 * This function is used to display or hide fields using sessionStorage 
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

  var Controller  = $(elem); //button selector
  
  var callBack    = Controller.data('callback'); //button selector 

  //data-switch points to the id of the element to be controlled          
  var field_id = Controller.attr('data-switch'); 
  
  //data-class, points to the class group (name) of the element to be controlled (also used as session storage key)                   
  var field_class  = Controller.attr('data-class');  
 
  //data-rel, contains shared value by controller and element to be controlled
  var field_rel = Controller.attr('data-rel');   

  //select the corresponding field to the controller item 
  var field_to_show  = $('.'+field_class+'#'+field_id+'[data-rel="'+field_rel+'"]');
  
  //select non corresponding fields sharing the same class with the controller item
  var fields_to_hide = $('.'+field_class+':not(#'+field_id+')'+'[data-rel="'+field_rel+'"]');
  
  // check if the storage class value points to the controller switch
  if(field_id == sessionStorage.getItem(field_class)){
    setTimeout(function(){
      //add active to the controller's class
      Controller.addClass("active");
    },500)
  } else {
      
      //remove active from other relative controllers (a new click event was called)
      $("[data-switch][data-class="+field_class+"]").removeClass("active")
      //store currently selected id into group's class
      sessionStorage.setItem(field_class, field_id);
      Controller.click();
      return;
      // //add active to the controller's class
      // Controller.addClass("active");
  }

  //store currently selected id into group's class
  sessionStorage.setItem(field_class, field_id);
  
  //Create a stoppage point for controllers if necessary
  if(fields_to_hide.length < 1){
    if(callBack){
      window[callBack](Controller);
    }
    return;
  } 
 
  //Remove active from all related fields only
  fields_to_hide.removeClass('active');
  
  fields_to_hide.fadeOut(10,function(){
    field_to_show.fadeIn(10);
    Controller.addClass("active")
    if(callBack){
      window[callBack](Controller);
    }
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

   loadSwitcher(...items) {

    for(var i=0; i < items.length; i++){
     
      var item = items[i]; var itemCalled, callback;
     
      if(sessionStorage.getItem(item)){

        var active = sessionStorage.getItem(item);

        itemCalled = $("[data-class='"+item+"'][data-switch='"+active+"']")
        itemCalled.click();

      }else{

        itemCalled = $("[data-class='"+item+"']").eq(0)
        itemCalled.click();

      }

    }

   }
   
   /**
    * This will silently update sessionStorage without any form of auto clicking
    * 
    * @param string field_id as switch id
    * @param string field_class as switch class or group
    */
   silentUpdate(field_id, field_class) { 
     
      if(sessionStorage.getItem(field_class)) { 
        
        //Remove active from other relative class 
        $("[data-switch][data-class="+field_class+"]").removeClass("active")
        
        //Add active to item
        $("[data-switch="+field_id+"][data-class="+field_class+"]").addClass("active")
        
        //update sessionStorage
        sessionStorage.setItem(field_class, field_id);
        
      }
      
   }

   set(key, value) {

        sessionStorage.setItem(key, value);

   }

   get(key) {

    return sessionStorage.getItem(key) || '';

   }

   bind(key, callBack) {

      if(this.get(key)) {
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

    if(sessionStorage.getItem(item)){

        var active = sessionStorage.getItem(item);

        itemCalled = $("[data-class='"+item+"'][data-switch='"+active+"']");
        itemCalled.click();

      }else{

       itemCalled = $("[data-class='"+item+"']").eq(0);
       itemCalled.click();

      }

      if(callback){
        setTimeout(()=>{ window[callback](itemCalled); }, 200);
      }

   }

}