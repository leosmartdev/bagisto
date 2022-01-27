@extends('shop::customers.account.index')

@section('page_title')
    {{ __('marketplace::app.shop.sellers.account.catalog.products.title') }}
@endsection

@section('page-detail-wrapper')
    <div class="account-layout">

        <div class="account-head mb-10" style="padding-bottom: 10px;">
            <span class="account-heading">
                {{ __('marketplace::app.shop.sellers.account.catalog.products.title') }}
            </span>

            <div class="account-action">
                <a href="{{ route('marketplace.account.products.search') }}" class="theme-btn">
                    {{ __('marketplace::app.shop.sellers.account.catalog.products.create') }}
                </a>
            </div>

            <div class="horizontal-rule"></div>
        </div>

        {!! view_render_event('marketplace.sellers.account.catalog.products.list.before') !!}

        <div class="account-items-list">
            <div class="account-table-content">

                {!! app('Webkul\Marketplace\DataGrids\Shop\ProductDataGrid')->render() !!}

            </div>
        </div>

        {!! view_render_event('marketplace.sellers.account.catalog.products.list.after') !!}

    </div>

@endsection