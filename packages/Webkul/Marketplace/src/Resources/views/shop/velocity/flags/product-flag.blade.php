@php
    $productRepository = app('Webkul\Marketplace\Repositories\ProductRepository');
    $seller = $productRepository->getSellerByProductId($product->product->id) ;
    $productFlags = app('Webkul\Marketplace\Repositories\ProductFlagReasonRepository')->findWhere(['status' => 1]);

    if ($seller) {
        $sellerProducts = $productRepository->findAllBySeller($seller);
    }

@endphp

@if ($seller)
<section class="mt-5 mb-5 report-section">
    <div class="row">
        <div class="col-lg-6 col-md-6 col-sm-12 col-12">
            <div class="row">
                <div class="col-lg-4 col-md-4 col-sm-4 col-4">
                    <div class="seller-logo">
                        <a href="{{route('marketplace.seller.show', $seller->url)}}">
                            <img class="img-fluid" src="{{asset($seller->logo_url)}}" alt="">
                        </a>
                    </div>
                </div>
                <div class="col-lg-8 col-md-8 col-sm-8 col-8">
                    <div class="seller-flag-info">
                        <div class="seller-store-name">
                            <a href="{{route('marketplace.seller.show', $seller->url)}}">{{$seller->shop_title}}</a>
                        </div>
                        <div class="seller-location">    <a target="_blank" href="https://www.google.com/maps/place/{{ $seller->city . ', '. $seller->state . ', ' . core()->country_name($seller->country) }}" class="shop-address"><i class="material-icons">location_on</i> {{ $seller->city . ', '. $seller->state . ' (' . core()->country_name($seller->country) . ')' }}</a></div>
                        <div class="contact-seller">    <a href="#" @click="showModal('contactForm')">{{ __('marketplace::app.shop.sellers.profile.contact-seller') }}</a></div>
                        <div class="report-flag">
                            <a href="javascript:void(0);"  @click="showModal('reportFlag')">
                                <i class="material-icons">flag</i>
                                {{core()->getConfigData('marketplace.settings.product_flag.text')}}
                            </a>
                            <modal id="reportFlag" :is-open="modalIds.reportFlag">
                                <h3 slot="header">
                                    {{ __('marketplace::app.shop.flag.title') }}
                                </h3>

                                <div slot="body">
                                    <product-flag-form></product-flag-form>
                                </div>
                            </modal>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-6 col-md-6 col-sm-12 col-12 report-seller-products">
            <div class="row">
                @foreach ($sellerProducts->take(5) as $sellerProduct)
                    @if ($sellerProduct->product->url_key)
                    <div class="seller-product-col-2">
                        <div class="seller-flag-product">
                            <a title="{{ $sellerProduct->product->name }}" href="{{route('shop.productOrCategory.index', $sellerProduct->product->url_key)}}">
                                <img class="img-fluid" src="{{productimage()->getProductBaseImage($sellerProduct->product)['small_image_url']}}" alt="">
                            </a>
                        </div>
                    </div>
                    @endif
                @endforeach
                <div class="seller-product-col-2">
                    <div class="seller-flag-product">
                        <a href="{{route('marketplace.products.index', $seller->url)}}"> <span> View all {{$sellerProducts->count()}} products </span> </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>


<modal id="contactForm" :is-open="modalIds.contactForm">
    <h3 style="margin-left: 80px;" slot="header">{{ __('marketplace::app.shop.sellers.profile.contact-seller') }}</h3>

    <i class="icon remove-icon "></i>

    <div slot="body">
        <contact-seller-form></contact-seller-form>
    </div>
</modal>

@push('scripts')

    <script type="text/x-template" id="flag-form-template">
        <form method="POST"  action="{{route('marketplace.flag.product.store')}}"   v-on:submit.prevent="onSubmit">
            @csrf()

            <input type="hidden" name="product_id" value="{{ $product->product->id }}">

            <div class="control-group" :class="[errors.has('name') ? 'has-error' : '']">
                <label for="name" class="required label-style">{{ __('marketplace::app.shop.flag.name') }}</label>
                <input v-validate="'required'" type="text" class="form-style" id="name" name="name" data-vv-as="&quot;{{ __('marketplace::app.shop.flag.name') }}&quot;" value="{{ old('name') }}"/>
                <span class="control-error" v-if="errors.has('name')">@{{ errors.first('name') }}</span>
            </div>

            <div class="control-group" :class="[errors.has('email') ? 'has-error' : '']">
                <label for="type" class="required label-style">{{ __('marketplace::app.shop.flag.email') }}</label>
               <input type="email" v-validate="'required'" class="form-style" id="email" name="email" data-vv-as="&quot;{{ __('marketplace::app.shop.flag.email') }}&quot;" value="{{ old('email') }}" />
                <span class="control-error" v-if="errors.has('email')">@{{ errors.first('email') }}</span>
            </div>

            <div class="control-group" :class="[errors.has('reason') ? 'has-error' : '']">
                <label for="reason" class="label-style">{{ __('marketplace::app.shop.flag.reason') }}</label>

                <select name="reason" id="reason" v-model="reason" class="form-style" >
                    @foreach ($productFlags as $flag)
                        <option value="{{$flag->reason}}">{{$flag->reason}}</option>
                    @endforeach
                    <option value="other">Other</option>
                </select>
                @if (core()->getConfigData('marketplace.settings.product_flag.other_reason'))
                <textarea class="form-style mt-3" v-validate="'required'" id="other-reason" v-if="reason == 'other'" placeholder="{{core()->getConfigData('marketplace.settings.product_flag.other_placeholder')}}" name="reason" data-vv-as="&quot;{{ __('marketplace::app.shop.flag.reason') }}&quot;" value="{{ old('reason') }}"
                ></textarea>
                @endif
                <span class="control-error" v-if="errors.has('reason')">@{{ errors.first('reason') }}</span>
            </div>

            <div class="mt-5">
                @if (core()->getConfigData('marketplace.settings.product_flag.guest_can'))
                <button type="submit" class="btn btn-lg btn-primary theme-btn">
                    {{ __('marketplace::app.shop.flag.submit') }}
                </button>
                @else
                    <a href="{{route('customer.session.index')}}" class="btn btn-lg btn-primary theme-btn"> {{ __('marketplace::app.shop.flag.submit') }}</a>
                @endif
            </div>

        </form>
    </script>

    <script type="text/x-template" id="contact-form-template">

        <form action="" class="account-table-content" method="POST" data-vv-scope="contact-form" @submit.prevent="contactSeller('contact-form')">

            @csrf

            <div class="form-container">

                <div class="form-group" :class="[errors.has('contact-form.name') ? 'has-error' : '']">
                    <label for="name" class="required mandatory">{{ __('marketplace::app.shop.sellers.profile.name') }}</label>
                    <input type="text" v-model="contact.name" class="form-style control" name="name" v-validate="'required'" data-vv-as="&quot;{{ __('marketplace::app.shop.sellers.profile.name') }}&quot;">
                    <span class="control-error" v-if="errors.has('contact-form.name')">@{{ errors.first('contact-form.name') }}</span>
                </div>

                <div class="form-group" :class="[errors.has('contact-form.email') ? 'has-error' : '']">
                    <label for="email" class="required mandatory">{{ __('marketplace::app.shop.sellers.profile.email') }}</label>
                    <input type="text" v-model="contact.email" class="form-style control" name="email" v-validate="'required|email'" data-vv-as="&quot;{{ __('marketplace::app.shop.sellers.profile.email') }}&quot;">
                    <span class="control-error" v-if="errors.has('contact-form.email')">@{{ errors.first('contact-form.email') }}</span>
                </div>

                <div class="form-group" :class="[errors.has('contact-form.subject') ? 'has-error' : '']">
                    <label for="subject" class="required mandatory">{{ __('marketplace::app.shop.sellers.profile.subject') }}</label>
                    <input type="text" v-model="contact.subject" class="control form-style" name="subject" v-validate="'required'" data-vv-as="&quot;{{ __('marketplace::app.shop.sellers.profile.subject') }}&quot;">
                    <span class="control-error" v-if="errors.has('contact-form.subject')">@{{ errors.first('contact-form.subject') }}</span>
                </div>

                <div class="form-group" :class="[errors.has('contact-form.query') ? 'has-error' : '']">
                    <label for="query" class="required mandatory">{{ __('marketplace::app.shop.sellers.profile.query') }}</label>
                    <textarea class="control form-style" v-model="contact.query" name="query" v-validate="'required'"  data-vv-as="&quot;{{ __('marketplace::app.shop.sellers.profile.query') }}&quot;">
                    </textarea>
                    <span class="control-error" v-if="errors.has('contact-form.query')">@{{ errors.first('contact-form.query') }}</span>
                </div>

                <button type="submit" class="btn btn-lg btn-primary theme-btn" :disabled="disable_button">
                    {{ __('marketplace::app.shop.sellers.profile.submit') }}
                </button>

            </div>

        </form>

    </script>

    <script>
        Vue.component('contact-seller-form', {

            data: () => ({
                contact: {
                    'name': '',
                    'email': '',
                    'subject': '',
                    'query': ''
                },

                disable_button: false,
            }),

            template: '#contact-form-template',

            created () {

                @auth('customer')
                    @if(auth('customer')->user())
                        this.contact.email = "{{ auth('customer')->user()->email }}";
                        this.contact.name = "{{ auth('customer')->user()->first_name }} {{ auth('customer')->user()->last_name }}";
                    @endif
                @endauth

            },

            methods: {
                contactSeller (formScope) {
                    var this_this = this;

                    this_this.disable_button = true;

                    this.$validator.validateAll(formScope).then((result) => {
                        if (result) {

                            this.$http.post ("{{ route('marketplace.seller.contact', $seller->url) }}", this.contact)
                                .then (function(response) {
                                    this_this.disable_button = false;

                                    this_this.$parent.closeModal();

                                    window.flashMessages = [{
                                        'type': 'alert-success',
                                        'message': response.data.message
                                    }];

                                    this_this.$root.addFlashMessages()
                                })

                                .catch (function (error) {
                                    this_this.disable_button = false;

                                    this_this.handleErrorResponse(error.response, 'contact-form')
                                })
                        } else {
                            this_this.disable_button = false;
                        }
                    });
                },

                handleErrorResponse (response, scope) {
                    if (response.status == 422) {
                        serverErrors = response.data.errors;
                        this.$root.addServerErrors(scope)
                    }
                }
            }
        });

    </script>


    <script>

        Vue.component('product-flag-form', {

        data: () => ({
            reason: ''
        }),

        template: '#flag-form-template',
        });
    </script>
@endpush

@endif

