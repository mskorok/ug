@extends('_layouts.admin')

@section('header')
    <a href="{{url('/admin')}}">Admin dashboard</a> >
    <a  href="{{url('/admin/adventures')}}">Adventures</a> > {{ $adventure->id ?? 'Create new adventure' }}
@stop

@section('content')
    <div class="container">
        <link type="text/css" rel="stylesheet" href="https://fonts.googleapis.com/css?family=Roboto:300,400,500" property='stylesheet'>
        <script src="https://maps.googleapis.com/maps/api/js?v=3.exp&libraries=places"></script>
        @include('_partials.admin_flash')
        <form id="add_edit_activities_form" role="form" method="POST"
              action="{{ url('/admin/adventures/'. (($action == 'create') ? $action : 'edit'  ).'/' .($adventure->id ?? '')) }}"
              enctype="multipart/form-data">
            {!! csrf_field() !!}
            <ul id="adventures_tablist" class="nav nav-tabs" role="tablist">
                <li class="nav-item">
                    <a class="nav-link active" data-toggle="tab" href="#step1" role="tab">Step 1</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" data-toggle="tab" href="#step2" role="tab">Step 2</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" data-toggle="tab" href="#step3" role="tab">Step 3</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" data-toggle="tab" href="#step4" role="tab">Step 4</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" data-toggle="tab" href="#User" role="tab">User</a>
                </li>
            </ul>

            <div id="add_edit_adventure_tab_content" class="tab-content">
                <div class="tab-pane fade active in" id="step1" role="tabpanel">
                    @include('_partials.bs4.input', [
                        'input' => 'title',
                        'value' => $adventure->title,
                        'label' => 'Title of adventure',
                        'required' => 1
                    ])
                    <input type="hidden" id="location_lat"    name="lat" value="{{ $adventure->location['lat'] }}">
                    <input type="hidden" id="location_lng"    name="lng" value="{{ $adventure->location['lng'] }}">
                    <input type="hidden" id="place_location"  name="place_location" value="{{ $adventure->place_location }}">
                    <input type="hidden" id="place_id"        name="place_id" value="{{ $adventure->place_id }}">
                    <div class="m-l-1">
                        <strong>Country:</strong> <div id="country_name" class="figure">{{ $adventure->getCountryName() ?? '' }}</div>
                    </div>

                    @include('_partials.bs4.input', [
                        'input'    => 'place_name',
                        'value'    => $adventure->place_name,
                        'label'    => 'Location',
                        'required' => 1
                    ])
                    @include('_partials.bs4.input', [
                        'input' => 'datetime_from',
                        'type'  => 'date',
                        'value' => date('Y-m-d', strtotime($adventure->datetime_from)),
                        'label' => 'Period from '.date('d-m-Y', strtotime($adventure->datetime_from)),
                        'required' => 1
                    ])
                    @include('_partials.bs4.input', [
                       'input' => 'datetime_to',
                       'type'  => 'date',
                       'value' => date('Y-m-d', strtotime($adventure->datetime_to)),
                       'label' => 'Period to '.date('d-m-Y', strtotime($adventure->datetime_to)),
                       'required' => 1
                   ])
                    @include('_partials.bs4.img_upload', [
                        'input' => 'promo_image',
                        'value' => $adventure->promo_image,
                        'label' => 'Promo image'
                    ])
                    @include('_partials.bs4.textarea', [
                        'input'        => 'short_description',
                        'value'        => $adventure->short_description,
                        'label'        => 'Short description',
                        'maxlength'    => 255,
                        'required'     => 1
                    ])
                </div>


                <div class="tab-pane fade" id="step2" role="tabpanel">
                    @include('_partials.bs4.textarea', [
                         'input' => 'description',
                         'value' => $adventure->description,
                         'label' => 'Description',
                         'rows'         => 7,
                    ])
                </div>

                <div class="tab-pane fade" id="step3" role="tabpanel">
                    @include('_partials.bs4.radio', [
                            'input' => 'is_private',
                            'label' => 'Privacy',
                            'data'  => [
                                [
                                    'value' => 0,
                                    'label' => 'Public',
                                    'checked' => $adventure->is_private
                                ],
                                [
                                    'value'   => 1,
                                    'label'   => 'Private',
                                    'checked' => !$adventure->is_private
                                ],
                            ],
                            'required' => 1
                     ])
                    @include('_partials.bs4.radio', [
                        'input' => 'is_published',
                        'label' => 'Published',
                        'data'  => [
                            [
                                'value' => 1,
                                'label' => 'Published',
                                'checked' => $adventure->is_published
                            ],
                            [
                                'value' => 0,
                                'label' => 'Unpublished',
                                'checked' => !$adventure->is_published
                            ]
                        ],
                        'required' => 1
                    ])
                </div>

                <div class="tab-pane fade" id="step4" role="tabpanel">
                    -
                </div>
                <div class="tab-pane fade" id="User" role="tabpanel">
                    <fieldset class="form-group">
                        <label class="col-form-label"  for="autocomplete">User</label>
                        <input type="text" class="form-control"  name="autocomplete"  id="user_autocomplete" value="{{ $selectData[$adventure->user->id ?? ($user->id ?? 1)] }}">
                    </fieldset>
                    <br>
                    <input type="hidden" id="user_id"    name="user_id" value="{{ $selectData[$adventure->user->id ?? ($user->id ?? 1)] }}">
                    <div class=" m-b-3">
                        <strong>About :&nbsp;</strong>
                        <span id="user_about">{{ $adventure->user->about ?? ($user->user->about ?? '') }}</span>
                    </div>

                    <img id="user_image" src="{{ $adventure->user->photo_path ?? ($user->user->photo_path ?? '') }}"
                         class="col-md-4 m-b-1 center-block ">
                    <div class="clearfix"></div>

                    <div class=" m-b-3">
                        <strong>User email :&nbsp;</strong>
                        <span id="user_email">{{ $adventure->user->email ?? ($user->email ?? '') }}</span>
                    </div>
                    <div class=" m-b-3">
                        <strong>Birth date : &nbsp;</strong>
                        <span id="user_birth">{{ $adventure->user->birth_date ?? ($user->birth_date ?? '')  }}</span>
                    </div>
                </div>
            </div>
            <button type="submit" class="btn btn-primary">
                @if ($action === 'create')
                    Create new adventure
                @elseif ($action === 'edit')
                    Edit adventure
                @endif
            </button>
        </form>
    </div>

@stop