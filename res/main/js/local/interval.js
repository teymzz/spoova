import { SPAuto } from "./autoload/SPAuto.js";

class Interval {

    constructor(){
        this.data = Object.create(null);
        this.names = Object.create(null);
        this.id = 0;
    }

    /**
     * 
     * @param {function} func function to be looped
     * @param {integer} time interval in seconds
     * @returns object
     */
    start(func, time, name = null) {

        let interval, obj, currentID;

        interval = this;
        interval.id++;
        currentID = interval.id;

        obj = {
            id: currentID,
            name: name,
            nativeID: setTimeout(func, time),
            func: func,
            time: time,
            wait: false,
            clear: function () {
                if(!obj.nativeID) return false;
                clearTimeout(obj.nativeID);
                delete obj.nativeID;
                if(obj.name && interval.names[obj.name] === obj) delete interval.names[obj.name];
            },
            stop: function() {
                obj.clear();
            },
            pause: function () {
                if(!obj.nativeID) return false;
                obj.wait = true;
            },
            resume: function(time) {
               if(!obj.nativeID) return false;
               obj.wait = false;
               obj.recall(time);
            }, 
            recall: function(time) {
               if(!obj.nativeID || (obj.wait === true)) return false;
               time = time || obj.time || 0;
               obj.nativeID = setTimeout(func, time);
            },
            onvisible: function(callback){
                if(!obj.nativeID) return false;
                document.addEventListener('visibilitychange', function(){ 
                    if(document.visibilityState === 'visible') callback()
                })
            },
            invisible: function(callback){
                if(!obj.nativeID) return false;
                document.addEventListener('visibilitychange', function(){ 
                    if(document.visibilityState !== 'visible') callback()
                }) 
            },
            visibility: function(callback){
                if(!obj.nativeID) return false;
                document.addEventListener('visibilitychange', function(){ 
                    callback(document.visibilityState === 'visible')
                })
            },
            monitor: function(){
                if(!obj.nativeID) return false;
                let interval = obj;
                document.addEventListener('visibilitychange', function(){ 
                    if(document.visibilityState === 'visible'){
                        interval.resume();
                    }else{
                        interval.pause();
                    }
                })
            },
        } 

        interval.data[currentID] = obj;
        if(name) interval.names[name] = obj;
        return interval.data[currentID];

    }

    /**
     * Look up a running interval by its numeric id or user-assigned name.
     * @param {string|number} ref
     * @returns {object|false}
     */
    get(ref) {
        if(typeof ref === 'string') return this.names[ref] || false;
        return this.data[ref] || false;
    }

    /**
     * Stop a running interval by its numeric id or user-assigned name.
     * @param {string|number} ref
     * @returns {boolean}
     */
    stop(ref) {
        let obj = this.get(ref);
        if(!obj) return false;
        obj.stop();
        return true;
    }

    /**
     * Create a page-visibility-aware interval controller.
     *
     * The `control` object handed to onEntry/onExit can start() or stop() the
     * interval this method manages — e.g. run a poller only while the tab is
     * visible. Optionally give it a `name` so it can also be referenced through
     * Interval.get(name) / Interval.stop(name).
     *
     * @param {object} config
     *   - func {function}    : function to loop (required)
     *   - time {number}      : delay in milliseconds (default 200)
     *   - name {string|null} : optional unique name for later reference
     *   - onEntry {function} : called with (control) when the page becomes visible
     *   - onExit  {function} : called with (control) when the page becomes hidden
     *   - immediate {boolean}: also run the matching handler for the current state now (default false)
     * @returns {object|false} the control object, or false on invalid config
     */
    wait(config) {

        let interval = this;
        let defaults = { func: null, time: 200, name: null, immediate: false };
        let options = { ...defaults, ...(config || {}) };

        let func = options.func;
        let time = options.time;
        let name = options.name;
        let onEntry = options.onEntry || options.onentry;
        let onExit  = options.onExit  || options.onexit;

        if(typeof func !== 'function') {
            console.error('Interval.wait({func}) must be a valid function.');
            return false;
        }
        if(isNaN(time)) {
            console.info('Interval.wait({time}) is not numeric; defaulting to 0.');
            time = 0;
        }

        let running = null; // the active interval instance created by start()

        let control = {
            name: name,
            // start (or restart) the managed interval
            start: function() {
                if(running && running.nativeID) return running; // already running
                running = interval.start(func, time, name);
                return running;
            },
            // stop the managed interval
            stop: function() {
                if(running) { running.stop(); running = null; }
                return control;
            },
            // the currently running instance, or null
            interval: function() { return running; },
            isRunning: function() { return !!(running && running.nativeID); },
            // remove the visibility binding and stop the interval
            cancel: function() {
                document.removeEventListener('visibilitychange', handler);
                control.stop();
                return control;
            }
        };

        function handler() {
            if(document.visibilityState === 'visible') {
                if(onEntry) onEntry(control);
            } else {
                if(onExit) onExit(control);
            }
        }

        document.addEventListener('visibilitychange', handler);

        if(options.immediate) handler();

        return control;

    }

}

export default SPAuto(Interval);

window.Interval = Interval;