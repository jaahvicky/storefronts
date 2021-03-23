@extends('backoffice/layout/default')

@section('content')

<div class='box box-primary'>
    <div class="box-header">
        <h3 class="box-title">Products Attributes List</h3>
        <div style="margin-top: 10px;">
           <a class="btn btn-sm btn-primary" data-modal="true" href="{!! URL::route('admin.variant.modal-add') !!}">Add Product Attribute</a>
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
                                <th>Date</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($variants As $variant)
                                
                                <tr role="row">
                                    <td class="sorting_1">{!! $variant->name !!}</td>
                                    <td>{!! date("d M Y", strtotime($variant->created_at)) !!}</td>
                                    <td class='table-actions'>
                                       
                                         <a class="btn btn-sm btn-default" data-modal="true" href="{!! URL::route('admin.variant.modal-edit', ['id' => $variant->id]) !!}"> Edit </a>
                                        <a class="btn btn-sm btn-default" data-modal="true" href="{{ URL::route('admin.variant.modal-delete', ['id' => $variant->id]) }}"> Delete </a>
                                    </td>
                                </tr>
                                
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
                                    Showing {{ $variants->firstItem() }} to {{ $variants->lastItem() }} of {{ $variants->total() }} entries
                            </div>
                    </div>
                    <div class="col-sm-4">
                            <div class='pull-right'>
                                    {!! $variants->appends(Input::except('page', '_token'))->render() !!}
                            </div>
                    </div>
            </div>
        </div>
    </div>
    <!-- /.box-body -->
</div>     

@js('plugins/methys-javascript/methys.paginator.js')
@stop

