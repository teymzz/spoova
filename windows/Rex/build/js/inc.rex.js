
#script:index

    window.onload = function(){
        
        const hamburger_menu = document.querySelector(".hamburger-menu");
        const container = document.querySelector(".maincover");
        hamburger_menu.addEventListener("click", () => {

            container.classList.toggle("active");
            
            const ul = document.querySelector(".links");
            const slideToggle = elem => {

            let newHeight, height = elem.offsetHeight;

            if(!isMobile(500)){
                elem.classList.remove('slided-up');
            }else{ 
                elem.offsetHeight = elem.scrollHeight
                if(height == 0){
                    elem.classList.remove('slided-up');
                    newHeight = elem.scrollHeight;
                    elem.style.height = `${newHeight}px`;
                } else {
                    elem.classList.add('slided-up');
                    newHeight = 0;
                    elem.style.height = `${newHeight}px`;
                }   
            }
            
            } 
            slideToggle(ul); 
        });        

    }
    
#script;