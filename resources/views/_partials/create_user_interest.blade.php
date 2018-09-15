<div class="container">
    <div id="interests_hidden_block"></div>
    <div class="col-sm-7" id="interests_for_creation"></div>
    <div class="col-sm-7 m-t-3 m-y-2">
        <div class="hidden-xs-up p-x-3 p-y-1 m-b-2" id="create_interest_result"></div>
            <fieldset class="form-group">
                <input type="text" class="form-control" name="autocomplete" id="autocomplete">
                <button type="button" class="btn btn-success m-l-1 m-t-1" id="first_user_interest">Create interest</button>
            </fieldset>
    </div>

    <div class="col-sm-7" id="interests-add"></div>
    <div class="col-sm-7">
        <button id="load_more_interest" class="btn btn-warning m-b-2">Load more interest</button>
    </div>

</div>
<script>
    var current_user = null;
    var mode = 'create';
</script>