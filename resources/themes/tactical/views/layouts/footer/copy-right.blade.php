<div class="container">
    <div class="footer-bottom d-sm-flex align-items-center">
        <div class="footer-left">
            <span class="footer-copyright">
                Copyright© True Tactical Store<br>All Rights Reserved
                <!-- @if (core()->getConfigData('general.content.footer.footer_content'))
                    {!! core()->getConfigData('general.content.footer.footer_content') !!}
                @else
                    {!! trans('admin::app.footer.copy-right') !!}
                @endif -->
            </span>
        </div>

        <div class="footer-right ml-auto mt-1 mt-sm-0">
            <div class="payment-icons mr-0">
                <span class="visa_part">
                    <img class="social_footer_icon_visa" src="{{ asset('tactical/assets/images/payment_icons/Visa.png') }}">
                </span>
                <span class = "master_part">
                    <img class="social_footer_icon_master" src="{{ asset('tactical/assets/images/payment_icons/Mastercard.png') }}">
                </span>
                <span class="paypal_part">
                    <img class="social_footer_icon_paypal" src="{{ asset('tactical/assets/images/payment_icons/Paypal.png') }}">
                </span>
                <span class="stripe_part">
                    <img class="social_footer_icon_stripe" src="{{ asset('tactical/assets/images/payment_icons/Stripe.png') }}">
                </span>
                <span class="verisign_part">
                    <img class="social_footer_icon_verisign" src="{{ asset('tactical/assets/images/payment_icons/Verisign.png') }}">
                </span>
            </div>
        </div>
    </div>
</div><!-- End .footer-bottom -->
