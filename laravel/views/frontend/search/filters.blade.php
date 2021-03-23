<!-- desktop filters -->

<section class="filters hidden-xs">
    <div class="row ">
        <div class="col-xs-5 ">
            <p class="results">{{ $products->count() }} item(s) in <span class="location">
                <!-- category listing or search results -->
                @if($category)
                    {{ $category->name }} 
                @else
                    All Categories
                @endif
            </span></p>
        </div>
        <div class="col-xs-7 clearfix">
            <div class="btn-group view-type pull-right hidden-xs" role="view type">
                <button class="btn btn-default active" data-label-placement="" id="grid"><i class="fa fa-th-large  data-label"></i></button>
                <button class="btn btn-default" data-label-placement="" id="list"><i class="fa fa-list data-label"></i></button>
            </div>
            <div class="dropdown sort-results pull-right">
                <button class="btn btn-default dropdown-toggle" type="button" id="dropdownMenu1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
                    {{ $order }}
                    <span class="caret"></span>
                </button>

                <!-- echo '?c=' . $t3->name; -->
 
                <ul class="dropdown-menu" aria-labelledby="dropdownMenu1">
                    <li><a href="{{URL::route('store-search', ['slug'=>$store->slug, 'sortby'=>'newest'])}}&{{ $term_parameter }}{{ $cat_parameter }}" data-url="{{URL::route('store', ['slug'=>$store->slug, 'sortby'=>'newest'])}}" >Newest</a></li>
                    <li><a href="{{URL::route('store-search', ['slug'=>$store->slug, 'sortby'=>'highest'])}}&{{ $term_parameter }}{{ $cat_parameter }}" >Highest to lowest price</a></li>
                    <li><a href="{{URL::route('store-search', ['slug'=>$store->slug, 'sortby'=>'lowest'])}}&{{ $term_parameter }}{{ $cat_parameter }}" >Lowest to highest price</a></li>
                </ul>
            </div>
        </div>
    </div>    
</section>
<!-- mobile filters-->
<section class="mobile-filters visible-xs">
    <div class="results"><p>{{ $products->count() }} item(s) in <span class="location">
        <!-- category listing or search results -->
        @if($category)
            {{ $category->name }} 
        @else
            All Categories
        @endif
    </span></p></div>
    <div class="filter-select clearfix">
            <a href="#" class="categories">Categories</a>
            <a href="#" class="sort">Sort</a>
    </div>
</section>