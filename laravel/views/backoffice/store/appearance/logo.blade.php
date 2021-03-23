<div class='box box-primary'>
    
    <div class='box-header with-border'>
        <h3 class='box-title'>Logo</h3>
        <p>Must be a .jpg, .gif or .png file and at least {{ \Config::get('storefronts-backoffice.image-logo-width') }}px x {{ \Config::get('storefronts-backoffice.image-logo-height') }}px in size.</p>
    </div>

    <?php

        $logo_img   = asset('images/store/store.png');
        $has_logo_image  = false;

        if(isset($store) && isset($store->appearance) && !empty($store->appearance->logo_image)) {

            $logo_img = asset($store->appearance->logo_image);
            $has_logo_image = true;

        }

    ?>
    
    <div class='box-body'>
        <div class="form-group fc-fileupload {{($has_logo_image) ? 'has-image' : ''}} clearfix">
            <label>Logo 
                    <small> (advised size: 
                    <span id='advised-size'>{{ \Config::get('storefronts-backoffice.image-logo-width') }}px x {{ \Config::get('storefronts-backoffice.image-logo-height') }}px</span>) 
                    </small>
            </label>

            <p><strong>NOTE</strong> : Hover and click on the default image to upload a new one.</p>

            <input type='hidden' name='logo-image' data-mfu-value='url' value='{{(isset($store) && isset($store->appearance)) ? $store->appearance->logo_image : ''}}'/>
            <div>
                    <div class='fc-fileupload-image fc-fileupload-image-logo' 
                             style='background-image: url({{  $logo_img }});'  
                             data-mfu-source='logo-image' 
                             data-mfu-imagebackground='fullUrl' 
                             data-mfu-trigger='logo-image'
                             >		
                        <div class='fc-fileupload-image-overlay'></div>
                    </div>
                    <input type='file' name='logo-image' value='' 
                               data-mfu='true' 
                               data-mfu-token='{{csrf_token()}}' 
                               data-mfu-route='{{URL::route('admin.image-upload')}}'
                               data-mfu-resize='{{\Config::get('storefronts-backoffice.image-logo-width')}},0'
                               />
            </div>
                <div>
                    <a href='#' class='fc-fileupload-remove' data-mfu-remove='{{asset('images/store/store.png')}}'>Remove Image</a>
                </div>
         
            <div class='help-block'>

            </div>
        </div>
    </div>
        
</div>
    







