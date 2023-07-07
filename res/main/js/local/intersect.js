class Intersect {

    constructor(){

        this.element = {};

    }

    /**
     * 
     * @param {*} el element
     * @param {*} callback 
     * @param {*} timeout 
     */
    observe(el) {
        let selector = el.el; 
        let elements = document.querySelectorAll(selector);
        let newOptions = el.options || {};
        let callback = el.callback || false;
        let intersect = this;
        let count = -1;
    
        const defaultOptions = {
            threshold: [0],
            rootMargin:"0px"
        };
    
        let sectOptions = {...defaultOptions, ...newOptions}

        const observer = new IntersectionObserver((entries)=>{
  
          entries.forEach(entry => {

              let elem = {};
  
              for(let i in entry){
                  elem[i] = entry[i];
              }
  
              elem.inview = entry.isIntersecting;
              elem.index  = entry.target.index;
              elem.selector  = entry.target.selector;
              
              if(elem.inview) entry.target.intersections++;

              elem.intersections = entry.target.intersections;

              elem['unobserve'] = function() {
                  observer.unobserve(entry.target);
              }
  
              if(callback) {
                  callback(elem, observer);
              }
          });
    
        }, sectOptions);

        elements.forEach(element => { 
            count++; 
            element.index = count;
            element.selector = selector;
            element.intersections = 0;
            observer.observe(element);
        })
        
    }
  
    status(el){

      let intersect = this; 
      let selector = el.el || '';
      let callback = el.callback || '';
      let onScroll = el.onScroll || false;
      let threshold = el.threshold || [0];
      if(!Array.isArray(threshold)) threshold = [0];
      if(threshold.length === 0) threshold = [0];
      let controller = {}; controller.terminate = [];
      let count = -1; let elementState = {};
  
      if(selector) {
  
          let elements = document.querySelectorAll(selector);

          intersect.element.count = elements.length;
  
          const scrollObserver = new IntersectionObserver(entries => {
  
              entries.forEach((entry) => {
                  let elementTop = entry.boundingClientRect.y;              
                  let position = {}, entri = {};              
                  position.fromWindowTop = parseInt(elementTop);
                  position.aboveWindowTop  = elementTop <= 0;
                  position.belowWindowTop  = elementTop > 0;
                  position.zeroDownwards  = elementTop < 0;
                  position.zeroPoint  = elementTop == 0;
                  position.zeroUpwards  = elementTop > 0;
                  position.isIntersecting = entry.isIntersecting;
  
                  for(let i in entry){
                      entri[i] = entry[i];
                  }
  
                  entri.inview = entry.isIntersecting;
                  entri.id     = entry.target.id || '';
                  entri.element = position;
                  entri.index = entry.target.index;
                  entri.element.index = entry.target.index;
                  entri.element.selector = entry.target.selector;
                  entri.selector = entry.target.selector;
                  entri.element.id = entri.id;
                  entri.scrollPoint = window.scrollY;
                  elementState[entry.index] = entry
                  
                  if(entri.inview && (!intersect.element[entri.index].intersecting)) {
                    intersect.element[entri.index].intersections++
                    intersect.element[entri.index].intersecting = true;
                  }else if(!entri.inview){
                    intersect.element[entri.index].intersecting = false;
                  }

                  entri.intersections = intersect.element[entri.index].intersections
  
                  entri['unobserve'] = function(){
                      controller.terminate.push(entry.target);
                  }
                  entri['unobserved'] = function() {
                      return controller.terminate.includes(entry.target);
                  }
                  if(controller.terminate.includes(entry.target)) { alert();
                      scrollObserver.unobserve(entry.target);
                      return;
                  }

                  if(onScroll !== 'intersect') scrollObserver.unobserve(entry.target);
                  if(callback) callback(entri);
              })
  
          },{
              threshold: threshold
          });

          let eventScroll = function eventScroll(element){
    
                if(!controller.terminate.includes(element)){
                    scrollObserver.observe(elementState[element.index]);
                } else {
                    let terminate = ((controller.terminate.length === intersect.element.count)
                                      || onScroll === 'scroll-item');

                    if(terminate) {
                        console.log(intersect.element.event)
                        document.removeEventListener('scroll', intersect.element.event) 
                    }
                }
          }
  
          if(elements.length > 1 && onScroll =='scroll-item'){
            console.error('Intersect:scroll-item cannot be used on more than one element!')
            return;
          }
          
          elements.forEach(element => {
            
              count++;
              
              element.index = count;
              element.selector = selector;
              element.intersections = 0;
              element.state = element;

              intersect.element[element.index] = {};
              intersect.element[element.index].intersections = 0;

              elementState[count] = element;
              element.state = elementState;

              scrollObserver.observe(element);

              intersect.element.event = function(){ 
                eventScroll(element) 
              }
          })

          if((onScroll === 'scroll') || (onScroll === 'scroll-item')){
            document.addEventListener('scroll', intersect.element.event);
          }
  
      }
  
    }
  
    onScroll(el) {
      el.onScroll = 'scroll';
      this.status(el);
    }
  
    item(el) {
      el.onScroll = 'scroll-item';
      this.status(el);
    }
  
}