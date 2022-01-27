<?php

namespace Webkul\Marketplace\DataGrids\Admin;

use DB;
use Webkul\Ui\DataGrid\DataGrid;

/**
 * Product Data Grid class
 *
 * @author Jitendra Singh <jitendra@webkul.com>
 * @copyright 2018 Webkul Software Pvt Ltd (http://www.webkul.com)
 */
class ProductDataGrid extends DataGrid
{
    /**
     *
     * @var integer
     */
    public $index = 'marketplace_product_id';

    protected $sortOrder = 'desc'; //asc or desc

    public function prepareQueryBuilder()
    {

        $queryBuilder = DB::table('marketplace_products')
            ->leftJoin('product_flat', 'marketplace_products.product_id', '=', 'product_flat.id')
            ->leftJoin('marketplace_product_flags', 'product_flat.product_id', '=', 'marketplace_product_flags.product_id')
            ->leftJoin('marketplace_sellers', 'marketplace_products.marketplace_seller_id', '=', 'marketplace_sellers.id')
            ->leftJoin('customers', 'marketplace_sellers.customer_id', '=', 'customers.id')
            ->leftJoin('product_inventories', 'marketplace_sellers.id', '=', 'product_inventories.vendor_id')
            ->addSelect('product_inventories.qty as quantity')->groupBy('marketplace_products.id')
            ->addSelect(
                'marketplace_products.id as marketplace_product_id',
                'product_flat.product_id',
                'product_flat.sku',
                'product_flat.url_key',
                'product_flat.name',
                'marketplace_products.price',
                'product_flat.product_number',
                'product_flat.price as   product_flat_price',
                'marketplace_products.is_owner',
                'marketplace_products.is_approved',
                DB::raw('CONCAT(customers.first_name, " ", customers.last_name) as seller_name'),
                DB::raw('COUNT(marketplace_product_flags.id) as flags')
                )

                ->where('channel', core()->getCurrentChannelCode())
                ->where('locale', app()->getLocale());


        $this->addFilter('seller_name', DB::raw('CONCAT(customers.first_name, " ", customers.last_name)'));
        $this->addFilter('sku', 'product_flat.sku');
        $this->addFilter('product_id', 'product_flat.product_id');
        $this->addFilter('product_number', 'product_flat.product_number');
        $this->addFilter('price', 'product_flat.price');
        $this->addFilter('is_approved', 'marketplace_products.is_approved');

        $this->setQueryBuilder($queryBuilder);
    }

    public function addColumns()
    {
        $this->addColumn([
            'index' => 'product_id',
            'label' => trans('marketplace::app.admin.products.product-id'),
            'type' => 'number',
            'searchable' => false,
            'sortable' => true,
            'filterable' => true
        ]);

        $this->addColumn([
            'index'      => 'product_number',
            'label'      => trans('marketplace::app.admin.products.product-number'),
            'type'       => 'string',
            'searchable' => true,
            'sortable'   => true,
            'filterable' => true,
        ]);

        $this->addColumn([
            'index' => 'seller_name',
            'label' => trans('marketplace::app.admin.sellers.seller-name'),
            'type' => 'string',
            'searchable' => true,
            'sortable' => true,
            'filterable' => true
        ]);

        $this->addColumn([
            'index' => 'sku',
            'label' => trans('marketplace::app.admin.products.sku'),
            'type' => 'string',
            'searchable' => true,
            'sortable' => true,
            'filterable' => true
        ]);

        $this->addColumn([
            'index' => 'name',
            'label' => trans('marketplace::app.admin.products.name'),
            'type' => 'string',
            'searchable' => true,
            'sortable' => true,
            'filterable' => true,
            'closure' => true,
            'wrapper' => function($row) {
                if ($row->url_key) {
                    return '<a target="_blank" href="'.route('shop.productOrCategory.index', $row->url_key).'">' . $row->name . '</a>';
                } else {
                    return $row->name;
                }
            }
        ]);

        if ( (core()->getConfigData('marketplace.settings.product_flag.enable'))) {
            $this->addColumn([
                'index' => 'flags',
                'label' => trans('marketplace::app.admin.flag.title'),
                'type' => 'integer',
                'searchable' => true,
                'sortable' => true,
                'filterable' => false,
                'closure' => true,
                'wrapper' => function($row) {
                    return '<a href="'.route('admin.catalog.products.edit', $row->product_id).'">' . $row->flags . '</a>';
                }
            ]);
        }

        $this->addColumn([
            'index' => 'price',
            'label' => trans('marketplace::app.admin.products.price'),
            'type' => 'price',
            'sortable' => true,
            'searchable' => false,
            'filterable' => true,
            'wrapper' => function($row) {
                if ($row->is_owner == 1)
                    return number_format($row->product_flat_price, 2);
                else
                    return number_format($row->price, 2);
            }
        ]);

        $this->addColumn([
            'index' => 'quantity',
            'label' => trans('marketplace::app.admin.products.quantity'),
            'type' => 'number',
            'sortable' => true,
            'searchable' => false,
            'filterable' => false
        ]);

        $this->addColumn([
            'index' => 'is_approved',
            'label' => trans('marketplace::app.admin.products.status'),
            'type' => 'boolean',
            'sortable' => true,
            'searchable' => false,
            'filterable' => true,
            'wrapper' => function($row) {
                if ($row->is_approved == 1)
                    return trans('marketplace::app.admin.products.approved');
                else
                    return trans('marketplace::app.admin.products.un-approved');
            }
        ]);
    }

    public function prepareActions()
    {
        $this->addAction([
            'type' => 'delete',
            'method' => 'POST',
            'route' => 'admin.marketplace.products.delete',
            'confirm_text' => trans('ui::app.datagrid.massaction.delete', ['resource' => 'product']),
            'icon' => 'icon trash-icon',
            'title' => trans('ui::app.datagrid.massaction.delete', ['resource' => 'product'])
        ]);
    }

    public function prepareMassActions()
    {
        $this->addMassAction([
            'type' => 'delete',
            'label' => trans('marketplace::app.admin.products.delete'),
            'action' => route('admin.marketplace.products.massdelete'),
            'method' => 'POST'
        ]);

        $this->addMassAction([
            'type' => 'update',
            'label' => trans('marketplace::app.admin.products.update'),
            'action' => route('admin.marketplace.products.massupdate'),
            'method' => 'POST',
            'options' => [
                trans('marketplace::app.admin.sellers.approve') => 1,
                trans('marketplace::app.admin.sellers.unapprove') => 0
            ]
        ]);
    }
}