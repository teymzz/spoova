
/**
 * This file contains custom helper functions
 * which are mostly jquery dependent. 
 */


// //reduces autocomplete of forms
// function hardFormFill(){
//   setTimeout(() => {

//     var inputs = $('form[autocomplete="off"]').find(':input:not(:button)')

//     inputs.on('input copy paste', function(e){
//         e.preventDefault(); 
//         return false;
//     })
      
//     //   inputs.attr({'readonly':'readonly'});
//       $('.flex-ico, div.i-flex-full').click(function(){
//         let parent = $(this).closest('.i-flex-full')
//         parent.find(':input:not([data-read="false"])').removeAttr('readonly').focusout(function(){
//         //   $(this).attr({'readonly':'readonly'});
//         })
//       })    
//   })
// }
