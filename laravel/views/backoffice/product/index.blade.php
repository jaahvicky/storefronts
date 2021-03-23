@extends('backoffice/layout/default')

@section('content')

    <link href="{{ asset('/css/backoffice.css') }}" rel="stylesheet">
    @js('/js/backoffice/product/index.js')
    @js('/js/backoffice/product/category.js')
    @js('/js/backoffice/product/angular.min.js')
    @js('/js/backoffice/product/bootstrap-tagsinput.js')
    @js('/js/backoffice/product/typehead.js')
    
    @js('/js/backoffice/product/details.js')
    @js('/js/backoffice/product/gallery.js')
    @js('/js/backoffice/product/visibility.js')
     
    @css('plugins/jquery-ui-1.11.4.custom/jquery-ui.min.css')
    @css('plugins/jquery-ui-smoothness/jquery-ui.css')
    @css('plugins/methys-fileupload/methys-fileupload.css')
    @css('/css/bootstrap-tagsinput.css')
    @js('plugins/jquery-ui-1.11.4.custom/jquery-ui.min.js')
    @js('plugins/methys-fileupload/jquery.iframe-transport.js')
    @js('plugins/methys-fileupload/jquery.fileupload.js')
    @js('plugins/methys-fileupload/methys-fileupload.js')
<!-- @js('/js/backoffice/product/variant-angular.js')       -->
    
    {!! Form::open(['class' => 'form', 'role' => 'form', 'route' => 'admin.product.update', 'id' => 'productForm']) !!}
    
    @include('backoffice.product.category', [])
    <!-- @include('backoffice.product.variants', []) -->
    
    @include('backoffice.product.details', [])

    @include('backoffice.product.contact', [])

    @include('backoffice.product.gallery', [])
    
    @include('backoffice.product.visibility', [])    
    
    <div>
        <small>        
            By publishing a product, you agree and accept Ownai Storefronts

            <a href="#">Terms &amp; Conditions</a>
        </small>
        <br/><br/>
    </div>
    
    {!! (isset($product)) ? Form::hidden('product_id', $product->id) : "" !!}

    {!! Form::button('Cancel', ['class' => 'btn btn-inverse btn-flat', 'onclick' => 'location.reload()']) !!}
    {!! Form::submit('Save & Submit for Moderation', ['class' => 'btn btn-primary btn-flat', 'id' => 'saveButton', 'disabled' => 'true']) !!}
    
    {!! Form::close() !!}
    <!-- do not move the code below -->
    <script type="text/javascript">
        function onchangeMake(value) {
            $("#model_cat_attr").html('');
            $.each(attributes_child, function(i, val){
                if(value == val.parent_value){
                    var option = $("<option>").attr('value', val.value).text(val.value);
                    $("#model_cat_attr").append(option); 
                }
            });
        }
    </script>
    
@stop

