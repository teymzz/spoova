  
class Theme {
    constructor(config = {}) {
      const defaults = {
        root: '',
        styles: '',
        script: '',
        assumeCssPath: false
      };
      this.defaults = { ...defaults, ...config };
      this.root = this.defaults.root;
      this.styles = this.defaults.styles;
      this.script = this.defaults.script;
      this.assumeCssPath = this.defaults.assumeCssPath;
      this.currentThemeName = null;
    }
  
    choose(themeName, callback) {
      if (!themeName) {
        console.error('Theme name is required.');
        return;
      }
  
      let stylePath;
      
      if (this.styles[themeName]) {
        stylePath = `${this.root}/${this.styles[themeName]}.css`;
      } else if (this.assumeCssPath) {
        stylePath = `${this.root}/${themeName}.css`;
      } else {
        console.error('Style path for the theme is not defined.');
        return;
      }
  
      const currentThemePath = `${this.root}/${this.currentThemeName}`;
      const existingStyle = document.querySelector(`link[href*="${currentThemePath}.css"]`);
      
      if (existingStyle) {
        existingStyle.href = stylePath;
      } else {
        const linkTag = document.createElement('link');
        linkTag.rel = 'stylesheet';
        linkTag.href = stylePath;
        document.head.appendChild(linkTag);
      }
  
      this.currentThemeName = themeName;
  
      const existingScript = document.querySelector(`script[src*="${this.script}"]`);
      if (!existingScript && this.script) {
        const scriptPath = `${this.root}/${this.script}`;
        const scriptTag = document.createElement('script');
        scriptTag.src = scriptPath;
        document.head.appendChild(scriptTag);
        scriptTag.onload = function(){
            callback()
        }
      }else{
        callback()
      }
    }
}
  