class TextAnime {

    constructor(selector, settings){

        let defaults = {}, options = {};
        let anime = this;

        defaults.speed  = 1000;
        defaults.delay  = 0;
        defaults.texts  = [];

        options = {...defaults, ...settings}

        anime.settings = options;

        anime.settings.alternate = function() {
            anime.settings.alternating = false;
        }

        function select(element){
            let selector = toSelectionArray(element)
            anime.settings.selector = selector;  
            if(!selector){
                console.log("no element found for selector: " + element);
            }      
        }
        select(selector);

        this.settings = anime.settings;

    }

    alternate(texts = [], settings = {}){

        let anime, bits, loop, onLoop, instance, counter = 0, elements;
        
        instance = this;

        settings = {...instance.settings, ...settings}
        anime = instance.settings;

        anime.flow = settings.flow;

        texts = (texts == undefined) ? [] : texts;
    
        elements = anime.selector;
        
        bits = settings.bits || 200;

        anime.typeWrite = function(options) {
            return instance.typeWrite(options)
        }            
        
        loop = settings.loop;
        onLoop = settings.onLoop;
        let animeTextWord;

        let animate = function(element, loops){

            if(!anime.alternating){

                setTimeout(() => { 
                    element.innerText = texts[counter];

                    if(typeof loop === 'function'){
                        anime.alternating = true;
                        counter++;
                        let looped = loop(anime);

                        if(onLoop && !settings.looped){
                            settings.looped = true;
                            onLoop(looped);
                        }
                    }else{
                        counter++;
                    }
        
                    if (counter === (loops.length)) {

                        if(!anime.flow){
                            clearInterval(animeTextWord);
                        }else{
                            counter = 0;
                        }
        
                    }                        

                })
            }

        }

        elements.forEach(element => {

            let loops = texts;
            let iniText = element.innerText;

            if(iniText) {
                loops.unshift(iniText);
                element.innerText = '';
            }

            animate(element, loops);

            animeTextWord = setInterval(function() {
                
                if(!instance.paused)
                    animate(element, loops);

            }, bits);

        });

        return this;
    }

    typeWrite(settings){

        let instance, each, beats, speed, before, done, final;
        let iniText, txts, span, field, animeField;
        let txt = '', style = '', item = '', controls = {};
        let options = Object.assign({}, settings);

        settings.counter  = settings.counter || 0, //text counter
        settings.timeouts = settings.timeouts || [];

        instance = this; 
        field = instance.settings.selector[0];
        iniText = field.innerText.trim();

        if(iniText && !settings.initialized) {
            if(iniText !== ''){
                if(settings.texts){
                    settings.texts.unshift(iniText)
                }else{
                   options.text = settings.texts = [iniText]
                }
            }
        }
        
        settings.initialized = true;

        txts = options.texts || field.innerText;

        if(txts && !Array.isArray(txts)){
            txts = [txts]; //convert to array
        }

        txt = txts[settings.counter];
        
        if(Array.isArray(txts) && txt !== undefined){

            controls = {

                i : 0,

                /**
                 * This is applied immediate this method is called.
                 * @param {function} callback callback
                 */
                pause: (callback) => {
                    settings.paused = true;
                    settings.timeouts.push(setTimeout(() => 
                        {
                            if(callback && (typeof callback === 'function')) callback(controls);
                        }
                    ));
                },

                /**
                 * Continue animation from last slide
                 * @param {function|object} callback preceeds or ends an animation
                 *   - #object : object containing optional keys for "before" and "after" play callbacks. 
                 *     The "before" key is exectuted only at the beginning of text animation. 
                 *   - #function : callback function for after play callback
                 * @returns 
                 */
                play: (callback) => {

                    let before;

                    if(typeof callback === 'object'){
                        if (typeof callback.before === 'function') before = callback.before
                        if (typeof callback.after === 'function') callback = callback.after
                    }

                    if(settings.counter === (settings.texts.length - 1)){
                        settings.timeouts.push(setTimeout(() => 
                            {
                                settings.paused = false;

                                if(before) before();
                                
                                if(settings.charsCount !== settings.charMarker){
                                    settings.type ? settings.type() : '';
                                }else{
                                    instance.typeWrite(settings)
                                }

                                if(callback && (typeof callback === 'function')) {
                                    callback(controls);
                                }
                                settings.next = false;
                            }
                        ));
                    }else{
                        if(!settings.paused) return false;
                        settings.played = true;
                        settings.paused = false;
                        
                        settings.timeouts.push(setTimeout(() => 
                            {
                                settings.type ? settings.type() : '';
                                if(callback && (typeof callback === 'function')) callback(controls);
                            }
                        ));
                    }
                },

                /**
                 * Proceed to the previous or first slide
                 * @param {function} callback 
                 */
                previous: (callback) => {

                    if((settings.counter - 1) >= 0){
                        settings.counter = settings.counter - 1
                    }else{
                        settings.counter--;
                    }

                    settings.timeouts.forEach((timeout, index) => {
                        clearTimeout(timeout);
                        delete settings.timeouts[index]
                    })
                    settings.timeouts = [];
                    
                    if(settings.timeouts.length === 0){
                        settings.next = true;
                        settings.played = false;
                        settings.timeouts.push(setTimeout(() => 
                            {
                                instance.typeWrite(settings)
                                settings.next = false;
                                if(callback && (typeof callback === 'function')) callback(controls);
                            }
                        ));
                    }
                },

                /**
                 * Proceed to next text or beginning of text
                 * @param {function} callback called after next is done
                 */
                next: function(callback){

                    if((settings.counter + 1) >= txts.length){
                        settings.counter = 0
                    }else{
                        settings.counter++;
                    }
                    settings.timeouts.forEach((timeout, index) => {
                        clearTimeout(timeout);
                        delete settings.timeouts[index]
                    })
                    settings.timeouts = [];

                    if(settings.timeouts.length === 0){
                        controls.i = 0;
                        settings.next = true;
                        settings.played = false;
                        settings.timeouts.push(setTimeout(() => {
                                instance.typeWrite(settings)
                                settings.next = false;
                                if(callback && (typeof callback === 'function')) callback(controls);
                            }
                        ));
                    }
                },

                reboot: function(callback){
                 
                    settings.next = false;
                    settings.paused = false;
                    settings.rebooted = true;
                    settings.played = true;
                    field.innerHTML  = '';
                    settings.counter = 0;
                    controls.i = 0;

                    settings.timeouts.forEach((timeout, index) => {
                        clearTimeout(timeout);
                        delete settings.timeouts[index]
                    })

                    if(callback && (typeof callback === 'function')) callback(controls);

                    settings.timeouts.push(setTimeout(() => instance.typeWrite(settings)));
                },

                anime: instance

            }

            if(!settings.paused){

                if(!settings.rebooted){
    
                    if(typeof options === "object"){
    
                        speed = options.speed;
                        beats = (options.beats === undefined) ? 1500 : options.beats;
                        before  = options.before;
                        done  = options.done;
                        each  = options.each;
                        final = options.final  || txt.length
                        if(final >= txt.length) final = txt.length - 1;
                        settings.charsCount = txt.length; 
                
                        delete options.speed;
                        delete options.final;
                        delete options.before;
                        delete options.done;
                        delete options.each;

                        if(done && (typeof done !== 'function')){

                            console.error('invalid callback detected for option key "done"')
                            return;
                        }
                        
                        if(before && (typeof before !== 'function')){

                            console.error('invalid callback detected for option key "before"')
                            return;
                        }
        
                
                        let color = options.color;
                        let bgcolor = options.bgcolor;
                
                        if(style === undefined){
                            if(color != undefined || bgcolor != undefined){
                                if(color != undefined){
                                    style += `color:${color};`
                                }
                                if(bgcolor != undefined){
                                    style += `background-color:${bgcolor};`
                                }                   
                            }
                        }else{
                            let styleset = options.style;
                            style = styleset;
                        }
                        
                        span = document.createElement('span');
                        
                        if(style){
                            span.setAttribute('style', style)
                        }
                
                        //other attributes
                        if(options.color) delete options.color;
                        if(options.bgcolor) delete options.bgcolor;
                        if(options.style) delete options.style;
                        
                        if(options.attributes && (typeof options.attributes === 'object')){
                            for(let [key, value] of Object.entries(options.attributes)){
                                span.setAttribute(key, value);
                            }
                        }
                        
                    }
                
                    speed = speed || 50;

                    let random = '';

                    for(let i = 0; i < 4; i++){
                        let randomNumber = Math.floor(Math.random() * (4 - 2)) + 1;
                        random += randomNumber; 
                    }
        
                    span.setAttribute('id', '__text-anime'+random);
                 
                    field.innerHTML = "";
        
                    options.textsCount = txts.length;
    
                    field.appendChild(span);
        
                    animeField = field.querySelector('#__text-anime'+random);
        
                    settings.type = function() { 
                        
                        if(!settings.paused){

                            settings.charMarker = controls.i;

                            if(controls.i < txt.length){
    
                                if(settings.rebooted){
                                    controls.i = 0;
                                    settings.rebooted = false;
                                    settings.timeouts.push(setTimeout(() => instance.typeWrite(settings), beats));
                                }else{
    
                                    if(!settings.paused){
    
                                        if(each){
                                            let text = each(txt.charAt(controls.i), controls.i)
                                            item = text ? text : txt.charAt(controls.i);
                                            let wrapper = document.createElement('div');
                                            wrapper.innerHTML = item; 
                                            animeField.appendChild(wrapper.firstChild)
                                        }else{ 
                                            let text = txt.charAt(controls.i);
                                            item = text ? text : txt.charAt(controls.i);
                                            text = document.createTextNode(item);
                                            animeField.appendChild(text);
                                        }   
                                        
                                        controls.i++;
                                    }
    
                                }
    
                                //run each character
                                settings.timeouts.push(setTimeout(settings.type, speed));
    
                            }else if(controls.i === txt.length) {
    
                                // @characters done: proceed to next text
                                let textsUnfinished = (settings.counter !== (txts.length - 1));

                                   //console.log(settings.counter)
                                if(done){
                                    //@each text complete, run this:
                                    settings.timeouts.push(
                                        setTimeout(() => {
                                            done(settings.counter);
                                        })
                                    );
                                }
                                
                                if(!settings.next){
                                        settings.counter++;
                                        settings.timeouts.push(setTimeout(() => {
                                            settings.timeouts.push(setTimeout(() => {
                                                let textsUnfinished = (settings.counter <= (txts.length - 1));
                                                if(textsUnfinished){
                                                  if(before) before();
                                                  instance.typeWrite(settings)
                                                }else{
                                                  if(settings.alternate){
                                                    //continue for alternation 
            
                                                    function restart(){
                                                        if(settings.alternate){
                                                            settings.timeouts.push(
                                                                setTimeout( () => {
                                                                    settings.counter = 0;
                                                                    settings.timeouts.push(setTimeout(() => instance.typeWrite(settings), beats));
                                                                })
                                                            )
                                                        }
                                                    }
                                                        
                                                    restart();
            
                                                  }                           
                                                }
                                            }, beats))
                                        })
                                        );
                                }else{
                                    settings.counter = settings.counter + 2;
                                    // settings.next = false;
                                }

                                /*if(textsUnfinished){
                                    
                                        console.log(settings.counter);
                                    //proceed to next text 
                                    if(!settings.next){
                                        settings.counter++;
                                            settings.timeouts.push(setTimeout(() => {
                                                settings.timeouts.push(setTimeout(() => {
                                                    if(before) before();
                                                    instance.typeWrite(settings)
                                                }, beats))
                                            })
                                        );
                                    }else{
                                        settings.counter = settings.counter + 2;
                                        // settings.next = false;
                                    }

                                } else {

                                    //text animation completed ... 

                                    if(settings.alternate){
                                        //continue for alternation 

                                        function restart(){
                                            if(settings.alternate){
                                                settings.timeouts.push(
                                                    setTimeout( () => {
                                                        settings.counter = 0;
                                                        settings.timeouts.push(setTimeout(() => instance.typeWrite(settings), beats));
                                                    })
                                                )
                                            }
                                        }
                                            
                                        restart();

                                    }

                                }*/
                                // if(settings.counter !== (txts.length - 1)){
                                //     if(!settings.next){
                                //         settings.next = false;
                                //         settings.counter++;
                                //         if(done) {
                                //             settings.timeouts.push(setTimeout(() => {
                                //                 done();
                                //                 settings.timeouts.push(setTimeout(() => {
                                //                     instance.typeWrite(settings)
                                //                 }, beats))
                                //                 })
                                //             );
                                //         }else{
                                //             settings.timeouts.push(setTimeout(() => instance.typeWrite(settings), beats));
                                //         }
                                //     }else{

                                //         if(!settings.played){
                                //             settings.timeouts.push(
                                //                 setTimeout(() => {
                                //                     done();
                                //                 })
                                //             );
                                //         }
                                //     }

                                // } else {

                                //     function roll(){
                                //         if(settings.alternate){
                                //             settings.timeouts.push(
                                //                 setTimeout( () => {
                                //                     settings.counter = 0;
                                //                     settings.timeouts.push(setTimeout(() => instance.typeWrite(settings), beats));
                                //                 })
                                //             )
                                //         }
                                //     }

                                    
                                //     if(done){
                                //         if(!settings.completed){
                                //             settings.timeouts.push(
                                //                 setTimeout( () => {
                                //                     done();
                                //                     roll()
                                //                 })
                                //             )
                                //         }
                                //     }else{
                                //         roll();
                                //     }

                                // }
    
                            }                        
                        } 
                        
                    }
                    
                    settings.type();
                    
                }else{
                    settings.rebooted = false;
                    settings.timeouts.push(setTimeout(() => instance.typeWrite(settings)));
                }

            }

        };


        return controls;
    }

    toSelectionArray(selector){

        let type = typeof selector;
        if(type === 'object'){
            selector = selector
        }else if(type === 'string'){
            selector = document.querySelectorAll(selector)
        }
        if(selector){
            if(!selector.length){
                selector = [selector];
            }else if(!Array.isArray(selector)){
                let selects = [] 
                for(const key in selector){
                    if(selector.hasOwnProperty(key)){
                        if(selector[key].childNodes){
                            selects.push(selector[key]);
                        }
                    }
                }
                selector = selects;
            }
        }  
        return selector;

    }

    

    pause(){
        this.paused = true;
    }

    play(){
        this.paused = false;
    }

    anime(){
        return new this;
    }


}