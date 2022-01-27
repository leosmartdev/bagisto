<?php

namespace Webkul\Marketplace\DataGrids\Admin;

use DB;
use Webkul\Ui\DataGrid\DataGrid;

/**
 * Seller Data Grid class
 *
 * @author Jitendra Singh <jitendra@webkul.com>
 * @copyright 2018 Webkul Software Pvt Ltd (http://www.webkul.com)
 */
class ProductFlagDataGrid extends DataGrid
{
    /**
     *
     * @var integer
     */
    public $index = 'id';

    protected $sortOrder = 'desc'; //asc or desc

    public function prepareQueryBuilder()
    {
        $queryBuilder = DB::table('marketplace_product_flags')

                ->select('marketplace_product_flags.id', 'marketplace_product_flags.reason', 'marketplace_product_flags.name', 'marketplace_product_flags.email');

        $this->addFilter('reason', 'marketplace_product_flags.reason' );
        $this->addFilter('email', 'marketplace_product_flags.email' );
        $this->addFilter('name', 'marketplace_product_flags.name' );
        $this->addFilter('id', 'marketplace_product_flags.id');
        $this->addFilter('created_at', 'marketplace_product_flags.created_at');

        $this->setQueryBuilder($queryBuilder);
    }

    public function addColumns()
    {
        $this->addColumn([
            'index' => 'id',
            'label' => trans('marketplace::app.admin.sellers.id'),
            'type' => 'number',
            'searchable' => false,
            'sortable' => true,
            'filterable' => false
        ]);

        $this->addColumn([
            'index' => 'name',
            'label' => trans('marketplace::app.admin.flag.name'),
            'type' => 'string',
            'searchable' => true,
            'sortable' => true,
            'filterable' => false
        ]);

        $this->addColumn([
            'index' => 'email',
            'label' => trans('marketplace::app.admin.flag.email'),
            'type' => 'string',
            'searchable' => true,
            'sortable' => true,
            'filterable' => false
        ]);

        $this->addColumn([
            'index' => 'reason',
            'label' => trans('marketplace::app.admin.products.flag.reason'),
            'type' => 'string',
            'searchable' => true,
            'sortable' => true,
            'filterable' => false,
            'closure' => true,
        ]);

    }
}