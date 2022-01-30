<footer class="footer bg-dark position-relative">
    <div class="footer-middle">

        @include('shop::layouts.footer.footer-links')

    </div><!-- End .footer-middle -->

    @if (core()->getConfigData('general.content.footer.footer_toggle'))
    @endif

    @include('shop::layouts.footer.copy-right')
</footer><!-- End .footer -->
