

/**
 * VANILLA JS: loops an array of texts supplied into a target element
 * @param {*} element target element selector
 * @param {*} texts array of texts
 * @param {*} interval loop interval
 * @param {*} callBack callback when loop finishes
 */
function animeText(element, texts, interval, callBack) {
    var counter = 0;
    var texts = (texts == undefined) ? [] : texts;
    

    if (element.length != false) {
        
        element = document.querySelector(element);
        if(element.length > 0){
            animeTextWord = setInterval(function() {
                
                element.html(texts[counter]);
                console.log(texts[counter]);
                counter++;
                if (counter === (texts.length)) {
                    clearInterval(animeTextWord);

                    setTimeout(() => {
                        callFunc(callBack);
                    }, interval)

                }
            }, interval);
        }else{
            console.log("no element found for selector: " + element);
        }

    } else {
        clearInterval(animeTextWord);
    }

}

/**
 * JQUERY DEPENDENT: Animate item visibility : smooter fadeIn / fadeOut 
 * @param element element selector  
 * @param display bool (true as show, false as hidden)
 * @param type (options: fast | slow)
 */

function animateView(element, display, type) {
    if (display == true) {
        var time1 = (type == 'fast') ? '0s' : '2.5s'
        var time2 = (type == 'slow') ? '3' : '10'

        defaultOptions = {
            opacity: '10',
            duration: 2500
        } 

        let newOptions = {...oldOptions, ...options} ;

        let opacity = newOptions.opacity;
        let duration = newOptions.opacity

        $(element).css({ "visibility": "visible", 'transform': 'scale(1)' }).animate({ opacity: opacity }, duration);

        $(element + " *").css({ "visibility": "visible" })
    } else {
        $(element).css({ "visibility": "hidden", "transition": "ease-in .2s", 'transform': 'scale(0)' }).animate({ opacity: "0" });
    }
}


function animLegend() {
    //animate input fields with legend as parent
    $("input[type='text']").on('focus', function() {
        inputParent = $(this).parent();
        var legend = inputParent.find('legend');
        var title = $(this).attr('placeholder');
        $(this).attr('placeholder', "");
        $(this).css({ "margin-top": "-5px" });
        //alert(legend);
        if (!legend.html()) {

            $(this).before("<legend class='font12' style='color:#b4921a;'>" + title + "</legend>");
        }
    }).on('focusout', function() {
        inputParent = $(this).parent();
        var title = inputParent.find('legend').text();
        inputValue = $(this).val();
        if (inputValue.trim() == '') {
            inputParent.find('legend').remove();
            $(this).css({ "margin-top": "0" });
        }

        $(this).attr('placeholder', title);
    })

}

function animeSlides(element, interval) {

    interval = (interval === undefined) ? 1000 : interval;

    let slides = $(element).find('.slides');
    let totSlides = slides.length //number of slides
    let numSlides = totSlides - 1;

    let activeSelector = $(element).find('.slides.active');

    if (activeSelector.length < 1) {
        $(element).find('.slides:first-child').addClass('active');
    }

    if ($(element).find('.slides.active').length > 0) {

        //start the interval here

        setInterval(() => {

            let activeSlide = $(element).find('.slides.active');
            let activeIndex = activeSlide.index();

            let nextIndex = (activeIndex == numSlides) ? 0 : activeIndex + 1;

            $(element).find('.slides.active').removeClass('active');
            $(element).find('.slides').eq(nextIndex).addClass('active');

        }, interval);

    }

}



/** 
 * JQUERY DEPENDENT: Animate text with slide down && fade in
 * @param {*} element element selector
 * @param {*} interval animation interval 
 * child element with .cool-entrance will be loaded first
 */
function coolSlides(element, interval) {
    var interval = (interval === undefined) ? 1000 : interval;
    if (element != false) {

        /*  */
        function coolslides() {

            let nSlide = '';
            let numSlides = $(element).find(".slides").length;

            //get current slide
            let curSlide = $(element).find(".slides.cool-entrance").index();

            let intro = $(element).find('slides.intro');

            if (intro.length > 0) { intro.removeClass('intro'); }

            if (numSlides == curSlide + 1) {
                nextSlide = 0;
            } else {
                nextSlide = curSlide + 1;
            }

            $(element).find(".slides").eq(curSlide).fadeIn(function() {
                $(this).removeClass("cool-entrance")
                $(element).find(".slides").eq(nextSlide).addClass("cool-entrance");
            })

        }

        $(element).attr({ 'data-interval': interval })

        if ($(element).find('slides.cool-entrance').length < 1) {
            $(element).find('.slides:first-child').addClass('intro')
        }

        coolSlider = setInterval(function() {
            coolslides(element)
        }, interval);
    } else {
        clearInterval(coolSlider);
    }

}