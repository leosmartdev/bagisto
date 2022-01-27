<?php

return [
    [
        'key' => 'marketplace',
        'name' => 'marketplace::app.admin.layouts.marketplace',
        'route' => 'admin.marketplace.sellers.index',
        'sort' => 2,
        'icon-class' => 'marketplace-icon',
    ], [
        'key' => 'marketplace.sellers',
        'name' => 'marketplace::app.admin.layouts.sellers',
        'route' => 'admin.marketplace.sellers.index',
        'sort' => 1
    ], [
        'key' => 'marketplace.products',
        'name' => 'marketplace::app.admin.layouts.products',
        'route' => 'admin.marketplace.products.index',
        'sort' => 2
    ], [
        'key' => 'marketplace.reviews',
        'name' => 'marketplace::app.admin.layouts.seller-reviews',
        'route' => 'admin.marketplace.reviews.index',
        'sort' => 3
    ], [
        'key' => 'marketplace.orders',
        'name' => 'marketplace::app.admin.layouts.orders',
        'route' => 'admin.marketplace.orders.index',
        'sort' => 3
    ], [
        'key' => 'marketplace.transactions',
        'name' => 'marketplace::app.admin.layouts.transactions',
        'route' => 'admin.marketplace.transactions.index',
        'sort' => 3
    ],[
        'key' => 'marketplace.sellerFlag',
        'name' => 'marketplace::app.shop.layouts.sellerFlag',
        'route' => 'marketplace.admin.seller.flag.reason.index',
        'sort' => 8
    ],[
        'key' => 'marketplace.productFlag',
        'name' => 'marketplace::app.shop.layouts.productFlag',
        'route' => 'marketplace.admin.product.flag.reason.index',
        'sort' => 9
    ]
];