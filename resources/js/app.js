import Alpine from 'alpinejs';

import {
    ClassicEditor,
    Essentials,
    Paragraph,
    Bold,
    Italic,
    List,
    Image,
    ImageUpload,
    SimpleUploadAdapter
} from 'ckeditor5';

import 'ckeditor5/ckeditor5.css';


window.Alpine = Alpine;

Alpine.start();


document.querySelectorAll('.rich-editor').forEach((editor) => {

    ClassicEditor
        .create(editor, {

            licenseKey: 'GPL',

            plugins: [
                Essentials,
                Paragraph,
                Bold,
                Italic,
                List,
                Image,
                ImageUpload,
                SimpleUploadAdapter
            ],

            toolbar: [
                'bold',
                'italic',
                '|',
                'bulletedList',
                'numberedList',
                '|',
                'imageUpload'
            ],

            simpleUpload: {
                uploadUrl: '/ckeditor/upload',

                headers: {
                    'X-CSRF-TOKEN': document
                        .querySelector('meta[name="csrf-token"]')
                        .getAttribute('content')
                }
            }

        })
        .catch(error => {
            console.error(error);
        });

});