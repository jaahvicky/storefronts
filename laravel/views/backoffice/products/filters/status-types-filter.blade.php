<div class="btn-group" data-methys-filter='dropdown-toggle'>
    <button class="btn btn-default btn-label">Visibility </button>
    <button data-toggle="dropdown" class="btn btn-primary dropdown-toggle">Any <span class="caret"></span></button>
    <ul class="dropdown-menu noclose">
         <li>
            <input type="radio" 
                id="productStatusTypeAny" 
                name="productStatus[]" 
                value="any"
                {{ SortFilterHelper::isFilterArrayValueSet('productStatus', 'any', 'products') ? 'checked="checked"':'' }}
                >
            <label for="productStatusTypeAny">Any</label>
        </li>
        @foreach (LookupHelper::getProductStatusTypes() as $type)
        <li>
            <input type="radio" 
                id="productStatusType{{$type->name}}" 
                name="productStatus[]" 
                value="{{$type->name}}"
                {{ SortFilterHelper::isFilterArrayValueSet('productStatus', $type->name, 'products') ? 'checked="checked"':'' }}
                >
            <label for="productStatusType{{$type->name}}">{{$type->name}}</label>
        </li>
        @endforeach
    </ul>
</div>
