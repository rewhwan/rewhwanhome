$(function(){
    var container = $('.slideshow');
    var slideGroup = container.find(".slideshow_slides");
    var slides = slideGroup.find("a");  
    var nav = container.find(".slideshow_nav");
    var indicator = container.find(".slideshow_indicator");
    var aIndicator = indicator.find("a");

    var currentIndex = 0;
    var intervalObject;


    for (var index = 0; index < slides.length; index++) {
        var indexLeft = index * 100 + '%';
        slides.eq(index).css("left", indexLeft);
    }

    function gotoSlide(index) {
        slideGroup.animate({ left: -100 * index + '%' }, 500, 'easeInOutExpo');
        indexDisplay(index)
    }

    function stopTimer() {
        clearInterval(intervalObject);
    }

    container.mouseenter(function () {
        stopTimer();
    });

    container.mouseleave(function () {
        startSlide();
    });

    aIndicator.on('click', function () {
        var index = $(this).index();
        gotoSlide(index);
    });

    function indexDisplay(index) {
        aIndicator.removeClass('active');
        aIndicator.eq(index).addClass('active');
    }

    function startSlide() {
        intervalObject = setInterval(function () {
            var nextIndex = (++currentIndex) % slides.length;
            gotoSlide(nextIndex);
        }, 2000);
    }

    indexDisplay(0);
    startSlide();
});