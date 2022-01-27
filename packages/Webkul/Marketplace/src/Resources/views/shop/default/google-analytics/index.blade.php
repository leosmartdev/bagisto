@if ($analyticsId = core()->getConfigData('marketplace.settings.google_analytics.google_analytics_id'))

<script async src="https://www.googletagmanager.com/gtag/js?id={{$analyticsId}}"></script>
<script>
  window.dataLayer = window.dataLayer || [];
  function gtag(){dataLayer.push(arguments);}
  gtag('js', new Date());

  gtag('config', "{{$analyticsId}}");
</script>
@endif

@if(core()->getConfigData('marketplace.settings.google_analytics.seller_google_analytics'))
    @php $analyticsids = app('Webkul\Marketplace\Repositories\SellerRepository')->findWhere([['google_analytics_id' ,'!=', null]]) @endphp
    @foreach ($analyticsids as $analyticsid)
        <script async src="https://www.googletagmanager.com/gtag/js?id={{$analyticsid->google_analytics_id}}"></script>
        <script>
        window.dataLayer = window.dataLayer || [];
        function gtag(){dataLayer.push(arguments);}
        gtag('js', new Date());

        gtag('config', "{{$analyticsid->google_analytics_id}}");
        </script>
    @endforeach
@endif