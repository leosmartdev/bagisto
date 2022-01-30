<!-- <script
    type="text/javascript"
    src="{{ asset('themes/velocity/assets/js/velocity-core.js') }}">
</script> -->

<script type="text/javascript">
    (() => {
        /* activate session messages */
        let message = @json($velocityHelper->getMessage());
        if (message.messageType && message.message !== '') {
            window.showAlert(message.messageType, message.messageLabel, message.message);
        }

        /* activate server error messages */
        window.serverErrors = [];
        @if (isset($errors))
            @if (count($errors))
                window.serverErrors = @json($errors->getMessages());
            @endif
        @endif

        /* add translations */
        window._translations = @json($velocityHelper->jsonTranslations());
    })();
</script>

<script>
    WebFontConfig = {
        google: { families: ['Open+Sans:300,400,600,700', 'Poppins:300,400,500,600,700,800', 'Playfair+Display:900', 'Shadows+Into+Light:400'] }
    };
    (function (d) {
        var wf = d.createElement('script'), s = d.scripts[0];
        wf.src = 'tactical/assets/js/webfont.js';
        wf.async = true;
        s.parentNode.insertBefore(wf, s);
    })(document);
</script>

<!-- Plugins JS File -->
<script src="{{ asset('tactical/assets/js/jquery.min.js') }}"></script>
<script src="{{ asset('tactical/assets/js/bootstrap.bundle.min.js') }}"></script>
<script src="{{ asset('tactical/assets/js/plugins.min.js') }}"></script>
<script src="{{ asset('tactical/assets/js/nouislider.min.js') }}"></script>

<!-- Main JS File -->
<script src="{{ asset('tactical/assets/js/main.min.js') }}"></script>

@stack('scripts')

<script>
    {!! core()->getConfigData('general.content.custom_scripts.custom_javascript') !!}
</script>