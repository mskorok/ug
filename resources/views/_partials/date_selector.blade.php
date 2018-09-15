
<div id="{{ $id }}" class="row">
    <label for="birth_day" class="col-sm-3 col-form-label text-sm-right">Birth date</label>

    <div class="col-sm-3">
        <div class="form-group form-group-select-arrow">
            <select class="app-day-input form-control" placeholder="Day" required>
                @for ($i = 1; $i <= 31; $i++)
                    <option @if(intval(date('d', strtotime($user->birth_date))) == $i) selected @endif>{{ $i }}</option>
                @endfor
            </select>
        </div>
    </div>

    <div class="col-sm-3">
        <div class="form-group form-group-select-arrow">
            <select class="app-month-input form-control"placeholder="Month" required>
                <option value="1" @if(intval(date('m', strtotime($user->birth_date))) == 1) selected @endif>{{ trans('January') }}</option>
                <option value="2" @if(intval(date('m', strtotime($user->birth_date))) == 2) selected @endif>{{ trans('February') }}</option>
                <option value="3" @if(intval(date('m', strtotime($user->birth_date))) == 3) selected @endif>{{ trans('March') }}</option>
                <option value="4" @if(intval(date('m', strtotime($user->birth_date))) == 4) selected @endif>{{ trans('April') }}</option>
                <option value="5" @if(intval(date('m', strtotime($user->birth_date))) == 5) selected @endif>{{ trans('May') }}</option>
                <option value="6" @if(intval(date('m', strtotime($user->birth_date))) == 6) selected @endif>{{ trans('June') }}</option>
                <option value="7" @if(intval(date('m', strtotime($user->birth_date))) == 7) selected @endif>{{ trans('July') }}</option>
                <option value="8" @if(intval(date('m', strtotime($user->birth_date))) == 8) selected @endif>{{ trans('August') }}</option>
                <option value="9" @if(intval(date('m', strtotime($user->birth_date))) == 9) selected @endif>{{ trans('September') }}</option>
                <option value="10" @if(intval(date('m', strtotime($user->birth_date))) == 10) selected @endif>{{ trans('October') }}</option>
                <option value="11" @if(intval(date('m', strtotime($user->birth_date))) == 11) selected @endif>{{ trans('November') }}</option>
                <option value="12" @if(intval(date('m', strtotime($user->birth_date))) == 12) selected @endif>{{ trans('December') }}</option>
            </select>
        </div>
    </div>

    <div class="col-sm-3">
        <div class="form-group form-group-select-arrow">
            <select class="form-control app-year-input" placeholder="Year" required>
                @for ($i = 1950; $i <= date("Y"); $i++)
                    <option value="{{$i}}" @if(intval(date('Y', strtotime($user->birth_date))) == $i) selected @endif>{{$i}}</option>
                @endfor
            </select>
        </div>
    </div>
    <input class="app-date-input" name="birth_date" type="hidden" value="{{ $date }}">
</div>
