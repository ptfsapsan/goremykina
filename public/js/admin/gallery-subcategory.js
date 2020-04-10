const T = {
    categoryId: 0,
    subcategoryId: 0,

    createImg: function (item, files, del) {
        const div = document.createElement('div');
        const tmp = document.createElement('div');
        tmp.classList.add('tmp_img');
        const img = document.createElement('img');
        img.setAttribute('src', '/images/gallery/' + T.categoryId + '/' + T.subcategoryId + '/' + item.thumb);
        tmp.appendChild(img);
        div.appendChild(tmp);
        const deleteIcon = del.cloneNode();
        deleteIcon.setAttribute('data-id', item.id);
        tmp.appendChild(deleteIcon);
        files.appendChild(div);
    }
};

function getGalleryImages() {
    $.post('/ajax/get-gallery-images', {subcategoryId: T.subcategoryId}, function (data) {
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
                $.post('/ajax/delete-gallery-image', {id: $(this).data('id')}, getGalleryImages);
            });
            document.getElementById('queue').innerHTML = '';
        }
    );
}


$(function () {
    T.categoryId = document.getElementById('categoryId').value;
    T.subcategoryId = document.getElementById('subcategoryId').value;

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
            categoryId: T.categoryId,
            subcategoryId: T.subcategoryId,
        },
        uploadScript: '/ajax/upload-gallery-image',
        onSelect: function () {

        },
        onUploadComplete: function (file, data) {
            var d = eval('(' + data + ')');
            if (d.result === 'error') {
                //showMessages(d.message, 'error');
            } else {
                //showMessages('Файл благополучно загружен', 'info');
                getGalleryImages();
            }
        },
        onQueueComplete: function () {
            $('#queue').html('');
        }
    });
    getGalleryImages();


});

