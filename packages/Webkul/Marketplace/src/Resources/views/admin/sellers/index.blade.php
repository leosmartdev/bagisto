@extends('marketplace::admin.layouts.content')

@section('page_title')
    {{ __('marketplace::app.admin.sellers.title') }}
@stop

@section('content')

    <div class="content">
        <div class="page-header">
            <div class="page-title">
                <h1>{{ __('marketplace::app.admin.sellers.title') }}</h1>
            </div>

            <div class="page-action">
                <a href="{{route('admin.marketplace.sellers.create')}}" class="btn btn-lg btn-primary">{{ __('marketplace::app.admin.sellers.create') }}</a>
            </div>
        </div>

        <div class="page-content">

            {{-- {!! app('Webkul\Marketplace\DataGrids\Admin\SellerDataGrid')->render() !!} --}}
            @inject('sellers', 'Webkul\Marketplace\DataGrids\Admin\SellerDataGrid')
            {!! $sellers->render() !!}

        </div>
    </div>

@stop
