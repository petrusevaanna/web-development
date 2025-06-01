const photoInput = document.getElementById('photoInput');
const photoArea = document.getElementById('photoArea');
const addPhotoButton = document.getElementById('addPhotoButton');
const addPhotoSecondary = document.getElementById('addPhotoSecondary');
const shareButton = document.getElementById('shareButton');
const captionTextarea = document.getElementById('caption');
const photoSliderContainer = document.getElementById('photoSliderContainer');
const photoSlider = document.getElementById('photoSlider');
const photoIndicator = document.getElementById('photoIndicator');
const defaultIcon = document.getElementById('defaultIcon');

let currentSlideIndex = 0;
let images = [];
const defaultImageWidth = 400;
const defaultImageHeight = 300;

addPhotoButton.addEventListener('click', () => {
    photoInput.click();
});

addPhotoSecondary.addEventListener('click', () => {
    photoInput.click();
});

photoInput.addEventListener('change', (event) => {
    const files = event.target.files;
    if (files && files.length > 0) {
        images = [];
        photoSlider.innerHTML = '';
        let filesProcessed = 0;
        const totalFiles = files.length;

        Array.from(files).forEach((file) => {
            if (file.type.startsWith('image/')) {
                const reader = new FileReader();
                reader.onload = (e) => {
                    const img = new Image();
                    img.src = e.target.result;
                    img.onload = () => {
                        let width = img.width;
                        let height = img.height;

                        if (width > defaultImageWidth || height > defaultImageHeight) {
                            const aspectRatio = width / height;
                            if (width > defaultImageWidth) {
                                width = defaultImageWidth;
                                height = defaultImageWidth / aspectRatio;
                            }
                            if (height > defaultImageHeight) {
                                height = defaultImageHeight * aspectRatio;
                            }
                        }

                        const imgElement = document.createElement('img');
                        imgElement.src = e.target.result;
                        imgElement.style.maxWidth = '100%';
                        imgElement.style.maxHeight = '100%';
                        photoSlider.appendChild(imgElement);
                        images.push({
                            src: e.target.result,
                            width: width,
                            height: height,
                        });

                        filesProcessed++;
                        if (filesProcessed === totalFiles) {
                            updateSlider();
                            updateShareButtonState();
                        }
                    };
                };
                reader.readAsDataURL(file);
            } else {
                filesProcessed++;
                if (filesProcessed === totalFiles) {
                    updateSlider();
                    updateShareButtonState();
                }
            }
        });
    }
});
         function showSlide(index) {
    currentSlideIndex = index;
    const translateX = -index * 100;
    photoSlider.style.transform = `translateX(${translateX}%)`;
}

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

function updateSliderIndicator() {
    const indicator = document.getElementById('photoIndicator');
    indicator.textContent = `${currentSlideIndex + 1}/${images.length}`;
}

function updateSlider() {
    updateSliderIndicator();
    if (images.length > 0) {
        photoArea.classList.remove('empty');
        photoSliderContainer.style.display = 'block';
        defaultIcon.style.display = 'none';
        addPhotoButton.style.display = 'none';
        showSlide(0);
    } else {
        photoArea.classList.add('empty');
        photoSliderContainer.style.display = 'none';
        defaultIcon.style.display = 'block';
        addPhotoButton.style.display = 'block';
    }
    shareButtonState();
}

function shareButtonState() {
    const hasPhotos = images.length > 0;
    const hasCaption = captionTextarea.value.trim() !== '';
    shareButton.disabled = !hasPhotos && !hasCaption;
}

function sharePost() {
    if (shareButton.disabled) {
        return;
    }

    const caption = captionTextarea.value.trim();
    const postData = {
        images: images.map(img => ({ src: img.src, width: img.width, height: img.height })),
        caption: caption
    };
    console.log('Информация о новом посте:', postData);
}

captionTextarea.addEventListener('input', updateShareButtonState); 

updateSlider();
shareButtonState()