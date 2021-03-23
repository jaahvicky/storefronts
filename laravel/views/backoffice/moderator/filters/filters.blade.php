<div class='row row-vertical-margin row-filters' data-methys-filter="container" 
    data-methys-filter-url="{{URL::route('ajax-filters-queue', ['tag'=>'products'])}}">
    <!-- search customer -->
    <div class='col-xs-12'>
        <div class='form-inline'>

            Filter by
            
            @include('backoffice.moderator.filters.categories-filter')
             @include('backoffice.moderator.filters.categoriessub-filter')

            
            @include('backoffice.moderator.filters.product-moderation-types-filter')

        </div>
        <div class='form-inline' style="margin:20px 0">
            @include('backoffice.moderator.filters.status-types-filter')
        </div>
    </div>
</div>

@js('plugins/methys-javascript/methys.filters.js')
@js('plugins/methys-javascript/methys.filters.products.js')
@js('plugins/bootstrap-dropdowns-enhancement/v3.1.1-beta/dropdowns-enhancement.js')
@js('/js/backoffice/products/filters.js')
@js('/js/backoffice/product/bulk_action.js')

@css('plugins/bootstrap-dropdowns-enhancement/v3.1.1-beta/dropdowns-enhancement.css')
@css('css/backoffice.css')
