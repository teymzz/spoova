<!DOCTYPE html>
<html lang="en">
<head>
    <?= Rexit::meta('dump') ?>
    <title>About</title>
    <?= Rexit::load('headers') ?>
    <?= Rexit::load('intersectJS') ?>
    <?= Res::live() ?>
</head>
<body>

    <style>
        :root{
            --img-color: white;
        }
        .main{
            flex-direction: column;
            padding: 5% 2%;
            min-height: 92vh;
        }
        .main > *{
            width:100%;
        }

        .main .left {
            gap: 1em;
        }
        .main .right video {
            min-height: 360px;
        }
        .vid-overlay{
            transition: opacity .2s;
        }
        .tile-left{
            background-color: var(--img-color);
        }
        .tile-left > .flex:first-child{
            background-color: #4d377c;
        }
        .tile-left > .flex:not(:last-child){
            align-items: flex-end;
        }
        .tile-left > .tile-2{
            height: 100%;
            width: 145px;
        }
        .im-bkg{
            min-height: 100px;
        }

        .anime{
            visibility: hidden;
            opacity: 0;
        }

        .image{
            border: solid 5px var(--img-color);
            background-color: var(--img-color);
            z-index: 4;
            top: 6em;
            left: 5em;
        }

        .flex-main{
            flex-wrap: wrap;
            align-items: stretch;
            gap: 1em;
        }

        .flex-item{
            width: 100%;
        }

        .flex-item > *:first-child{
            height: 350px;
        }

        .msg-btn{
            color: #fb6a00;
            border-color: currentColor;
        }
        .bio {
            background-color: #3d364c;
        }
        .lang-btn{
            border:solid 1px #574e6a;
            color: white;
            margin: 2px 0;
        }

        .developer{
            width: 100px;
            height: 100px;
        }
        .developer-btn-pane{
            display: none;
        }
        .info-tiles {
            padding-left: 5%;
        }
        .langs{
            display: none;
        }
        @media(min-width:700px){
            .main {
                flex-direction: row;
                min-height: auto;
                align-items: center;
                justify-content: center;
            }
            .main > * {
                width: 400px;
            }
            .main .right video {
                width: 400px;
                min-height: 200px;
            }

            .f-padd{
                padding: 0% 5%;
            }
            .flex-main{
                flex-direction: row;
                justify-content: space-between;
            }
            .flex-item{
                min-height: 200px;
                width: calc(100% / 3.5);
            }
            .flex-item > *:first-child{
                height: 150px;
            }
            .bio-tile-1{
                height: 250px;
            }
            .langs{
                display: block;
            }
            .developer-btn-pane {
                display: block;
            }
        }
    </style>

    <div class="header bc-deep-blue-d flex-full">
        <div class="flex-ico midv">
            <a href="<?= Rexit::domurl() ?>" class="ico-spin">
                <div class="px-40 b-fluid" data-src="<?= Rexit::mapp('images/icons/favicon-white.png') ?>"></div>
            </a>
            <a href="<?= Rexit::domurl() ?>"><div class="c-white">spoova</div></a>
        </div>
        <div class="flex-full c-white flex-r font-em-1d5">
            <div class="flex-ico mid mobile">
                <span class="bi-braces-asterisk"></span>
            </div>
        </div>
    </div>

    <div class="main bc-deep-blue c-white flex xs-3s" style="gap:2em;">


        <div class="left flex f-col midv">
            <div class="wid-full fb-6 font-em-1d5 helvetica">About Framework</div>
            <div class="wid-full">
                Spoova is a php mvc framework built for faster and dynamic 
                cross-device web development.
            </div>
            <div class="flex-full flex-l" style="gap:1em">
                <a href="#developer" class="c-white c-i" data-scroll-hash="developer"><div class="bd-white bd-2 pxv-10 bc-white bc bh-deep-blue c-deep-blue ch-white">Developer</div></a>
                <a href="#framework" class="c-white c-i" data-scroll-hash="framework"><div class="bd-white bd-2 pxv-10" >Framework</div></a>
            </div>
        </div>
        <div class="right">

            <div class="bc-deeper-blue"> 
                <div class="relative video-player">
                    <video id="video" src="<?= Rexit::assets('video/spoova.mp4') ?>" class="px-full"></video>
                    <div class="overlay vid-overlay grid-center bc-black font-em-1d5">
                        <span class="bi-play-circle video-btn"></span>
                    </div>
                </div>

            </div>

        </div>

    </div>

    <div class="box-3s pvs-20 frame-tiles">
    
        <div class="flex-full flex-main pvs-20">  


            <div class="flex f-col flex-item">
                <div class="pxv-4 tile bc-silver rad-5">
                    <div class="px-full b-cover flex mid">
                        <div class="flex mid f-col c-deep-blue">
                            <span class="bi-stack"></span>
                            <div class="text-center">
                                Develop project applications in live state
                            </div>
                        </div>
                    </div>
                </div>
                <div class="pvs-10 font-14 flex-info">
                    Use inbuilt live server to develop projects 
                    in live state mode.
                </div>
            </div>

            <div class="flex f-col flex-item">
                <div class="pxv-4 tile bc-silver rad-5">
                    <div class="px-full b-cover flex mid">
                        <div class="flex mid f-col c-deep-blue">
                            <span class="bi-stack"></span>
                            <div class="text-center">
                                Manage routes with window shutters.
                            </div>
                        </div>
                    </div>
                </div>
                <div class="pvs-10 font-14 flex-info">
                    Manage routes easily by applying route logics using 
                    window shutters
                </div>
            </div>

            <div class="flex f-col flex-item">
                <div class="pxv-4 tile bc-silver rad-5">
                    <div class="px-full b-cover flex mid">
                        <div class="flex mid f-col c-deep-blue">
                            <span class="bi-stack"></span>
                            <div class="text-center">
                               Work smartly saving development time 
                            </div>
                        </div>
                    </div>
                </div>
                <div class="pvs-10 font-14 flex-info">
                    Employ management structures that 
                    saves development time. 
                </div>
            </div>

        </div>
    </div>

    <div id="framework" class="framework box-3s pvs-20 bc-silver">

        <div class="f-padd-2">
            <div class="">
                <div class="pvb-10 fb-6 font-em-1d2 c-deep-blue"><i class="bi-app-indicator"></i> Framework</div>
                <div class="flex-full">
                    The spoova framework was built to emulate mobile compatibility and enable faster web development 
                    through the use of live server. It implements internal structures that makes it easier to manage 
                    and maintain project applications in a more dynamic way. The concept behind its creation is to provide 
                    a strong connection between online and offline development such that it simplifies file migration from 
                    development to production. Hence, it provides some useful backend and front-end functions that helps to 
                    easily map static files such as css and javascipt files to the development environment. 
                    It also uses a windows-frame mvc logic which follows a predefined templating structure for managing web pages.
                </div>
            </div>

            <div class="">
                <div class="pvt-20 pvb-10 fb-6 font-em-1d2 c-deep-blue"><span class="bi-clock-history"></span> Live server</div>
                <div class="flex-full">
                    The live server integrated plugin is a javascript powered feature that is introduced into the framework to enable a faster development 
                    by monitoring errors and changes within the application. This activity requires a lot of resources in order to be able to maintain 
                    a live state development. Several internal measures were put in place in order to minimize the intensive use of resources. 
                    Some good practices are also encouraged to help keep the live server efficient over a long range of time on web browsers.
                </div>
            </div>

            <div class="">
                <div class="pvt-20 pvb-10 fb-6 font-em-1d2 c-deep-blue"><span class="bi-cpu"></span> Integrated features</div>
                <div class="flex-full">
                    Aside from the live server, other features of this framework include, integerated javascript plugins, 
                    local css library, in-built template engine, reusable components, bond components, route managers and resource management. 
                    Altogether, these features are introduced into the framework to make it easier to develop project applications.
                </div>
            </div>
          
        </div>

    </div>

    <div class="bc-off-white-dd box-3s pvs-10">
        <div class="bc-white-dd">
            <div class="bc-orange c-white pxv-10 font-em-d8">

                <div class="bi"> <span class="bi-hdd-stack"></span> Deploying Application</div>  

            </div>

            <div class="pxv-20">
                Spoova ensures to keep the project application development on a production-ready state as long as the integrated 
                frontend and backend tools are employed. This means that once a project application has been sucessfully deployed on a live environment,                   
                it is automatically mapped to its enviroment. The root htaccess file is a key feature in the functionality of the framework which should 
                not be tampered with. Also, all respective configuration files and database configuration access keys 
                required to kickstart the framework should be properly configured.
            </div>
        </div>  
    </div>

    <div id="developer" class="box-3s">

        <div class="flex" style="gap:.5em; align-items:stretch">

            <div class="pvs-20 flex f-col relative tile-left" style="gap:1em">
    
                <div class="flex tile-1 rad-5 flex-l bc-silver rad-lb-none rad-rt-none b-cover anime bio-tile-1" data-anime="animate__bounceIn" data-src="<?= Rexit::images('pexels-pixabay-316093.jpg') ?>">
                    <div class="im-bkg"></div>
                </div>

                <div class="flex tile-2 rad-5 flex-r bc-silver rad-lt-none b-cover"></div>

                <div class="flex tile-3 pxv-10 flex-r rad-r absolute image">
                    <div class="px-full developer b-fluid rad-i oo-5 oc-5 anime" data-anime="animate__bounceIn" style="outline-color: #fb6a00;" data-src="<?= Rexit::images('dev.jpg') ?>"></div>
                </div>
    
            </div>
    
            <div id="info-section" class="pvs-20 flex-full tile-right" style="height: 400px; z-index: 0">
                <div class="info-tiles rad-5 px-full flex midl bio anime animation anim" data-anime="animate__bounceInUp" style="border-top-left-radius:0">

                    <div class="relative pxv-20 info-pane" style="left:1em">
                        
                        <div class="pxs-20">
                            <div class="font-em-1d5 fb-6 developer-btn-pane c-white">
                                <div class="span-btns rad-10 pxv-10 pxs-16 font-em-d85" style="background-color:#4b4459">Developer</div>
                            </div>
                            <div class="mvt-18 c-white">
                                <span class="c-orange fb-6">Hi there,</span> I'm Saheed. I'm a fullstack web developer and I have passion for learning and creating new ideas and technologies.
                            </div> <br>
                            <div class="flex bio-info" style="gap:1em">
                                <div class="pvs-10 rad-5 skills">
                                    <div class="fb-6 pxv-6 pxs-8 bc-white-dd rad-r c-soft-pink" style="background-color: #342c43;">Skills</div> <br>
                                    <div class="pxs-2">
                                        <span class="span-btns lang-btn rad-5 font-em-d85">Web Development</span>
                                        <span class="span-btns lang-btn rad-5 font-em-d85">Graphics design</span>
                                        <span class="span-btns lang-btn rad-5 font-em-d85">Content writing</span>
                                    </div>
                                </div>
                                <div class="pvs-10 rad-5 langs">
                                    <div class="fb-6 pxv-6 pxs-8 bc-white-dd rad-r c-soft-pink" style="background-color: #342c43;">Languages</div> <br>
                                    <div class="pxs-2">
                                        <span class="span-btns lang-btn rad-5 font-em-d85">PHP</span>
                                        <span class="span-btns lang-btn rad-5 font-em-d85">JAVASCRIPT</span>
                                        <span class="span-btns lang-btn rad-5 font-em-d85">CSS</span>
                                        <span class="span-btns lang-btn rad-5 font-em-d85">PYTHON</span>
                                        <span class="span-btns lang-btn rad-5 font-em-d85 hide">ANDROID</span>
                                        <span class="span-btns lang-btn rad-5 font-em-d85 hide">NODEJS</span>
                                    </div>
                                </div>
                            </div>
                           
                        </div>
                    </div>

                </div>
            </div>
        </div>

    </div>


    <script>

        let intersect = new Intersect;

        intersect.observe({
            el: '#developer',
            options: {
            'rootMargin': '500px 0px 0px 0px',
            'threshold': '.25',
            },
            callback: function(entry) {
                
                let target = entry.target;
                let animes = target.querySelectorAll('.anime');
                let image  = '';

                if(entry.inview){ 
                    let tiles, tilesCount, timeout, step, etile;

                    timeout = 0; 
                    tiles = [];
                    tilesCount = animes.length;

                    animes.forEach((anime, index) => {
                        step = index + 1;

                        if(step != 2){

                            timeout = timeout + 500;
                            anime.style.visibility = 'visible';

                            setTimeout(() => {
                                anime.classList.add(anime.getAttribute('data-anime')) 
                                setTimeout(()=>{
                                    anime.style.opacity = 1;
                                })
                            }, timeout)

                            if((step === 3) && etile){
                                etile.style.visibility = 'visible';
                                //finalize ..
                                setTimeout(() => {
                                    etile.classList.add(etile.getAttribute('data-anime')) 
                                    setTimeout(()=>{
                                        etile.style.opacity = 1;
                                    })
                                }, timeout + 1000);
                            }

                        } else{
                            etile = anime;
                        }
                    })

                } else {
                    animes.forEach((anime) => {
                        anime.style.visibility = 'hidden';
                        anime.style.opacity = 0;
                        anime.classList.remove(anime.getAttribute('data-anime'))
                    })
                }
            }
        })

        window.onload = function() {

            videoPlayer = document.querySelector('.video-player'); 
            videoBtn = videoPlayer.querySelector('.video-btn');
            video  = videoPlayer.querySelector('video');

            video.addEventListener('pause', function(){
                videoBtn.parentNode.style.opacity = 1;
            })

            video.addEventListener('play', function(){ 
                videoBtn.parentNode.style.opacity = 0;
            })

            videoPlayer.addEventListener('click', function(event){

                videoBtn.classList.toggle('bi-pause')
                videoBtn.classList.toggle('bi-play-circle');

                if(video.paused){
                    videoBtn.parentNode.style.opacity = 0;
                    video.play()
                }else{
                    videoBtn.parentNode.style.opacity = 1;
                    video.pause();
                }

            })

            let intersect = new Intersect;

            intersect.observe({
                el:'.video-player',
                callback: function(entry){ 
                    if(!entry.inview){
                        video.pause();
                    }
                }
            })

        }

    </script>

</body>
</html>