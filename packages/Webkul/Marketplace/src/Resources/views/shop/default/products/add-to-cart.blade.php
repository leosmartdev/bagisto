{!! view_render_event('bagisto.shop.products.add_to_cart.before', ['product' => $product]) !!}
@inject('InventoryHelper', 'Webkul\Marketplace\Helpers\Helper')

@php
    $width = (core()->getConfigData('catalog.products.storefront.buy_now_button_display') == 1) ? '49' : '95';
@endphp

@if($product->type == 'simple' || $product->type == 'configurable')
    <button type="submit" class="btn btn-lg btn-primary addtocart" {{ ! $InventoryHelper->isSaleable($product) ? 'disabled' : '' }}
    style="width: <?php echo $width.'%';?>;">
        {{ ($product->type == 'booking') ?  __('shop::app.products.book-now') :  __('shop::app.products.add-to-cart') }}
    </button>
@else
    <button type="submit" class="btn btn-lg btn-primary addtocart" {{ ! $product->isSaleable() ? 'disabled' : '' }}
    style="width: <?php echo $width.'%';?>;">
        {{ ($product->type == 'booking') ?  __('shop::app.products.book-now') :  __('shop::app.products.add-to-cart') }}
    </button>
@endif
{!! view_render_event('bagisto.shop.products.add_to_cart.after', ['product' => $product]) !!}