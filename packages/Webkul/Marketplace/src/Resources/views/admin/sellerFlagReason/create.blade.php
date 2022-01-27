@extends('marketplace::admin.layouts.content')

@section('page_title')
    {{ __('marketplace::app.admin.sellers.flag.create.add-title') }}
@stop

@section('content')

    <div class="content">
        <form method="POST" action="{{ route('marketplace.admin.seller.flag.reason.store') }}" @submit.prevent="onSubmit">

            <div class="page-header">
                <div class="page-title">
                    <h1>
                        <i class="icon angle-left-icon back-link" onclick="history.length > 1 ? history.go(-1) : window.location = '{{ route('admin.dashboard.index') }}';"></i>

                        {{ __('marketplace::app.admin.sellers.flag.create.add-title') }}
                    </h1>
                </div>

                <div class="page-action">
                    <button type="submit" class="btn btn-lg btn-primary">
                        {{ __('marketplace::app.admin.sellers.flag.create.create-btn-title') }}
                    </button>
                </div>
            </div>

            <div class="page-content">

                <div class="form-container">
                    @csrf()

                    {!! view_render_event('marketplace.admin.seller.flag.before') !!}

                        <div slot="body">
                            <div class="control-group">
                                <label for="status" class="required">{{ __('marketplace::app.admin.sellers.flag.create.status') }}</label>
                                <label class="switch">
                                    <input type="hidden" name="status" value="0" />
                                    <input type="checkbox" id="status" name="status" value="1" >
                                    <span class="slider round"></span>
                                </label>
                            </div>

                            <div class="control-group" :class="[errors.has('reason') ? 'has-error' : '']">
                                <label for="page_title" class="required">{{ __('marketplace::app.admin.sellers.flag.create.reason') }}</label>

                                <input type="text" class="control" name="reason" v-validate="'required'" value="{{ old('reason') }}" data-vv-as="&quot;{{ __('marketplace::app.admin.sellers.flag.create.reason') }}&quot;">

                                <span class="control-error" v-if="errors.has('reason')">@{{ errors.first('reason') }}</span>
                            </div>
                        </div>


                    {!! view_render_event('marketplace.admin.seller.flag.after') !!}
                </div>
            </div>
        </form>
    </div>

@stop

