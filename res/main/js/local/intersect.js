class Intersect {

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
        let $this = this;
        let count  = {}; count.index = -1;
    
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
              elem.index  = count.index;
              elem['unobserve'] = function() {
                  observer.unobserve(entry.target);
              }
  
              if(callback) {
                  callback(elem, observer);
              }
          });
    
        }, sectOptions);
    
        elements.forEach(element => {  
            count.index++;
            observer.observe(element);
        })
        
    }
  
    status(el){
      
      let selector = el.el || '';
      let callback = el.callback || '';
      let onScroll = el.onScroll || false;
      let threshold = el.threshold || [0];
      if(!Array.isArray(threshold)) threshold = [0];
      if(threshold.length === 0) threshold = [0];
      let controller = {}; controller.terminate = [];
  
      if(selector) {
  
          let elements = document.querySelectorAll(selector);
  
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
                  entri.element.id = entri.id;
                  entri.scrollPoint = window.scrollY;
  
                  entri['unobserve'] = function(){
                      controller.terminate.push(entry.target);
                  }
                  entri['unobserved'] = function() {
                      return controller.terminate.includes(entry.target);
                  }
                  if(controller.terminate.includes(entry.target)) {
                      scrollObserver.unobserve(entry.target);
                      return;
                  }
                  if(onScroll !== 'intersect') scrollObserver.unobserve(entry.target);
                  if(callback) callback(entri);
              })
  
          },{
              threshold: threshold
          });
  
  
          elements.forEach(element => {
              scrollObserver.observe(element);
          })
      
          if(onScroll === 'scroll'){    
  
              window.addEventListener('scroll', function(){
     
                  elements.forEach((element) => {  
    
                      if(!controller.terminate.includes(element)){
                          scrollObserver.observe(element);
                      } 
  
                  })
          
              });
      
          }
  
      }
  
    }
  
    onScroll(el) {
      el.onScroll = 'scroll';
      this.status(el);
    }
  
}