function TimeToggle(element) {

    let toggle = element[0];

    let timeout = toggle.getAttribute('data-delay') | 100;

    setTimeout(() => {

        let classToggled = toggle.getAttribute('data-time-toggle');
        classToggled = classToggled.split(' ');
        let timed  =  toggle.getAttribute('[data-interval]') | 1000;
        if(toggle) { 
            let counter = 0;
            setInterval(() => {
                counter++;
                if(counter > 1){
                    counter = 0;
                    toggle.classList.add(...classToggled)
                }else{
                    toggle.classList.remove(...classToggled);
                }
            }, timed)
        }   

    }, timeout)

}