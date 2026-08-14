let pressTimer, link, options;

link = document.querySelectorAll('.nav-btn-lt');

options = () => {

  return {
    open:() =>{
      let ul = document.querySelector('.nav-pane ul');
      let sidebar = document.querySelector('.side-bar');
      //ul.classList.add('open');
      sidebar.classList.add('active');
    },
    close: ()=>{
      let ul = document.querySelector('.nav-pane ul');
      let barClose = document.querySelector('.side-bar .close');
      setTimeout(() => { ul.classList.remove('open');  }, 5000);
    }
  }

}

function handleLongPress(e) {
    options().open()
}

function pressDown(e){
  e.preventDefault()
    counter = 0;
    interval = setInterval(() => {
      counter++
      if(counter > 20){
        clearInterval(interval);
        pressTimer = setTimeout(handleLongPress);
      }
    } );  
}

function pressRelease(e){
    if(counter < 20) {
      clearInterval(interval)
      window.location.href = e.target.getAttribute('href') || e.target.closest("a").getAttribute("href");

      counter = 0;
    }else{
      options().close();
    }
    clearTimeout(pressTimer);  
}

function pressClose(){
  let sideClose = document.querySelector('.side-bar .close');
  sideClose.addEventListener('click', function() {
    document.querySelector('.side-bar').classList.remove('active')
  })
}
pressClose();

link.forEach(element => {
   
    let counter = 0, interval;

    //handler mouse events
    element.addEventListener('click', (e) => e.preventDefault())

    element.addEventListener('mousedown', (e) => pressDown(e));

    element.addEventListener('mouseup', (e) => pressRelease(e));
    
    //handle touch events
    element.addEventListener('touchstart', (e) => pressDown(e));
    
    element.addEventListener('touchend', (e) => pressRelease(e));
  
})

// auto detect menu 


window.onload = function() {
    
  var origin = window.location.origin;
  var page = origin + '/' + 'checkbox/';
  var docs = page + 'docs/';
  var nav = page + 'docs/navbar.html';
      
  var xhr = new XMLHttpRequest();
  xhr.open("GET", nav, true);
      
  xhr.onreadystatechange = function () {
      if (xhr.readyState == 4 && xhr.status == 200) {
          let navArea = document.querySelector('.side-bar-fit');
          navArea.innerHTML = xhr.responseText
          let url = location.href.split('/');
          url = url[url.length - 1];
          url = url.split('.html')[0]; 
          let menu = document.getElementById(url);
          if(!menu && (url.split('-')[0] === 'toggle')){
            menu = document.getElementById('toggling-attribute');
          }
          menu.classList.add('active');
          menu.scrollIntoView({behavior: "smooth"})
      }
  };
  xhr.send();
  // let url = location.href.split('/');
  // url = url[url.length - 1];
  // url = url.split('.html')[0];
  // let menu = document.getElementById(url);
  // menu.classList.add('active');
  // menu.scrollIntoView()
}
