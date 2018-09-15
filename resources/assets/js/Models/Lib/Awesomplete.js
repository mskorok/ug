import './../../lib/awesomplete';

export var Awesom = {

    url: '/api/v1/adventures/users',
    autocomplete: null,


    init(selector){
        this.autocomplete = new Awesomplete(document.querySelector('#' + selector), {list: []});
        return this.autocomplete;
    },

    fill() {
        var self = this;

        if(this.autocomplete) {
            Ajax.get(self.url, function (data) {
                self.autocomplete.list = JSON.parse(data).map(function (i) {
                    return i.name;
                });
            });
        }

    }
};
