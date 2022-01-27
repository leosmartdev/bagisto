@extends('admin::layouts.content')

@section('page_title')
    {{ __('marketplace::app.admin.sellers.add-title') }}
@stop

@section('content')
    <div class="content">
        <form method="POST" action="{{ route('admin.customer.store') }}" @submit.prevent="onSubmit">

            <div class="page-header">
                <div class="page-title">
                    <h1>
                        <i class="icon angle-left-icon back-link" onclick="history.length > 1 ? history.go(-1) : window.location = '{{ route('admin.dashboard.index') }}';"></i>

                        {{ __('marketplace::app.admin.sellers.add-title') }}

                        {{ Config::get('carrier.social.facebook.url') }}
                    </h1>
                </div>

                <div class="page-action">
                    <button type="submit" class="btn btn-lg btn-primary">
                        {{ __('marketplace::app.admin.sellers.save-btn-title') }}
                    </button>
                </div>
            </div>

            <div class="page-content">

                <div class="form-container">
                    @csrf()

                    {!! view_render_event('bagisto.admin.customers.create.before') !!}

                    <div class="control-group" :class="[errors.has('first_name') ? 'has-error' : '']">
                        <label for="first_name" class="required">{{ __('admin::app.customers.customers.first_name') }}</label>
                        <input type="text" class="control" name="first_name" v-validate="'required'" value="{{ old('first_name') }}" data-vv-as="&quot;{{ __('shop::app.customer.signup-form.firstname') }}&quot;">
                        <span class="control-error" v-if="errors.has('first_name')">@{{ errors.first('first_name') }}</span>
                    </div>

                    {!! view_render_event('bagisto.admin.customers.create.first_name.after') !!}

                    <div class="control-group" :class="[errors.has('last_name') ? 'has-error' : '']">
                        <label for="last_name" class="required">{{ __('admin::app.customers.customers.last_name') }}</label>
                        <input type="text" class="control" name="last_name" v-validate="'required'" value="{{ old('last_name') }}" data-vv-as="&quot;{{ __('shop::app.customer.signup-form.lastname') }}&quot;">
                        <span class="control-error" v-if="errors.has('last_name')">@{{ errors.first('last_name') }}</span>
                    </div>

                    {!! view_render_event('bagisto.admin.customers.create.last_name.after') !!}

                    <div class="control-group" :class="[errors.has('email') ? 'has-error' : '']">
                        <label for="email" class="required">{{ __('shop::app.customer.signup-form.email') }}</label>
                        <input type="email" class="control" name="email" v-validate="'required|email'" value="{{ old('email') }}" data-vv-as="&quot;{{ __('shop::app.customer.signup-form.email') }}&quot;">
                        <span class="control-error" v-if="errors.has('email')">@{{ errors.first('email') }}</span>
                    </div>

                    {!! view_render_event('bagisto.admin.customers.create.email.after') !!}

                    <div class="control-group" :class="[errors.has('gender') ? 'has-error' : '']">
                        <label for="gender" class="required">{{ __('admin::app.customers.customers.gender') }}</label>
                        <select name="gender" class="control" v-validate="'required'" data-vv-as="&quot;{{ __('admin::app.customers.customers.gender') }}&quot;">
                            <option value=""></option>
                            <option value="{{ __('admin::app.customers.customers.male') }}">{{ __('admin::app.customers.customers.male') }}</option>
                            <option value="{{ __('admin::app.customers.customers.female') }}">{{ __('admin::app.customers.customers.female') }}</option>
                            <option value="{{ __('admin::app.customers.customers.other') }}">{{ __('admin::app.customers.customers.other') }}</option>
                        </select>
                        <span class="control-error" v-if="errors.has('gender')">@{{ errors.first('gender') }}</span>
                    </div>

                    {!! view_render_event('bagisto.admin.customers.create.gender.after') !!}

                    <div class="control-group" :class="[errors.has('date_of_birth') ? 'has-error' : '']">
                        <label for="dob">{{ __('admin::app.customers.customers.date_of_birth') }}</label>
                        <input type="date" class="control" name="date_of_birth" v-validate="" value="{{ old('date_of_birth') }}"  data-vv-as="&quot;{{ __('admin::app.customers.customers.date_of_birth') }}&quot;">
                        <span class="control-error" v-if="errors.has('date_of_birth')">@{{ errors.first('date_of_birth') }}</span>
                    </div>

                    {!! view_render_event('bagisto.admin.customers.create.date_of_birth.after') !!}

                    <div class="control-group" :class="[errors.has('phone') ? 'has-error' : '']">
                        <label for="phone">{{ __('admin::app.customers.customers.phone') }}</label>
                        <input type="text" class="control" name="phone" value="{{ old('phone') }}" data-vv-as="&quot;{{ __('admin::app.customers.customers.phone') }}&quot;">
                        <span class="control-error" v-if="errors.has('phone')">@{{ errors.first('phone') }}</span>
                    </div>

                    {!! view_render_event('bagisto.admin.customers.create.phone.after') !!}


                    <input type="hidden" name="want_to_be_seller" value="1">

                    <seller-controls></seller-controls>

                    {!! view_render_event('bagisto.admin.customers.create.after') !!}
                </div>
            </div>
        </form>
    </div>
@stop


@push('scripts')

    <script type="text/x-template" id="seller-controls-template">

        <div class="seller-form-controls">

            <div class="control-group" :class="[errors.has('url') ? 'has-error' : '']" >
                <label for="url" class="required">{{ __('marketplace::app.shop.sellers.account.signup.shop_url') }}</label>

                <input type="text" class="control form-style" name="url" v-validate="'required|min:3'" min="3" value="{{ old('url') }}" data-vv-as="&quot;{{ __('marketplace::app.shop.sellers.account.signup.shop_url') }}&quot;" v-on:keyup="checkShopUrl($event.target.value)">

                <span class="control-info text-success" v-if="isShopUrlAvailable != null && isShopUrlAvailable">{{ __('marketplace::app.shop.sellers.account.signup.shop_url_available') }}</span>

                <span class="control-info text-danger" v-if="isShopUrlAvailable != null && !isShopUrlAvailable">{{ __('marketplace::app.shop.sellers.account.signup.shop_url_not_available') }}</span>

                <span class="control-error" v-if="errors.has('url')">@{{ errors.first('url') }}</span>
            </div>
        </div>

    </script>

    <script>

        Vue.component('seller-controls', {
            template: "#seller-controls-template",

            data: () => ({
                isShopUrlAvailable: null
            }),


            methods: {
                checkShopUrl (shopUrl) {
                    this_this = this;

                    if (shopUrl.length < 3) {
                        return;
                    }

                    this.$http.post("{{ route('marketplace.seller.url') }}", {'url': shopUrl})
                        .then(function(response) {
                            if (response.data.available) {
                                this_this.isShopUrlAvailable = true;

                                document.querySelectorAll(".btn-primary")[0].disabled = false;
                            } else {
                                this_this.isShopUrlAvailable = false;
                                document.querySelectorAll(".btn-primary")[0].disabled = true;
                            }
                        })
                        .catch(function (error) {
                            document.querySelectorAll(".btn-primary")[0].disabled = true;
                        })
                },

                toggleButtonDisable (value) {
                    var buttons = document.querySelectorAll(".btn-primary");

                    if (value == 1) {
                        buttons[0].disabled = true;
                    } else {
                        buttons[0].disabled = false;
                    }
                },
            }
        });

    </script>

    <style>
        .text-success {
            color: #4CAF50 !important;
        }

        .text-danger {
            color: #FC6868 !important;
        }
    </style>

@endpush