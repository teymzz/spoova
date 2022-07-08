<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="icon" type="image/png" href="@mapp('images/icons/favicon.png')">
    <title>Spoova</title>
    @Res(':headers')
    @Res('res/assets/css/index.css')
    <style>
      .slided-up{
        height:0 !important;
      }
      @media (min-width: 480px){
        .links{
          height:100vh !important;
        }        
      }
      #ul li a{
        color: #a5afbd;
      }
      #ul li a:hover{
        color: #737b86;
      }
    </style>

  </head>
  <body>
    {{ header? }} 
    <div class="maincover">          
    
      <div class="navbar">
        <div class="menu flex" style="padding-left:1em">
          <h3 class="logo flex-full midv">  
           <div class="in-flex midv mxr-6">
             <div class="flex midv rad-r" style="background-color:rgba(255, 255, 255, 0.27)">
               <div class="px-40 b-cover ico-spin" data-src="@DomUrl('res/main/images/icons/favicon-5.png')"></div>
             </div>
           </div>
           <div class="flex-full">
            {{ site_name ?? 'spoova' }} 
            <span> {{ site_name2 ?? 'frame' }} </span>
           </div>
            <div class="hamburger-menu flex midv ">
              <div class="bar"></div>
            </div>
          </h3>
        </div>
      </div>
      
      <div class="links">
        <ul id="ul">
          <li>
            <a href="home" style="--i: 0.05s;">Home</a>
          </li>
          <li>
            <a href="tutorial" style="--i: 0.1s;">Tutorial</a>
          </li>
          <li>
            <a href="tutorial/installation" style="--i: 0.15s;">Installation</a>
          </li>
          <li>
            <a href="download" style="--i: 0.15s;"> <span class="bi-download"></span> Download</a>
          </li>
          <li>
            <a href="about" style="--i: 0.2s;">About</a>
          </li>
        </ul>
      </div>

      <div class="main-container">
        <div class="main">
          <header data-src="@DomUrl('res/assets/images/lach.jpg')">
            <div class="overlay">
              <div class="inner">
                <h2 class="title"> {{ site_name ?? 'spoova' }} </h2>
                <p>
                  An environmental friendly, simple and light php framework for fast web development
                </p>
                <a href="@route('docs')" class="i-btns"><button class="btn">Learn more</button></a>
              </div>
            </div>
          </header>
        </div>

        <div class="shadow one"></div>
        <div class="shadow two"></div>
      </div>

    </div>


    <script>
          
      const hamburger_menu = document.querySelector(".hamburger-menu");
      const container = document.querySelector(".maincover");
      hamburger_menu.addEventListener("click", () => {

          container.classList.toggle("active");
          
          const ul = document.querySelector(".links");
          const slideToggle = elem => {

            let newHeight, height = elem.offsetHeight;

            if(!isMobile(480)){
              elem.classList.remove('slided-up');
            }else{
              elem.offsetHeight = elem.scrollHeight
              if(height == 0){
                elem.classList.remove('slided-up');
                newHeight = elem.scrollHeight;
                elem.style.height = `${newHeight}px`;
              } else {
                elem.classList.add('slided-up');
                //newHeight = 0;
              }   
            }
            
            //elem.style.height = `${newHeight}px`;
            
          } 
          slideToggle(ul); 
      });
      
    
    </script>
  </body>
</html>
