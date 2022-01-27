@extends('marketplace::admin.layouts.content')

@section('page_title')
    {{ __('marketplace::app.admin.sellers.flag.title') }}
@stop

@section('content')


    <div class="content">
        <div class="page-header">
            <div class="page-title">
                <h1>{{ __('marketplace::app.admin.sellers.flag.title') }}</h1>
            </div>

            <div class="page-action">
                <a href="{{route('marketplace.admin.seller.flag.reason.create')}}" class="btn btn-lg btn-primary" > {{ __('marketplace::app.admin.sellers.flag.add-btn-title') }}</a>
            </div>
        </div>

        <div class="page-content">

            {!! app('Webkul\Marketplace\DataGrids\Admin\SellerFlagReasonDataGrid')->render() !!}

        </div>
    </div>

@stop