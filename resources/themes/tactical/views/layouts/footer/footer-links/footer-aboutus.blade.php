<div class="col-lg-4 col-md-4 col-sm-12 pb-5 pb-sm-0">
    <div class="widget">
        <!-- <h4 class="widget-title">About Us</h4> -->
        <a href="{{ route('shop.home.index') }}">
            @if ($logo = core()->getCurrentChannel()->logo_url)
                <img
                    src="{{ $logo }}"
                    class="logo-footer" alt="Logo" />
            @else
                <img
                    src="{{ asset('tactical/assets/images/logo-footer.png') }}"
                    class="logo-footer" alt="Logo" />
            @endif
        </a>
        <p class="m-b-4 ls-0">
            @if ($velocityMetaData)
                {!! $velocityMetaData->footer_left_content !!}
            @else
                {!! __('velocity::app.admin.meta-data.footer-left-raw-content') !!}
            @endif
        </p>
        <div class="social-icons">
            <a href="#" class="social-icon social-facebook icon-facebook" target="_blank">
            </a>
            <a href="#" class="social-icon" target="_blank" title="Line">
                <img style="width: 20px;" src="{{ asset('tactical/assets/images/icons/Line.png') }}">
            </a>
            <a href="#" class="social-icon" target="_blank" title="Line">
                <img style="width: 20px;" src="{{ asset('tactical/assets/images/icons/Tiktok.png') }}">
            </a>
            <a href="#" class="social-icon" target="_blank" title="Line">
                <img style="width: 20px;" src="{{ asset('tactical/assets/images/icons/Youtube.png') }}">
            </a>
        </div><!-- End .social-icons -->
    </div><!-- End .widget -->
</div><!-- End .col-lg-3 -->