{!! view_render_event('bagisto.shop.products.view.stock.before', ['product' => $product]) !!}
@inject('InventoryHelper', 'Webkul\Marketplace\Helpers\Helper')

<div class="col-12 availability">
    @if($product->type == 'simple' || $product->type == 'configurable')
        <button
            type="button"
            class="{{! $InventoryHelper->stockHaveSufficientQuantity($product) ? '' : 'active' }} disable-box-shadow">
                @if ( $InventoryHelper->stockHaveSufficientQuantity($product) === true )
                    {{ __('shop::app.products.in-stock') }}
                @elseif ( $InventoryHelper->stockHaveSufficientQuantity($product) > 0 )
                    {{ __('shop::app.products.available-for-order') }}
                @else
                    {{ __('shop::app.products.out-of-stock') }}
                @endif
        </button>
    @else
        <button
            type="button"
            class="{{! $product->haveSufficientQuantity(1) ? '' : 'active' }} disable-box-shadow">
                @if ( $product->haveSufficientQuantity(1) === true )
                    {{ __('shop::app.products.in-stock') }}
                @elseif ( $product->haveSufficientQuantity(1) > 0 )
                    {{ __('shop::app.products.available-for-order') }}
                @else
                    {{ __('shop::app.products.out-of-stock') }}
                @endif
        </button>
    @endif
</div>

{!! view_render_event('bagisto.shop.products.view.stock.after', ['product' => $product]) !!}