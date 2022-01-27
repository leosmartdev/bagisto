<?php

namespace Webkul\Marketplace\Providers;

use Konekt\Concord\BaseModuleServiceProvider;

class ModuleServiceProvider extends BaseModuleServiceProvider
{
    protected $models = [
        \Webkul\Marketplace\Models\Seller::class,
        \Webkul\Marketplace\Models\Review::class,
        \Webkul\Marketplace\Models\Product::class,
        \Webkul\Marketplace\Models\ProductImage::class,
        \Webkul\Marketplace\Models\Order::class,
        \Webkul\Marketplace\Models\OrderItem::class,
        \Webkul\Marketplace\Models\Shipment::class,
        \Webkul\Marketplace\Models\ShipmentItem::class,
        \Webkul\Marketplace\Models\Invoice::class,
        \Webkul\Marketplace\Models\InvoiceItem::class,
        \Webkul\Marketplace\Models\Transaction::class,
        \Webkul\Marketplace\Models\Refund::class,
        \Webkul\Marketplace\Models\RefundItem::class,
        \Webkul\Marketplace\Models\ProductFlagReason::class,
        \Webkul\Marketplace\Models\SellerFlagReason::class,
        \Webkul\Marketplace\Models\ProductFlag::class,
        \Webkul\Marketplace\Models\SellerFlag::class,
        \Webkul\Marketplace\Models\ProductVideo::class,
    ];
}