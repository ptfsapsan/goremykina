$(function(){
    $('[name=active-image]').on('change', function () {
        location.href = '?act=active&id=' + $(this).val();
    });
});

