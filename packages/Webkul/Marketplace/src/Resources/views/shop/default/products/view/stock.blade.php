{!! view_render_event('bagisto.shop.products.view.stock.before', ['product' => $product]) !!}

@if($product->type == 'simple' || $product->type == 'configurable')
    @inject('InventoryHelper', 'Webkul\Marketplace\Helpers\Helper')

    <div class="stock-status {{! $InventoryHelper->stockHaveSufficientQuantity($product) ? '' : 'active' }}">
        @if ( $InventoryHelper->stockHaveSufficientQuantity($product) === true )
            {{ __('shop::app.products.in-stock') }}
        @elseif ( $InventoryHelper->stockHaveSufficientQuantity($product) > 0 )
            {{ __('shop::app.products.available-for-order') }}
        @else
            {{ __('shop::app.products.out-of-stock') }}
        @endif
    </div>
@else
    <div class="stock-status {{! $product->haveSufficientQuantity(1) ? '' : 'active' }}">
        @if ( $product->haveSufficientQuantity(1) === true )
            {{ __('shop::app.products.in-stock') }}
        @elseif ( $product->haveSufficientQuantity(1) > 0 )
            {{ __('shop::app.products.available-for-order') }}
        @else
            {{ __('shop::app.products.out-of-stock') }}
        @endif
    </div>
@endif
{!! view_render_event('bagisto.shop.products.view.stock.after', ['product' => $product]) !!}