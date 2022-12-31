/**
 * Jquery dependent class for checking handling scroll positions
 */
class Intersect {

  /**
   * 
   * @param {*} el element
   * @param {*} callback 
   * @param {*} timeout 
   */
  observe(el, callback, timeout) {
  
      let selector = el.el; 
      let element = document.querySelectorAll(selector);
      let newOptions = el.options || {};
      timeout = timeout || 10;
  
      const defaultOptions = {
          threshold: 1,
          rootMargin:"0px 0px 0px 0px"
      };
  
      let sectOptions = {...defaultOptions, ...newOptions}
      
      const observer = new IntersectionObserver((entries)=>{
  
      entries.forEach(entry => {
          
          entry.inview = entry.isIntersecting;
  
          if(callback) {
              setTimeout(() => {
              callback(entry, observer);
              }, timeout)
          }
      })
  
      }, sectOptions);
  
      element.forEach(elem => {  
          observer.observe(elem);
      })
      
  }

  status(el, callback, timeout){
      $(window).scroll(function(){
          //get scroll position
          let selector = el.el || '';
          let element = document.querySelectorAll(selector);
          let newOptions = el.options || {};
          timeout = timeout || 10;
      
          const defaultOptions = {};

          if(selector){
              let sectOptions = {...defaultOptions, ...newOptions}
              let windowTop  = $(window).scrollTop();
              let elementTop = $(el.el).offset().top;
              let distance   = elementTop - windowTop;
              
              let position = {}, entry = {};
              position.fromTop = distance;
              position.upZero  = distance > 0;
              position.atZero  = distance == 0;
              position.downZero  = distance < 0;
              position.aboveTop  = distance <= 0;
              position.belowTop  = distance > 0;
              entry.target = $(el.el);
              entry.position = position;
              if(callback){    
                  setTimeout(() => {
                      callback(entry);
                  }, timeout)
              }
            
          }
      
      })
  }

}

