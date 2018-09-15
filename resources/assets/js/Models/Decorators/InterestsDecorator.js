
import { Interests } from './../Lib/Interests'

export default  {

    hiddenClass: 'hidden-xs-up',
    addInterest: 'add-interest-buttons',
    createInterest: 'create-interest-buttons',

    refreshButtons(res) {
        var html = '';
        res.forEach(function (item) {
            html += '<button  class="app-s-close ' + Interests.buttonStyle + '  refresh-buttons" data-item="' + item + '">' + item + ' '  + ' </button>'
        });
        document.getElementById(Interests.interests).innerHTML = html;
        var class_name = document.getElementsByClassName('refresh-buttons');

        for (var i = 0; i < class_name.length; i++) {
            class_name[i].addEventListener('click', function (e) {
                e.preventDefault();
                e.stopPropagation();
                var name = this.getAttribute('data-item');
                Interests.remove(name);
            });
        }
    },

    addInterestButtons(res) {
        var div = document.createElement('div');

        var html = '';
        res.forEach(function (item) {
            var id = item.replace(/\s+/g, '_');
            if (!(Interests.mode == 'create' && Interests.testForSelected(id))) {
                html += '<button type="button" id="add_interest_buttons_' + id + '" class="' + Interests.buttonStyle +' add-interest-buttons" data-item="' + item + '">' + item + '  +</button>';
            }
        });
        div.innerHTML = html;
        if (document.getElementById(Interests.interestsAdd)) {
            document.getElementById(Interests.interestsAdd).appendChild(div);
            Interests.interestPage++;
            var class_name = document.getElementsByClassName('add-interest-buttons');
            for (var i = 0; i < class_name.length; i++) {
                class_name[i].addEventListener('click', function (e) {
                    e.preventDefault();
                    e.stopPropagation();
                    var name = this.getAttribute('data-item');

                    if (Interests.mode == 'edit') {
                        Interests.add(name);
                    } else if (Interests.mode == 'create') {
                        Interests.collectInterestsForCreation(name);
                    }
                });
            }
        }
    },

    collectInterestsDecorator(name, new_interest) {
        let self = Interests;
        var html;
        var id = name.replace(/\s+/g, '_');
        var i = document.createElement('input');
        i.setAttribute('type', 'hidden');
        i.setAttribute('name', 'interests[]');
        i.setAttribute('id', 'interest_hidden_field_' + id);
        i.setAttribute('class', self.hiddenInterests);
        i.setAttribute('value', name);
        if(document.getElementById(self.interestsHiddenBlock)) {
            document.getElementById(self.interestsHiddenBlock).appendChild(i);
        }

        if (document.getElementById('create_interest_buttons_' + id)) {
            document.getElementById('create_interest_buttons_' + id).classList.remove('hidden-xs-up');
        } else {
            html = '<button type="button" id="create_interest_buttons_' + id + '" class="app-s-close ' + self.buttonStyle +' create-interest-buttons" data-item="' + name + '">' + name + ' </button>';
            var div = document.createElement('div');
            div.style.display = 'inline-block';
            div.innerHTML = html;
            if (document.getElementById(self.interestsForCreationBlock)) {
                document.getElementById(self.interestsForCreationBlock).appendChild(div);
            }

            if (new_interest) {
                this.listSelected();
            }
            document.getElementById('create_interest_buttons_' + id).addEventListener('click', function (e) {


                e.preventDefault();
                e.stopPropagation();

                if(document.getElementById('add_interest_buttons_' + id)) {
                    document.getElementById('add_interest_buttons_' + id).classList.remove('hidden-xs-up');
                }
                document.getElementById(self.interestsHiddenBlock).removeChild(document.getElementById('interest_hidden_field_' + id));
                document.getElementById('create_interest_buttons_' + id).classList.add('hidden-xs-up');
                return false;
            });
        }
        if(document.getElementById('add_interest_buttons_' + id)) {
            document.getElementById('add_interest_buttons_' + id).classList.add('hidden-xs-up');
        }
    }


}
