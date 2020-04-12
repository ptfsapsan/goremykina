const T = {
    bgImages: [],
    bgCurrentIndex: 0,
    bgNextIndex: 1,
    bgCount: 0,

    init: function () {
        $.post('/ajax/get-index-init', function (data) {
            T.bgImages = data.backgroundImages;
            $('#main-image').prop('src', data.mainImage);
            setInterval(T.setBackground, 50000);
            T.bgCount = data.backgroundImages.length;
        }, 'json');
        T.setBackground();
    },

    setBackground: function () {
        $('#wrapper-hide').hide().css('background-image', 'url("/' + T.bgImages[T.bgNextIndex] + '")')
            .fadeIn(1000, function () {
                    $('#wrapper').css('background-image', 'url("/' + T.bgImages[T.bgCurrentIndex] + '")');
                    $('#wrapper-hide').hide();
                }
            );
        T.bgCurrentIndex++;
        T.bgNextIndex++;
        if (T.bgCount === T.bgCurrentIndex) {
            T.bgCurrentIndex = 0;
        }
        if (T.bgCount === T.bgNextIndex) {
            T.bgNextIndex = 0;
        }
    },
};


$(function () {
    T.init();
});