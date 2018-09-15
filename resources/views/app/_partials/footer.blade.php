
<footer class="app-footer">

        <div class="row">

            {{-- col 1 / row 1 on mobile --}}
            <div class="col-xl-4 m-b-1">

                <h3 class="app-footer-name">{{ trans('core.project_name') }}</h3>

                <p class="app-footer-copyright">2016 &copy; {{ trans('core.copyright') }}</p>

                <div class="dropdown dropdown-block app-footer-dropdown">
                    <button class="app-btn-void dropdown-toggle w-100-lg-down" id="footer_lang_dropdown" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        @if (App::getLocale() === 'en')
                            {{ trans('core.english') }}
                        @else
                            {{ trans('core.german') }}
                        @endif
                    </button>
                    <div class="dropdown-menu w-100-lg-down" aria-labelledby="footer_lang_dropdown">
                        @if (App::getLocale() === 'en')
                            <a class="dropdown-item" href="{{ trans_url('de') }}">{{ trans('core.german') }}</a>
                        @else
                            <a class="dropdown-item" href="{{ trans_url() }}">{{ trans('core.english') }}</a>
                        @endif
                    </div>
                </div>

            </div>

            {{-- col 3 (col 2 below) / row 2 on mobile --}}
            <div class="col-xl-4 push-xl-4 m-b-1">

                {{--<form name="footer_subscribe" id="footer_subscribe" method="POST" action="">
                    <div class="form-group">
                        <label for="footer_subscribe" class="app-block text-xl-right">{{ trans('core.subscribe_label') }}</label>
                        <div class="app-relative">
                            <input class="form-control" type="email" name="email" placeholder="{{ trans('core.subscribe_placeholder') }}" required>
                            <input type="submit" value="{{ trans('core.subscribe') }}" class="app-btn-in-input">
                        </div>
                    </div>
                </form>--}}

                <div class="app-footer-socials col-xs-12 text-lg-right p-a-0">

                    {{--<a href="#">
                        <svg class="app-footer-icon">
                            <use xlink:href="#svg__social__instagram"></use>
                        </svg>
                    </a>--}}

                    <a href="#">
                        <svg class="app-footer-icon m-r-3">
                            <use xlink:href="#svg__social__facebook"></use>
                        </svg>
                    </a>

                    <a href="#">
                        <svg class="app-footer-icon">
                            <use xlink:href="#svg__social__twitter"></use>
                        </svg>
                    </a>

                </div>

            </div>

            {{-- col 2 / row 3 on mobile --}}
            <div class="col-xl-4 pull-xl-4 m-b-1 p-a-0">

                <div class="app-footer-links">
                    <div class="col-xs-6 p-a-0">
                        <a href="#">{{ trans('core.about_us') }}</a>
                        <a href="#">{{ trans('core.for_press') }}</a>
                        <a href="#">{{ trans('core.blog') }}</a>
                        <a href="#">{{ trans('core.help') }}</a>
                    </div>
                    <div class="col-xs-6 p-a-0">
                        <a href="#">{{ trans('core.privacy_policy') }}</a>
                        <a href="#">{{ trans('core.terms_of_service') }}</a>
                        <a href="#">{{ trans('core.legal') }}</a>
                        <a href="#">{{ trans('core.jobs') }}</a>
                    </div>
                </div>

            </div>

        </div>
        <div class="app-footer-build">
            {{ get_build_number() }}
        </div>

</footer>
