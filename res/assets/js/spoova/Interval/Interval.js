class Interval {

    constructor(){
        this.data = Object.create(null),
        this.id = 0;
    }

    /**
     * 
     * @param {function} func function to be looped
     * @param {integer} time interval in seconds
     * @returns object
     */
    start(func, time) {

        let interval, obj, currentID;

        interval = this;
        interval.id++;
        currentID = interval.id;

        obj = {
            id: currentID,
            nativeID: setTimeout(func, time),
            func: func,
            time: time,
            wait: false,
            clear: function () {
                if(!obj.nativeID) return false;
                clearTimeout(obj.nativeID);
                delete obj.nativeID;
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
        return interval.data[currentID];

    }

}