class Hash {

    currentHash(){
        if (window.location.hash) {
            return window.location.hash.substring(1);
        }
        return false;
    }

    set(value){
        history.replaceState(null, null, '#'+value);
    }

    /**
     * 
     * @param {array|string} lists specifies an array list of 
     * ids or a string attribute selector for a group of elements with id attribute.
     * @param {object} options for margins an callback options
     */
    scrollwatch(lists, options){

        let controller = this;

        function exit(text){
            if(text) console.error(`hashString.js : ${text}`);
            window.removeEventListener('scroll', updateHash);
            return false;
        }

        let margin = options.margin || 0;
        let callback = options.switch || false;
        if(callback && (typeof callback !== 'function')){
            return exit('scrollwatch callback must be a function');
        }

        function updateHash(){
            let currentElement = null;
            let listArray = [];

            if(typeof lists === 'string'){
                
                if(typeof Selector === 'undefined'){
                    return exit('string arguments require the Selector library');
                }

                let selector  = new Selector;

                let items = selector.select(lists);

                if(items.length === 0){
                    return exit('query selector found no relative elements');
                }

                for(let i = 0; i < items.length; i++){
                    if(items[i].id === undefined || items[i].id===''){
                        return exit('some selected elements have undefined id attribute.');
                    }
                    listArray.push(items[i].id);
                }

                lists = listArray;

            }

            lists.forEach(list => {
                let element = document.getElementById(list);

                if(element){
                    const rect = element.getBoundingClientRect();
                    if((rect.top >= -margin) && (rect.top < (window.innerHeight - margin))){
                        currentElement = element;
                    }
                }
            })

            if(currentElement && (window.location.hash !== '#' + currentElement.id)){
                let id = currentElement.id
                controller.set(id)
                if(callback) callback({old:window.location.hash, new:id,  target: document.getElementById(id)});
            }
        }

        window.addEventListener('scroll', updateHash);

    }

    viewElement(margin = 0){
        // fix this 
        let hash = this.currentHash();
        if(hash){
            let element = document.getElementById(hash);
            if(element){
                const rect = element.getBoundingClientRect();
                if((rect.top - margin) !== (window.innerHeight - margin)){
                    window.scrollTo({
                        top: rect.top - margin,
                        behavior: 'smooth'
                    });
                }
            }
        }
    }
    
    /**
     * 
     * @param {string} attr select element
     */
    select(attr){
        if(attr){

        }else{
            let hash = this.currentHash();
            if(hash){
                let element = document.getElementById(element);
                if(element){
                    
                }
            }
        }
    }

    onload(callback){

        window.addEventListener('load', function(){
            let id = this.currentHash();
            if(id){
                callback({old: id, new: id, target: document.getElementById(id)});
            }
        })

    }

    popstate(callback){
        window.addEventListener('popstate', function(){
            let id = this.currentHash();
            let element = document.querySelector(window.location.hash)
            element.scrollIntoView({behavior: smooth});

            callback({old: id, new: id, target: document.getElementById(id)});
        })
    }

    autoload(callback){

        let id = this.currentHash()
        let events = ['load', 'hashchange', 'popstate'];

        if(id) {
    
            events.forEach(event => {
                window.addEventListener(event, function(){
                    if(event === 'popstate'){
                        let element = document.querySelector(window.location.hash)
                        element.scrollIntoView({behavior: smooth});
                    }
                    callback({old: id, new: id, target: document.getElementById(id)});
                })
            })

        }

    }

}