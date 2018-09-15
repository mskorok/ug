
import { Element } from 'bunnyjs/src/bunny.element';
import { Navbar } from '../../Components/Nav/Navbar';

export var IndexController = {

    btnHowItWorks: document.getElementById('btn_how_it_works'),
    sectionHowItWorks: document.getElementById('how_it_works'),
    classHowItWorksHidden: 'app-how-it-works-hidden',
    btnCloseHowItWorks: document.getElementById('how_it_works_close'),

    index: function()
    {
        this.attachEventListeners();
    },

    attachEventListeners()
    {
        this.btnHowItWorks.addEventListener('click', () => {
            this.sectionHowItWorks.style.maxHeight = '2000px';
            this.sectionHowItWorks.classList.remove(this.classHowItWorksHidden);
            Element.scrollTo(this.sectionHowItWorks, {duration: 1000, offset: -Navbar.getHeight()});
        });

        this.btnCloseHowItWorks.addEventListener('click', () => {
            this.sectionHowItWorks.style.maxHeight = 0;
            setTimeout(() => { // add class after transition over
                this.sectionHowItWorks.classList.add(this.classHowItWorksHidden);
            }, 700);
        });
    }

};
