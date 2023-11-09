class Interval {

    constructor(){
        this.data = Object.create(null),
        this.storage = Object.create(null),
        this.storageid = 0;
        this.id = 0;
    }

    // wait(config){

    //     let interval = this, defaults, options = {};

    //     defaults = {func: null, time: 200}

    //     options = {...defaults, ...config}

    //     let func = options.func.item;
    //     let time = options.func.time;
    //     let onload = options.onload;

    //     if(typeof func !== 'function'){
    //         console.error('wait({func:}) key must be a valid function')
    //         return false;
    //     }

    //     if(isNaN(time)){
    //         console.info('invalid wait({time:}) key is set as zero')
    //         time = 0;
    //     }

    //     return {
    //         start: function() {
    //             if(this.started) return false;
    //             if(onload){
    //                let loaded = interval.start(func, time)
    //                this.started = true;
    //                onload(loaded);
    //                return loaded;
    //             }
    //             return interval.start(func, time);
    //         },
    //         tillExit: function () {
    //             if(this.started) return false;
    //             let obj = this;
    //             document.addEventListener('visibilitychange', function(){
    //                 if(document.visibilityState !== 'visible') {
    //                     return obj.start();
    //                 }
    //             })
    //         }
    //     }
    // }

    start(func, time) {

        let interval = this;
        interval.id++;
        let currentID = interval.id;

        let obj = {
            id: currentID,
            nativeID: setTimeout(func, time),
            func: func,
            time: time,
            wait: false,
            state: {
                paused: false,
                monitor: false
            },
            pause: function () {
                if(!this.nativeID) return false;
                this.state.paused = true;
            },
            play: function(time) {
                if(!this.nativeID) return false;
                if(!this.state.paused) return false;
               this.state.paused = false;
               this.recall(time);
            },
            stop: function () {
                if(!this.nativeID) return false;
                clearTimeout(this.nativeID);
                delete this.nativeID;
            }, 
            recall: function(time) {
               if(!this.nativeID || (this.state.wait === true)) return false;
               time = time || this.time || 0;
               this.nativeID = setTimeout(func, time);
            },
            onvisible: function(callback){
                if(!this.nativeID) return false;
                document.addEventListener('visibilitychange', function(){ 
                    if(document.visibilityState === 'visible') callback()
                })
            },
            invisible: function(callback){
                if(!this.nativeID) return false;
                document.addEventListener('visibilitychange', function(){ 
                    if(document.visibilityState !== 'visible') callback()
                }) 
            },
            visibility: function(callback){
                if(!this.nativeID) return false;
                document.addEventListener('visibilitychange', function(){ 
                    callback(document.visibilityState === 'visible')
                })
            },
            monitor: function(force){
                if(force === true) {
                    this.state.monitor = false;
                }
                if(!this.nativeID || this.state.monitor) return false;
                this.state.monitor = true;
                let interval = this;
                document.addEventListener('visibilitychange', function(){ 
                    if(document.visibilityState === 'visible'){
                        interval.play();
                    }else{
                        interval.pause();
                    }
                })
            },
        } 

        interval.data[currentID] = obj;
        return obj;

    }

    wait(control) {

        let onEntry = control.onentry;
        let onExit  = control.onexit;

        document.addEventListener('visibilitychange', function(){

            if(document.visibilityState === 'visible'){
               if(onEntry && !control.entry) {
                   onEntry(control);
                   control.entered = true;
                }
            }else{
               if(onExit) {
                    onExit(control);
                    control.exited = true
                }
            }

        })

    }

}