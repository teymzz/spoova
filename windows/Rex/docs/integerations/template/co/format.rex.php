<!DOCTYPE html>
<html>

    <head>
        @meta('dump')
        <title></title>
        @Res(':headers')
        @style('docs.integerations.template.css.index:index')
        @res('res/main/js/switcher.js')
        @styles
        @live
    </head>


    <body class="">

        <div id="userscreen" data-height="full" data-form="validate" data-resp=".resp" class="grid-center bc-sky-blue-dd relative">
            <div class="overlay">
                <div class="box-full i-trans padd-20 content-field bc-white xs-2s">
                    @yield()
                </div> <br>
            </div>
        </div>

    </body>

    
    <script>
        formValidator();

        function htmlentities(str) {
            return String(str).replace(/&/g, '&amp;');
        }
    </script>

    @onScript('build.js.theme:theme')

</html>

