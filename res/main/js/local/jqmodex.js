
/**
 * This file contains custom helper functions
 * which are mostly jquery dependent. 
 */


// scroll to a particular point on the web page using data-scroll attribute
function dataScroll() {
    
  if ($('body').find('[data-scroll]').length < 1) { return false; }
  
  $("[data-scroll]").on('click', function(e) {
      var point = $(this).attr("data-scroll");
      var dataPlus = $(this).attr("data-plus");
      var dataMinus = $(this).attr("data-minus");
      var dataDelay = $(this).attr("data-delay") || 50;

      e.preventDefault();
      scrollIncrease = isNaN(parseFloat(dataPlus)) ? 0 : parseFloat(dataPlus);
      scrollDecrease = isNaN(parseFloat(dataMinus)) ? 0 : parseFloat(dataMinus);
      scrollOffset = 0;

      if( $("#" + point).length > 0 ) {
          scrollOffset = $("#" + point).offset().top;
      }

      newTarget = scrollOffset + scrollIncrease - scrollDecrease;

      if (scrollOffset != 0) {
          $([document.documentElement, document.body]).animate({
              scrollTop: newTarget, 
              easing: 'bounce'
          }, dataDelay);
      }

  })
}

/**
*  scroll to a url hash value on the web page
* Note: Also performs dataScroll() functions
*/
function dataScrollHash() {

  if ($('body').find('[data-scroll-hash]').length < 1) { return false; }
  $("[data-scroll-hash]").on('click', function(e) {
      //point = $(this).attr("data-scroll-hash");
      var dataPlus = $(this).attr("data-plus");
      var dataMinus = $(this).attr("data-minus")
      var scrollOffset = 0;

      if ($(window).scrollTop() != 0) {
          setTimeout(function() { window.scrollTo(0, 0); }, 1);
      }

      if($(this).attr("href")){
          
          if (window.location.hash.substring(1) == $(this).attr("href").substring(1)) {
              e.preventDefault();
          }
          
          var dataDelay = $(this).attr("data-delay") || 2000;
          var point = $(this).attr("href").split("#")[1];

      } else{        
          e.preventDefault(); 
          var dataDelay = $(this).attr("data-delay") || 50;
          var point = $(this).attr("data-scroll-hash");
      }

      var scrollIncrease = isNaN(parseFloat(dataPlus)) ? 0 : parseFloat(dataPlus);
      var scrollDecrease = isNaN(parseFloat(dataMinus)) ? 0 : parseFloat(dataMinus);

      if( $("#" + point).length > 0 ) {
          scrollOffset = $("#" + point).offset().top;
      }

      var newTarget = scrollOffset + scrollIncrease - scrollDecrease;

      $([document.documentElement, document.body]).animate({
          scrollTop: newTarget,
          easing: 'bounce'
      }, dataDelay);

  })

}

//reduces autocomplete of forms
function hardFormFill(){
  setTimeout(() => {

    var inputs = $('form[autocomplete="off"]').find(':input:not(:button)')

    inputs.on('input copy paste', function(e){
        e.preventDefault(); 
        return false;
    })
      
    //   inputs.attr({'readonly':'readonly'});
      $('.flex-ico, div.i-flex-full').click(function(){
        let parent = $(this).closest('.i-flex-full')
        parent.find(':input:not([data-read="false"])').removeAttr('readonly').focusout(function(){
        //   $(this).attr({'readonly':'readonly'});
        })
      })    
  })
}
