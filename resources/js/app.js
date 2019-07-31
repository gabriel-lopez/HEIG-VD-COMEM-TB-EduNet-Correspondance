/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

// Import TinyMCE
import tinymce from 'tinymce/tinymce';

// A theme is also required
import 'tinymce/themes/silver';

// Any plugins you want to use has to be imported
import 'tinymce/plugins/paste';
import 'tinymce/plugins/link';
import 'tinymce/plugins/wordcount';
import 'tinymce/plugins/autosave';
import 'tinymce/plugins/autoresize';
import 'tinymce/plugins/image';
import 'tinymce/plugins/imagetools'
import 'tinymce/plugins/emoticons';
import 'tinymce/plugins/lists';
import 'tinymce/plugins/preview';

import 'bootstrap-select'
import 'bootstrap-select/js/i18n/defaults-fr_FR'

window.Vue = require('vue');

/**
 * The following block of code may be used to automatically register your
 * Vue components. It will recursively scan this directory for the Vue
 * components and automatically register them with their "basename".
 *
 * Eg. ./components/ExampleComponent.vue -> <example-component></example-component>
 */

// const files = require.context('./', true, /\.vue$/i);
// files.keys().map(key => Vue.component(key.split('/').pop().split('.')[0], files(key).default));

Vue.component('example-component', require('./components/ExampleComponent.vue').default);

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

const app = new Vue({
    el: '#app',
});

$(document).ready(function () {

    console.log('ready')

    $('#sidebarCollapse').on('click', function () {
        $('#sidebar').toggleClass('active');
    });

    tinymce.init({
        selector: 'textarea',
        language: 'fr_FR',
        relative_urls: false,
        images_upload_url: '/upload',
        images_upload_handler: function (blobInfo, success, failure) {
            let xhr = new XMLHttpRequest();
            xhr.open('POST', '/upload');
            xhr.setRequestHeader('X-CSRF-TOKEN', $('meta[name="csrf-token"]').attr('content')); // manually set header

            xhr.onload = function() {
                if (xhr.status !== 200) {
                    failure('HTTP Error: ' + xhr.status);
                    return;
                }

                let json = JSON.parse(xhr.responseText);

                if (!json || typeof json.location !== 'string') {
                    failure('Invalid JSON: ' + xhr.responseText);
                    return;
                }

                success(json.location);
            };

            let formData = new FormData();
            formData.append('file', blobInfo.blob(), blobInfo.filename());

            xhr.send(formData);
        },
        /*file_browser_callback: function(field_name, url, type, win) {
            // trigger file upload form
            if (type === 'image') {
                $('#formUpload input').click();
            }
        },*/
        plugins: ['paste', 'link', 'wordcount', 'autosave', 'autoresize', 'image', 'imagetools', 'emoticons', 'lists'],
        toolbar: ['undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | outdent indent | link image', 'wordcount restoredraft emoticons preview '],
        browser_spellcheck: true,
        branding: false // To disable "Powered by TinyMCE"
    });

    $('*[data-href]').on('click', function() {
        window.location = $(this).data("href");
    });

    $('table[data-form="deleteForm"]').on('click', '.form-delete', function(e){
        e.preventDefault();
        var $form=$(this);
        $('#confirm').modal({ backdrop: 'static', keyboard: false })
            .on('click', '#delete-btn', function(){
                $form.submit();
            });
    });

    $('#visto').change(function(){
        if($(this).is(':checked'))
        {
            $('#login').prop('disabled', true);
        }
        else
        {
            $('#login').prop('disabled', false);
        }
    });
    $('#passwordCheckBox').change(function(){
        if($(this).is(':checked'))
        {
            $('#password').prop('disabled', true);
            $('#password_confirmation').prop('disabled', true);
        }
        else
        {
            $('#password').prop('disabled', false);
            $('#password_confirmation').prop('disabled', false);
        }
    });
});
