document.addEventListener('DOMContentLoaded', function() {
    var slides = document.querySelectorAll('.slide');
    var currentSlide = 0;
    var slideInterval = setInterval(nextSlide, 8000); 

    slides[currentSlide].classList.add('active'); 

    function nextSlide() {
        slides[currentSlide].classList.remove('active');
        slides[currentSlide].classList.add('prev');
        currentSlide = (currentSlide + 1) % slides.length;
        slides[currentSlide].classList.add('active');
        slides[currentSlide].classList.remove('next');
    }

    var prevButton = document.querySelector('.prev-button');
    var nextButton = document.querySelector('.next-button');

    prevButton.addEventListener('click', function() {
        slides[currentSlide].classList.remove('active');
        slides[currentSlide].classList.add('next');
        currentSlide = (currentSlide - 1 + slides.length) % slides.length;
        slides[currentSlide].classList.add('active');
        slides[currentSlide].classList.remove('prev');
    });

    nextButton.addEventListener('click', function() {
        nextSlide();
    });
});
