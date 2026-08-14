/* This script file is used for documentation purpose only */

function pass(checker){
    input = document.getElementById('pass')
    if(checker.checked){
        input.setAttribute('type','text')
    }else{
        input.setAttribute('type','password')
    }
  }
  
    let checkbox =  new CheckBox(false);
  
    let check1 = checkbox.check({
        assign: {
            attr: ['data-anime', 'class'],
            alter: function(dataAnime){
                dataAnime.unshift('animated')
                return dataAnime.map(el => 'animate__' + el);
            }
        },
        toggle: function(checkbox) {
            let anime = [], value, animation;
  
            value     = checkbox.value;
  
            if(checkbox.checked){
                //console.log(`checkbox ${value} is: checked`)
            }else{
                //console.log(`checkbox ${value} is: unchecked`)
            }
        },
        flip: true, 
    })
  
  // #2 checker................................ 
  checkbox.check({
      target: '[checker]', 
      assign: {
          attr: ['data-anime', 'class', 'unchecked'],
          alter: (dataAnime) => {
              dataAnime.unshift('animated');      
              return dataAnime.map(el => 'animate__' + el);
          }
      },
      toggle: function(checkbox) {
  
          let value = checkbox.value;
          
          if( checkbox.checked ) {
              console.log(`checkbox ${value} is: checked`)
          } else {
              console.log(`checkbox ${value} is: unchecked`)
          }
  
      },
      flip: true,
  });
  
  function onCopy(btn) {  
    field = btn.parentNode.closest('.code').querySelector('pre.active');

    if(!field) return false; 

    function copied(response){
        if(field) {
          if(response){
              btn.innerHTML = 'Copied!'
              let html = navigator.onLine ? '<i class="bi-clipboard "></i>' : '<i class="">&#x2398</i>'
    
              timeout = setTimeout(() => {
                btn.innerHTML = html
              } , 500)
          }
        }
    }
    
    function nativeCopy(field) {
      const range = document.createRange();
        range.selectNode(field);
        window.getSelection().removeAllRanges();
        window.getSelection().addRange(range);
        let response = document.execCommand('copy');
        window.getSelection().removeAllRanges();
        copied(response);
    }
  
    if (!navigator.clipboard) {
        // fallback for browsers that don't support clipboard API
        nativeCopy(field)
    } else { 
        navigator.clipboard.writeText(field.textContent)
            .then(() => copied(true))
            .catch(err => nativeCopy(field))
    }
  
  }
  
  document.querySelectorAll('.copy-btn').forEach(btn => {
    btn.addEventListener('click', function(event){
        onCopy(btn);
    })
  })
  
  let tags = document.querySelectorAll('.tag');
  
  tags.forEach(tag => {
  
    let attributes = tag.children;
    attributes = {...attributes}
    for( let attribute in attributes) {
        
  
        attributes[attribute].classList.add('func');
  
        let attrvals = {...attributes[attribute].children};
  
        for(let attrval in attrvals) {
  
            attrvals[attrval].classList.add('var');
  
        }
  
  
    }
  
  });
  
  // ........code split
  let activeScreens = document.querySelectorAll('.code pre.active');

  activeScreens.forEach(activeScreen => {
    //get parent 
    let parent = activeScreen.closest('.code');
    let isHTML = activeScreen.classList.contains('html')
    let isCSS = activeScreen.classList.contains('css')
    let isJS = activeScreen.classList.contains('js')
    let isView = activeScreen.classList.contains('view')

    if(parent){

        try {
            if(isHTML) {
                parent.querySelector(`.code-btn[rel="html"]`).classList.add('active')
            }else if(isCSS){
                parent.querySelector(`.code-btn[rel="css"]`).classList.add('active')
            }else if(isJS) {
                parent.querySelector(`.code-btn[rel="js"]`).classList.add('active')
            }else if(isView){
                parent.querySelector(`.code-btn[rel="view"]`).classList.add('active')
            }
        } catch (error) {
            // Do nothing ... 
        }
    }

  });

  let codeBtns = document.querySelectorAll('.code-btn');
          
  codeBtns.forEach(codeBtn => {
    codeBtn.addEventListener('click', function(){
      let parent = this.closest(".code");
      let codeBtns = parent.querySelectorAll('.code-btn');
      codeBtns.forEach(btn => {
        btn.classList.remove('active');
      })
      codeBtn.classList.add('active');
      let rel = this.getAttribute('rel');
      let pres = parent.querySelectorAll('pre,.pre');
      let pre = parent.querySelector('pre.'+rel);
      pres.forEach(preItem => {
        preItem.classList.remove('active')
      })
      if(pre) pre.classList.add('active');
    })
  })

  if(!navigator.onLine){

    let icoMap = {
        'bi-window' : '&#9863;',
        'bi-clipboard' : '&#x2398;',
        'bi-chevron-left' : '&#10094;',
        'bi-chevron-right' : '&#10095;',
        'bi-arrow-left-circle': '&#8617;',
        'bi-arrow-right-circle': '&#8618;',
        'bi-stop': '&#9724;',
    }

    for(let icon in icoMap) {
        let icons = document.querySelectorAll('.'+icon);
        icons.forEach(element =>{
            element.classList.remove(icon);
            element.innerHTML = icoMap[icon]
        })
    }

  }