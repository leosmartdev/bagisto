<div class="col-lg-4 col-md-4 col-sm-12 pb-5 pb-sm-0">
    <div class="widget mb-2">
        <h4 class="widget-title pb-1">Customer Service</h4>
        <div class="row">
            @if ($velocityMetaData)
                {!! DbView::make($velocityMetaData)->field('footer_middle_content')->render() !!}
            @else
                <div class="col-lg-6 col-md-6">
                    <ul class="links">
                        <li>
                            <a href="{{ route('shop.cms.page', ['slug' => 'about-us']) }}">
                                {{ __('velocity::app.admin.meta-data.footer-middle.about-us') }}
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('shop.cms.page', ['slug' => 'cutomer-service']) }}">
                                {{ __('velocity::app.admin.meta-data.footer-middle.customer-service') }}
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('shop.cms.page', ['slug' => 'whats-new']) }}">
                                {{ __('velocity::app.admin.meta-data.footer-middle.whats-new') }}
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('shop.cms.page', ['slug' => 'contact-us']) }}">
                                {{ __('velocity::app.admin.meta-data.footer-middle.contact-us') }}
                            </a>
                        </li>
                    </ul>
                </div>
                <div class="col-lg-6 col-md-6">
                    <ul class="links">
                        <li>
                            <a href="{{ route('shop.cms.page', ['slug' => 'return-policy']) }}">
                            {{ __('velocity::app.admin.meta-data.footer-middle.order-and-returns') }}
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('shop.cms.page', ['slug' => 'payment-policy']) }}">
                                {{ __('velocity::app.admin.meta-data.footer-middle.payment-policy') }}
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('shop.cms.page', ['slug' => 'shipping-policy']) }}">
                                {{ __('velocity::app.admin.meta-data.footer-middle.shipping-policy') }}
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('shop.cms.page', ['slug' => 'privacy-policy']) }}">
                                {{ __('velocity::app.admin.meta-data.footer-middle.privacy-and-cookies-policy') }}
                            </a>
                        </li>
                    </ul>
                </div>
            @endif
        </div>
    </div><!-- End .widget -->
</div><!-- End .col-lg-3 -->