<section class='search-results'>
    <div class='search-header'>

    </div>
    <div class='search-contents'>
        @if(count($products))
        <ul class='product-list grid-view'>

            <!-- desktop view-->
            @foreach ($products as $product)

                <?php $cover_img_url = $product->getCoverImageUrl(); ?>

                <li class='product'>
                    <div class="product-image">
                        @if ($cover_img_url)

                        <a href="{{URL::route('product', ['slug' => $product->store->slug, 'productSlug' => $product->slug])}}" >
                            <img class='thumbnail-small' src='{!! LookupHelper::Imagecover($product->getCoverImageUrl()) !!}' />         
                        </a>

                        @endif  
                    </div>     
                    <div class='product-info'>
                        <a href="{{URL::route('product', ['slug' => $product->store->slug, 'productSlug' => $product->slug])}}" class='product-title'>
                        {{ (strlen($product->title) > 40) ? substr($product->title, 0, 40) . '&hellip;' : substr($product->title, 0, 40) }}
                        </a>
                        <div class='product-category'>
                            {{ ($product->category_custom_id) ? $product->categoryCustom->name : $product->category->name }}
                        </div>
                        <a href="{{URL::route('product', ['slug' => $product->store->slug, 'productSlug' => $product->slug])}}">
                        @if ($appearance)
                            <span class='product-price' style='color: {{ $appearance->secondary_colour  }}; '>${{ $product->price/100 }}</span></a>
                        @else
                            <span class='product-price'>${{ $product->price/100 }}</span></a>
                        @endif

                        <?php $variant = $product->attributeVariantValue; ?>
                        @if(count($variant))

                            <?php $variant_data = json_decode($variant->data); ?>

                            @if(array_key_exists('data_values', $variant_data))

                                <?php $out_stock = 1; ?>
                                @foreach ($variant_data->data_values as $value)
                                    @if($value->options[0]->options->available == 1)
                                        <?php $out_stock = 0; break; ?>
                                    @endif
                                @endforeach

                                @if($out_stock)
                                    <span class="text-danger">Out Of Stock</span>
                                @endif

                            @endif

                        @endif
                        
                    </div>
                </li>
            @endforeach   
        </ul>
        <div class="product-pagenating">{{ $products->render() }}</div>
        @else
            <p class="no-product">No results found </p>
        @endif  
    </div>
</section>
<?php //dd(URL::route("product", ['slug' => $product->store->slug, "productSlug" => $product->slug])) ?>
<!-- mobile sort -->
<div class="sort-div-fade"></div>
<div class="sort-menu visible-xs">
    <div class="head-sort">
        <h4 class="sort-heading">Sort</h4>
        <div class="sort-btn">
            <button type="button" class="btn btn-primary pull-right close-sort">Done</button>
        </div>
    </div>
    <div class="sort_line"></div>
    <div class="sort-check-btns checkbox">
            <input type="hidden" name="" value="{{ $order }}">
          <label><input type="checkbox" value="" data-url="{{URL::route('store', ['slug'=>$store->slug, 'sortby'=>'newest'])}}">Newest</label>
    </div>
    <div class="sort-check-btns checkbox">
        <label><input type="checkbox" value="" data-url="{{URL::route('store', ['slug'=>$store->slug, 'sortby'=>'highest'])}}">Highest to lowest price</label>
    </div>
    <div class="sort-check-btns checkbox ">
        <label><input type="checkbox" data-url="{{URL::route('store', ['slug'=>$store->slug, 'sortby'=>'lowest'])}}">Lowest to highest price</label>
    </div>
</div>  

