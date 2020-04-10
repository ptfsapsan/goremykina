const T = {
    backgroundImage: '',

    init: function () {
        T.setBackground();
        setInterval(T.setBackground, 50000);
    },

    setBackground: function () {
        $.post('/ajax/get-background-image', {backgroundImage: T.backgroundImage}, function (data) {
            T.backgroundImage = data.image;
            $('#wrapper-hide').hide().css('background-image', 'url("' + data.image + '")').fadeIn(1000, function () {
                $('#wrapper').css('background-image', 'url("' + data.image + '")');
                $('#wrapper-hide').hide();
            });
        }, 'json')
    }
};


$(function () {
    T.init();

    $('body').css('backgroundColor', '#222');
});