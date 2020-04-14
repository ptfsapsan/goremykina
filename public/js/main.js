const T = {
    bgImages: [],
    bgCurrentIndex: 0,
    bgNextIndex: 1,
    bgCount: 0,

    init: function () {
        $.post('/ajax/get-index-init', function (data) {
            // показываем картинку в шапке
            $('#main-image').prop('src', data.mainImage);
            // картинки на подложке
            T.bgImages = data.backgroundImages;
            T.bgCount = data.backgroundImages.length;
            T.setBackground();
            setInterval(T.setBackground, 30000);
        }, 'json');
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