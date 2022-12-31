#script:tutorial

     $(document).ready(function(){
          function runHash(){
          $('.lacier').removeClass('active');
          $hash = hashRunner(':get');       
          $('#'+$hash).on('click',function(){
               let el = '#'+$hash+' .lacier';
               $('.lacier').removeClass('active');
               $(el).addClass('active');
          })
          hashRunner('id');             
          }
          runHash();
          $(window).on('hashchange', function() { runHash(); })
     })

#script;