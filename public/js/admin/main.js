$(function () {
    if ($('textarea[name=text]').length) {
        tinymce.init({
            selector: 'textarea[name=text]',
            height: 500,
            plugins: [
                'advlist lists charmap preview searchreplace visualblocks code' +
                ' fullscreen media table contextmenu paste textcolor colorpicker table'
            ],
            menubar: 'edit view format tools table tc help',
            toolbar: 'undo redo formatselect removeformat | bold italic underline fontsizeselect | ' +
                ' alignleft aligncenter alignright alignjustify | visualblocks ' +
                ' copy paste cut searchreplace | forecolor backcolor | ' +
                'bullist numlist outdent indent | media | charmap' +
                ' | table | preview fullscreen',
            content_css: [
                '/css/tinymce/codepen.min.css',
                '/css/tinymce/fonts.css'
            ],
            language: 'ru',
            preview_styles: 'font-size color'
        });
    }
});