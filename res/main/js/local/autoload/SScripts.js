import SSDom, { miDom } from "./SSDom.js";

const SPRegister = new Map();

function SScripts(cls) {
  if (typeof cls !== 'function' || !cls.name) {
    throw new Error('Only named classes can be registered.');
  }
  let name = cls.name;
  name = name.charAt(0).toLowerCase() + name.slice(1);
  SPRegister.set(name, cls);
}

const handler = {
  get(_, prop) {
    if (prop === 'scripts') {
      return (cb) => {
        let scripts = Array.from(SPRegister.keys());
        scripts = scripts.map(name => name.charAt(0).toLowerCase() + name.slice(1));
        return typeof cb === 'function' ? cb(scripts) : scripts;
      };
    }

    if (prop === 'includes') {
      return (cb) => {
        let scripts = Array.from(SPRegister.keys()); let includes = false;
        scripts = scripts.map(name => name.charAt(0).toLowerCase() + name.slice(1));
        cb = Array.isArray(cb)? cb : [cb];
        cb.forEach(c => {
          includes = scripts.includes(c);
          if(includes === false) return;
        });

        return includes;
      };
    }

    if (prop === 'requires') {
      return (names, main = 'class') => {
        names = Array.isArray(names)? names : [names];
        const missing = names.filter(name => !SPRegister.has(name.charAt(0).toLowerCase() + name.slice(1)));
        const misseds = missing.map(name => "ss." + name.charAt(0).toLowerCase() + name.slice(1));
        if (missing.length) {
          console.error(`${main} missing [${misseds.join(',')}]`);
          return false;
        }
        return true;
      };
    }

    if(prop === 'select'){
      return (selector) => miDom(selector)
    }

    // if (prop === 'ssDOM') {
    //   return (selector, context = document) => {new SSDom(selector, context)};
    // }

    const cls = SPRegister.get(prop.charAt(0).toLowerCase() + prop.slice(1));
    if (!cls) {
      throw new Error(`class "${prop}" not found in SScripts module.`);
    }

    // Return a proxy to support both instance and static access
    return new Proxy(function () {}, {
      apply(_, __, args) {
        return new cls(...args); // Allow SScripts.myClass() to create instance
      },
      get(_, staticProp) {
        if (staticProp === 'methods') {

          /**
           * @param {bool|string} type optional [true|false|static|instance]
           *  - false: returns grouped object keys and values pair (names, instance, static, items)
           *  - true: returns full numbered list of method items within the current class object 
           *  - static: returns grouped object keys and values pair relative to static methods (instance, items)
           *  - instance: returns grouped object keys and values pair relative to instance methods (instance, items)
          */
          return (type = false) => {
            let staticList = {}, instanceList = {}, staticNames = [], instanceNames = [];

            function createSignatureOnlyWrapper(fn) {
              const fnStr = fn.toString()
                .replace(/\/\*.*?\*\//g, '')   // Remove block comments
                .replace(/\/\/.*$/gm, '');     // Remove line comments

              const nameMatch = fnStr.match(/function\s+([^\s(]+)/);
              const fnName = nameMatch ? nameMatch[1] : fn.name || 'wrappedFunction';

              const paramMatch = fnStr.match(/^[^(]*\(\s*([^)]*)\)/m);
              const paramList = paramMatch ? paramMatch[1].trim() : '';

              const code = `
                return function ${fnName}(${paramList}) {
                  throw new Error("calling ${prop}.${fnName}() out of required scope is denied.");
                };
              `;

              return new Function(code)(); // Returns the named function
            }

            const instanceKeys = Object.getOwnPropertyNames(cls.prototype)
              .filter(k => typeof cls.prototype[k] === 'function' && k !== 'constructor');
            
            instanceList['**protected**'] = true;
            instanceKeys.forEach((instanceKey) => {
              instanceNames.push(instanceKey);
              instanceList[instanceKey] = createSignatureOnlyWrapper(cls.prototype[instanceKey])
            })
            
            const staticKeys = Object.getOwnPropertyNames(cls)
              .filter(k => typeof cls[k] === 'function' && k !== 'prototype' && k !== 'name' && k !== 'length');
              
              staticList['**protected**'] = true;
              staticKeys.forEach((staticKey) => {
                staticNames.push(staticKey);
                staticList[staticKey] = createSignatureOnlyWrapper(cls[staticKey])
              })
              
              
            if(type === true){
              return Object.freeze({...instanceList, ...staticList}); // instance and static lists
            }else if(type === false){
              return Object.freeze({
                names: [...staticNames, ...instanceNames],
                instance: instanceList,
                static: staticList,
                items: {...instanceList, ...staticList}
              });
            }else if(type === 'static'){
              return Object.freeze({
                names: staticNames,
                items: staticList
              })
            } else if(type === 'instance') {    
              return Object.freeze({
                names: instanceNames,
                items: instanceList
              })
            }

            if (type === 'all') {
              // methods(true)
              // all.names, all.objects, static.names, static.objects, instance.names, instance.objects,
              return Object.freeze({
                // '::all': iKeys,
                static: staticKeys,
                instance: instanceKeys,
              });
            }

            return staticKeys;
          };
        }

        if (staticProp in cls) {
          return cls[staticProp]; // Allow SScripts.myClass.staticMethod
        }

        return undefined;
      }
    });
  }
};

const SScriptProxy = new Proxy(SScripts, handler);
export { SScriptProxy as SScripts };


// const SPRegister = new Map();

// function SScripts(cls) {
//   if (typeof cls !== 'function' || !cls.name) {
//     throw new Error('Only named classes can be registered.');
//   }
//   let name = cls.name;
//   // SPRegister.set(name, cls); // save as normal case
//   name = name.charAt(0).toLowerCase() + name.slice(1);
//   SPRegister.set(name, cls); // save as small case initial
// }

// const handler = {
//   get(_, prop) {

//     if (prop === 'scripts') {
//       return (cb) => {
//         let scripts = Array.from(SPRegister.keys());
//         scripts = scripts.map(name => name.charAt(0).toLowerCase() + name.slice(1));
//         if (typeof cb === 'function') {
//           cb(scripts);
//         } else {
//           return scripts;
//         }
//       };
//     }
//     if (prop === 'requires') {
//       return (names, main = 'class') => {
//         const missing = names.filter(name => !SPRegister.has(name.charAt(0).toLowerCase() + name.slice(1)));
//         const misseds = missing.map(name => "ss."+name.charAt(0).toLowerCase() + name.slice(1));
//         if (missing.length) {
//           console.error(`${main} missing [${misseds.join(',')}]`);
//           return false;
//         }
//         return true; // or return the found class names if needed
//       };
//     }
//     const cls = SPRegister.get(prop.charAt(0).toLowerCase() + prop.slice(1));
//     // console.log(cls)
//     if (!cls) {throw new Error(`class "${prop}" not found in SScripts module.`); return false; }
//     return (...args) => new cls(...args);
//   }
// };

// const SScriptProxy = new Proxy(SScripts, handler);
// export { SScriptProxy as SScripts };

// .......................................................................................

if (typeof window !== 'undefined') {
  // window.SScripts ??= SScripts;
}
// class SS {

//     constructor() {

//         let tthis = this, myscripts;
//         this.scripts = [];
        
//         myscripts = this.myscripts();
//         myscripts.forEach(scripts => {
//           tthis.scripts.push(scripts);
//         });
//     }

//     autoload(url, callback) {
//         // Check if script with the provided URL has already been loaded
//         var scriptExists = this.myscripts().some(function(script) {
//           return script.src === url;
//         });
      
//         if (!scriptExists) {
//           // Script has not been loaded, load it dynamically
//           var script = document.createElement('script');
//           script.src = url;
//           script.onload = callback;
//           document.head.appendChild(script);
//           this.scripts.push(url);

//         }
        

//         callback({exists: scriptExists});
//     }

//     myscripts(){
//         return Array.from(document.querySelectorAll('script[src]'));
//     }

//     view(){
//       let allScript = document.querySelectorAll('script[src]');
//       let scripts = [];
//       allScript.forEach(script => {
//         scripts.push(script.src)
//       })
//       console.log(scripts);
//     }
      
// }

// let ss = new SS();