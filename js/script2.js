        function nextSlide(sliderId) {
            const slider = document.getElementById(sliderId);
            const slides = slider.children;
            let currentIndex = parseInt(slider.dataset.index || '0');
            const totalSlides = slides.length;

            currentIndex = (currentIndex + 1) % totalSlides;

            slider.style.transform = `translateX(-${currentIndex * 100}%)`;
            slider.dataset.index = currentIndex;

            updateIndicator(sliderId, currentIndex, totalSlides);
        }

        function prevSlide(sliderId) {
            const slider = document.getElementById(sliderId);
            const slides = slider.children;
            let currentIndex = parseInt(slider.dataset.index || '0');
            const totalSlides = slides.length;

            currentIndex = (currentIndex - 1 + totalSlides) % totalSlides; 

            slider.style.transform = `translateX(-${currentIndex * 100}%)`;
            slider.dataset.index = currentIndex;

            updateIndicator(sliderId, currentIndex, totalSlides);
        }
      window.onload = function() {
          const slider1 = document.getElementById('slider1');
          if (slider1) {
              updateIndicator('slider1', 0, slider1.children.length);
          }
      };