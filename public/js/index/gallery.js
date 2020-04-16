(function () {
    const SLIDE_SHOW_SPEED = 500;
    const SLIDE_WIDTH = 600;

    $('.bxSlider').bxSlider({
        keyboardEnabled: false,
        touchEnabled: false,
        mode: 'fade',
        pager: false,
        controls: true,
        speed: SLIDE_SHOW_SPEED,
        slideWidth: SLIDE_WIDTH,
        autoControls: false,
        infiniteLoop: false,
        hideControlOnEnd: true,
        adaptiveHeight: true,
        auto: false,
        onSlideNext: function onSlideNext(slide, oldIndex, activeIndex) {
            // triggerCurrentSlide($container, activeIndex);
            console.log(slide);
            console.log(oldIndex);
            console.log(activeIndex);
            return true;
        },
        // onSliderResize: function onSliderResize() {
        //     // fixBxSliderContainerHeight(slider);
        // },
        // onSlideAfter: function onSlideAfter() {
        //     // if (module.goToSlide !== null) {
        //     //     slider.goToSlide(module.goToSlide);
        //     //     module.goToSlide = null;
        //     // }
        // }
    });
})();