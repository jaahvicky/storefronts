@extends('backoffice/layout/default')

@section('content')

<div class='box box-primary'>
    <div class="box-header">
        <h3 class="box-title">Store List</h3>
        <div>
            @include('backoffice.admin.stores.filters')
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
                                <th>Name</th>
                                <th>Status</th>
                                <th>Payment status</th>
                                <th>Date</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $i =0; ?>
                            @foreach($stores As $store)
                                @if(LookupHelper::paymentstatusfiltercheck($store))
                                    <tr role="row">
                                        <td class="sorting_1">{!! $store->name !!}</td>
                                        <td><span class='label label-default'>{!! $store->status->label !!}</span></td>
                                        <td><span class='text-capitalize'>{{ LookupHelper::checkpaymentstatus($store)}}</span></td>
                                        <td>{!! date("d M Y", strtotime($store->status_at)) !!}</td>
                                        <td class='table-actions'>
                                            <a class="btn btn-sm btn-primary" href="{{ URL::route('admin.stores.modal-change-status', ['id' => $store->id]) }}" data-modal='true'> Change Status </a>
                                            <a class="btn btn-sm btn-primary" href="{{ URL::route('admin.stores.details', ['id' => $store->id]) }}" > View Detail </a>
                                        </td>
                                    </tr>
                                    <?php $i++; ?>
                                @endif
                                
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
            <div class='row'>
                    <div class='col-sm-4'>
                            @include('helpers.paginator-recordsperpage')
                    </div>
                    <div class="col-sm-4">
                            <div class="text-center">
                                    Showing {{ $i }} to {{ $i }}  <!-- of {{ $stores->total() }} entries-->
                            </div>
                    </div>
                    <div class="col-sm-4">
                            <div class='pull-right'>
                                    {!! $stores->appends(Input::except('page', '_token'))->render() !!}
                            </div>
                    </div>
            </div>
        </div>
    </div>
    <!-- /.box-body -->
</div>     

@js('plugins/methys-javascript/methys.paginator.js')
@stop

