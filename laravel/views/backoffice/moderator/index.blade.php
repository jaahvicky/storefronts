@extends('backoffice/layout/default')

@section('content')
<div class="btn-group" data-methys-filter='dropdown-toggle'>
 <input type="hidden" id="orderbyname" name="orderbyname[]">
 </div>
<div class='box box-primary'>
    <div class="box-header">
        <h3 class="box-title">Product List</h3>
        <div>
            @include('backoffice.moderator.filters.filters') 
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
                                <th class="check_bulk_all"><input type="checkbox" name="bulk_action" class="b_check_all"></th>
                                <th class='order_by prod_mod_status' data-order-name='prod_mod_status'><i class="order fa " ></i>Status</th>
                                <th class='store_name' data-order-name=''><i class="order fa " ></i>Store</th>
                                <th class='store_name' data-order-name=''><i class="order fa " ></i>Product thumbnail</th>
                                
                                <th class='order_by prod_title' data-order-name='prod_title'><i class="order fa " ></i>Title</th>
                                <th class='order_by prod_price' data-order-name='prod_price'><i class="order fa " ></i>Price</th>
                                <th class='order_by prod_category' data-order-name='prod_category'><i class="order fa " ></i>Category</th>
                                
                                <th >Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($products As $product)
                            
                                <tr role="row">
                                   <td><input type="checkbox" name="bulk_action" class="b_check" value="{{ $product->id }}"></td>
                                   
                                    <td>{!! $product->productModerationType->name !!}</td>
                                  
                                     <td>{!! $product->store->name !!}</td>
                                      <td><a href="{!! URL::route('admin.moderator.product', ['id' => $product->id]) !!}">
                                            @if($product->coverImage && $product->coverImage->filename)
                                                     <img class='thumbnail-small' src='{!! LookupHelper::getImage($product->coverImage->filename) !!}' />
                                              
                                            @endif
                                            
                                    </a></td>
                                    <td class="sorting_1"><a href="{!! URL::route('admin.moderator.product', ['id' => $product->id]) !!}">
                                            {!! $product->title !!}
                                    </a></td>
                                    <td>${!! $product->price/100 !!}</td>
                                    <td>{!! LookupHelper::getCategoriesForCategory($product->category->id) !!}</td>
                                  
                                       
                                    <td class='table-actions'>
                                        <a class="btn btn-sm btn-default" href="{!! URL::route('admin.moderator.product', ['id' => $product->id]) !!}"> Edit </a>
                                        <a class="btn btn-sm btn-default" data-modal="true" href="{{ URL::route('admin.moderator.products.modal-delete', ['id' => $product->id]) }}"> Delete </a>
                                        
                                        
                                        <a class="btn btn-sm btn-primary" href="{{ URL::route('admin.moderation.modal-status', ['id' => $product->id]) }}" data-modal='true'> Change Status </a>

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

