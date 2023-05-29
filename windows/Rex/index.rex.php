@template('template.t-html')

    @title('Spoova')
  
    <!-- add css -->
    @res('res/assets/css/index.css') 
    @style('build.css.inc:t-doc')
    @style('build.css.inc:index')
    
    <!-- script -->
    @script('build.js.inc:index')

    <section>

        <div class="maincover">          
        
        <div class="spv-nav">
            <div class="menu flex" style="padding-left:1em">
            <h3 class="logo flex-full midv">  
            <div class="in-flex midv mxr-6">
                <div class="flex midv rad-r" style="background-color:rgba(255, 255, 255, 0.27)">
                    <div class="px-40 b-cover ico-spin" data-src="@DomUrl('res/main/images/icons/favicon-white.png')"></div>
                </div>
            </div>
            <div class="flex-full">
                {{ $site_name ?? 'spoova' }} 
                <span> {{ $site_name2 ?? 'frame' }} </span>
            </div>
                <div class="hamburger-menu flex midv">
                <div class="bar"></div>
                </div>
            </h3>
            </div>
        </div>
        
      
        <div class="links">
            <ul id="ul">
            <li>
                <a href="@domurl('')" style="--i: 0.05s;">Home</a>
            </li>
            <li>
                <a href="@domurl('docs')" style="--i: 0.1s;">Documentation</a>
            </li>
            <li>
                <a href="@domurl('docs/installation')" style="--i: 0.15s;">Installation</a>
            </li>
            <li>
                <a href="@domurl('features')" style="--i: 0.15s;"> <span class="bi-vinyl"></span> Features </a>
            </li>
            <li>
                <a href="@domurl('about')" style="--i: 0.2s;">About</a>
            </li>
            </ul>
        </div>

        <div class="main-container">
            <div class="main">
            <header data-src="@domurl('res/assets/images/bkg.jpg')">
                <div class="overlay">
                <div class="inner">
                    <h2 class="title"> {{ $site_name ?? 'spoova' }} </h2>
                    <p>
                    An environmental friendly, simple and light php framework for fast web development
                    </p>
                    <a href="@route('about')" class="i-btns"><button class="btn">Learn more</button></a>
                </div>
                </div>
            </header>
            </div>

            <div class="shadow one"></div>
            <div class="shadow two"></div>
        </div>

        </div>

    </section>

@template;