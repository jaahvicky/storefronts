@extends('backoffice/layout/default')

@section('content')
<div class="btn-group" data-methys-filter='dropdown-toggle'>
 <input type="hidden" id="orderbyname" name="orderbyname[]">
 </div>
<div class='box box-primary'>
    <div class="box-header">
        <div>
            <a id="submit-status" href="{{ URL::route('admin.billing')}}" class="btn btn-sm btn-primary pull-left"> BACK TO BILLING</a>
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
                                <th class='order_by prod_title' data-order-name='prod_title'><i class="order fa " ></i>Invoice</th>
                                <th class='order_by prod_price' data-order-name='prod_price'><i class="order fa " ></i>DATE</th>
                                <th class='order_by prod_category' data-order-name='prod_category'><i class="order fa " ></i>Amount</th>
                                <th class='order_by prod_visibilty' data-order-name='prod_visibilty'><i class="order fa " ></i>PAID</th>
                                
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($invoices As $invoice)
                                <tr role="row">
                                    <td class="sorting_1"><a href="{{ URL::route('admin.billing.pdf', ['id'=> $invoice->id])}}">{!! $invoice->correlator !!}</a></td>
                                    <td>{!! date("d M Y", strtotime($invoice->paid_on)) !!}</td>
                                    <td>$ {!! $invoice->amount !!}</td>
                                    @if( $invoice->status == 'completed')
                                      <td>{!! date("d M Y", strtotime($invoice->updated_at)) !!}</td>
                                    @else
                                      <td></td>
                                    @endif 
                                </tr>
                            @endforeach    
                            
                        </tbody>
                    </table>
                </div>
            </div>
            <div class='row'>
                    <div class='col-sm-4'>
                            @include('helpers.paginator-recordsperpage', ['listingName' => 'invoices'])
                    </div>
                    <div class="col-sm-4">
                            <div class="text-center">
                                    Showing {{ $invoices->firstItem() }} to {{ $invoices->lastItem() }} of {{ $invoices->total() }} invoices
                            </div>
                    </div>
                    <div class="col-sm-4">
                            <div class='pull-right'>
                                    {!! $invoices->appends(Input::except('page', '_token'))->render() !!}
                            </div>
                    </div>
            </div>
        </div>
    </div>
    <!-- /.box-body -->
</div>     

@js('plugins/methys-javascript/methys.paginator.js')
@stop

