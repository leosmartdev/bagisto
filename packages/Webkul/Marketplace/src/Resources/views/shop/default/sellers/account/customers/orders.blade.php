@extends('marketplace::shop.layouts.account')

@section('page_title')
       {{ __('marketplace::app.shop.sellers.account.sales.orders.title') }}
@endsection

@section('content')

    <div class="account-layout">

        <div class="account-head mb-10">
            <span class="account-heading">
                   {{ __('marketplace::app.shop.sellers.account.sales.orders.title') }}
            </span>

            <div class="horizontal-rule"></div>
        </div>

        {!! view_render_event('marketplace.sellers.account.sales.customer.orders.list.before') !!}

        <div class="account-items-list">

            {!! app('Webkul\Marketplace\DataGrids\Shop\CustomerOrderDataGrid')->render() !!}

        </div>

        {!! view_render_event('marketplace.sellers.account.sales.customer.orders.list.after') !!}

    </div>

@endsection