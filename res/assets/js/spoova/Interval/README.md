# Interval Package

The Interval javascript plugin is used for handling timeout events and loops in a more consise way providing extended functionality for pausing timeouts and managing browser visibilitychange events.

## Initialization 

Once the package is downloaded, and imported into a project file, the plugin can be intialized as shown below

```js 
let interval = new Interval
```

### Handling Timeouts Events

Once the class has been intialized, we can easily handle timeout events by following the proceedure below: 

```js 
let timeout_a, timeout_b;

timeout_a = interval.start(() => {

    console.log('This is timeout event A')

}, 2000)


timeout_b = interval.start( () => {

    console.log('This is timeout event B')
    
}, 3000)
```

> In the code above, each timeout event will be excecuted at the specified time range. The "timeout_a" will run after 2 seconds while the "timeout_b" will run separately after 3 seconds. 


### Handling Event Loops

With the plugin, we can easily create a loop event by using the _recall()_ method. This method ensures that an intialized function can be easily looped. An example of this is shown below

```js 
let timeout;

timeout = interval.start(() => {

    console.log('This is timeout event A');
    timeout.recall();

}, 2000)
```

> In the code above, the recall method will ensure that the timeout is looped. Both the function defined and the timeout are usually maintained when the recall method is called. This method can either be applied outside or inside the _start()_ method. When it is applied within the function called, it resorts to a timeout loop. It is a good practice to call the _recall_ method after other required operations have been done to avoid conflicting or eager loops.

### Overriding Default Interval

In the previous code, the default timeout interval is _2000_ which is equivalent to 2 seconds. In certain cases where we want to initialize the function called immediately but once the function is called, we need to keep a certain interval space, we can easily do this by overriding the default timeout time by supplying a 
new timeout time into the _recall()_ method. This is shown below

```js 
let timeout;

timeout = interval.start(() => {

    console.log('This is timeout event A');
    timeout.recall(2000);

})
```

> In code above, we started the timeout event immediately but ended up overriding the timeout loop with an interval 2 seconds. This means that the function will run instantly and after which it will continue to loop for at 2 seconds interval.


### Ending a loop

We can easily end a loop by calling the _stop()_ method. Once this method is called, the timeout event will be terminated. An example is shown below.

```js 
let timeout, counter = 1;

timeout = interval.start(() => {

    console.log(counter++);

    if(counter > 10) {
        timeout.stop();
    }

    timeout.recall(2000);

})
```

> In the above code, when the _counter_ reaches is more than ten, the _stop()_ method is called and the timeout loop will be terminated. Also, the _recall()_ method declared after will be suspended. This means that the function above will 
only run 10 times after which it is suspended. We can also rewrite the above code as shown below

```js 
let timeout, counter = 1;

timeout = interval.start(() => {

    console.log(counter++);

    if(counter < 11) timeout.recall(2000);

})
```

> While the code above may be more concise, in certain cases, we may require the _stop()_ method especially when we need to terminate the loop outside the defined function scope.

### Handling Visibility Changes 

The _Interval_ plugin gives extended functionality for handling browser _onvisibilitychange_ events. This makes it easier to control an manage loops

   #### Interval Monitor Method

   The _monitor()_ method allows the a looped timeout to pause when the webpage is not in view and to resume back when the page's focus is in view.

   ```js
   let timeout, counter = 0;

   timeout = interval.start(() => {

        console.log(counter++)

        timeout.recall(2000);
        timeout.monitor(); // applied only once

   })
   ```

   > In the code above, once the _monitor()_ method is initialized from the first callback of _start()_ 
   method, it will not be re-applied for susbsequent callback loops since it has already been initialized 
   within that callback scope. The _monitor()_ method will ensure that the timeout loop is paused when the web page visibility state is not visible and it will resume when the page becomes visible. The ability to call the _monitor()_ method within the function scope makes it concise, organized and easy to read.

   #### Interval Pause, Play and Stop Methods

   We can determine when we want to pause a timeout loop and when we need to play it 
   using the _pause()_ and _play()_ methods. We can also stop the loop by using the _stop()_ method. Assuming we have three buttons with id of _"pause"_, _"play"_ and _"stop"_ respectively, we can add an event listener for the pausing and resuming of loops. This is shown below

   ```js

   let pauseButton, playButton;
   let timeout, counter = 0;

   timeout = interval.start(() => {

        console.log(counter++);
        timeout.recall(2000);

   })

   pauseButton = document.getElementById('pause'); // select a pause button
   playButton = document.getElementById('play');  // select a play button
   stopButton = document.getElementById('stop'); // select a stop button

   pauseButton.addEventListener('click', function() {

        timeout.pause();

   })

   playButton.addEventListener('click', function() {

        timeout.play();

   })

   stopButton.addEventListener('click', function() {

        timeout.stop();

   })

   ```

   > In the code above, the callback function will run for pause and play. However, once the _stop()_ method is called, both the _pause()_ and _play()_ 
   method will not work since the loop has been terminated. 

   #### Visibility Methods

   While the plugin offers the automatic pause and resume event through the _monitor()_ method, in situations where we need to customize what happens when the visibility state of the page changes, this can be handled using the _onvisible()_, _invisible()_ and _visibity()_ methods. The _onvisible()_ callback function is only called when the page is visible after it was initially hidden.

   ```js
   let timeout, counter = 0;

   timeout = interval.start(() => {

        console.log(counter++);
        timeout.recall(2000);

   })
   
   timeout.invisible(function(){
     
     console.log('This page is not visible');
     timeout.pause();

   })
   
   timeout.onvisible(function(){
     
     console.log('This page was resumed!');
     timeout.play();

   })

   ```

   > In the code above, we executed the _pause()_ and _play()_ methods by taking advantage of the _invisible()_ and _onvisible()_ methods respectively. These two activities can also be handled in a more concise way using the _onVisibility()_ method 


   ```js
   let timeout, counter = 0;

   timeout = interval.start(() => {

        console.log(counter++);
        timeout.recall(2000);

   });
   
   timeout.onVisibility(function(isVisible){
     
     if(isVisible){

        console.log('This page was resumed!');
        timeout.play();

     } else {
     
        console.log('This page is not visible');
        timeout.pause();

     }

   })
   ```   



