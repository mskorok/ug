

export var Gallery = {

    imageContainerId: 'app_gallery_image_container',
    galleryContainerId: 'app_gallery',
    prev: 'app_gallery_prev_button',
    next: 'app_gallery_next_button',
    numCurrent: 'app_gallery_image_current',
    numCount: 'app_gallery_image_count',
    hiddenClass: 'hidden-xs-up',
    current: 0,
    images: [],
    init() {
        let imageContainer = document.getElementById(this.imageContainerId);
        this.images = imageContainer.getElementsByTagName('div');
        this.toStep();
        this.setCurrent();
        document.getElementById(this.numCount).innerHTML = this.images.length.toString();
        this.nextListener();
        this.previousListener();
    },

    nextListener() {
        document.getElementById(this.next).addEventListener('click', (e) => {
            e.stopPropagation();
            e.preventDefault();
            let maxLength = this.images.length -1;
            if (0 <= this.current &&  this.current < (maxLength)) {
                this.current ++;
            } else {
                this.current = 0;
            }
            this.toStep();
            this.setCurrent();
        })
    },

    previousListener() {
        document.getElementById(this.prev).addEventListener('click', (e) => {
            e.stopPropagation();
            e.preventDefault();
            let maxLength = this.images.length -1;
            if (0 < this.current &&  this.current <= (maxLength)) {
                this.current--;
            } else {
                this.current = maxLength;
            }
            this.toStep();
            this.setCurrent();
        })
    },

    toStep() {
        this.images.forEach((image) => {
            image.classList.add(this.hiddenClass);
        });
        this.images[this.current].classList.remove(this.hiddenClass);
    },

    setCurrent() {
        document.getElementById(this.numCurrent).innerHTML = (this.current +1).toString();
    }
};
