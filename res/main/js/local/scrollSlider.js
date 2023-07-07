class HorizontalSlider {
    constructor(sliderId, slideClassName) {
      this.slider = document.getElementById(sliderId);
      this.slides = this.slider.getElementsByClassName(slideClassName);
      this.currentSlideIndex = 0;
  console.log(slider)
      this.createSwitchButtons();
    }
  
    createSwitchButtons() {
      this.switchButtons = document.createElement('div');
      this.switchButtons.className = 'slider-switch-buttons';
  
      for (let i = 0; i < this.slides.length; i++) {
        const button = document.createElement('button');
        button.className = 'slider-switch-button';
        button.addEventListener('click', () => this.showSlide(i));
        this.switchButtons.appendChild(button);
      }
  
      this.slider.appendChild(this.switchButtons);
      this.updateSwitchButtons();
    }
  
    updateSwitchButtons() {
      const buttons = this.switchButtons.getElementsByClassName('slider-switch-button');
  
      for (let i = 0; i < buttons.length; i++) {
        if (i === this.currentSlideIndex) {
          buttons[i].classList.add('active');
        } else {
          buttons[i].classList.remove('active');
        }
      }
    }
  
    showSlide(slideIndex) {
      if (slideIndex < 0 || slideIndex >= this.slides.length) {
        return;
      }
  
      this.slides[slideIndex].scrollIntoView({ behavior: 'smooth', inline: 'center' });
      this.currentSlideIndex = slideIndex;
      this.updateSwitchButtons();
    }
  
    showNextSlide() {
      const nextSlideIndex = (this.currentSlideIndex + 1) % this.slides.length;
      this.showSlide(nextSlideIndex);
    }
  
    showPreviousSlide() {
      const previousSlideIndex = (this.currentSlideIndex + this.slides.length - 1) % this.slides.length;
      this.showSlide(previousSlideIndex);
    }
  
    startAutoScroll(intervalTime) {
      this.stopAutoScroll();
  
      this.autoScrollInterval = setInterval(() => {
        this.showNextSlide();
      }, intervalTime);
    }
  
    stopAutoScroll() {
      clearInterval(this.autoScrollInterval);
    }
  }


  /* 
  Usage:
  const slider = new HorizontalSlider('slider', 'slide');

  slider.showSlide(2); // Show the third slide
  slider.showNextSlide(); // Show the next slide
  slider.showPreviousSlide(); // Show the previous slide
  slider.startAutoScroll(3000); // Start auto-scrolling every 3 seconds
  slider.stopAutoScroll(); // Stop auto-scrolling
  */