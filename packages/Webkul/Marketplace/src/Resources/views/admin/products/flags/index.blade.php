<accordian :title="'{{ __('marketplace::app.admin.products.flag.flag-title') }}'" :active="'true'">
    <div slot="body">
        {!! app('Webkul\Marketplace\DataGrids\Admin\ProductFlagDataGrid')->render() !!}
    </div>
</accordian>