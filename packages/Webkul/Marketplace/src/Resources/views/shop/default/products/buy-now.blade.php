{!! view_render_event('bagisto.shop.products.buy_now.before', ['product' => $product]) !!}
@if($product->type == 'simple' || $product->type == 'configurable')
    @inject('InventoryHelper', 'Webkul\Marketplace\Helpers\Helper')

    <button type="submit" class="btn btn-lg btn-primary buynow" {{ ! $InventoryHelper->isSaleable($product) ? 'disabled' : '' }}>
        {{ __('shop::app.products.buy-now') }}
    </button>
@else
    <button type="submit" class="btn btn-lg btn-primary buynow" {{ ! $product->isSaleable(1) ? 'disabled' : '' }}>
        {{ __('shop::app.products.buy-now') }}
    </button>
@endif

{!! view_render_event('bagisto.shop.products.buy_now.after', ['product' => $product]) !!}