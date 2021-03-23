<div class='categories-sidebar '>
    <div class="head-category-menu visible-xs">
        <h4 class="sort-heading">REFINE</h4>
        <small class="data-s-results">{{ $products->count() }} item(s)</small>
        <div class="sort-btn">
            <button type="button" class="btn btn-primary pull-right close-cat">Done</button>
        </div>
    </div>

        <?php 
            $active_cats = (isset($active_cats)) ? $active_cats : []; 
            $count_active_cats = count($active_cats);
            $tier = 1;
            if ($count_active_cats === 2) {
                $tier = 2;
            }
            if ($count_active_cats === 3) {
                $tier = 3;
            }

        ?>

    <ul>

        <li>

            <a href='{{URL::route('store', ['slug' => $store->slug])}}' class="sidebar-title">All Categories
                <span class='product-count'></span>
            </a>

        </li>

        <li class='primary dropdown open'>

            <ul class="dropdown-menu">

                @foreach ($categories as $t1)
                <li class="dropdown-submenu<?php if( (isset($home) && $home) || in_array($t1->slug, $active_cats) ) { echo ' open'; } ?>">
                    
                    <a href='{{ URL::route('store-category', ['slug' => $store->slug, 'categorySlug' => $t1->slug]) }}'  
                    class="category-item @if( (isset($home) && $home) || ($tier === 1 && in_array($t1->slug, $active_cats)) ) {{ 'bold' }} @endif  
                    "
                    >{{ $t1->name }}
                        <span class='product-count'></span>
                    </a>

                    <a href="#" 
                        data-toggle="dropdown" class="extend<?php if( (isset($home) && $home) || in_array($t1->slug, $active_cats)) { echo ' active-toggle'; } ?>">
                            &nbsp;
                    </a>
                     
                    <ul class="dropdown-menu">
                        @foreach ($t1->children as $t2)
                        <li class="dropdown-submenu sub-category<?php if( in_array($t2->slug, $active_cats)) { echo ' open'; } ?>">

                            <a href="{{ URL::route('store-category', ['slug' => $store->slug, 'categorySlug' => $t2->slug]) }}"
                            class="category-item @if(in_array($t2->slug, $active_cats)) {{ 'bold ' }} @endif 
                            @if(empty($t2->children)) {{ 'lower-tier' }} @endif">
                                {{ $t2->name }}
                                <span class='product-count'>{{ $t2->numProducts }}</span>
                            </a>

                            @if(!empty($t2->children))
                                <a href="#{{ $t2->id }}" 
                                tabindex="-1" data-toggle="dropdown" class="extend 
                                @if( in_array($t2->slug, $active_cats) ) {{ ' active-toggle' }} @endif
                                ">
                                    &nbsp;
                                </a>
                            @endif

                            <ul class="dropdown-menu tier-three">
                                @if(!empty($t2->children))
                                    @foreach ($t2->children as $t3)
                                        <li class="">

                                            <a href="{{ URL::route('store-category', ['slug' => $store->slug, 'categorySlug' => $t3->slug]) }}" 
                                            class="category-item @if($tier === 3 && in_array($t3->slug, $active_cats)) {{ 'bold' }} @endif" >
                                                {{ $t3->name }}
                                                <span class='product-count'>{{ $t3->numProducts }}</span></a>

                                        </li>
                                    @endforeach 
                                @endif
                            </ul>
                        </li>
                        @endforeach  
                    </ul>
                </li>
                @endforeach 
               
            </ul>
        </li>
     


        <!-- <li class='primary dropdown open'>
            <a href='#' data-toggle="dropdown">Price
                <b class="caret pull-right"></b>
            </a>
        </li>
        <li class="clear-filters">
            <a class="btn btn-default"  href="{{URL::route('store', ['slug'=>$store->slug])}}">Clear All</a>
        </li> -->

        <li class="want-a-store text-center">
            <a href="{{URL::route( 'content-page', [ 'storeslug' => $store->slug, 'pageslug' => 'open-a-store' ])}}">Want a Storefront?</a>
        </li>
    </ul>
</div>

@css('plugins/bootstrap-dropdowns-enhancement/v3.1.1/dropdowns-enhancement.css')
@js('plugins/bootstrap-dropdowns-enhancement/v3.1.1/dropdowns-enhancement.js')
@js('plugins/store-front/storefront.js')