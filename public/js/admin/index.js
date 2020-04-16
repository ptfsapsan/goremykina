const T = {
    page: '',
    imagePath: '',
    createImg: function (item, files, del) {
        const div = document.createElement('div');
        const tmp = document.createElement('div');
        tmp.classList.add('tmp_img');
        const img = document.createElement('img');
        img.setAttribute('src', T.imagePath + T.page + '/' + item.thumb);
        tmp.appendChild(img);
        div.appendChild(tmp);
        const deleteIcon = del.cloneNode();
        deleteIcon.setAttribute('data-id', item.id);
        tmp.appendChild(deleteIcon);
        const fileName = document.createElement('div');
        fileName.innerText = item.big;
        tmp.appendChild(fileName);
        files.appendChild(div);
    },
    getImages: function () {
        $.post('/ajax/get-page-images', {page: T.page}, function (data) {
            const files = document.getElementById('files');
            files.innerText = '';
            const del = document.createElement('img');
            del.classList.add('del_file');
            del.setAttribute('src', '/images/delete-icon.png');
            del.setAttribute('alt', 'Удалить');
            del.setAttribute('title', 'Удалить');
            $.each(data, function (i, item) {
                T.createImg(item, files, del);
            });

            // удаление
            $('.del_file').on('click', function () {
                $.post('/ajax/delete-page-image', {id: $(this).data('id')}, T.getImages);
            });
        });
    },
    uploadImage: function () {
        $('#load_button').uploadifive({
            auto: true,
            buttonText: 'Загрузить файл',
            buttonClass: 'button',
            width: 200,
            fileType: false,
            fileObjName: 'file',
            queueID: "queue",
            fileSizeLimit: '8000',
            formData: {
                page: T.page,
            },
            uploadScript: '/ajax/upload-page-image',
            onSelect: function () {

            },
            onUploadComplete: function (file, data) {
                T.getImages();
                $('#queue').html('');
            },
            onQueueComplete: function () {
                $('#queue').html('');
            }
        });
    },

};

(function () {
    T.page = $('#page').val();
    T.imagePath = $('#imagePath').val();
    // загрузка файла
    T.uploadImage();
    T.getImages();

    $('#page-select').on('change', function () {
        location.href = '/admin/pages/' + $(this).val();
    });
})();


