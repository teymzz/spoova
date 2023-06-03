@layout:header
 
 @style('build.css.headers:tutorial')
 @script('build.js.headers:tutorial')

 <header class="animated-header bc-white-dd flex-full pxv-10">

    <div class="flex text-caps font-em-1d2">
        <div class="flex midv">
            
            <div class="flex midv animation animate__bounceIn">
                <div class="theme-btn navtheme px-40 rad-r b-cover ico-spin">
    
                </div>
            </div>
            
        </div>
        <div class="no-wrap fb-6 c-blue-dd flex midv">
            <a href="@DomUrl('/')" class="inherit ch-i">{{ $topic ?? 'SPOOVA' }}</a>
        </div>
    </div>

 </header>

@layout;