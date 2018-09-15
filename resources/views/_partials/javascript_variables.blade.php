<script>
    var Server = {
        app: {
            locale: '{{ App::getLocale() }}',
            localePrefix: '{{ App::getLocalePrefix() }}',
            webRedirectTo: '{{ config('auth.views.web.redirect_to') }}'

        },
        project: {
            apiPrefix: '{{ config('_project.api_prefix') }}',
            noAvatarImagePath: '{{ config('_project.no_avatar_image_path') }}'
        },
        env: {
            fbAppId: '{{ env('FACEBOOK_APP_ID') }}',
            googleClientId: '{{ env('GOOGLE_CLIENT_ID') }}'
        },
        lang: {}
    };
</script>
