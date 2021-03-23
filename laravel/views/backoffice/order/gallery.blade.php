<div class='box box-primary'>
    
    <div class='box-header with-border'>
        <div class='stepper-container'>
            <span class="stepper-circle left">3</span>
            <div class='stepper-header'>
                <h3 class='box-title'>Product Gallery</h3>
                <p>Add product photos to show different angles and details. Accepted formats are .jpg, .gif and .png. Max allowed size for uploaded files is 5 MB. Drag images to change their display order.</p>
            </div>
        </div>
    </div>
    
    <div class='box-body'>
        
        <?php
            $featured = 0;
            if (isset($product) && isset($product->images)) {
                $imgs = $product->images->all();
                $cnt = 0;
                foreach($imgs As $i => $img) {
                                        
                    if ($img->featured === "1") {
                        $featured = $cnt;
                    }
                    $cnt++;
                } 
            }
        ?>
        
        <?php for ($i=0; $i<5; $i++): ?>
        
            <div class="form-group">
                
                <label for="featured">Featured</label>
                {!! Form::radio('featured', $i,  ($i == $featured) ? true : false, []) !!}    

            </div>
            <div class="form-group fc-fileupload {{(isset($images) && isset($images[$i]) && !empty($images[$i])) ? 'has-image' : ''}} clearfix">
                
                <input type='hidden' name='images-{!!$i!!}' data-mfu-value='filename' value='{{  (isset($images) && isset($images[$i]) && !empty($images[$i])) ? $images[$i] : '' }}'/>
                <div>
                    <div class='fc-fileupload-image fc-fileupload-image-{!!$i!!}' 
                        style='background-image: url({{  (isset($images) && isset($images[$i]) && !empty($images[$i])) ? asset(\Storage::url($images[$i])) : asset('images/samples/image-holder.jpg') }});'
                        data-mfu-source='images-{!!$i!!}' 
                        data-mfu-imagebackground='fullUrl'
                        data-mfu-trigger='images-{!!$i!!}'
                        >	
                        <div class='fc-fileupload-image-overlay'></div>
                    </div>
                    <input type='file' name='images-{!!$i!!}' value=''
                        data-mfu='true'
                        data-mfu-token='{{csrf_token()}}' 
                        data-mfu-route='{{URL::route('admin.image-upload')}}'
                        data-mfu-resize='{{\Config::get('storefronts-backoffice.image-banner-width')}},0'
                        />
                </div>
                <div>
                    <a href='#' class='fc-fileupload-remove' data-mfu-remove='{{asset('images/samples/image-holder.jpg')}}'>Remove Image</a>
                </div>

            </div>
        
        <?php endfor; ?>
        
    </div>
    
</div>