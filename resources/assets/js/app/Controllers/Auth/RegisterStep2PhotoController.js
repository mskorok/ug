
import Form from 'bunnyjs/src/form/form';
import { BunnyFile } from "bunnyjs/src/file/file";
import { BunnyImage } from 'bunnyjs/src/file/image';

import { RegisterController } from './RegisterController';


export const RegisterStep2PhotoController = {

    resizeSize: 500,
    croppieViewportSize: 250,

    btnsAddPhoto: document.querySelectorAll('[data-id="add_photo"]'),
    labelsAddPhoto: document.querySelectorAll('[data-id="add_or_change_photo_label"]'),
    btnRemovePhoto: document.getElementById('remove_photo'),
    photoInput: document.getElementById('photo'),
    photoPreview: document.getElementById('photo_preview'),
    photoPreviewEmpty: document.getElementById('photo_preview_empty'),
    photoPreviewContainer: document.getElementById('photo_preview_container'),
    btnPhotoCrop: document.getElementById('photo_crop_btn'),
    btnPhotoRotate: document.getElementById('photo_rotate_btn'),

    photoPopup: document.getElementById('photo_popup'),

    croppie: null,

    //imageBlob: null,

    init() {
        // if after refresh file is in input, remove it
        if (Form.get(RegisterController.form.id, this.photoInput.name) !== '') {
            this.removeImageFromForm();
        }

        this.attachEventListeners();
        Form.mirror(RegisterController.form.id, this.photoInput.name);
    },
    
    initFromUrl(url) {
        Form.setFileFromUrl(RegisterController.form.id, this.photoInput.name, url);
    },

    initCroppie(width, height) {

        const k = this.resizeSize / this.croppieViewportSize;

        width = Math.floor(width / k);
        height = Math.floor(height / k);

        const viewport_size = Math.min(width, height);

        if (this.croppie !== null) {
            this.croppie.destroy();
        }

        this.croppie = new Croppie(document.getElementById('photo_preview_container'), {
            viewport: {
                width: viewport_size,
                height: viewport_size,
                type: 'circle'
            },
            boundary: {
                width: width,
                height: height
            },
            //exif: true,
            showZoomer: false,
            enableOrientation: true
        });
    },

    attachEventListeners() {
        this.btnsAddPhoto.forEach( btn => {
            btn.addEventListener('click', () => this.photoInput.click());
        });

        this.btnRemovePhoto.addEventListener('click', () => {
            this.removeImageFromForm();
        });

        this.photoInput.addEventListener('change', () => {
            if (this.photoInput.value !== '') {
                this.updateImage(this.photoInput.value);
                this.showPopup();
            }
        });

        document.getElementById('photo_crop_btn').addEventListener('click', () => {
            this.croppie.result({
                type: 'canvas',
                size: 'viewport',
                format: 'jpeg',
                quality: 0.8
            }).then( (imgBase64) => {
                this.setNewImageToForm(imgBase64);
                this.hidePopup();
            });
        });

        document.getElementById('photo_rotate_btn').addEventListener('click', () => {
            this.croppie.rotate(90);
        });

    },

    updateCroppieImage(url) {
        this.croppie.bind( {
            url: url,
            orientation: 1
        });
        //this.croppie.setZoom(0);
    },

    /**
     *
     * @param {Blob|File} img_file
     */
    updateImage(img_file) {
        BunnyImage.getImageByBlob(img_file).then( (img) => {
            return BunnyImage.resizeImage(img, this.resizeSize, this.resizeSize);
        }).then( (img) => {
            this.initCroppie(img.width, img.height);
            this.updateCroppieImage(img.src);
        });
    },

    setNewImageToForm(imgBase64) {
        const blob = BunnyFile.base64ToBlob(imgBase64);
        Form.set(RegisterController.form.id, this.photoInput.name, blob);
        this.hideEmptyPreview();
        this.showRemovePhotoBtn();
        this.labelsAddPhoto.forEach(label => label.textContent = Server.lang.changePhoto);
    },

    removeImageFromForm() {
        Form.set(RegisterController.form.id, this.photoInput.name, '');
        this.showEmptyPreview();
        this.hideRemovePhotoBtn();
        this.labelsAddPhoto.forEach(label => label.textContent = Server.lang.addPhoto);
    },

    showPopup() {
        this.photoPopup.removeAttribute('hidden');
    },

    hidePopup() {
        this.photoPopup.setAttribute('hidden', '');
    },

    showEmptyPreview() {
        this.photoPreviewEmpty.removeAttribute('hidden');
    },

    hideEmptyPreview() {
        this.photoPreviewEmpty.setAttribute('hidden', '');
    },

    showRemovePhotoBtn() {
        this.btnRemovePhoto.removeAttribute('hidden');
    },

    hideRemovePhotoBtn() {
        this.btnRemovePhoto.setAttribute('hidden', '');
    }

};
