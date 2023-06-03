function LoadImages(options) {

    setTimeout(() => {

        let images, newOptions = {}, imOptions = {}; 
        
        newOptions = options || {}; 
            
        images = document.querySelectorAll("[data-src]");

        function preloadImage(image){
            const src = image.getAttribute("data-src");

            if(!src){
                return;
            }

            if(image.tagName === "IMG"){
                    image.src = src;
            }else{
                image.style.backgroundImage = 'url('+src+')';
            }
        }

        const defaultOptions = {
            threshold: 0,
            rootMargin:"0px 0px 300px 0px"
        };

        imOptions = {...defaultOptions, ...newOptions}

        const imObserver = new IntersectionObserver((entries)=>{
            entries.forEach(entry=>{
                if(!entry.isIntersecting){
                    return;
                }else{
                    preloadImage(entry.target); 
                    imObserver.unobserve(entry.target);
                }
            })
        }, imOptions);

        images.forEach(image => {
            imObserver.observe(image);
        })


    }, 200)

        
}

LoadImages();