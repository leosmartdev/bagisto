<?php

namespace Webkul\Marketplace\Http\Controllers\Shop\Account;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Webkul\Marketplace\Http\Controllers\Shop\Controller;
use Webkul\Marketplace\Repositories\SellerRepository;

/**
 * Marketplace review controller
 *
 * @author    Jitendra Singh <jitendra@webkul.com>
 * @copyright 2018 Webkul Software Pvt Ltd (http://www.webkul.com)
 */
class CustomerController extends Controller
{
    /**
     * Contains route related configuration
     *
     * @var array
     */
    protected $_config;

    /**
     *
     * @var mixed
     */
    protected $sellerRepository;

    /**
     * Create a new controller instance.
     *
     * @param  Webkul\Marketplace\Repositories\SellerRepository $sellerRepository
     * @return void
     */
    public function __construct(
        SellerRepository $sellerRepository
    )
    {
        $this->sellerRepository = $sellerRepository;

        $this->_config = request('_config');
    }

    /**
     * Method to populate the seller review page which will be populated.
     *
     * @return Mixed
     */
    public function index()
    {
        return view($this->_config['view']);
    }

    /**
     * Method to populate the seller customer order page which will be populated.
     *
     * @return Mixed
     */
    public function orders($customerId)
    {

        return view($this->_config['view'], compact('customerId'));
    }
}