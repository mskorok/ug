<div class="container">

    @include('_partials.admin_flash')

    @if(isset($user))
        <div class="col-sm-7" id="interests"></div>
    @endif
    <div class="col-sm-7">
        <div class="hidden-xs-up p-x-3 p-y-1 m-b-2" id="create_interest_result"></div>
        <fieldset class="form-group">
            <input type="text" class="form-control" name="autocomplete" id="autocomplete">
            <button type="button" class="btn btn-success m-l-1  m-t-1" id="add_interest">Add interest</button>
        </fieldset>
    </div>
</div>
<?php
echo '<script>';
$userId = $user->id ?? 4;
echo 'var current_user = ' . $userId . ';';
echo 'var mode  = "edit";';
echo '</script>';
?>