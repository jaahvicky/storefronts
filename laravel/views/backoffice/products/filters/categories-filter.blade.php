
<div class="btn-group" data-methys-filter='dropdown-toggle' data-methys-cat="container" 
    data-methys-cat-url="{{URL::route('category_pull')}}">

    <button class="btn btn-default btn-label" data-methys-ses="container" 
    data-methys-session-url="{{URL::route('get_session')}}">Main Category </button>
    <button data-toggle="dropdown" class="btn btn-primary dropdown-toggle">Any <span class="caret"></span></button>

    <ul class="dropdown-menu main-cat">
                <li >
                    <input type="radio" 
                        id="productCategoryany"
                        class='main_cat_selected'  
                        name="productCategory[]" 
                        value="all"
                        {{ SortFilterHelper::isFilterArrayValueSet('productCategory','all', 'products') ? 'checked="checked"':'' }}
                        >
                    <label for="productCategoryany">Any</label>
                </li>
                @foreach(LookupHelper::getCategories() As $id => $fields)
                
                <li>
                    <input type="radio" 
                        id="productCategory{{$fields['record']->name}}" 
                        class='main_cat_selected'
                        name="productCategory[]" 
                        value="{{$fields['record']->slug}}"
                        {{ SortFilterHelper::isFilterArrayValueSet('productCategory', $fields['record']->slug, 'products') ? 'checked="checked"':'' }}
                        >
                    <label for="productCategory{{$fields['record']->name}}">{{$fields['record']->name}}</label>
                </li><!-- /.second level-->
                @endforeach
                
    </ul>
   
</div>




