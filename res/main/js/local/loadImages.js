import { SPAuto } from "./autoload/SPAuto.js";

/**
 * Lazy-loads any element carrying a [data-src], with a blur-up placeholder.
 *
 * Two things happen per element:
 *
 *  1. A placeholder from [data-lqip] — a tiny inlined copy of the image — is
 *     shown blurred straight away, before the element is anywhere near the
 *     viewport.
 *  2. When the element does approach the viewport, the real image is fetched
 *     into a detached Image and *fully decoded* before it is attached. Assigning
 *     src directly, as this used to, hands the url to the browser and lets it
 *     paint the bytes as they arrive — which is what draws a baseline JPEG in
 *     from the top edge a strip at a time.
 *
 * Images (<img>) carry the placeholder in src and are blurred directly.
 * Anything else carries it in background-image and is blurred through a
 * ::before overlay, so that the element's own children stay sharp.
 */
class LoadImages{

    constructor(options) {

        setTimeout(() => {

            const defaultOptions = {
                threshold: 0,
                rootMargin: "0px 0px 300px 0px"
            };

            const imOptions = {...defaultOptions, ...(options || {})};

            const images = document.querySelectorAll("[data-src]");

            /**
             * Show the inlined placeholder, blurred, while the real image loads.
             */
            function applyPlaceholder(image){
                const lqip = image.getAttribute("data-lqip");

                if(!lqip){
                    // nothing to blur up from — the image simply appears when ready
                    image.classList.add("lqip-none");
                    return;
                }

                if(image.tagName === "IMG"){
                    if(!image.getAttribute("src")) image.src = lqip;
                }else{
                    image.style.backgroundImage = 'url("'+lqip+'")';
                }

                image.classList.add("lqip", "lqip-loading");
            }

            /**
             * Fetch and decode an image, resolving only once it is ready to paint
             * in a single go.
             */
            function fetchImage(src){
                return new Promise((resolve, reject) => {
                    const loader = new Image();

                    loader.onload = () => {
                        /* decode() keeps the main thread from doing the decode work
                           during the swap. Where it is missing, or rejects on an
                           image that is otherwise fine, onload alone is enough */
                        if(typeof loader.decode === "function"){
                            loader.decode().then(resolve, resolve);
                        }else{
                            resolve();
                        }
                    };

                    loader.onerror = reject;
                    loader.src = src;
                });
            }

            async function preloadImage(image){
                const src = image.getAttribute("data-src");

                if(!src) return;

                try{
                    await fetchImage(src);
                }catch(e){
                    /* the real image never arrived. The placeholder is left in place
                       rather than being cleared to nothing, and the element is marked
                       so a stylesheet can treat a failed load differently if it wants */
                    image.classList.add("lqip-failed");
                    image.classList.remove("lqip-loading");
                    return;
                }

                // cached and decoded by now, so this paints in one step
                if(image.tagName === "IMG"){
                    image.src = src;
                }else{
                    image.style.backgroundImage = 'url("'+src+'")';
                }

                image.classList.remove("lqip-loading");
                image.classList.add("lqip-loaded");

                image.dispatchEvent(new CustomEvent("lqip:loaded", {bubbles: true}));
            }

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
                applyPlaceholder(image);
                imObserver.observe(image);
            })


        }, 200)


    }
}

export default SPAuto(LoadImages);
