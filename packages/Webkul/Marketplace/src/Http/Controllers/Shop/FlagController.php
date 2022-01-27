<?php

namespace Webkul\Marketplace\Http\Controllers\Shop;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Webkul\Marketplace\Repositories\ProductFlagRepository;
use Webkul\Marketplace\Repositories\SellerFlagRepository;

/**
 * Marketplace flag controller
 *
 * @author    Mohammad Asif <mohdasif.woocommerce337@webkul.com>
 * @copyright 2020 Webkul Software Pvt Ltd (http://www.webkul.com)
 */
class FlagController extends Controller
{
    /**
     * Contains route related configuration
     *
     * @var array
     */
    protected $_config;

    /**
     * productFlagRepository object
     *
     *  @object
     */
    protected $productFlagRepository;

    /**
     * sellerFlagRepository object
     *
     * @var array
     */
    protected $sellerFlagRepository;

    /**
     * Create a new controller instance.
     *
     * @param  Webkul\Marketplace\Repositories\ProductFlagRepository $productFlagRepository
     * @param  Webkul\Marketplace\Repositories\SellerFlagRepository $sellerFlagRepository
     * @return void
     */
    public function __construct(
        SellerFlagRepository $sellerFlagRepository,
        ProductFlagRepository $productFlagRepository
    )
    {
        $this->_config = request('_config');

        $this->productFlagRepository = $productFlagRepository;

        $this->sellerFlagRepository = $sellerFlagRepository;
    }



    /**
     * Store a newly created resource in storage.
     *
     * @param  string  $url
     * @return \Illuminate\Http\Response
     */
    public function productFlagstore()
    {

        $this->validate(request(), [
            'name' => 'required',
            'email' => 'required|unique:marketplace_product_flags'
        ]);

        $data = request()->all();

        $this->productFlagRepository->create($data);

        session()->flash('success', 'Product has been reported successfully.');

        return redirect()->back();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function sellerFlagstore()
    {

        $this->validate(request(), [
            'name' => 'required',
            'email' => 'required|unique:marketplace_seller_flags'
        ]);

        $data = request()->all();

        $this->sellerFlagRepository->create($data);

        session()->flash('success', 'Seller has been reported successfully.');

        return redirect()->back();
    }
}