<?php

namespace Webkul\Marketplace\DataGrids\Shop;

use DB;
use Webkul\Ui\DataGrid\DataGrid;
use Webkul\Marketplace\Repositories\SellerRepository;

/**
 * Order Data Grid class
 *
 * @author Jitendra Singh <jitendra@webkul.com>
 * @copyright 2018 Webkul Software Pvt Ltd (http://www.webkul.com)
 */
class CustomerDataGrid extends DataGrid
{
    /**
     * @var integer
     */
    protected $index = 'id';

    protected $sortOrder = 'desc'; //asc or desc

    /**
     * SellerRepository object
     *
     * @var Object
     */
    protected $sellerRepository;

    /**
     * Create a new repository instance.
     *
     * @param  Webkul\Marketplace\Repositories\SellerRepository $sellerRepository
     * @return void
     */
    public function __construct(SellerRepository $sellerRepository)
    {
        parent::__construct();

        $this->sellerRepository = $sellerRepository;
    }

    public function prepareQueryBuilder()
    {
        $seller = $this->sellerRepository->findOneByField('customer_id', auth()->guard('customer')->user()->id);

        $queryBuilder = DB::table('marketplace_orders')
                ->leftJoin('orders', 'marketplace_orders.order_id', '=', 'orders.id')
                ->rightJoin('addresses', 'marketplace_orders.order_id', 'addresses.order_id')
                ->select('orders.id', 'orders.customer_id',  'marketplace_orders.order_id', DB::raw('sum(marketplace_orders.base_grand_total) as base_grand_total'), 'marketplace_orders.grand_total', 'marketplace_orders.created_at', 'channel_name', 'marketplace_orders.status', 'orders.order_currency_code')
                ->addSelect(DB::raw('CONCAT(orders.customer_first_name, " ", orders.customer_last_name) as customer_name'), 'orders.increment_id','orders.customer_email', DB::raw('CONCAT(addresses.	address1, " " ,addresses.state, " " , addresses.country, " ", addresses.postcode ) as address'), 'addresses.gender', 'addresses.phone', DB::raw('count(*) as order_count') )
                ->where('addresses.address_type', 'order_billing')
                ->where('marketplace_orders.marketplace_seller_id', $seller->id)
                ->groupBy('orders.customer_email');

        $this->addFilter('customer_name', DB::raw('CONCAT(orders.customer_first_name, " ", orders.customer_last_name)'));
        $this->addFilter('base_grand_total', 'marketplace_orders.base_grand_total');

        $this->setQueryBuilder($queryBuilder);
    }

    public function addColumns()
    {

        $this->addColumn([
            'index' => 'customer_name',
            'label' => trans("marketplace::app.shop.sellers.account.sales.orders.customer-name"),
            'type' => 'string',
            'searchable' => true,
            'sortable' => true,
            'filterable' => true
        ]);

        $this->addColumn([
            'index' => 'customer_email',
            'label' => trans("marketplace::app.shop.sellers.account.sales.orders.email"),
            'type' => 'string',
            'searchable' => true,
            'sortable' => true,
            'filterable' => true
        ]);

        $this->addColumn([
            'index' => 'phone',
            'label' => trans("marketplace::app.shop.sellers.account.sales.orders.phone"),
            'type' => 'string',
            'searchable' => true,
            'sortable' => true,
            'filterable' => true
        ]);

        $this->addColumn([
            'index' => 'gender',
            'label' => trans("marketplace::app.shop.sellers.account.sales.orders.gender"),
            'type' => 'string',
            'searchable' => true,
            'sortable' => true,
            'filterable' => true
        ]);

        $this->addColumn([
            'index' => 'address',
            'label' => trans("marketplace::app.shop.sellers.account.sales.orders.address"),
            'type' => 'string',
            'searchable' => false,
            'sortable' => false,
            'filterable' => false
        ]);

        $this->addColumn([
            'index' => 'base_grand_total',
            'label' => trans('marketplace::app.shop.sellers.account.sales.orders.base-total'),
            'type' => 'price',
            'searchable' => false,
            'sortable' => true,
            'filterable' => true
        ]);

        $this->addColumn([
            'index' => 'order_count',
            'label' => trans('marketplace::app.shop.sellers.account.sales.orders.order-count'),
            'type' => 'integer',
            'searchable' => false,
            'sortable' => true,
            'filterable' => false,
            'closure' => true,
            'wrapper' => function($row) {
                return '<a href="' . route('marketplace.account.customers.order.index', encrypt($row->customer_email)) . '">' . $row->order_count. '</a>';
            }
        ]);

    }

}