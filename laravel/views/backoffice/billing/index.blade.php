@extends('backoffice/layout/default')

@section('content')
    @css('/css/backoffice.css')
    @css('/css/backoffice-billing.css')
    @include('backoffice.billing.account', [])
    @include('backoffice.billing.balance', [])
    @include('backoffice.billing.store', [])

@stop

