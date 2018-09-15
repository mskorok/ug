@extends('_layouts.admin')

@section('header')
    <a href="{{url('/admin')}}">Admin dashboard</a> > <a href="{{url('/admin/users')}}">Users</a> > {{ $user->id ?? 'Create new user' }}
@stop

@section('content')
    <div class="container">

            <form id="add_edit_user_form" role="form" method="POST" action="{{ url('/admin/users/' . $user->id . (($action === 'add') ? 'add' : '') ) }}" enctype="multipart/form-data">
                {!! csrf_field() !!}

                <ul id="users_tablist" class="nav nav-tabs" role="tablist">
                    <li class="nav-item">
                        <a class="nav-link active" data-toggle="tab" href="#info" role="tab">Personal information</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" data-toggle="tab" href="#profile" role="tab">Profile settings</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" data-toggle="tab" href="#notifications" role="tab">Notifications</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" data-toggle="tab" href="#settings" role="tab">E-mail and password</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" data-toggle="tab" href="#interests_tab" role="tab">Interests</a>
                    </li>
                </ul>

                <div id="add_edit_user_tab_content" class="tab-content" data-user="{{  $user->id ?? 0 }}">
                    <div class="tab-pane fade active in" id="info" role="tabpanel">
                        @include('_partials.bs4.input', [
                            'input' => 'name',
                            'value' => $user->getName(),
                            'label' => 'First name',
                            'required' => 1
                        ])
                        @include('_partials.bs4.img_upload', [
                            'input' => 'photo_path',
                            'value' => $user->photo_path,
                            'label' => 'Profile photo'
                        ])
                        @include('_partials.bs4.select', [
                            'input' => 'gender_sid',
                            'data' => ['1' => 'Male', '2' => 'Female'],
                            'selected' => $user->gender_sid,
                            'label' => 'Gender'
                        ])
                        @include('_partials.bs4.input', [
                            'input' => 'birth_date',
                            'value' => $user->birth_date,
                            'label' => 'Birth date',
                            'type' => 'date',
                            'required' => 1
                        ])
                    </div>


                    <div class="tab-pane fade" id="profile" role="tabpanel">

                        {{ 'Activated at: ' . $user->activated_at ?? '' }}

                        @include('_partials.bs4.checkbox', [
                            'input' => 'activated_at',
                            'type' => 'checkbox',
                            'value' => "true",
                            'label' => 'Active',
                            'checked' => $user->activated_at ?? ''
                        ])

                        @include('_partials.multi_select_list',
                            [
                                'input' => 'categories_bit',
                                'class' => 'btn btn-info m-r-1 m-b-1',
                                'label' => 'Categories',
                                'data' => $categories
                            ]
                        )

                        {{--@include('_partials.bs4.input', [
                            'input' => 'adventurer_title',
                            'value' => $user->adventurer_title,
                            'label' => 'Adventurer title',
                        ])--}}
                        @include('_partials.bs4.select', [
                            'input' => 'profile_locale',
                            'data' => ['en' => 'English', 'de' => 'German'],
                            'selected' => $user->profile_locale,
                            'label' => 'Profile locale'
                        ])
                        @include('_partials.bs4.textarea', [
                            'input' => 'app.static.about',
                            'value' => $user->about,
                            'label' => 'app.static.about',
                            'maxlength' => 140
                        ])
                    </div>

                    <div class="tab-pane fade" id="notifications" role="tabpanel">
                        -
                    </div>

                    <div class="tab-pane fade" id="settings" role="tabpanel">
                        @include('_partials.bs4.input', [
                            'input' => 'email',
                            'value' => $user->email,
                            'label' => 'E-mail',
                            'type' => 'email',
                            'required' => 1
                        ])
                        @if ($action === 'add')
                            @include('_partials.bs4.input', [
                                'input' => 'password',
                                'label' => 'Password',
                                'type' => 'password',
                                'minlength' => 8,
                                'required' => 1
                            ])
                        @else
                            @include('_partials.bs4.input', [
                                'input' => 'password',
                                'label' => 'Password',
                                'type' => 'password',
                                'minlength' => 8
                            ])
                        @endif
                    </div>
                    <div class="tab-pane fade" id="interests_tab" role="tabpanel">
                        @if ($action === 'add')
                            @include('_partials.create_user_interest')
                        @elseif ($action === 'edit')
                            @include('_partials.edit_user_interests', [
                            'user' => $user
                        ])
                        @endif
                    </div>
                </div>

                <button type="submit" class="btn btn-primary">
                    @if ($action === 'add')
                        Create new user
                    @elseif ($action === 'edit')
                        Edit user
                    @endif
                </button>
            </form>
    </div>
@stop
