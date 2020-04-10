$(function(){
   $('.theme_title').on('blur', function(){
       var t = $(this);
       location.href = '?act=edit_theme&title=' + t.val() + '&id=' + t.data('id');
   })
});