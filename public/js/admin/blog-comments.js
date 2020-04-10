$(function(){
    $('[name=active]').on('click', function(){
        location.href = '?act=ch_active&id=' + $(this).data('id');
    });
});