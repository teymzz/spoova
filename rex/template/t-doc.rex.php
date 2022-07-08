<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/png" href="@mapp('images/icons/favicon.png')">
    <title>{{title?}}</title>
    @meta('dump')
    @Res(':headers')
    @live()
</head>
<body>

    <style>
        .wall{
            padding: 0 0; 
        }
        .content{
            box-shadow: 0 0 6px 4px #efefef;
            border: solid thin #dedede;
        }
        @media (min-width:1000px){
            .wall{
                padding: 0 10%; 
            }
        }
    </style>
    
    <section class="grid-center wall" style="">
        <div class="bc-off-white vhm-full wid-full content">
            @yield()
        </div>
    </section>


</body>
</html>