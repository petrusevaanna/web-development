        function openModal(modalId) {
    const modal = document.getElementById(modalId);
    modal.style.display = "block";

    const sliderId = modalId.replace('Modal', 'Slider');
    const slider = document.getElementById(sliderId);
    if (slider) {
        slider.dataset.index = 0; 
        updateModalIndicator(sliderId, 0, slider.children.length);
        slider.style.transform = 'translateX(0)';
    }
}

function closeModal(modalId) {
    document.getElementById(modalId).style.display = "none";
}

function updateModalIndicator(sliderId, currentIndex, totalSlides) {
    document.getElementById(sliderId.replace('Slider', 'Indicator')).innerText = `${currentIndex + 1}/${totalSlides}`;
}

function nextModalSlide(sliderId) {
    const slider = document.getElementById(sliderId);
    const slides = slider.children;
    let currentIndex = parseInt(slider.dataset.index || '0', 10);
    const totalSlides = slides.length;

    currentIndex = (currentIndex + 1) % totalSlides;

    slider.style.transform = `translateX(-${currentIndex * 100}%)`;
    slider.dataset.index = currentIndex;

    updateModalIndicator(sliderId, currentIndex, totalSlides);
}

function prevModalSlide(sliderId) {
    const slider = document.getElementById(sliderId);
    const slides = slider.children;
    let currentIndex = parseInt(slider.dataset.index || '0', 10);
    const totalSlides = slides.length;

    currentIndex = (currentIndex - 1 + totalSlides) % totalSlides;

    slider.style.transform = `translateX(-${currentIndex * 100}%)`;
    slider.dataset.index = currentIndex;

    updateModalIndicator(sliderId, currentIndex, totalSlides);
}

document.addEventListener('keydown', function(event) {
    if (event.key === 'Escape') { 
        const modals = document.querySelectorAll('.modal[style*="display: block"]');
        modals.forEach(modal => {
            closeModal(modal.id);
        });
    }
});
