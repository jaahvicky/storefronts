<div class="btn-group">
    <button class="btn btn-default btn-label">Bulk actions </button>
    <button data-toggle="dropdown" class="btn btn-primary dropdown-toggle">Actions <span class="caret"></span></button>
    <ul class="dropdown-menu noclose">
        @foreach ($statuses as $status)
        <li>
            <input type="radio" 
                id="bulk_action{{$status->name}}" 
                name="bulk_action[]" 
                value="{{$status->id}}"
                class="bulk_radio" 
                >
            <label for="bulk_action{{$status->name}}">{{(($status->id == 1)? 'Waiting moderation': $status->name)}}</label>
        </li>
        @endforeach
    </ul>
    
</div>
<div class="btn-group">
    <input type="hidden" name="selected_ids" id="selected_ids" value="[]">
    <input type="hidden" name="selected_action" id="selected_action">
    <a class="btn btn-primary" id='bulk_action_apply' href="#" data-modal='true'> Apply </a>
</div>
