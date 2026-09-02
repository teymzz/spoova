import { SPAuto } from "../autoload/SPAuto.js";

class CheckBox {

    static customListItems = {};

    constructor(config = true) {

        let checkbox = this;

        checkbox.hardchecks = [];

        // checkbox.customListItems = {};
        checkbox.customListData = {};

        if(config === false) return checkbox;
        
        let defaults, customBoxes, init, toggle, assign, css, size, fsize, fit, checkEvent;

        defaults = {
            target: '[checkbox]',
            marker: '[marker]',
            assign:  {
                attr: [],
                alter: () => {}
            },
            group: {

            },
            init:   function(){},
            toggle: function(){},
            flip: false,
            size: null,
            fit: true
        };

        config = {...defaults, ...config};
        checkbox.target = config.target;
        checkbox.marker = config.marker;
        checkbox.flip = config.flip;
        checkbox.fit = config.fit;

        init = config.init;
        toggle = config.toggle;
        assign = config.assign;
        size = config.size;
        fsize = config.fsize;
        fit = config.fit;
        css = false;
        let populate;

        if(typeof Selector === 'function'){
            populate = () => {
                let selector = new Selector;
                let customBoxes = selector.select(checkbox.target);
                return customBoxes;
            }
        }else{
            populate = () =>  document.querySelectorAll(checkbox.target);
        }
        
        let checkListItems = [];
        
        customBoxes = populate();
        customBoxes.forEach(box => {
            let parent = box.closest('[data-role="checkbox-list"]');
            if(parent && (parent.getAttribute('data-role') === "checkbox-list") && !checkListItems.includes(parent) && parent.getAttribute('data-clones')){
                let rootItems = parent.querySelectorAll(":scope > *").length;
                if(rootItems.length > 1){
                    console.warn('custom clones must have one root source');
                    return false;
                }
                checkListItems.push(parent);
                let clones = parent.getAttribute('data-clones');
                let config = clones.split(':');
                clones = config[0];
                let onEachBox = config[1];
                let escapes = config[2];

                if(onEachBox) onEachBox = onEachBox.trim(' ');
                escapes = escapes ? escapes.split('.') : [];

                if(isNaN(clones)){
                    try{
                        let testClones = document.querySelectorAll(clones+" > *");
                        clones = testClones.length;
                    }catch(err){
                        console.error('generic data-clones attribute must be of value formats: \n "integer", "integer:callback:inversions" or "rootElement:callback:inversions"')
                    }    
                }

                if(!isNaN(clones)){
                    clones = parseInt(clones);
                    clones = clones > 0 ? clones -1 : clones;
                    if(onEachBox && (typeof window[onEachBox] === 'undefined')){
                        console.warn('generic data-clones callback function does not exist in window"')
                    }
                    function onEach(box, id) {
                        let input = box.querySelector('input');
                        let checked = input.getAttribute('checked') === 'true';
                        if(escapes.includes(`${id}`)||escapes.includes('*')||escapes.includes('+')) input.setAttribute('checked', checked? 'false':'true') 
                        if(typeof window[onEachBox] === 'function') onEachBox(box, id);
                    }
                    CheckBox.generic(parent.innerHTML, { clones : clones, checklists: [parent], onEachBox: onEach })
                }
            }

        })
        customBoxes = populate(); // Repopulate customBoxes 

        // DEFINED HELPER FUNCTIONS

        function stringSplit(string, separator = '|'){
            let item = {};
            string = string || '';
            let splitItem = string.split(separator);

            splitItem.forEach((split, index) => {
                item[index] = split;
            })

            return item;
        }
        
        /**
         * Resolves the width and height of custom box
         * @param {string|object} size 
         * @returns object
         */
        function getSize(size){
            let width, height;
            size = size || '';

            if(typeof size === 'object'){
                width = size.width || size.x || '';
                height = size.height || size.y || width;
            }else{
                size = stringSplit(size);
                width = size[0] || '';
                height = size[1] || width;
            }
            return {x:width, y:height};
        }

        // get attribute from an element (match with value if supplied)
        function at(element, attr){

           attr = element.getAttribute(attr)

           return {
            value: (returnType = '') => {
                if(arguments.length > 0){
                    return attr || returnType;
                }
                return attr;
            },
            is: (value) => {
                return attr === value;
            },
            not: (value) => {
                if(Array.isArray(value)){
                    let ret = true;
                    value.forEach(val => {
                        if(attr === val){
                            ret = false;
                            return false;
                        }
                    })
                    return ret;
                }else{
                    return attr !== value;
                }
            },
            has: (value, separator = ' ') => {
                if(!typeof attr === 'string') return false;
                attr = attr.split(separator);
                return attr.includes(value);
            },
            hasAttr: (attribute) => {
                attribute = attribute || attr;
                if(!attribute) return false;
                if(element.getAttribute(attribute) !== null){
                    return true;
                }
                return false;
            },
            /**
             * 
             * @param {string} separator 
             * @param {string} returnType options [array|string]
             * @returns {*}
             */
            attrvals: (separator = ' ', returnType = 'array') => {
                if(typeof attr !== 'string'){
                    if(returnType === 'string') return ''; 
                    if(returnType === 'array') return []; 
                    return attr; //value of attribute
                }
                if(returnType !== 'array') return attr;
                return attr = attr.split(separator).filter((str) => str !== "");
            },
            checked: () => {
                return (isCheckbox(element) && element.checked);
            },
            click: () => {
                 //if(isCheckbox(element)){
                    element.click();
                 //}
            }
           };
        }

        /* detect if element is checkbox */
        function isCheckbox(element){

            return ((element.tagName === 'INPUT')
            && (element.getAttribute('type') === 'checkbox'))? element : false;

        }

        /* detect if element is checked */
        function hasChecked(element){
            return (isCheckbox(element) && element.checked);
        }

        let animeAttr;

        if(typeof assign === 'object' && Array.isArray(assign.attr)){

            /**
             * Add attribute toggle support
             * @param {object} box custom box
             * @param {boolean} checked checkbox status 
             * @param {string} assignAnime data-assign value 
             * @param {array} markers 
             */        
            animeAttr = (box, checked, assignAnime, markers) => {

                // set default assign configuration
                let iniAssign  = assign.attr;
                let dataAssign = iniAssign;

                if(assignAnime){

                    // format local data-assign attribute

                    dataAssign = [];

                    //split handle string value
                    let attrSplit = assignAnime.split('|');
                    if((attrSplit.length === 1) && (iniAssign.length > 1)){
                        // assign [source, destination, <data-assign>]
                        // data-assign: status
                        assignAnime = attrSplit[0];    
                        dataAssign[0] = iniAssign[0];  
                        dataAssign[1] = iniAssign[1];   
                        dataAssign[2] = assignAnime;  
                    }else if(attrSplit.length > 2){
                        // assign [<data-assign[0]>,<data-assign[1]>]
                        // data-assign [status, source, destination]
                        assignAnime = attrSplit[0];    
                        dataAssign[0] = attrSplit[1];  
                        dataAssign[1] = attrSplit[2];
                        dataAssign[2] = assignAnime;
                    }

                }

                let attrs = dataAssign;

                if(attrs.length > 1){
                    //when three argument supplied source, dest, type
                    let sourceAttr = attrs[0]; //source attribute
                    let destAttr = attrs[1]; //destination attribute
                    let animated = 'checked';
                    let animate  = false;
                    let animator = assignAnime || attrs[2];
                    let animateMarker = false;
                    markers = markers || []
                    if(attrs.length > 2){
                        let animations = ['checked','unchecked','both','false',':markers',':marker1',':marker2'];
                        if(animations.includes(animator)){
                            animated = animator
                        }else{
                            console.error('unknown attribute animation type "'+animator+'" assigned to checkbox')
                        }
                    }

                    if(animated !== 'false'){
                        if(animated === 'both'){
                            animate = true;
                        }else if(checked && (animated === 'checked')){
                            animate = true;
                        }else if(!checked && (animated === 'unchecked')){
                            animate = true;
                        }else if(animated === ':markers'){
                            animate = true;
                            animateMarker = true;
                        }else if(animated === ':marker1'){
                            animate = true;
                            animateMarker = 1;
                        }else if(animated === ':marker2'){
                            animate = true;
                            animateMarker = 2;
                        }
                    }
                    let destValue = '', sourceValue, sourceValue2;

                    sourceValue = at(box, sourceAttr).value('');
                    

                    if(!animateMarker) {
                        destValue = at(box, destAttr).value('');
                    }
           
                    //get toggle values
                    let animeValues = sourceValue.split('|'); 
                    
                    //set unchecked toggle values in array
                    sourceValue = animeValues[0].split(' ');
                    destValue = destValue.split(' ');

                    if(animeValues.length > 1){
                       //set checked toggle values in array
                       sourceValue2 = animeValues[1].split(' ');
                    }
                   
                    if(typeof assign.alter === 'function'){
                        let mod = assign.alter(sourceValue);
                        if(Array.isArray(mod)){
                            sourceValue = mod;
                        }

                        if(sourceValue2){
                            let mod2 = assign.alter(sourceValue2);
                            if(Array.isArray(mod2)){
                                sourceValue2 = mod2;
                            }                           
                        }
                    }
 
                    if(!animateMarker){

                        let CDestValue; // old destination value
                        let CNewDestVal; // new destination value

                        let appliedSource = '';

                        //set default destination values
                        CDestValue = at(box, destAttr).attrvals(' ');

                        if(animated === 'both'){

                            //resolve for "both" modifer
                            if(sourceValue) {
                                //remove source value 1 from CDestValue
                                CNewDestVal = CDestValue.filter(value => !sourceValue.includes(value));
                                // add source value 1 to destination attribute
                                CNewDestVal = CNewDestVal.concat(sourceValue);
                                appliedSource = CNewDestVal;
                            }

                        } else {

                            let modchecked = checked;
                            modchecked = (animated === 'unchecked')? !checked : checked;

                            //resolve "checked" and "unchecked" modifers
                            if(modchecked){
                                if(sourceValue2){
                                    //remove source value 1 from CDestValue
                                    CNewDestVal = CDestValue.filter(value => !sourceValue.includes(value));

                                    // add source value 2 to destination attribute
                                    CNewDestVal = CNewDestVal.concat(sourceValue2);
                                    appliedSource = sourceValue2;
                                } else {

                                    // add source value 1 to destination attribute
                                    CNewDestVal = CDestValue.concat(sourceValue);
                                    appliedSource = sourceValue;

                                }
                            }else{

                                if(sourceValue2){
                                
                                    // remove source value 2 from destination attribute
                                    CNewDestVal = CDestValue.filter(value => !sourceValue2.includes(value));
                                    
                                    //add source value 1 to checkerDestValue (CNewDestVal)
                                    CNewDestVal = CNewDestVal.concat(sourceValue);
                                    appliedSource = sourceValue;

                                }else{
                                    // remove source value 1 from destination attribute
                                    CNewDestVal = CDestValue.filter(value => !sourceValue.includes(value));
                                }

                            }
                        }

                        //animation for custom box ............................

                        //remove animation first ...
                        if(appliedSource){
                            //remove applied source value first 
                            let stripSource = CNewDestVal.filter(value => !appliedSource.includes(value))
                            box.setAttribute(destAttr, stripSource.join(' ')) 
                            setTimeout(() => box.setAttribute(destAttr, CNewDestVal.join(' ')), 20)
                        } else {

                            //add full data
                            box.setAttribute(destAttr, CNewDestVal.join(' '))
                        }


                    }else {

                        if(markers.length > 0){

                            //define variables 
                            let marker1Val, marker2Val; //old destination values
                            let M1NewDestVals, M2NewDestVals; // new destination values
                            let M1SourceValue, M2SourceValue // piped sources values

                            //set source values
                            M1SourceValue = sourceValue; //marker1 source value
                            M2SourceValue = sourceValue2 || sourceValue; //marker 2 source value
                            
                            //set default destination values
                            marker1Val = at(markers[0], destAttr).attrvals(' ');

                          
                            if(markers.length > 1) {
                                marker2Val = at(markers[1], destAttr).attrvals(' ');
                            }

                            if(checked){

                                if(animateMarker === 1){
                                    // marker 1 is hidden, remove value from marker 1
                                    
                                    // //add source to only marker 1
                                    M1NewDestVals = M1SourceValue.filter(val => !marker1Val.includes(val));    
                                    M1NewDestVals = marker1Val.concat(M1NewDestVals);
                                     
                                    //remove source from marker 2 (main action)
                                    M2NewDestVals = marker2Val.filter(val => !M2SourceValue.includes(val));                                    
                                }else if(animateMarker === 2){
                                    //add source to only marker 2 
                                    M2NewDestVals = M2SourceValue.filter(val => !marker2Val.includes(val) && (val !== ''));    
                                    M2NewDestVals = marker2Val.concat(M2NewDestVals);

                                    //remove source from marker 1
                                    M1NewDestVals = marker1Val.filter(val => !M1SourceValue.includes(val));
                                }else if(animateMarker === true){
                                    //add source to marker 2
                                    M2NewDestVals = M2SourceValue.filter(val => !marker2Val.includes(val));    
                                    M2NewDestVals = marker2Val.concat(M2NewDestVals);
                                    
                                    //remove source from marker 1
                                    M1NewDestVals = marker1Val.filter(val => !M1SourceValue.includes(val));
                                }

                            }else{

                                // Resolve this when checkbox is unchecked

                                if(animateMarker === 1){

                                    //remove source from marker 1
                                    M1NewDestVals = marker1Val.filter(val => !M1SourceValue.includes(val));   

                                }else if(animateMarker === 2){

                                    //marker 2 is hidden, remove source value from marker 2
                                    M2NewDestVals = marker2Val.filter(val => !M2SourceValue.includes(val));                                    

                                }else if(animateMarker === true){
                                    //add source to marker 1
                                    M1NewDestVals = M1SourceValue.filter(val => !marker1Val.includes(val));    
                                    M1NewDestVals = marker1Val.concat(M1NewDestVals);

                                    //remove source from marker 2
                                    if(marker2Val) M2NewDestVals = marker2Val.filter(val => !M2SourceValue.includes(val));
                                    
                                }else{
                                    console.error(`Markers must be 2 when set as ':markers'`)
                                }   

                            }

                            //set marker 1 and marker 2 new values ... 
                            if(M1NewDestVals) {
                                markers[0].setAttribute(destAttr, M1NewDestVals.join(' '));
                            }
                            if(M2NewDestVals) {                            
                                markers[1].setAttribute(destAttr, M2NewDestVals.join(' '));
                            }
        
                        }

                    }
                    
                }

            }

        }
        
        checkEvent = function(input){
            let customBox, checker = {};
                    
            //get custom box element 
            customBox = input.previousElementSibling;

            if(input.tagName === 'INPUT'){

                checker.native = input;
                checker.custom = customBox;
                checker.marker = customBox.querySelectorAll(checkbox.marker);
                checker.value = input.value;
                checker.label = customBox.getAttribute('data-label');
                checker.color = customBox.getAttribute('data-color');
                checker.listId;
                checker.checkedBoxes = 0;


                let callback = customBox.getAttribute('data-func');
                let callbackArg = [];
                if(callback){
                    let [func, ...arg] = callback.split(':');
                    callback = func;
                    arg = arg.join(':');
                    if(arg) callbackArg = [arg];
                }
                
                let marker1, marker2, flip = checkbox.flip;
                let label, labels = [], label1, label2;
                let color, colors = [], color1, color2;
                let mColor = false;

                let customParent = customBox.parentNode.closest('[data-role="checkbox"]');
                let customLabel  = (customParent)? customParent.nextElementSibling : undefined; 

                if(customParent){
                    checker.parent = customParent;
                    let grandParent = customParent.parentNode.closest('[data-role="checkbox-list"]');
                    if(grandParent){
                        checker.checkList = grandParent;
                        checker.listId = Array.from(grandParent.children).indexOf(customParent); 
                        if(!isNaN(parseInt(checker.listId))){
                            checker.listId += 1;
                        }
                        checker.checkedBoxes = grandParent.querySelectorAll('input:checked').length
                    }
                }

                if(customLabel && (customLabel.getAttribute('data-access') !== 'label')){
                    customLabel = undefined;
                }
                
                label = input.nextElementSibling;

                if(label && (label.getAttribute('data-access') !== 'label')){
                    label = undefined;
                }else if (customLabel) {
                    label = customLabel;
                }

                if(checker.label){
                    if(label && (label.getAttribute('data-access') === 'label')){
                        if(typeof checker.label === 'string'){
                            labels = stringSplit(checker.label);
                            label1 = labels[0]; //uncheck
                            label2 = labels[1]; //checked
                        }
                    }
                }
                
                if(checker.color){
                    if(typeof checker.color === 'string'){
                        //get first character 
                        mColor = checker.color.charAt(0);
                        if(mColor === '@'){
                          mColor = true;
                          checker.color = checker.color.substring(1);
                        }else{
                          mColor = false;
                        }
                        colors = stringSplit(checker.color);
                        color1 = colors[0];
                        color2 = colors[1];
                    }
                }

                if(at(customBox,'data-flip').is('true')){
                    flip = true;
                }else if(at(customBox,'data-flip').is('false')){
                    flip = false;
                }

                if((checkbox.marker.length > 1)){
                    marker1 = checker.marker[0];
                    marker2 = checker.marker[1];
                }

                if(input.disabled){
                    customBox.setAttribute('disabled', 'true');
                    if(customParent) customParent.setAttribute('disabled', 'true');
                    checker.disabled = true;
                }else{
                    customBox.removeAttribute('disabled');
                    if(customParent) customParent.removeAttribute('disabled');
                    checker.disabled = false;
                }

                if(input.checked) { 
                    //run for check
                    checker.checked = true;
                    input.setAttribute('checked', 'checked');
                    customBox.setAttribute('checked', 'checked');
                    if(customParent) customParent.setAttribute('checked', 'checked');
                    if(marker2 && flip){
                        marker1.setAttribute('hidden','');
                        marker2.removeAttribute('hidden');
                    }
                    if(label2){
                        label.textContent = label2;
                    }
                    if(label && color2) label.style.color = color2; 
                    if(mColor) {
                      if(marker2) {
                        marker2.style.color = color2;
                      }else if(marker1 &&  (color2 !== marker1.style.color)){
                        marker1.style.color = color2;
                      }
                    }
                }else{
                    //run for uncheck 
                    checker.checked = false;
                    input.removeAttribute('checked');
                    customBox.setAttribute('checked', 'unchecked'); 
                    if(customParent) customParent.setAttribute('checked', 'unchecked');
                    if(marker2 && flip){
                        marker2.setAttribute('hidden','');
                        marker1.removeAttribute('hidden');
                    }
                    if(label1){
                        label.textContent = label1;
                    }
                    if(label && color1) label.style.color = color1;
                    if((mColor=== true) && marker1) marker1.style.color = color1;
                }

                if(typeof animeAttr === 'function'){
                    animeAttr(customBox, input.checked, customBox.getAttribute('data-assign'), checker.marker)
                }

                checker.init = init;

                if(typeof toggle === 'function') toggle(checker);
                
                if(callback) {
                    if(typeof window[callback] !=='function'){
                        console.warn('unknown callback function "'+callback+'" defined in data-func attribute');
                    }else{
                        window[callback](checker, ...callbackArg);
                    }
                }

            }else{

                console.error('next element of custom checkbox must be an input checkbox')

            }
        }

        let checkLists = document.querySelectorAll('[data-role="checkbox-list"]:not([initialized])');

        checkLists.forEach(checkList => {

            //get all custom checkboxes in the checkbox list...
            let customLists = checkList.querySelectorAll(checkbox.target);

            if(at(checkList).hasAttr('id')){
                CheckBox.customListItems[at(checkList,'id').value()] = checkList;
            }

            if(customLists.length > 0){
                
                checkList.setAttribute('initialized', true);
                let checkListBind = at(checkList, 'data-bind');
                let checkListSwipe = at(checkList, 'data-swipe');
                let dataBindValue = checkListBind.value().split("-");
                let dataNavi = at(checkList, 'data-nav').value().split(':');
                let checkListNav = dataNavi[0]?.split('|');
                let isSlide = false, slideTime = 2500;

                if(checkListNav.length > 0 && (at(checkList,'id') !== '')) {
                     
                    if((checkListNav.length > 0) && (checkListNav[checkListNav.length - 1] === ':bind')) {
                      checkListNav.pop();
                      let NavBtns = checkbox.checkList(at(checkList,'id').value());
                      
                      checkListNav.forEach((Nav, index) => {
                        if(checkListNav[index].trim() !== ''){
                          let NavBtn = document.getElementById(Nav);
                          if(NavBtn && NavBtns.exists){
                            NavBtn.addEventListener('click', () => {
                              NavBtns.switch(index + 1);
                            })
                          }
                        }
                      });
                    } else {
                      
                      //get the controller buttons 
                      let stopNav, PrevNav, NextNav, NavEvents;
    
                      if(checkListNav[0] && (checkListNav[0].trim() !== '')){
                          PrevNav = document.getElementById(checkListNav[0]);
                      }
                      if(checkListNav[1] && (checkListNav[1].trim() !== '')){
                          NextNav = document.getElementById(checkListNav[1]);
                      }
                      NavEvents = dataNavi[1]; // event
                      
                      if(checkListNav.length === 3) { 
                          stopNav = checkListNav[2];
                      }
                    //   else{
                    //       NavEvents = checkListNav[2];
                    //   }
                      
                      if(stopNav && (stopNav.trim() !== '')) stopNav = document.getElementById(stopNav);
    
                      let NavBtns = checkbox.checkList(at(checkList,'id').value());
    
                      if(NavEvents === undefined) {
                          if(PrevNav){ 
                              PrevNav.addEventListener('click', function(){
                                  NavBtns.prev();
                              })
                          }
    
                          if(NextNav){
                              NextNav.addEventListener('click', function(){
                                  NavBtns.next();
                              })
                          } 
                      } else {
                          let scrollEvents = NavEvents.split(',');
                          let pushedEvents = [];
    
                          let declaredEvents = scrollEvents.map((value) => {
                              let forwards;
                              forwards = value.split('-');
                              if(forwards.length > 1){
                                  value = forwards[0];
                              }
    
                              return value.toLowerCase();
                          })
    
                          scrollEvents.forEach( event => {
                              
                              let forwards, timer;
                              
                              let flowEvents = ['load','hover','click','press'];
                              let isNavigatorEffect = false;
    
                              forwards = event.split('-');
                              if(forwards.length > 1){
                                  event = forwards[0];
                                  timer = parseInt(forwards[1]);
                              }
    
                              if(pushedEvents.includes(event)) return;
    
                              pushedEvents.push(event);
    
                              if(flowEvents.includes(event)){
                                  if(declaredEvents.length > 1){
                                      console.error('Error: unsupported events combination ('+declaredEvents.join(',')+') for navigators')
                                      return false;
                                  }else{
                                      isNavigatorEffect = true;
                                  }
                              }
    
                              // set navigation sliding handlers
                              function NavSlide(Nav, event){
                                  if(Nav){
                                      if(event === 'load'){
                                          (Nav === PrevNav)? NavBtns.prev(timer) : NavBtns.next(timer);
                                      }else{
                                          Nav.addEventListener(event, function(e){
                                              (Nav === PrevNav)? NavBtns.prev(timer) : NavBtns.next(timer);
                                          })
                                      }
                                  }
                              }
                              function NavUnSlide(Nav, event){
                                  if(Nav){
                                      Nav.addEventListener(event, function(e){
                                          NavBtns.stop()
                                      })
                                  }
                              }
    
                              if(isNavigatorEffect){ 
                                  let starter1, stopper1;
                                  let starter2, stopper2;
                                  if(event === 'hover') {
                                      starter1 = 'mouseenter';
                                      stopper1 = 'mouseleave';
                                  }else if(event === 'press') {
                                      starter1 = 'mousedown';
                                      stopper1 = 'mouseup';
                                  
                                      starter2 = 'touchstart';
                                      stopper2 = 'touchend';
                                  
                                      NavSlide(PrevNav, starter2);
                                      NavSlide(NextNav, starter2);
    
                                      NavUnSlide(PrevNav, stopper2);
                                      NavUnSlide(NextNav, stopper2);
                                  }else if(event === 'click') {
                                      starter1 = 'click';
                                  }else if(event === 'load') {
                                      starter1 = 'load';
                                  }
                                  
                                  NavSlide(PrevNav, starter1);
                                  NavSlide(NextNav, starter1);
                          
                                  if(stopNav && timer){
                                      stopNav.addEventListener('click', function(){
                                          NavBtns.stop();
                                      })
                                  }

                                  if(event !== 'click' && event !== 'load'){
                                      // apply exit effect to only hover & mousedown
                                      NavUnSlide(PrevNav, stopper1);
                                      NavUnSlide(NextNav, stopper1);
                                  }
                                  
                              }else{
                                  NavSlide(PrevNav, event);
                                  NavSlide(NextNav, event);
                              }
    
    
                          })
                      }
                      
                    }

                }


                if(dataBindValue.length === 2){
                  isSlide = dataBindValue['0'] === 'slide';
                  slideTime = parseInt(dataBindValue['1']);
                  if(slideTime < 20) slideTime = 2500;
                }else if (checkListBind.is('slide')) {
                  isSlide = true;
                }
                
                if(checkListBind.is('radio') || isSlide){

                    customLists.forEach((customList, index) => {
                        
                        let mainChecker, subChecker, exToggles;

                        mainChecker = isCheckbox(customList.nextElementSibling);
    
                        if(mainChecker){
                            mainChecker.setAttribute('e-prev','');
                        }
                            
                        customList.addEventListener('click', function(){

                            if(mainChecker){
                              
                                if(at(mainChecker,'data-bind').not('free')){
                                    
                                    if(!hasChecked(mainChecker)) {
                                        mainChecker.click();
                                    } else{
                                        if(at(mainChecker).hasAttr('data-checked')){
                                            let active = at(mainChecker, 'data-checked').value();
                                            if(typeof window[active] === 'function'){
                                                window[active](mainChecker);
                                            }
                                        }
                                    }
                                    
                                    //remove index from selected boxes
                                    exToggles = {...customLists};
                                    delete exToggles[index];
        
                                    for(let exToggle in exToggles){
                                        subChecker = isCheckbox(exToggles[exToggle].nextElementSibling);
                                        
                                        if(at(subChecker,'data-bind').not('free')){
                                            if(hasChecked(subChecker)){
                                                subChecker.click(); //uncheck
                                            }
                                        }
                                    }
    
                                }else{ 
                                    mainChecker.click();
                                }
                            }
                        })
                        
                    })
                    
                    if(isSlide) {
                        let timeout;
                        
                        function autoSwitch() {
                            
                            let checkedBox = checkList.querySelector('[data-role="checkbox"][checked="checked"]') 
                            let checkedIndex = Array.from(checkList.children).indexOf(checkedBox);
                            if(customLists.length > 0) {
                              if((checkedIndex + 1) === customLists.length){
                                  checkedIndex = 0;
                              } else {
                                checkedIndex = checkedIndex + 1;
                              }
                              customLists[checkedIndex].addEventListener('click', function(){
                                if(timeout) clearTimeout(timeout);
                                timeout = setTimeout(() => {
                                    autoSwitch()
                                }, slideTime)
                              });
                              customLists[checkedIndex].click();
                            }
                        }
                        
                        timeout = setTimeout(() => { autoSwitch(); }, 1000);
                      
                    }
                    
                }else if(checkListBind.is('base')){
                    
                    customLists.forEach((customList, index) => {

                        let mainChecker = isCheckbox(customList.nextElementSibling);

                        if(isCheckbox(mainChecker)){
                            mainChecker.setAttribute('e-prev', '')
                        }

                        customList.addEventListener('click', function(){

                            let exToggles, subChecker;
                            
                            //remove index from selected boxes
                            exToggles = {...customLists};
                            delete exToggles[index];
                            
                            if(mainChecker && !mainChecker.disabled){
                              
                              if(index === 0){
                                  
                                  mainChecker.click();
                                  
                                  if(!mainChecker.getAttribute('escape')) {
                                    
                                    for(let exToggle in exToggles){
    
                                        subChecker = isCheckbox(exToggles[exToggle].nextElementSibling);
                                        
                                        if(subChecker && !subChecker.disabled && !checkbox.hardchecks.includes(subChecker)){
                                          
                                          let subCheckerBind = at(subChecker, 'data-bind');
                                          
                                          if(subCheckerBind.not('free')){
                                            
                                            if(subCheckerBind.is('reverse')){
                                              let reverse = mainChecker.checked === subChecker.checked;
                                              
                                              if( reverse ) subChecker.click() //reverse
                                              
                                            }else{
                                              
                                              let reflect = mainChecker.checked !== subChecker.checked;
                                              
                                              if( reflect ) subChecker.click();
                                              
                                            }
                                            
                                          }
                                          
                                        }
    
                                    }
                                    
                                  } else {
                                    
                                    mainChecker.removeAttribute('escape')
                                    
                                  }
  
                              } else {
                                  
                                  //handle other boxes

                                  if(at(mainChecker,'data-bind').not(['free'])){
                                      
                                      let isReverse = at(mainChecker,'data-bind').is('reverse');
                                      let rootChecker = isCheckbox(customLists[0].nextElementSibling) 
  
                                      if(isReverse){
                                          mainChecker.click()
                                          
                                          if(rootChecker){ 
                                            if(mainChecker.checked === rootChecker.checked){
                                                customLists[0].click(); //click respective items
                                            }
                                          }
                                      }else{
                                        
                                        if(mainChecker.checked){ 
                                          mainChecker.click(); //uncheck 

                                          function reverseBoxes(){
                                            let reversed = [];
                                            let toggleOn = true;
                                            for(let exToggle in exToggles){
                                                let remToggle = exToggles[exToggle].nextElementSibling;
                                                let remToggleBind = at(remToggle, 'data-bind');
                                                
                                                if(remToggleBind.not(['free', 'reverse'])){
                                                    if(remToggle.checked){
                                                        toggleOn = false
                                                        break;
                                                    }
                                                }else if(remToggleBind.is('reverse')) {
                                                    reversed.push(exToggles[exToggle]);
                                                }
                                            }

                                            if(toggleOn){

                                                reversed.forEach(reverse => {
                                                    if(!reverse.checked){
                                                        reverse.click();
                                                    }
                                                })

                                            }
                                          }

                                          if(rootChecker.checked){
                                            rootChecker.click(); //uncheck only root
                                            reverseBoxes()
                                          }else{
                                            //check all children not checked
                                            reverseBoxes();
                                          }
                                        }else{
                                          
                                          mainChecker.click(); //check 
                                          
                                          //check if all boxes are checked before checking main box 
                                          delete exToggles[0];
                                          delete exToggles[index];
                                          let toggleOn = true;
                                          for(let exToggle in exToggles){
                                            let remToggle = exToggles[exToggle].nextElementSibling;
                                            let remToggleBind = at(remToggle, 'data-bind');
                                            
                                            if(remToggleBind.not(['free', 'reverse'])){
                                                if(!remToggle.checked && (toggleOn !== false)){
                                                    toggleOn = false
                                                    break;
                                                }
                                            }
                                          }
                                        
                                          if(toggleOn && !rootChecker.checked){
                                            
                                            customLists[0].click(); //click only parent checkbox when others are checked
                                          }
                                          
                                        }
  
                                      }
                                      
                                  }else{
                                      if(!mainChecker.disabled && !checkbox.hardchecks.includes(mainChecker)){
                                          mainChecker.click();
                                      }
                                  }
  
                              }
                              
                            }

                        })
                        
                    })
                }else if(checkListBind.is('rating')){
                  
                    //add touch sliding effects here 

                    customLists.forEach((customList, index) => {

                        customList.addEventListener('click', function(){
                            
                            let exToggles = {...customLists};
                            
                            let boxes = Object.keys(exToggles).length;
                               
                           
                            for(let i = boxes - 1; i > index; i--){
                              let checkboxItem = exToggles[i].nextElementSibling;
                              if(checkboxItem.checked){
                                customLists[index].setAttribute('check-pause', 'true')
                             
                                customLists[i].click();   //get next element item
                              }
                            }
                            
                           for(let i = 0; i <= index; i++){
                              let checkboxItem = exToggles[i].nextElementSibling;
                              if(!checkboxItem.checked){
                                customLists[i].click();
                              }
                            }
                           

                        })
                        
                        // Allow touch effect
                        if(checkListSwipe.is('enabled')){
                          touchSlide(checkList, checkbox.target)
                        }

                    })

                }
                
            }

        })

        //Handle Animation ............................

        customBoxes.forEach(customBox => {

            //set custom checkbox sibling
            let input = customBox.nextElementSibling;
                        
            if(input.getAttribute('checked') === 'false'){
                input.checked = false;
                input.removeAttribute('checked')
            }else if(input.getAttribute('checked') === 'true') {
                input.checked = true;
                input.setAttribute('checked','checked')
            }
            
            let inputType = input.getAttribute('type');

            let defaultSize = getSize(size);
            let attributeSize = getSize(customBox.getAttribute('data-size'));
            let customSize = {...defaultSize,...attributeSize}
   
            let customFSize = customBox.getAttribute('data-fsize');
            let checker = {} 

            if(
                (input.tagName === 'INPUT') && inputType &&
                (inputType.toLowerCase() === 'checkbox')
            ){

                let marker, marker1, marker2, flip;
                let labels = [], label1, label2, label;
                let colors = [], color1, color2, mColor = false;
                let customParent, customLabel;
                let callback, callbackArg = [], eager = false;

                input.setAttribute('hidden', '');

                checker.label = customBox.getAttribute('data-label') || '';
                checker.color = customBox.getAttribute('data-color') || '';
                
                callback = customBox.getAttribute('data-func');
                if(callback){
                    let [func, ...arg] = callback.split(':');
                    callback = func;
                    arg = arg.join(':');
                    if(arg) callbackArg = [arg];
                }

                eager = at(customBox).hasAttr('data-init');

                marker = customBox.querySelectorAll(checkbox.marker);
                flip = checkbox.flip;

                customParent = customBox.parentNode.closest('[data-role="checkbox"]');
                customLabel  = (customParent)? customParent.nextElementSibling : undefined;
                
                if(customLabel && (customLabel.getAttribute('data-access') !== 'label')){
                    customLabel = undefined;
                }

                label = input.nextElementSibling;

                if(label && (label.getAttribute('data-access') !== 'label')){
                    label = undefined;
                }

                if(!label && customLabel) label = customLabel;

                if(checker.label){
                    if(label){
                        if(typeof checker.label === 'string'){
                            labels = stringSplit(checker.label);
                            label1 = labels[0]; //uncheck
                            label2 = labels[1]; //checked
                        }
                    }
                }
                
                if(checker.color){
                    //get first character 
                    mColor = checker.color.charAt(0);
                    if(mColor === '@'){
                      mColor = true;
                      checker.color = checker.color.substring(1);
                    }else{
                      mColor = false;
                    }
                    colors = checker.color.split("|");
                    if(colors.length > 0){
                        color1 = colors[0]; //uncheck
                        color2 = colors[1]; //checkeds
                    }
                }

                if(marker.length > 0 && !css){

                    let style, styleCss = ''; let id = btoa(`${checkbox.target} ${checkbox.marker}`);

                    let styleExists = document.querySelector(`style[checkbox="${id}"]`);

                    if(!styleExists){

                        style = document.createElement('style');
                        style.setAttribute('id',`${id}`);
    
                        if(size && customSize){
                            styleCss += `
                                width: ${customSize.x};
                                height: ${customSize.y};
                            `
                        }
    
                        if(fsize){
                            styleCss += `
                                font-size: ${customFSize};
                            `
                        }
    
                        if(fit){
                            styleCss += `
                                background-size: cover;
                                background-position: center top;
                                background-repeat: no-repeat;
                            `
                        }
        
                        if(styleCss !== ''){
                            styleCss = `
                            ${checkbox.target} ${checkbox.marker} {
                                ${styleCss}
                            }
                            `
                            style.textContent = styleCss;
                            document.head.appendChild(style);
                        }

                    }
                    css = true;  

                }

                
                if(at(customBox,'data-flip').is('true')){
                    flip = true;
                }else if(at(customBox,'data-flip').is('false')){
                    flip = false;
                }

                if((marker.length > 0)){
                    marker1 = marker[0];
                    marker2 = marker[1];
                } else {
                    if(customSize) {
                        if(customSize.x !== '') customBox.style.width = customSize.x;
                        if(customSize.y !== '') customBox.style.height = customSize.y;
                    }
                }

                if(marker1){
                    if(customSize){
                        marker1.style.width = customSize.x;
                        marker1.style.height = customSize.y;
                        if(marker2) marker2.style.width = customSize.x;
                        if(marker2) marker2.style.height = customSize.y;
                    }
                    if(customFSize){
                        marker1.style.fontSize = customFSize;
                        if(marker2) marker2.style.fontSize = customFSize;
                    }
                }

                if(input.disabled){
                    checkbox.hardchecks.push(input);
                    checkbox.hardchecks.push(customBox);
                    customBox.setAttribute('disabled', 'true');
                    if(customParent) customParent.setAttribute('disabled', 'true');
                }

                //set default behaviour
                if(input.checked){
                    customBox.setAttribute('checked', 'checked'); 
                    if(customParent) customParent.setAttribute('checked', 'checked');
                    if(marker2 && flip){
                        marker1.setAttribute('hidden','');
                        marker2.removeAttribute('hidden');
                    }
                    
                    if(label1){
                        label.textContent = label2;
                    }

                    //apply second color to label only if second color is defined 
                    if(color2 && label1) label.style.color = color2;  
                    
                    //apply color to markers if first or second color is defined
                    if(color1 && marker1 && mColor) {
                        if(!color2){
                            marker1.style.color = color1;
                        }else{
                            marker1.style.color = color2;
                        }
                    }
                    if(color2 && marker2 && mColor) marker2.style.color = color2;

                }else{
                    customBox.setAttribute('checked', 'unchecked');
                    if(customParent) customParent.setAttribute('checked', 'unchecked');
                    if(marker2 && flip){
                        marker1.removeAttribute('hidden');
                        marker2.setAttribute('hidden','');
                    }  
                    
                    if(label1){
                        label.textContent = label1;
                    }

                    if(color1 && label) label.style.color = color1;     
                    if(color1 && marker1 && mColor) marker1.style.color = color1;
                    if(color2 && marker2 && mColor) marker2.style.color = color2;
                }
                
                let grandParent, checkedBoxes, listId;
                
                // get checkbox-list and selections
                if(customParent){
                  grandParent = customParent.closest('[data-role="checkbox-list"]');
                  if(grandParent) {
                    checkedBoxes = grandParent.querySelectorAll('input:checked').length
                    let gpId = grandParent.getAttribute('id');
                    if(gpId && (gpId.trim() !== '')){
                        listId = Array.from(grandParent.children).indexOf(customParent);
                        if(!isNaN(parseInt(listId))){
                            listId += 1;
                        }
                    }
                  }
                }
                
                let properties = {
                  native:input, 
                  custom: customBox, 
                  marker: marker, 
                  checked: (input.checked), 
                  fit: checkbox.fit, 
                  flip: flip, 
                  value: (input.value),
                  checkList: grandParent, //checkbox list
                  parent: customParent, //data role checkbox
                  checkedBoxes: checkedBoxes,       
                  listId: listId           
                }

                if(typeof init === 'function'){
                    if(typeof animeAttr == 'function'){
                        animeAttr(customBox, input.checked, customBox.getAttribute('data-assign'), marker)
                    }
                    init(properties);
                }else if (init === true) {
                    if(typeof animeAttr == 'function'){
                        animeAttr(customBox, input.checked, customBox.getAttribute('data-assign'), marker)
                    }
                }

                if(eager && callback !== ''){
                    if(typeof window[callback] !=='function'){
                        console.warn('unknown callback function "'+callback+'" defined in data-func attribute');
                        callback = undefined;
                    }else{
                        window[callback](properties, ...callbackArg);
                    }
                }

                input.addEventListener('click', function(e){

                    if(input.getAttribute('disabled')  || checkbox.hardchecks.includes(input)){
                        e.preventDefault();
                    }else{
                        if(!this.getAttribute('selection')) {
                            checkEvent(this)
                        }else{
                            this.removeAttribute('selection');
                            e.preventDefault();
                        }
                    }

                });

                customBox.addEventListener('click', function(){
                    
                    
                    if(grandParent){
                        
                        checkedBoxes = grandParent.querySelectorAll('input:checked').length
         
                        if(at(grandParent).hasAttr('data-max')) {
                            let max, callback;

                            if(at(grandParent).hasAttr('data-maxim')){
                                callback = at(grandParent,'data-maxim').value();
                            }

                            max = parseInt(at(grandParent, 'data-max').value()); 

                            if((checkedBoxes === max) && !at(customBox,'checked').is('checked')) {
                                if(typeof window[callback] === 'function') {
                                    let props = {};
                                    props.checked = grandParent.querySelectorAll(checkbox.target+'[checked="checked"]');
                                    props.unchecked = grandParent.querySelectorAll(checkbox.target+':not([checked="checked"])');
                                    props.max = true;
                                    window[callback](props);
                                }
                                return false;
                                
                            }
                        }
                    }
                    //if not e-prev defined
                    if(!at(customBox, 'check-pause').is('true')){
                      if(input.getAttribute('e-prev') === null){
                          if(!at(customBox).hasAttr('controllers')) input.click();
                          input.setAttribute('selection', 'true');
                          setTimeout(() => input.removeAttribute('selection'), 50);
                      }
                    }else{
                      customBox.removeAttribute('check-pause');
                    }
                })

                if(label){
                    label.addEventListener('click', function(){
                        customBox.click();
                    })
                }  
                
                if(at(customBox).hasAttr('data-control')){

                    let auto  = false;

                    let controller = at(customBox,'data-control').value('');

                    if(controller === 'reload'){
                        controller = ':markers';
                        auto = true;
                    }

                    if(controller !== ''){
                        let parent, markers;

                        if(controller === ':markers'){
                            markers = controller;
                        }else{
                            parent = controller;
                            parent = customBox.closest(parent);
                        }

                        if(parent){
                            parent.addEventListener('click', function(){
                                 customBox.click();
                                 if(input.checked){
                                    parent.setAttribute('checked', 'checked')
                                 }else{
                                    parent.removeAttribute('checked')
                                 }
                            })
                        }else if(markers){

                            customBox.setAttribute('controllers', '');
                            
                            if(marker1 && marker2){

                                marker1.addEventListener('click', function(){
                                    if(input.checked){
                                        input.click(); //uncheck
                                    }
                                })

                                marker2.addEventListener('click', function(){
                                    if(!input.checked){
                                        input.click(); //check
                                    }
                                })

                            }
                            if(auto) input.click();
                        }

                    }
                }

            }

        })
        
        // handle touch sliding animation ..... 
        function touchSlide(ratebind, target){
          
            const rateboxes = ratebind.querySelectorAll('[data-role="checkbox"]');
            let startCheckbox; let mousePressed;

            rateboxes.forEach((ratebox) => {
              ratebox.addEventListener('touchstart', handleTouchStart);
              ratebox.addEventListener('touchmove', handleTouchMove);
              ratebox.addEventListener('mousedown', handleTouchStart);
              ratebox.addEventListener('mousemove', handleTouchMove);
              ratebox.addEventListener('mouseup', handleMouseEnd);
            });

            function handleTouchStart(event) {
              startCheckbox = event.currentTarget;
              let customBox = startCheckbox.querySelector(target);
              mousePressed = true;
              if((getIndex(startCheckbox) === 0) && !isChecked(customBox)){ 
                // customBox.click();********************************************
              }
            }

            function handleTouchMove(event) {
              event.stopPropagation();
              let currentCheckbox; let customBox;

              if(event.touches){
                 currentCheckbox = document.elementFromPoint(event.touches[0].clientX, event.touches[0].clientY);
                }else{
                  if(mousePressed) {
                      currentCheckbox = document.elementFromPoint(event.clientX, event.clientY);
                  }
              }
              if(currentCheckbox) customBox = currentCheckbox.querySelector(target);
              
              if (customBox && (currentCheckbox !== startCheckbox)) {
                
                const checkex = customBox.nextElementSibling;
                let front = isForwardSlide(startCheckbox, currentCheckbox);
                let backs = isBackwardSlide(startCheckbox, currentCheckbox);
                let neutral = (front === false) && (backs === false);
                
                let checkNum = getIndex(currentCheckbox);
                // permit activity: if item is checkbox
                let isCheckBox = currentCheckbox.getAttribute('data-role') === 'checkbox';
                
                if(isCheckBox) {
                  startCheckbox = currentCheckbox;

                    if(front && !isChecked(customBox)){
                      for(let i = 0; i < checkNum; i++){
                        let ltCheck = rateboxes[i].querySelector(target)
                        if(!ltCheck.nextElementSibling.checked){
                          ltCheck.click()
                        }
                      }
                      customBox.click();
                     
                    } else if (backs && !neutral){
                      for(let i = rateboxes.length - 1; i > checkNum; i--){
                        let ltCheck = rateboxes[i].querySelector(target)
                        if(ltCheck.nextElementSibling.checked){
                          ltCheck.click()
                        }
                      }
                    }
                  
                }

              }
              
            }

            function handleMouseEnd(event){
                mousePressed = false;
            }

            function isForwardSlide(startCheckbox, currentCheckbox) {
              // Logic to determine if the slide is forward
              return currentCheckbox.offsetLeft > startCheckbox.offsetLeft;
            }
            
            function isBackwardSlide(startCheckbox, currentCheckbox) {
              // Logic to determine if the slide is backward
              //return startCheckbox.offsetLeft > currentCheckbox.offsetLeft;
              // Get the index of the current and start checkboxes
              const currentIndex = getIndex(currentCheckbox);
              const startIndex = getIndex(startCheckbox);
            
              // Logic to determine if the slide is forward
              return currentIndex < startIndex;
            }
            
            function isChecked(customBox) {
              // Logic to determine if the custom box has the checked attribute
              return customBox.getAttribute('checked') === "checked";
            }
         
            // Helper function to get the index of the checkbox in its parent
            function getIndex(checkbox) {
              return Array.from(checkbox.parentNode.children).indexOf(checkbox);
            }
          
        }
        
    }

    /**
     * Static helper to append custom boxes into checklist containers.
     * 
     * @param {HTMLElement|string} customBox - The checkbox element or HTML string
     * @param {Object} options
     * @param {number} [options.clones=1] - Number of copies to insert per container
     * @param {Function} [options.onEachBox] - Function run on each inserted box
     * @param {string|string[]} [options.checklists] - Target container(s) by id
     * @returns {HTMLElement[]} - Flat array of all appended elements
     */
    static generic(customBox, { clones = 1, onEachBox = null, checklists = [] } = {}) {
        if (!customBox) return [];

        // Normalize checklists to array
        if ((typeof checklists === "string") || (checklists instanceof Element)) {
            checklists = [checklists];
        }

        // Convert string to HTMLElement if needed
        let templateEl;
        if (typeof customBox === "string") {
        const parser = new DOMParser();
        const doc = parser.parseFromString(customBox, "text/html");
        templateEl = doc.body.firstElementChild;

        // Wrap if missing data-role="checkbox"
        if (!templateEl || templateEl.getAttribute("data-role") !== "checkbox") {
            const wrapper = document.createElement("div");
            wrapper.setAttribute("data-role", "checkbox");
            if (templateEl) wrapper.appendChild(templateEl);
            templateEl = wrapper;
        }
        } else {
            templateEl = customBox;
        }

        // Validation: must contain <input type="checkbox">
        const hasInput = templateEl.querySelector?.('input[type="checkbox"]');
        if (!hasInput) {
            console.warn("generic custom checkboxes must contain an input of checkbox type");
            return [];
        }

        const appended = [];

        // Insert into target containers
        checklists.forEach(id => {
            let container;
            if(typeof id === 'string'){
                container = document.getElementById(id);
                if (!container) return;
            }else{
                container = id;
            }

            // Ensure container has [data-role="checkbox-list"]
            container.setAttribute("data-role", "checkbox-list");

            for (let i = 1; i <= clones; i++) {
                const box = templateEl.cloneNode(true);

                if (typeof onEachBox === "function") {
                    onEachBox(box, i, container);
                }

                container.appendChild(box);
                appended.push(box);
            }
        });

        return appended;
    }

    check(config) {
      return new CheckBox(config);
    }

    checkList(id) {
        let checkbox = this;

        //get checklist id from custom lists 
        let customListItem = CheckBox.customListItems[id];
        
        if(!customListItem) return {response: 'checklist id {'+id+'} not found!', exists: false}; //Accept only checkbox lists with id
        let customListSelector = checkbox.target;
        let customBoxes = customListItem.querySelectorAll(customListSelector);
        let customBoxesNum = customBoxes.length;
        let checkedOnes = []
        let controller;
        
        function currentCheckbox(){
          let i = -1;
          customBoxes.forEach((customBox, index) =>{
              if(customBox.getAttribute('checked') === 'checked') {
                i = index;
                checkedOnes.push(customBox);
              }
          })
          return i;
        }
        
        if(!checkbox.customListData.hasOwnProperty(id)){
            checkbox.customListData[id]= {}
        }
        let data = checkbox.customListData[id];
        
        return controller = {
            response: 'checklist id {'+id+'}',

            exists: true,
            
            /**
             * Returns  main checklist item
             * @returns object
             */
            frame: customListItem,
            
            /**
             * Returns the grouped sections (identified with data-role="checkbox") within a checkbox list
             * @param {integer} index optional box index : runs from 1 above
             * @returns {object} checklist sections 
             */
            sections: function(index) {

                let sects = {}, sectionList;
                
                sectionList = customListItem.querySelectorAll('[data-role="checkbox"]');

                if(arguments.length > 0){
                    // resolve specified argument 
                    index = parseInt(index);
                    if(!Number.isNaN(index)){
                        index = index - 1;
                    }
                    return sectionList[index];
                } else {
                    sectionList.forEach((section,index)=>{
                        sects[index+1] = section;
                    });
                    return sects;
                }

            },

            /**
             * Returns the custom checkboxes within a checkbox list
             * @param {int} index optional box index runs from 1 above
             * @returns object
             */
            boxes: function(index)  {     
                if(arguments.length > 0){
                    if(index && parseInt(index)){
                        index = index - 1;
                        return customBoxes[index]   
                    } 
                    return undefined;
                }           
                let boxList = {};
                
                customBoxes.forEach((box, index) => {
                    boxList[index+1] = box
                })
                return boxList;
            },
            
            /**
             * Get all custom boxes or specified custom box 
             **/
            get: function(number) {
              if(arguments.length > 0) {
                 if(parseInt(number) && (number > 0)) {
                    let cbox = customBoxes[number-1];
                    let responder;
                    return responder = {
                      customBox : () => cbox, //relative custom box
                      disable : () => {
                        let cboxInput = cbox.nextElementSibling;
                        let cboxCase = cbox.closest('[data-role="checkbox"]');
                        cbox.setAttribute('disabled', 'disabled')
                        cboxInput.setAttribute('disabled', 'disabled')
                        cboxCase.setAttribute('disabled', 'disabled')
                        let bindedNav = responder.nav();
                        if(bindedNav){
                          bindedNav.setAttribute('disabled','disabled')
                        }
                        return true;
                      },
                      enable : () => {
                        let cboxInput = cbox.nextElementSibling;
                        let cboxCase = cbox.closest('[data-role="checkbox"]');
                        cbox.removeAttribute('disabled')
                        cboxInput.removeAttribute('disabled')
                        cboxCase.removeAttribute('disabled')
                        let bindedNav = responder.nav();
                        if(bindedNav){
                          bindedNav.removeAttribute('disabled')
                        }
                        return true;
                      },
                      switch : (status) => {
                        controller.switch(number, status)
                      },
                      nav: () => {
                        // get binded controller for current number... 
                        let dataNav = customListItem.getAttribute('data-nav'); 
                        
                        if(dataNav){
                          let checkListNav = dataNav.split('|');
                          let checkListId  = customListItem.getAttribute('id')
                          let checkListLen = checkListNav.length
                          
                          if(checkListLen > 0 && (checkListId !== '')) {
                              if(checkListNav[checkListLen - 1] === ':bind') {
                                checkListNav.pop();
                                let relBtn = checkListNav[number - 1];
                                if(relBtn && relBtn.trim() !== ''){
                                  return document.getElementById(relBtn);
                                }
                              }
                          }
                        }
                        
                        return false;
                        
                      }
                    }
                 }
                 return undefined;
              } else{
                  return { 
                    customBox: function(index) {
                        if(arguments.length > 0){
                            return controller.get(index);
                        }else{
                            //return all custom boxes
                            let boxList = {};
                            customBoxes.forEach((customBox, index) => {
                                boxList[index + 1] = customBox
                            })
                            return boxList;
                        }
                    },
                  }
              }
            },
            
            disable: (number) => {
              
              controller.get(number).disable();

            },
            
            enable: (number) => {
              
              controller.get(number).enable();

            },

            prev: (interval) => {
            
              if(interval === false && !data.statePaused){
                data.statePaused = true;
                return false;
              }else if(interval === true){
                data.statePaused = false;
                return true;
              }else if(!isNaN(interval)) {
                data.statePaused = false;
              }
              if(!data.statePaused){
                  if(data.nextActive) {
                    clearInterval(data.nextInterval);
                    data.nextActive = false;
                  }
                   
                  //get all custom boxes... 
                  let current = currentCheckbox();
                  let previous = current - 1;
    
                  if(previous < 0) previous = customBoxesNum - 1;
                 
                  if(!customBoxes[previous]) console.warn('Target checkbox selector may mismatch. Current selector is:'+customListSelector)
                  customBoxes[previous]?.click();
                  
                  if(interval && (!data.prevActive)) {
                    data.prevActive = true;
                    data.prevInterval = setInterval(() => controller.prev(), interval)
                  }
              }
            }, 
            
            stop: () => { 
              if(data.nextActive){
                    clearInterval(data.nextInterval)
              }
              if(data.prevActive){
                    clearInterval(data.prevInterval)
              }
                
              data.nextActive = false;
              data.prevActive = false;
            },
            
            next: (interval) => {
                
              if(interval === false && !data.statePaused){
                data.statePaused = true;
                return false;
              }else if(interval === true){
                data.statePaused = false; 
                return true;
              }else if(!isNaN(interval)) {
                data.statePaused = false;
              }

              if(!data.statePaused){
                  if(data.prevActive) {
                    clearInterval(data.prevInterval)
                    data.prevActive = false;
                  }
                  //get all custom boxes... 
                  let current = currentCheckbox();
                  let next = current + 1;
    
                  if(next > (customBoxesNum - 1)) next = 0;
                 
                  if(!customBoxes[next]) console.warn('Target checkbox selector may mismatch. Current selector is: '+customListSelector)
                  customBoxes[next]?.click();
                  if(interval && (!data.nextActive)) {
                    data.nextActive = true;
                    data.nextInterval = setInterval(() => controller.next(), interval)
                  }
              }

            },

            switch: (number, status = 'both') => {
                let current = currentCheckbox();
                let choice = customBoxes[number-1];
                let choiceInput = choice.nextElementSibling;

                if(!(['on','off','both'].includes(status))){
                    console.error('invalid type supplied for switch');
                    return false; 
                }

                function resetAll() {
                    checkedOnes.forEach(checked => {
                        if(choice && (checked !== choice) && (checked.getAttribute('checked') === 'checked')) {
                            checked.click();
                        }
                    })
                }

                if(status === 'on'){

                    if(choice && (choice.getAttribute('checked') !== 'checked')) {
                        choice.click();
                    }

                } else if (status === 'off') {
                    if(choice && (choice.getAttribute('checked') === 'checked')) {
                        //choice.click();
                        if(choice && (choice.getAttribute('checked') === 'checked')){ 
                            let radioList = choice.closest('[data-bind="radio"]');
                            if(radioList){
                              //fix radio buttons ... 
                              choiceInput.click()
                            } else {
                              choice.click()
                            }
                        }
                    }
                } else {

                    choice.click();
                    
                }
              
            },

            nav : (index) => {

                if((arguments.length > 0)){
                    if(!parseInt(index)) return false;
                    index = (index > 0)? index - 1 : index;  
                }

                let dataNav = customListItem.getAttribute('data-nav'); 
                        
                if(dataNav){
                    let checkListNav = dataNav.split('|');
                    let checkListId  = customListItem.getAttribute('id')
                    let checkListLen = checkListNav.length
                    
                    if(checkListLen > 0 && (checkListId !== '')) {
                        if(checkListNav[checkListLen - 1] === ':bind') {
                            checkListNav.pop();

                            if(arguments.length > 0) {
                                if(checkListNav[index].trim() === '') return undefined;
                                return document.getElementById(checkListNav[index]);
                            }

                            checkListNav = checkListNav.map((value) => {
                                if(value.trim() === '') return undefined;
                                return document.getElementById(value);
                            })
                            return checkListNav;
                        }
                    }
                }
                
                return false;

            }

        }

    }

}

export default SPAuto(CheckBox);

window.CheckBox = CheckBox;