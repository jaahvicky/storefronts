<div class="btn-group" data-methys-filter='dropdown-toggle'>
    <button class="btn btn-default btn-label">Moderation status </button>
    <button data-toggle="dropdown" class="btn btn-primary dropdown-toggle">Any <span class="caret"></span></button>
    <ul class="dropdown-menu noclose">
        <li>
            <input type="radio"
                id="moderationTypeany" 
                name="moderationType[]" 
                value="any"
                {{ SortFilterHelper::isFilterArrayValueSet('moderationType', 'any', 'products') ? 'checked="checked"':'' }}
                >
            <label for="moderationTypeany">Any</label>
        </li>
        @foreach (LookupHelper::getProductModerationTypes() as $type)
        <li>
            <input type="radio"
                id="moderationType{{$type->name}}" 
                name="moderationType[]" 
                value="{{$type->name}}"
                {{ SortFilterHelper::isFilterArrayValueSet('moderationType', $type->name, 'products') ? 'checked="checked"':'' }}
                >
            <label for="moderationType{{$type->name}}">{{$type->name}}</label>
        </li>
        @endforeach
    </ul>
</div>