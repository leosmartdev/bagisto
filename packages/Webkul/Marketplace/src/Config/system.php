<?php

return [
    [
        'key' => 'marketplace',
        'name' => 'marketplace::app.admin.system.marketplace',
        'sort' => 1
    ], [
        'key' => 'marketplace.settings',
        'name' => 'marketplace::app.admin.system.settings',
        'sort' => 1,
    ], [
        'key' => 'marketplace.settings.general',
        'name' => 'marketplace::app.admin.system.general',
        'sort' => 1,
        'fields' => [
            [
                'name' => 'status',
                'title' => 'marketplace::app.admin.system.status',
                'type' => 'boolean'
            ],  [
                'name' => 'featured',
                'title' => 'marketplace::app.admin.system.featured',
                'type' => 'boolean'
            ], [
                'name' => 'new',
                'title' => 'marketplace::app.admin.system.new',
                'type' => 'boolean'
            ],[
                'name' => 'commission_per_unit',
                'title' => 'marketplace::app.admin.system.commission-per-unit',
                'type' => 'text',
                'validation' => 'required|min_value:0|max_value:100',
                'channel_based' => true,
                'locale_based' => false
            ], [
                'name' => 'seller_approval_required',
                'title' => 'marketplace::app.admin.system.seller-approval-required',
                'type' => 'select',
                'options' => [
                    [
                        'title' => 'marketplace::app.admin.system.yes',
                        'value' => true
                    ], [
                        'title' => 'marketplace::app.admin.system.no',
                        'value' => false
                    ]
                ]
            ], [
                'name' => 'product_approval_required',
                'title' => 'marketplace::app.admin.system.product-approval-required',
                'type' => 'select',
                'options' => [
                    [
                        'title' => 'marketplace::app.admin.system.yes',
                        'value' => true
                    ], [
                        'title' => 'marketplace::app.admin.system.no',
                        'value' => false
                    ]
                ]
            ], [
                'name' => 'can_create_invoice',
                'title' => 'marketplace::app.admin.system.can-create-invoice',
                'type' => 'select',
                'options' => [
                    [
                        'title' => 'marketplace::app.admin.system.yes',
                        'value' => true
                    ], [
                        'title' => 'marketplace::app.admin.system.no',
                        'value' => false
                    ]
                ]
            ], [
                'name' => 'can_create_shipment',
                'title' => 'marketplace::app.admin.system.can-create-shipment',
                'type' => 'select',
                'options' => [
                    [
                        'title' => 'marketplace::app.admin.system.yes',
                        'value' => true
                    ], [
                        'title' => 'marketplace::app.admin.system.no',
                        'value' => false
                    ]
                ]
            ], [
                'name' => 'can_cancel_order',
                'title' => 'marketplace::app.admin.system.can_cancel_order',
                'type' => 'select',
                'options' => [
                    [
                        'title' => 'marketplace::app.admin.system.yes',
                        'value' => true
                    ], [
                        'title' => 'marketplace::app.admin.system.no',
                        'value' => false
                    ]
                ]
            ]
        ]
    ], [
        'key' => 'marketplace.settings.landing_page',
        'name' => 'marketplace::app.admin.system.landing-page',
        'sort' => 1,
        'fields' => [
            [
                'name' => 'page_title',
                'title' => 'marketplace::app.admin.system.page-title',
                'type' => 'text',
                'channel_based' => true,
                'locale_based' => true
            ], [
                'name' => 'show_banner',
                'title' => 'marketplace::app.admin.system.show-banner',
                'type' => 'select',
                'options' => [
                    [
                        'title' => 'marketplace::app.admin.system.yes',
                        'value' => true
                    ], [
                        'title' => 'marketplace::app.admin.system.no',
                        'value' => false
                    ]
                ]
            ], [
                'name' => 'banner',
                'title' => 'marketplace::app.admin.system.banner',
                'type' => 'image',
                'validation' => 'mimes:jpeg,bmp,png,jpg',
                'channel_based' => true,
                'locale_based' => false
            ], [
                'name' => 'banner_content',
                'title' => 'marketplace::app.admin.system.banner-content',
                'type' => 'textarea',
                'channel_based' => true,
                'locale_based' => true
            ], [
                'name' => 'show_features',
                'title' => 'marketplace::app.admin.system.show-features',
                'type' => 'select',
                'options' => [
                    [
                        'title' => 'marketplace::app.admin.system.yes',
                        'value' => true
                    ], [
                        'title' => 'marketplace::app.admin.system.no',
                        'value' => false
                    ]
                ]
            ], [
                'name' => 'feature_heading',
                'title' => 'marketplace::app.admin.system.feature-heading',
                'type' => 'text',
                'channel_based' => true,
                'locale_based' => true
            ], [
                'name' => 'feature_info',
                'title' => 'marketplace::app.admin.system.feature-info',
                'type' => 'textarea',
                'channel_based' => true,
                'locale_based' => true
            ], [
                'name' => 'feature_icon_1',
                'title' => 'marketplace::app.admin.system.feature-icon-1',
                'type' => 'image',
                'validation' => 'mimes:jpeg,bmp,png,jpg',
                'channel_based' => true,
                'locale_based' => false
            ], [
                'name' => 'feature_icon_label_1',
                'title' => 'marketplace::app.admin.system.feature-icon-label-1',
                'type' => 'text',
                'channel_based' => true,
                'locale_based' => true
            ], [
                'name' => 'feature_icon_2',
                'title' => 'marketplace::app.admin.system.feature-icon-2',
                'type' => 'image',
                'validation' => 'mimes:jpeg,bmp,png,jpg',
                'channel_based' => true,
                'locale_based' => false
            ], [
                'name' => 'feature_icon_label_2',
                'title' => 'marketplace::app.admin.system.feature-icon-label-2',
                'type' => 'text',
                'channel_based' => true,
                'locale_based' => true
            ], [
                'name' => 'feature_icon_3',
                'title' => 'marketplace::app.admin.system.feature-icon-3',
                'type' => 'image',
                'validation' => 'mimes:jpeg,bmp,png,jpg',
                'channel_based' => true,
                'locale_based' => false
            ], [
                'name' => 'feature_icon_label_3',
                'title' => 'marketplace::app.admin.system.feature-icon-label-3',
                'type' => 'text',
                'channel_based' => true,
                'locale_based' => true
            ], [
                'name' => 'feature_icon_4',
                'title' => 'marketplace::app.admin.system.feature-icon-4',
                'type' => 'image',
                'validation' => 'mimes:jpeg,bmp,png,jpg',
                'channel_based' => true,
                'locale_based' => false
            ], [
                'name' => 'feature_icon_label_4',
                'title' => 'marketplace::app.admin.system.feature-icon-label-4',
                'type' => 'text',
                'channel_based' => true,
                'locale_based' => true
            ], [
                'name' => 'feature_icon_5',
                'title' => 'marketplace::app.admin.system.feature-icon-5',
                'type' => 'image',
                'validation' => 'mimes:jpeg,bmp,png,jpg',
                'channel_based' => true,
                'locale_based' => false
            ], [
                'name' => 'feature_icon_label_5',
                'title' => 'marketplace::app.admin.system.feature-icon-label-5',
                'type' => 'text',
                'channel_based' => true,
                'locale_based' => true
            ], [
                'name' => 'feature_icon_6',
                'title' => 'marketplace::app.admin.system.feature-icon-6',
                'type' => 'image',
                'validation' => 'mimes:jpeg,bmp,png,jpg',
                'channel_based' => true,
                'locale_based' => false
            ], [
                'name' => 'feature_icon_label_6',
                'title' => 'marketplace::app.admin.system.feature-icon-label-6',
                'type' => 'text',
                'channel_based' => true,
                'locale_based' => true
            ], [
                'name' => 'feature_icon_7',
                'title' => 'marketplace::app.admin.system.feature-icon-7',
                'type' => 'image',
                'validation' => 'mimes:jpeg,bmp,png,jpg',
                'channel_based' => true,
                'locale_based' => false
            ], [
                'name' => 'feature_icon_label_7',
                'title' => 'marketplace::app.admin.system.feature-icon-label-7',
                'type' => 'text',
                'channel_based' => true,
                'locale_based' => true
            ], [
                'name' => 'feature_icon_8',
                'title' => 'marketplace::app.admin.system.feature-icon-8',
                'type' => 'image',
                'validation' => 'mimes:jpeg,bmp,png,jpg',
                'channel_based' => true,
                'locale_based' => false
            ], [
                'name' => 'feature_icon_label_8',
                'title' => 'marketplace::app.admin.system.feature-icon-label-8',
                'type' => 'text',
                'channel_based' => true,
                'locale_based' => true
            ], [
                'name' => 'show_popular_sellers',
                'title' => 'marketplace::app.admin.system.show-popular-sellers',
                'type' => 'select',
                'options' => [
                    [
                        'title' => 'marketplace::app.admin.system.yes',
                        'value' => true
                    ], [
                        'title' => 'marketplace::app.admin.system.no',
                        'value' => false
                    ]
                ]
            ], [
                'name' => 'open_shop_button_label',
                'title' => 'marketplace::app.admin.system.open-shop-button-label',
                'type' => 'text',
                'channel_based' => true,
                'locale_based' => true
            ], [
                'name' => 'about_marketplace',
                'title' => 'marketplace::app.admin.system.about-marketplace',
                'type' => 'textarea',
                'channel_based' => true,
                'locale_based' => true
            ], [
                'name' => 'show_open_shop_block',
                'title' => 'marketplace::app.admin.system.show-open-shop-block',
                'type' => 'select',
                'options' => [
                    [
                        'title' => 'marketplace::app.admin.system.yes',
                        'value' => true
                    ], [
                        'title' => 'marketplace::app.admin.system.no',
                        'value' => false
                    ]
                ]
            ], [
                'name' => 'open_shop_info',
                'title' => 'marketplace::app.admin.system.open-shop-info',
                'type' => 'textarea',
                'channel_based' => true,
                'locale_based' => true
            ]
        ]
    ], [
        'key' => 'marketplace.settings.velocity',
        'name' => 'marketplace::app.velocity.system.velocity-content',
        'sort' => 2,
        'fields' => [
            [
                'name' => 'page_title',
                'title' => 'marketplace::app.admin.system.page-title',
                'type' => 'text',
                'channel_based' => true,
                'locale_based' => true
            ], [
                'name' => 'show_banner',
                'title' => 'marketplace::app.admin.system.show-banner',
                'type' => 'select',
                'options' => [
                    [
                        'title' => 'marketplace::app.admin.system.yes',
                        'value' => true
                    ], [
                        'title' => 'marketplace::app.admin.system.no',
                        'value' => false
                    ]
                ]
            ], [
                'name' => 'banner',
                'title' => 'marketplace::app.admin.system.banner',
                'type' => 'image',
                'validation' => 'mimes:jpeg,bmp,png,jpg',
                'channel_based' => true,
                'locale_based' => false
            ], [
                'name' => 'banner_content',
                'title' => 'marketplace::app.admin.system.banner-content',
                'type' => 'textarea',
                'channel_based' => true,
                'locale_based' => true
            ], [
                'name' => 'show_features',
                'title' => 'marketplace::app.admin.system.show-features',
                'type' => 'select',
                'options' => [
                    [
                        'title' => 'marketplace::app.admin.system.yes',
                        'value' => true
                    ], [
                        'title' => 'marketplace::app.admin.system.no',
                        'value' => false
                    ]
                ]
            ], [
                'name' => 'feature_heading',
                'title' => 'marketplace::app.admin.system.feature-heading',
                'type' => 'text',
                'channel_based' => true,
                'locale_based' => true
            ], [
                'name' => 'feature_info',
                'title' => 'marketplace::app.admin.system.feature-info',
                'type' => 'textarea',
                'channel_based' => true,
                'locale_based' => true
            ], [
                'name' => 'feature_icon_1',
                'title' => 'marketplace::app.admin.system.feature-icon-1',
                'type' => 'image',
                'validation' => 'mimes:jpeg,bmp,png,jpg',
                'channel_based' => true,
                'locale_based' => false
            ], [
                'name' => 'feature_icon_label_1',
                'title' => 'marketplace::app.admin.system.feature-icon-label-1',
                'type' => 'text',
                'channel_based' => true,
                'locale_based' => true
            ], [
                'name' => 'feature_icon_2',
                'title' => 'marketplace::app.admin.system.feature-icon-2',
                'type' => 'image',
                'validation' => 'mimes:jpeg,bmp,png,jpg',
                'channel_based' => true,
                'locale_based' => false
            ], [
                'name' => 'feature_icon_label_2',
                'title' => 'marketplace::app.admin.system.feature-icon-label-2',
                'type' => 'text',
                'channel_based' => true,
                'locale_based' => true
            ], [
                'name' => 'feature_icon_3',
                'title' => 'marketplace::app.admin.system.feature-icon-3',
                'type' => 'image',
                'validation' => 'mimes:jpeg,bmp,png,jpg',
                'channel_based' => true,
                'locale_based' => false
            ], [
                'name' => 'feature_icon_label_3',
                'title' => 'marketplace::app.admin.system.feature-icon-label-3',
                'type' => 'text',
                'channel_based' => true,
                'locale_based' => true
            ], [
                'name' => 'feature_icon_4',
                'title' => 'marketplace::app.admin.system.feature-icon-4',
                'type' => 'image',
                'validation' => 'mimes:jpeg,bmp,png,jpg',
                'channel_based' => true,
                'locale_based' => false
            ], [
                'name' => 'feature_icon_label_4',
                'title' => 'marketplace::app.admin.system.feature-icon-label-4',
                'type' => 'text',
                'channel_based' => true,
                'locale_based' => true
            ], [
                'name' => 'feature_icon_5',
                'title' => 'marketplace::app.admin.system.feature-icon-5',
                'type' => 'image',
                'validation' => 'mimes:jpeg,bmp,png,jpg',
                'channel_based' => true,
                'locale_based' => false
            ], [
                'name' => 'feature_icon_label_5',
                'title' => 'marketplace::app.admin.system.feature-icon-label-5',
                'type' => 'text',
                'channel_based' => true,
                'locale_based' => true
            ], [
                'name' => 'feature_icon_6',
                'title' => 'marketplace::app.admin.system.feature-icon-6',
                'type' => 'image',
                'validation' => 'mimes:jpeg,bmp,png,jpg',
                'channel_based' => true,
                'locale_based' => false
            ], [
                'name' => 'feature_icon_label_6',
                'title' => 'marketplace::app.admin.system.feature-icon-label-6',
                'type' => 'text',
                'channel_based' => true,
                'locale_based' => true
            ], [
                'name' => 'feature_icon_7',
                'title' => 'marketplace::app.admin.system.feature-icon-7',
                'type' => 'image',
                'validation' => 'mimes:jpeg,bmp,png,jpg',
                'channel_based' => true,
                'locale_based' => false
            ], [
                'name' => 'feature_icon_label_7',
                'title' => 'marketplace::app.admin.system.feature-icon-label-7',
                'type' => 'text',
                'channel_based' => true,
                'locale_based' => true
            ], [
                'name' => 'feature_icon_8',
                'title' => 'marketplace::app.admin.system.feature-icon-8',
                'type' => 'image',
                'validation' => 'mimes:jpeg,bmp,png,jpg',
                'channel_based' => true,
                'locale_based' => false
            ], [
                'name' => 'feature_icon_label_8',
                'title' => 'marketplace::app.admin.system.feature-icon-label-8',
                'type' => 'text',
                'channel_based' => true,
                'locale_based' => true
            ], [
                'name' => 'show_popular_sellers',
                'title' => 'marketplace::app.admin.system.show-popular-sellers',
                'type' => 'select',
                'options' => [
                    [
                        'title' => 'marketplace::app.admin.system.yes',
                        'value' => true
                    ], [
                        'title' => 'marketplace::app.admin.system.no',
                        'value' => false
                    ]
                ]
            ], [
                'name' => 'open_shop_button_label',
                'title' => 'marketplace::app.admin.system.open-shop-button-label',
                'type' => 'text',
                'channel_based' => true,
                'locale_based' => true
            ], [
                'name' => 'about_marketplace',
                'title' => 'marketplace::app.admin.system.about-marketplace',
                'type' => 'textarea',
                'channel_based' => true,
                'locale_based' => true
            ], [
                'name' => 'show_open_shop_block',
                'title' => 'marketplace::app.admin.system.show-open-shop-block',
                'type' => 'select',
                'options' => [
                    [
                        'title' => 'marketplace::app.admin.system.yes',
                        'value' => true
                    ], [
                        'title' => 'marketplace::app.admin.system.no',
                        'value' => false
                    ]
                ]
            ], [
                'name' => 'open_shop_info',
                'title' => 'marketplace::app.admin.system.open-shop-info',
                'type' => 'textarea',
                'channel_based' => true,
                'locale_based' => true
            ], [
                'name' => 'setup_icon_1',
                'title' => 'marketplace::app.admin.system.setup-icon-1',
                'type' => 'image',
                'validation' => 'mimes:jpeg,bmp,png,jpg',
                'channel_based' => true,
                'locale_based' => false
            ], [
                'name' => 'setup_icon_2',
                'title' => 'marketplace::app.admin.system.setup-icon-2',
                'type' => 'image',
                'validation' => 'mimes:jpeg,bmp,png,jpg',
                'channel_based' => true,
                'locale_based' => false
            ], [
                'name' => 'setup_icon_3',
                'title' => 'marketplace::app.admin.system.setup-icon-3',
                'type' => 'image',
                'validation' => 'mimes:jpeg,bmp,png,jpg',
                'channel_based' => true,
                'locale_based' => false
            ], [
                'name' => 'setup_icon_4',
                'title' => 'marketplace::app.admin.system.setup-icon-4',
                'type' => 'image',
                'validation' => 'mimes:jpeg,bmp,png,jpg',
                'channel_based' => true,
                'locale_based' => false
            ], [
                'name' => 'setup_icon_5',
                'title' => 'marketplace::app.admin.system.setup-icon-5',
                'type' => 'image',
                'validation' => 'mimes:jpeg,bmp,png,jpg',
                'channel_based' => true,
                'locale_based' => false
            ]
        ]
    ], [
        'key' => 'marketplace.settings.seller_flag',
        'name' => 'marketplace::app.admin.system.seller-flag',
        'sort' => 2,
        'fields' => [
            [
                'name' => 'enable',
                'title' => 'marketplace::app.admin.system.enable',
                'type' => 'select',
                'options' => [
                    [
                        'title' => 'marketplace::app.admin.system.yes',
                        'value' => true
                    ], [
                        'title' => 'marketplace::app.admin.system.no',
                        'value' => false
                    ]
                ]
            ], [
                'name' => 'text',
                'title' => 'marketplace::app.admin.system.text',
                'type' => 'text',
                'channel_based' => true,
                'locale_based' => true
            ], [
                'name' => 'guest_can',
                'title' => 'marketplace::app.admin.system.guest-can',
                'type' => 'select',
                'options' => [
                    [
                        'title' => 'marketplace::app.admin.system.yes',
                        'value' => true
                    ], [
                        'title' => 'marketplace::app.admin.system.no',
                        'value' => false
                    ]
                ]
            ],[
                'name' => 'reason',
                'title' => 'marketplace::app.admin.system.reason',
                'type' => 'select',
                'options' => [
                    [
                        'title' => 'marketplace::app.admin.system.yes',
                        'value' => true
                    ], [
                        'title' => 'marketplace::app.admin.system.no',
                        'value' => false
                    ]
                ]
            ],[
                'name' => 'other_reason',
                'title' => 'marketplace::app.admin.system.other-reason',
                'type' => 'select',
                'options' => [
                    [
                        'title' => 'marketplace::app.admin.system.yes',
                        'value' => true
                    ], [
                        'title' => 'marketplace::app.admin.system.no',
                        'value' => false
                    ]
                ]
            ], [
                'name' => 'other_placeholder',
                'title' => 'marketplace::app.admin.system.other-placeholder',
                'type' => 'text',
                'channel_based' => true,
                'locale_based' => true
            ],
        ]
     ],[
        'key' => 'marketplace.settings.product_flag',
        'name' => 'marketplace::app.admin.system.product-flag',
        'sort' => 2,
        'fields' => [
            [
                'name' => 'enable',
                'title' => 'marketplace::app.admin.system.enable',
                'type' => 'select',
                'options' => [
                    [
                        'title' => 'marketplace::app.admin.system.yes',
                        'value' => true
                    ], [
                        'title' => 'marketplace::app.admin.system.no',
                        'value' => false
                    ]
                ]
            ], [
                'name' => 'text',
                'title' => 'marketplace::app.admin.system.text',
                'type' => 'text',
                'channel_based' => true,
                'locale_based' => true
            ], [
                'name' => 'guest_can',
                'title' => 'marketplace::app.admin.system.guest-can',
                'type' => 'select',
                'options' => [
                    [
                        'title' => 'marketplace::app.admin.system.yes',
                        'value' => true
                    ], [
                        'title' => 'marketplace::app.admin.system.no',
                        'value' => false
                    ]
                ]
            ],[
                'name' => 'reason',
                'title' => 'marketplace::app.admin.system.reason',
                'type' => 'select',
                'options' => [
                    [
                        'title' => 'marketplace::app.admin.system.yes',
                        'value' => true
                    ], [
                        'title' => 'marketplace::app.admin.system.no',
                        'value' => false
                    ]
                ]
            ],[
                'name' => 'other_reason',
                'title' => 'marketplace::app.admin.system.other-reason',
                'type' => 'select',
                'options' => [
                    [
                        'title' => 'marketplace::app.admin.system.yes',
                        'value' => true
                    ], [
                        'title' => 'marketplace::app.admin.system.no',
                        'value' => false
                    ]
                ]
            ], [
                'name' => 'other_placeholder',
                'title' => 'marketplace::app.admin.system.other-placeholder',
                'type' => 'text',
                'channel_based' => true,
                'locale_based' => true
            ],
        ]
        ], [
            'key' => 'marketplace.settings.minimum_order_amount',
            'name' => 'marketplace::app.admin.system.minimum-order-amount',
            'sort' => 2,
            'fields' => [
                [
                    'name' => 'enable',
                    'title' => 'marketplace::app.admin.system.enable',
                    'type' => 'select',
                    'options' => [
                        [
                            'title' => 'marketplace::app.admin.system.yes',
                            'value' => true
                        ], [
                            'title' => 'marketplace::app.admin.system.no',
                            'value' => false
                        ]
                    ]
                ], [
                    'name' => 'min_amount',
                    'title' => 'marketplace::app.admin.system.min-amount',
                    'type' => 'text',
                    'channel_based' => true,
                ], [
                    'name' => 'seller_min_amount',
                    'title' => 'marketplace::app.admin.system.seller-min-amount',
                    'type' => 'select',
                    'options' => [
                        [
                            'title' => 'marketplace::app.admin.system.yes',
                            'value' => true
                        ], [
                            'title' => 'marketplace::app.admin.system.no',
                            'value' => false
                        ]
                    ]
                ]
            ]
        ],[
            'key' => 'marketplace.settings.google_analytics',
            'name' => 'marketplace::app.admin.system.google-analytics',
            'sort' => 2,
            'fields' => [
                [
                    'name' => 'enable',
                    'title' => 'marketplace::app.admin.system.enable',
                    'type' => 'select',
                    'options' => [
                        [
                            'title' => 'marketplace::app.admin.system.yes',
                            'value' => true
                        ], [
                            'title' => 'marketplace::app.admin.system.no',
                            'value' => false
                        ]
                    ]
                ],[
                    'name' => 'google_analytics_id',
                    'title' => 'marketplace::app.admin.system.google-analytics-id',
                    'type' => 'text',
                    'channel_based' => true,
                ], [
                    'name' => 'seller_google_analytics',
                    'title' => 'marketplace::app.admin.system.seller-google-analytics',
                    'type' => 'select',
                    'options' => [
                        [
                            'title' => 'marketplace::app.admin.system.yes',
                            'value' => true
                        ], [
                            'title' => 'marketplace::app.admin.system.no',
                            'value' => false
                        ]
                    ]
                ]
            ]
        ]
];