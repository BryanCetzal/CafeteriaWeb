const carouselWrapper = document.getElementById('carouselWrapper');
let currentIndex = 0;

function showSlide(index) {
    currentIndex = index;
    const translateValue = -index * 100 + '%';
    carouselWrapper.style.transform = `translateX(${translateValue})`;
}

function prevSlide() {
    currentIndex = (currentIndex - 1 + carouselWrapper.children.length) % carouselWrapper.children.length;
    showSlide(currentIndex);
}

function nextSlide() {
    currentIndex = (currentIndex + 1) % carouselWrapper.children.length;
    showSlide(currentIndex);
}

// Cambia a la siguiente imagen cada 5 segundos
setInterval(() => {
    nextSlide();
}, 5000);