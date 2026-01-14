let slideIndex = 0;

// Инициализация слайд-шоу
document.addEventListener('DOMContentLoaded', function() {
    showSlides(slideIndex);
    // Автоматическая смена слайдов каждые 5 секунд
    setInterval(function() {
        changeSlide(1);
    }, 5000);
});

// Функция для смены слайда
function changeSlide(n) {
    showSlides(slideIndex += n);
}

// Функция для отображения слайдов
function showSlides(n) {
    const slides = document.getElementsByClassName('slide');
    
    if (slides.length === 0) return;
    
    if (n >= slides.length) {
        slideIndex = 0;
    }
    if (n < 0) {
        slideIndex = slides.length - 1;
    }
    
    // Скрываем все слайды
    for (let i = 0; i < slides.length; i++) {
        slides[i].style.display = 'none';
    }
    
    // Показываем текущий слайд
    if (slides[slideIndex]) {
        slides[slideIndex].style.display = 'block';
    }
}

