$(function(){

    // загрузка файла
    $('#load_button').uploadifive({
        auto: true,
        buttonText: 'Загрузить файл',
        buttonClass: 'button',
        width: 200,
        //multi: true,
        fileType: false,
        //dnd: true,
        fileObjName: 'file',
        queueID: "queue",
        fileSizeLimit: '8000',
        formData: {
            page: vars.link
        },
        uploadScript: '/ajax/upload-page-files',
        onSelect: function (){

        },
        onUploadComplete: function (file, data){
            var d = eval('(' + data + ')');
            if(d.result == 'error'){
                //showMessages(d.message, 'error');
            }
            else{
                //showMessages('Файл благополучно загружен', 'info');
                getTempFiles();

            }
        },
        onQueueComplete: function (){
            $('#queue').html('');
        }
    });
    getTempFiles();

    $('[name=pages]').on('change', function(){
       location.href = '?act=change_page&page=' + $(this).val();
    });
});

function getTempFiles(){
    $('#files').load('/ajax/get-page-files', {page: vars.link}, function (data){
        // удаление
        $('.del_file').on('click', function (){
            $.post('/ajax/delete-page-file', {name: $(this).data('name')}, getTempFiles);
        });
    });
}

