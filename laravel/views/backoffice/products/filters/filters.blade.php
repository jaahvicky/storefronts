<div class='row row-vertical-margin row-filters' data-methys-filter="container" 
    data-methys-filter-url="{{URL::route('ajax-filters-queue', ['tag'=>'products'])}}">
    <!-- search customer -->
    <div class='col-xs-12'>
        <div class='form-inline'>

            Filter by
            
            @include('backoffice.products.filters.categories-filter')
             @include('backoffice.products.filters.categoriessub-filter')
            @include('backoffice.products.filters.status-types-filter')
            
            @include('backoffice.products.filters.product-moderation-types-filter')

        </div>
    </div>
</div>

@js('plugins/methys-javascript/methys.filters.js')
@js('plugins/methys-javascript/methys.filters.products.js')
@js('plugins/bootstrap-dropdowns-enhancement/v3.1.1-beta/dropdowns-enhancement.js')
@js('/js/backoffice/products/filters.js')

@css('plugins/bootstrap-dropdowns-enhancement/v3.1.1-beta/dropdowns-enhancement.css')
@css('css/backoffice.css')
