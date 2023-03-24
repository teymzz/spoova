   <!-- @js('res','js.intersect'); -->
   @res('res/main/js/intersect.js')
   <script>
        let intersect = new Intersect();

        // intersect.status({
        //     el: '.setup',
        //     onScroll: 'scroll',
        //     callback: function(entry) {
        //         console.log(entry);
        //     }
        // })

        // intersect.onScroll({
        //     el: '.setup',
        //     callback: function(entry){
        //        if(entry.inview) { 
        //         console.log(entry.target, ": in view and has been removed from scroll list")
        //            entry.unobserve(); 
        //        } else {
        //         if(!entry.unobserved(entry.target)){
        //             console.log(entry.target, ": not in view");
        //         }
        //        }
        //     }
        // })

        // intersect.observe({
        //     el: '.setup',
        //     callback: (entry, observer) => {

        //         console.log(entry)
        //         if(entry.inview)  observer.unobserve(entry.target)

        //     }
        // });

   </script>