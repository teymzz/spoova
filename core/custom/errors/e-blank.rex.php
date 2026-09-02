<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    @load('headers')
    @live
</head>
<style>
    body{
        background: #2a2b38;
        color: #c9caf1;
        display: grid;
        place-items: center;
    }
    .error-div{
        max-width: 500px;
        p{
            font-size: .8em;
            small{
                color: rgb(255, 104, 104);
            }
        }
    }
</style>
<body>
    @uses('core\classes\Compiler')
    <div class="error-div">
        <div> 
            Error 404 | CANNOT FIND THIS PAGE
        </div>
        <p>
            You are seeing this page because you attempted to load a 
            {{: $path = Compiler::failedRex() }}
            template component <br>
            @if(!online):
            <small>"@project_root\{{ ltrim(explode(docBase,$path,2)[1],'\\') }}"</small> 
            @endif;
            which cannot be resolved.
        </p>
    </div>
</body>
</html>