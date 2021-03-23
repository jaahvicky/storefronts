
<div class="modal fade" id="product-img-modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" data-backdrop="static">

	<div class="modal-dialog" role="document">
		<div class="modal-content">
			
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				<h4 class="modal-title" id="myModalLabel">&nbsp;</h4>
			</div>
			<div class="modal-body">
	                    
	                 
			
			</div>
			<div class="modal-footer">
				
			</div>

		</div>

		<div class="current-img">	
			{{-- <img src="http://econet-storefronts-website.henkr.56.dev/storage/product_sample_01-740-555.jpg" alt="" /> --}}

			<div id="carousel-product-images" class="carousel slide" data-ride="carousel" data-interval="false">
				
				<div class="carousel-inner" role="listbox">
					
					{{-- <div class="item active">
						<img src="http://econet-storefronts-website.henkr.56.dev/storage/product_sample_01-740-555.jpg" alt="" />
					</div>
					<div class="item">
						<img src='{{ asset('images/samples/no-photo-available.png') }}'/>
					</div> --}}

					@if(count($product->images) <= 0)
						<div class="item active"><img src='{{ asset('images/samples/no-photo-available.png') }}'/></div>
					@endif

					@foreach($product->images as $image)
						
						<?php 
							$url = \Storage::url($image->filename); 
						?>

						@if( $url === FALSE)
							<div class="item"><img src='{{ asset('images/samples/no-photo-available.png') }}'/></li>
						@else
							<div data-img="{{ asset($url) }}" class="item"><img src='{{ asset($url) }}'/></div>
						@endif

					@endforeach

				</div>

				<!-- Controls -->
				<a class="left carousel-control" href="#carousel-product-images" role="button" data-slide="prev">
					<span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span>
					<span class="sr-only">Previous</span>
				</a>
				<a class="right carousel-control" href="#carousel-product-images" role="button" data-slide="next">
					<span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span>
					<span class="sr-only">Next</span>
				</a>

			</div>


			

    	</div>
	</div>

	<!-- layer to come over th above one -->
	

</div>
