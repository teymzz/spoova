@layout:header
 
 @style('build.css.headers:tutorial')
 @script('build.js.headers:tutorial')

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