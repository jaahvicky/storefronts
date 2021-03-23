@if(count($other_products))

<div class="other-products-wrapper">

	<div class="title-header-wrapper">
		<h3>Other products from the same store</h3>
	</div>

	<div class="other-products">
        <ul class='product-list grid-view'>

            @foreach ($other_products as $other_product)
                <li class='product'>

                    <?php $cover_img_url = $other_product->getCoverImageUrl(); ?>

                    <div class="product-image">
                        @if($cover_img_url)
                        <a href="{{URL::route('product', ['slug' => $other_product->store->slug, 'productSlug' => $other_product->slug])}}">
                        <img src='{!! LookupHelper::Imagecover($other_product->getCoverImageUrl()) !!}'/>
                        </a>
                        @endif
                    </div>     
                    <div class='product-info'>
                        <a href="{{URL::route('product', ['slug' => $other_product->store->slug, 'productSlug' => $other_product->slug])}}" class='product-title'>
                        {{ (strlen($other_product->title) > 40) ? substr($other_product->title, 0, 40) . '&hellip;' : substr($other_product->title, 0, 40) }}
                        </a>
                        <div class='product-description'>
                            {{-- {{ ($other_product->category_custom_id) ? $other_product->categoryCustom->name : $other_product->category->name }} --}}
                            @if ($other_product->description)
                            	{{ substr($other_product->description, 0, 100) }}
                            	@if(strlen($other_product->description) > 100)
                            			{{ '&hellip;'  }}
                       			@endif
                            @else
                            	{{ 'No description' }}
                            @endif
                        </div>

                        <div class="product-bottom-wrapper">

                        <a href="{{URL::route('product', ['slug' => $other_product->store->slug, 'productSlug' => $other_product->slug])}}">
                        @if ($appearance)
                            <span class='product-price' style='color: {{ $appearance->secondary_colour  }}; '>${{ $other_product->price }}</span></a>
                        @else
                            <span class='product-price'>${{ $other_product->price/100 }}.00</span></a>
                        @endif

                        <?php $variant = $other_product->attributeVariantValue; ?>
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
                        
                    </div>
                </li>
            @endforeach

        </ul>
    </div>
</div>

@endif 