$(function () {
    const SLIDE_SHOW_SPEED = 1;

    $('.bxSlider').bxSlider({
        keyboardEnabled: false,
        touchEnabled: false,
        mode: 'fade',
        pager: false,
        controls: true,
        speed: SLIDE_SHOW_SPEED,
        // // startSlide: background.$currentPreviewImage || 0,
        // // pause: calculateSliderPause(background.options),
        // // wrapperClass: CLASS_SLIDER_WRAP,
        // auto: false,
        // onSlideNext: function onSlideNext(slide, oldIndex, activeIndex) {
        //     // triggerCurrentSlide($container, activeIndex);
        //     return true;
        // },
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
});