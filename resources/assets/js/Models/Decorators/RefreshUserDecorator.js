
export var refreshUserDecorator = {

    refreshUserAnchors: {
        email: 'user_email',
        about: 'user_about',
        birth: 'user_birth',
        image: 'user_image',
        id:    'user_id'
    },

    refreshUserDecorator(el, result){
        if(typeof el !== 'object' || el.tagName !== 'INPUT') {
            return false;
        }
        if (typeof result === 'string' && result == 'error'){
            el.value = document.getElementById(self.refreshUserAnchors.id).value;
            console.log('error refreshUser');
        } else {
            if (document.getElementById(self.refreshUserAnchors.email)) {
                document.getElementById(self.refreshUserAnchors.email).innerText = document.createTextNode(result.email).textContent;
            } else {
                console.log('email anchor not found');
            }
            if (document.getElementById(self.refreshUserAnchors.about)) {
                document.getElementById(self.refreshUserAnchors.about).innerText = document.createTextNode(result.about).textContent;
            } else {
                console.log('about anchor not found');
            }
            if (document.getElementById(self.refreshUserAnchors.birth)) {
                document.getElementById(self.refreshUserAnchors.birth).innerText = document.createTextNode(result.birth_date).textContent;
            } else {
                console.log('birth anchor not found');
            }
            if (document.getElementById(self.refreshUserAnchors.image)) {
                document.getElementById(self.refreshUserAnchors.image).setAttribute('src', result.photo_path);
            } else {
                console.log('image anchor not found');
            }
            if (document.getElementById(self.refreshUserAnchors.id)) {
                document.getElementById(self.refreshUserAnchors.id).value = el.value;
            } else {
                console.log('id anchor not found');
            }

        }
    }
};
