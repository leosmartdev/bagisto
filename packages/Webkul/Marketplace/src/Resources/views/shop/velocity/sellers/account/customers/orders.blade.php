@extends('shop::customers.account.index')

@section('page_title')
    {{ __('marketplace::app.shop.sellers.account.sales.orders.title') }}
@endsection

@section('page-detail-wrapper')

    <div class="account-layout">

        <div class="account-head mb-10">
            <span class="account-heading">
                {{ __('marketplace::app.shop.sellers.account.sales.orders.title') }}
            </span>

            <div class="account-action">
            </div>

            <div class="horizontal-rule"></div>
        </div>

        {!! view_render_event('marketplace.sellers.account.sales.customer.orders.list.before') !!}

        <div class="account-items-list">
            <div class="account-table-content">

                {!! app('Webkul\Marketplace\DataGrids\Shop\CustomerOrderDataGrid')->render() !!}

            </div>
        </div>

        {!! view_render_event('marketplace.sellers.account.sales.orders.list.after') !!}

    </div>

@endsection