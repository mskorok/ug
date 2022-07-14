# UrlaubsGlueck v2

*Urlaubsgluck* (From German Urlaubs -Vocations, Glück (read. Glueck) - happiness) – is an amazing online meeting place for unforgettable adventures.

Urlaubsgluck is a classic mobile friendly web application.

Urlaubsgluck is a social network for adventurers to help find people with similar adventure interests and locations.

**How it works:**
1. Connect with people who share similar interests
2. Plan an adventure together
3. Meeting new friends and experience the unforgettable

# Contacts

Tech lead, architect:



# Technical specification

...

# Wireframes


# Server requirements

* PHP >= 7.0.0
* MySQL >= 5.7.10
* OpenSSL PHP extension
* PDO PHP extension
* Mbstring PHP extension
* Tokenizer PHP extension

Laravel 5.2, Bootstrap 4 alpha, BunnyJS are used.

# Installation instructions

1. Add new virtual host (for example urlaubsgluck.local) or set up virtual machine / vagrant (vagrant is in git)
2. DocumentRoot in project_folder/public
3. git clone.
4. Create new MySQL DB and user
5. Install composer.phar, rename to composer if not installed and add to PATH
6. run "composer install" in terminal ~project root
7. goto /dev in browser (urlaubsgluck.local/dev)
8. create .env file
9. generate app key
10. fill DB credentials
11. press on db hard delete, migrate and seed (button at bottom or via terminal: php artisan rebuild && php artisan migrate && php artisan db:seed)


Test user: test@user.com (pass: 12345678)

Test admin: test@admin.com (pass: 12345678)


# API setup

### Google Oauth

1. Follow steps to create Google OAuth APP KEY https://developers.google.com/+/web/api/rest/oauth
2. select - called by JavaScript
3. Create credentials
4. Authorized JavaScript origins: enter http(s)://yourdomain.com
5. Authorized redirect URIs: http(s)://yourdomain.com/login

# Assets (sass and js)

* Assets in project_folder/resources/assets/
* Bootstrap 4 alpha SASS used as html/css framework
* Native JavaScript (EcmaScript 6) used and compiled via babel and bundled via rollup.js
* to compile assets install node.js 5 and npm if not installed
* run "npm install" in project root
* to compile assets run "gulp"
* to compile and minify assets, remove console.log etc run "gulp --production"

# Dev server

https://dev.urlaubsglueck.com (deploy on push to master)
