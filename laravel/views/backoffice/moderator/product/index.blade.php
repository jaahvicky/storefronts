@extends('backoffice/layout/default')

@section('content')

    <link href="{{ asset('/css/backoffice.css') }}" rel="stylesheet">
    @js('/js/backoffice/product/index.js')
    @js('/js/backoffice/product/category.js')
    <!-- @js('/js/backoffice/product/angular.min.js')
    @js('/js/backoffice/product/variant-angular.js')  -->
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
     
    
    {!! Form::open(['class' => 'form', 'role' => 'form', 'route' => 'admin.moderator.product.update', 'id' => 'productForm']) !!}
    
    @include('backoffice.moderator.product.category', [])
    <!-- @include('backoffice.moderator.product.variants', []) -->
    
    @include('backoffice.moderator.product.details', [])

    @include('backoffice.product.contact', [])

    @include('backoffice.moderator.product.gallery', [])
    
    @include('backoffice.moderator.product.visibility', [])    
    
    <div>
        <small>        
            By publishing a product, you agree and accept Ownai Storefronts

            <a href="#">Terms & Conditions</a>
        </small>
        <br/><br/>
    </div>
    <input type="hidden" name="product_status" id="product_status">
    
    {!! (isset($product)) ? Form::hidden('product_id', $product->id) : "" !!}
    <a class="btn btn-default btn-flat cancel_btn" href="{{URL::route('admin.moderator')}}">Cancel</a>
  
    
    {!! Form::submit('Save & Approve', ['class' => 'btn btn-primary btn-flat', 'id' => 'approveButton' ]) !!}
    
    {!! Form::submit('Save & Reject', ['class' => 'btn btn-primary btn-flat', 'id' => 'rejectButton']) !!}
    
   <!-- <button id="rejectButton" class="btn btn-primary btn-flat">Save & Reject</button> -->
    {!! Form::close() !!}
<script type="text/javascript">
(function() {
    'use strict';
    $('#approveButton').on('click', function(){
        $('#product_status').val(2);
    });
    
    $('#rejectButton').on('click', function(){
        $('#product_status').val(3);
    });
    
})();
</script>
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


