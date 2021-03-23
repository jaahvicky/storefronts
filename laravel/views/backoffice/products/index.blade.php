@extends('backoffice/layout/default')

@section('content')
<div class="btn-group" data-methys-filter='dropdown-toggle'>
 <input type="hidden" id="orderbyname" name="orderbyname[]">
 </div>
<div class='box box-primary'>
    <div class="box-header">
        <h3 class="box-title">Product List</h3>
        <div>
            @include('backoffice.products.filters.filters')
        </div>
    </div>
    <!-- /.box-header -->
    <div class="box-body">
        <div class="dataTables_wrapper form-inline dt-bootstrap" id="example2_wrapper">
            <div class="row">
                <div class="col-sm-6"></div>
                <div class="col-sm-6"></div>  
            </div>
            <div class="row">
                <div class="col-sm-12">
                    <table role="grid" id="example2" class="table table-bordered table-hover dataTable">
                        <thead>
                            <tr role="row">
                                <th class='order_by prod_title' data-order-name='prod_title'><i class="order fa " ></i>Name</th>
                                <th class='order_by prod_price' data-order-name='prod_price'><i class="order fa " ></i>Price</th>
                                <th class='order_by prod_category' data-order-name='prod_category'><i class="order fa " ></i>Category</th>
                                <th class='order_by prod_visibilty' data-order-name='prod_visibilty'><i class="order fa " ></i>Visibility</th>
                                <th class='order_by prod_mod_status' data-order-name='prod_mod_status'><i class="order fa " ></i>Moderation Status</th>
                                <th >Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($products As $product)
                            
                                <tr role="row">
                                    <td class="sorting_1"><a href="{!! URL::route('admin.product', ['id' => $product->id]) !!}">
                                            @if($product->coverImage && $product->coverImage->filename)
                                                    
                                                      <img class='thumbnail-small' src='{!! LookupHelper::getImage($product->coverImage->filename) !!}' />
                                                   
                                            @endif
                                            {!! $product->title !!}
                                    </a></td>
                                     <td>${!! $product->price/100 !!}</td>
                                    <td><a href="{!! URL::route('admin.product', ['id' => $product->id]) !!}">{!! LookupHelper::getCategoriesForCategory($product->category->id) !!}</a></td>
                                    <td>{!! $product->productStatus->name !!}</td>

                                    @if( $product->productModerationType)
                                        <td>{!! $product->productModerationType->name !!}</td>
                                    @else 
                                        <td>N/A</td>
                                    @endif

                                    <td class='table-actions'>
                                        <a class="btn btn-sm btn-default" href="{!! URL::route('admin.product', ['id' => $product->id]) !!}"> Edit </a>
                                        <a class="btn btn-sm btn-default" data-modal="true" href="{{ URL::route('admin.products.modal-delete', ['id' => $product->id]) }}"> Delete </a>
                                    </td>
                                </tr>
                                
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
            <div class='row'>
                    <div class='col-sm-4'>
                            @include('helpers.paginator-recordsperpage', ['listingName' => 'Products'])
                    </div>
                    <div class="col-sm-4">
                            <div class="text-center">
                                    Showing {{ $products->firstItem() }} to {{ $products->lastItem() }} of {{ $products->total() }} products
                            </div>
                    </div>
                    <div class="col-sm-4">
                            <div class='pull-right'>
                                    {!! $products->appends(Input::except('page', '_token'))->render() !!}
                            </div>
                    </div>
            </div>
        </div>
    </div>
    <!-- /.box-body -->
</div>     

@js('plugins/methys-javascript/methys.paginator.js')
@stop

