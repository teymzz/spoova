@layout:header
 <style>
     .pre-area{
       font: menu;
       font-size: .85em;
       display: inline-block;
       width:100%;
       background-color : #f4f4f4;
     }

     .pre-area.fix {
         font-size: 1em;
     }
     
     pre.pre-code {
         overflow: auto hidden;
         color: darkred;
         font-size: .95em; 
         margin-bottom:0;
         padding-top:1em;
     }
     
     pre .comment {
         color: #909090;
     }

     .lacier.active {
        background-color: #3ecb32;
        color: white;
        box-shadow: 0 0 2px 2px #3ecb32;
     }
     .lacier.active .c-lime-dd{
        color: white;
     }
     a:visited {
         color: #3653a8;
     }
 </style>
 <script>
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
 </script>
 <header class="bc-white-dd flex-full pxv-10">

    <div class="flex text-caps midv font-em-1d2">
        <div class="">
            <a href="@DomUrl('/')">
                <div class="px-40 rad-r b-cover ico-spin" data-src="@DomUrl('res/main/images/icons/favicon.png')">
    
                </div>
            </a>
        </div>
        <div class="no-wrap fb-6 c-blue-dd">{{ topic ?? 'SPOOVA FRAME' }}</div>
    </div>

    <div class="flex-full flex-r midv c-blue-dd hide"> 
        <span class="mxr-4"> <span class="bi-house"></span>  Home</span>
    </div>
    
 </header>

@layout;

@layout:header2

    <header class="flex bg-primary">
        <div class="flex-ico"></div>
        <div class="flex-full flex-r">
            <form method="post">
                <!-- @csrf -->
                <div class="flex-btn">
                    <button class="flex-btn c-white" @btn('logout') >
                        Logout
                    </button>
                </div>
            </form>

        </div>
    </header>

@layout;