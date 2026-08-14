import { SPAuto } from "./autoload/SPAuto.js";   

/**
 * initialize usable functions
 */
function init() {
  ss.helper.dataScrollHash();
  ss.helper.dataScroll();
  ss.loadImages();
  // ss.formValidator();
}

export default SPAuto(init);
window.init = init 
init();