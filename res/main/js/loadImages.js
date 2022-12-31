async function isrcLoad(){
    dataIsrc = document.querySelectorAll('[data-isrc]');
    if(dataIsrc.length > 0){
        dataIsrc.forEach(image => {
            var path = image.getAttribute("data-isrc");
            var pathProtocol = image.getAttribute("data-isp") || undefined;
            if ((path.slice(0, 1) != "/") && (path.slice(0, 4) != 'http') && pathProtocol === undefined) {
                //get auto protocol
                var url = window.location.href
                var arr = url.split("/");
                var http = arr[0] + "//" + arr[2];
                
                //$(this).css({ "background-image": "url(" + http + path + ")" });
            } else {
                var http = $(this).data("isp") || '';
                if (http.split(0, 4) == "http") { http + "://"; }

                //$(this).css({ "background-image": "url(" + http + path + ")" });
            }
            Object.assign(image.style,{"background-image":"url(" + http + path + ")"});
        })        
    }
}

function loadImages(options){
    setTimeout(() => {

        let newOptions = options || {};
        const images = document.querySelectorAll("[data-src]");

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

loadImages();
