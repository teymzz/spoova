<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>trial</title>
    <link  rel="stylesheet" type="text/css" href="http://localhost/spoova/res/main/css/res.css" x-debug="res-css"><script src='http://localhost/spoova/res/main/js/jquery/jquery-3.6.0.js'></script><script src='http://localhost/spoova/res/main/js/jquery/jquery.mousewheel.js'></script><script src='http://localhost/spoova/res/main/css/bootstrap/js/bootstrap.min.js'></script><link  rel="stylesheet" type="text/css" href="http://localhost/spoova/res/main/css/mdb5/css/mdb.min.css"><script src='http://localhost/spoova/res/main/js/local/core.js'></script><script src='http://localhost/spoova/res/main/js/local/onLoaded.js'></script><script src='http://localhost/spoova/res/main/js/local/jqmodex.js'></script><script src='http://localhost/spoova/res/main/js/local/device.js'></script><script src='http://localhost/spoova/res/main/js/local/loadImages.js'></script><script src='http://localhost/spoova/res/main/js/local/formValidator.js'></script><script src='http://localhost/spoova/res/main/js/local/helper.js'></script><script src='http://localhost/spoova/res/main/js/local/init.js'></script>
</head>
<body>
    
    <section class="vh-full grid-center">
        
        <form class="form-field">
    
            <div class="i-flex">
                <input id="firstname" type="text" placeholder="firstname">
            </div>
    
            <div id="lastname" class="i-flex">
                <input type="text" placeholder="lastname">
            </div>

            <div class="flex-btn">
                <button>submit</button>
            </div>
    
        </form>
    </section>

    <script>

        $('button').click((e) => {

            e.preventDefault();
            firstname = $("#firstname").val(); 
            lastname = $("#lastname").val();
            
            $.ajax({
                type: "post",
                url: "post-er",
                data: {
                    firstname : firstname, 
                    lastname:lastname
                },
                complete: function(response) {
                    console.log(response);
                }
            })

            
        })

    </script>


</body>
</html>
