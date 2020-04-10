$(function(){
   $('[name=active]').on('change', function (){
      location.href = '?act=ch_active&id=' + $(this).data('id');
   });

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
         page: 'gallery'
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


});

function getTempFiles(){
   $('#files').load('/ajax/get-page-files', {page: 'gallery'}, function (data){
      // удаление
      $('.del_file').on('click', function (){
         $.post('/ajax/delete-page-file', {name: $(this).data('name')}, getTempFiles);
      });

      $('.tmp_img').on('click', function (){
         tinymce.execCommand('mceInsertContent', false, $(this).html());
      })

   });
}
