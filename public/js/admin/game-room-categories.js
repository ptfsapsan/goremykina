(function () {
    $('[id^=active_]').on('change', function () {
        location.href = '?act=active&id=' + $(this).data('id');
    });
    $('.cat_title').on('change', function () {
        const t = $(this);
        location.href = '?act=title&id=' + $(this).data('id') + '&title=' + t.val();
    })
})();
