
<div class="btn-group sub-cat" data-methys-filter='dropdown-toggle' >

    <button class="btn btn-default btn-label">Sub Category </button>
    <button data-toggle="dropdown" class="btn btn-primary dropdown-toggle">Any <span class="caret"></span></button>
    <ul class="dropdown-menu sub_cat_list">
        @for ($i = 0; $i < 50; $i++)
        <li>
            <input type="radio" 
                    id="subCategory{{ $i }}"
                    class='subCategory_tab'  
                    name="subCategory[]" 
                    value="{{ $i }}">
            <label ></label>
        </li> 
        @endfor  
            
    </ul>
</div>