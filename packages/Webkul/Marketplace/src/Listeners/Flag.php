<?php

namespace Webkul\Marketplace\Listeners;


use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Event;

/**
 * Flag event handler
 *
 * @author   Mohammad Asif <mohdasif.woocommerce337@webkul.com>
 * @copyright 2018 Webkul Software Pvt Ltd (http://www.webkul.com)
 */
class Flag
{

    /**
     * Create a new customer event listener instance.
     *
     * @param  Webkul\Marketplace\Repositories\RefundRepository $refund
     * @return void
     */
    // public function __construct(
    //     RefundRepository $refund
    // )
    // {
    //     $this->refund = $refund;
    // }

    public function productFlags ($product) {

        return view('marketplace::shop.flags.flags-accordian');
    }
}