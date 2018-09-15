
//import BunnyImage from 'bunnyjs/src/file/image';

export var GalleryUploads = {
    files: [],
    previewId: 'gallery_preview',
    inputId: 'gallery',
    imgClass: 'app-gallery-item',
    resizeMaxWidth: 1200,
    resizeMaxHeight: 1200,

    collectFilesListener() {
        var self = this;
        var input = document.getElementById(this.inputId);

        input.addEventListener('change', (event) => {
            let el = event.target || event.srcElement;

            if (input.files.length > 1 ) {
                for (let j = 0; j < input.files.length; j++) {
                    self.files.push(input.files[j]);
                }
            } else if (input.files.length == 1) {
                self.files.push(input.files[0]);
            }

            var container = document.getElementById(this.previewId);
            if (container) {
                while (container.firstChild) container.removeChild(container.firstChild);
            }
            for (let i = 0; i < self.files.length; i++) {
                const file = self.files[i];
                /*BunnyImage.getImageByBlob(file).then( (img) => {
                    return BunnyImage.resizeImage(img, this.resizeMaxWidth, this.resizeMaxHeight)
                }).then( (img) => {*/
                    var src = URL.createObjectURL(self.files[i]);
                    var img = document.createElement('div');
                    img.setAttribute('style', `background-image: url(${src})`);
                    img.setAttribute('role', 'button');
                    /*img.setAttribute('width', '200');
                     img.setAttribute('height', '135');*/
                    img.setAttribute('class', this.imgClass);
                    /*img.style.margin = '2px';*/

                    container.appendChild(img);

                    img.addEventListener('click', (e) => {
                        let target = e.target || e.srcElement;
                        self.files.splice(i, 1);
                        target.remove();

                    });
                //});
            }

            el.value = null;



        });
    }

};
