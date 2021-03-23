<div class='box box-primary'>
    
    <div class='box-header with-border'>
        <h3 class='box-title'>Store Banner</h3>
        <p>The banner displayed on the store landing page. Must be a .jpg, .gif or .png and at least {{ \Config::get('storefronts-backoffice.image-banner-width') }}px x {{ \Config::get('storefronts-backoffice.image-banner-height')}}px in size.</p>
    </div>

    <?php

        $banner_img   = asset('images/store/default_banner.png');
        $has_banner_image  = false;

        if(isset($store) && isset($store->appearance) && !empty($store->appearance->banner_image)) {

            $banner_img = asset($store->appearance->banner_image);
            $has_banner_image = true;

        }

    ?>
    
    <div class='box-body'>
        <div class="form-group fc-fileupload {{($has_banner_image) ? 'has-image' : ''}} clearfix">
            <label>Banner 
                    <small> (advised size: 
                    <span id='advised-size'>{{ \Config::get('storefronts-backoffice.image-banner-width') }}px x {{ \Config::get('storefronts-backoffice.image-banner-height')}}px</span>) 
                    </small>
            </label>

            <p><strong>NOTE</strong> : Hover and click on the default image to upload a new one.</p>

            <input type='hidden' name='banner-image' data-mfu-value='url' value='{{  ($has_banner_image) ? asset($store->appearance->banner_image) : '' }}'/>
            <div>
                    <div class='fc-fileupload-image fc-fileupload-image-banner' 
                             style='background-image: url({{  $banner_img }});'  
                             data-mfu-source='banner-image' 
                             data-mfu-imagebackground='fullUrl' 
                             data-mfu-trigger='banner-image'
                             >	
                        <div class='fc-fileupload-image-overlay'></div>
                    </div>
                    <input type='file' name='banner-image' value='' 
                               data-mfu='true' 
                               data-mfu-token='{{csrf_token()}}' 
                               data-mfu-route='{{URL::route('admin.image-upload')}}'
                               data-mfu-resize='{{\Config::get('storefronts-backoffice.image-banner-width')}},0'
                               />
            </div>
            <div>
                <a href='#' class='fc-fileupload-remove' data-mfu-remove='{{asset('images/store/default_banner.png')}}'>Remove Image</a>
            </div>
            <div class='help-block'>

            </div>
        </div>
    </div>
        
</div>
    







