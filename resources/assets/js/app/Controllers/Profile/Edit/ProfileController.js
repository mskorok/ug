
import { Checkbox } from "../../../../../../../node_modules/bunnyjs/src/form/checkbox";
import { SettingsController } from "./SettingsController";
import { ChangePasswordController } from "./ChangePasswordController";
import { DeactivateAccountController } from "./DeactivateAccountController";
import { NotificationsController } from "./NotificationsController";
import { BlockedUsersController } from "./BlockedUsersController";

export var ProfileController = {

    hiddenClass: 'hidden-xs-up',
    activeClass: 'active',

    // Tabs
    sections: document.getElementsByClassName('app-profile-section'),
    sectionSettings: document.getElementById('profile_settings'),
    sectionNotifications: document.getElementById('notifications'),
    sectionPassword: document.getElementById('change_password'),
    sectionDeactivate: document.getElementById('deactivate_account'),
    sectionBlockedUsers: document.getElementById('blocked_users'),

    // Nav bar
    subNavBar: document.querySelector('.app-subnavbar'),
    navItems: document.querySelectorAll('.app-subnavbar li'),
    navSettings: document.getElementById('nav_settings'),
    navNotifications: document.getElementById('nav_notifications'),
    navBlockedUsers: document.getElementById('nav_blocked_users'),
    // ...
    navChangePassword: document.getElementById('change_password'),
    navDeactivateAccount: document.getElementById('deactivate_account'),

    edit() {
        SettingsController.init();
        ChangePasswordController.init();
        DeactivateAccountController.init();
        NotificationsController.init();
        BlockedUsersController.init();
        this.attachEventHandlers();
        Checkbox.create('checkbox', 'app-checkbox', 'checked');
    },

    attachEventHandlers() {
        // Nav
        this.navSettings.addEventListener('click', () => this.handleNavSettingsClick());
        this.navChangePassword.addEventListener('click', () => this.handleNavChangePasswordClick());
        this.navDeactivateAccount.addEventListener('click', () => this.handleNavDeactivateClick());
        this.navNotifications.addEventListener('click', () => this.handleNavNotificationsClick());
        this.navBlockedUsers.addEventListener('click', () => this.handleNavBlockedUsersClick());
    },

    handleNavChangePasswordClick() {

        this.activateSection(this.sectionPassword.getAttribute('id'));
        this.navDeselectAll();
    },

    handleNavDeactivateClick() {

        this.activateSection(this.sectionDeactivate.getAttribute('id'));
        this.navDeselectAll();
    },

    handleNavSettingsClick() {

        this.activateSection(this.sectionSettings.getAttribute('id'));
        this.activateNavItem(this.navSettings.getAttribute('id'));
    },

    handleNavNotificationsClick() {

        this.activateSection(this.sectionNotifications.getAttribute('id'));
        this.activateNavItem(this.navNotifications.getAttribute('id'));
    },

    handleNavBlockedUsersClick() {

        this.activateSection(this.sectionBlockedUsers.getAttribute('id'));
        this.activateNavItem(this.navBlockedUsers.getAttribute('id'));
    },

    navDeselectAll() {
        this.navItems.forEach((i) => {
            i.classList.remove("active");
            i.getElementsByClassName('nav-link')[0].classList.remove(this.activeClass);
        });
    },

    activateSection(id) {

        this.sections.forEach((i) => {
            if (i.getAttribute('id') == id) {
                i.classList.remove(this.hiddenClass);
            } else if (! i.classList.contains(this.hiddenClass)) {
                i.classList.add(this.hiddenClass);
            }
        });
    },

    activateNavItem(id) {
        this.navItems.forEach((i) => {
            if (i.getAttribute('id') == id && ! i.classList.contains(this.activeClass)) {
                i.classList.add(this.activeClass);
                i.getElementsByClassName('nav-link')[0].classList.add(this.activeClass);
            } else {
                i.classList.remove(this.activeClass);
                i.getElementsByClassName('nav-link')[0].classList.remove(this.activeClass);
            }
        });
    }

}
