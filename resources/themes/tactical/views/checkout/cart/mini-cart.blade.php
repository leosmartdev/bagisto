<div class="mini-cart-container pull-right">
    <mp-mini-cart
         is-tax-inclusive="{{ Webkul\Tax\Helpers\Tax::isTaxInclusive() }}"
         view-cart-route="{{ route('shop.checkout.cart.index') }}"
         checkout-route="{{ route('shop.checkout.onepage.index') }}"
         check-minimum-order-route="{{ route('shop.checkout.check-minimum-order') }}"
         cart-text="{{ __('shop::app.minicart.cart') }}"
         view-cart-text="{{ __('shop::app.minicart.view-cart') }}"
         checkout-text="{{ __('shop::app.minicart.checkout') }}"
         subtotal-text="{{ __('shop::app.checkout.cart.cart-subtotal') }}">
     </mp-mini-cart>
 </div>

 @push('scripts')
 <script type="text/x-template" id="mp-mini-cart-template">
    <div :class="`dropdown ${cartItems.length > 0 ? '' : 'disable-active'}`">
        <mini-cart-button
            :item-count="cartItems.length"
            :cart-text="cartText"
        ></mini-cart-button>

        <div
            id="cart-modal-content"
            v-if="cartItems.length > 0"
            class="modal-content sensitive-modal cart-modal-content hide"
        >
            <div class="mini-cart-container">
                <div
                    class="row small-card-container"
                    :key="index"
                    v-for="(item, index) in cartItems"
                >
                    <div class="col-3 product-image-container mr15">
                        <a @click="removeProduct(item.id)">
                            <span class="rango-close"></span>
                        </a>

                        <a
                            class="unset"
                            :href="`${$root.baseUrl}/${item.url_key}`"

                        >


                        <div
                            class="product-image"
                            :style="
                                `background-image: url(${$root.baseUrl}/${'storage/'+sellerInfo[item.product_id]['image']['0']['path']});`
                            "
                            v-if = "item.additional.seller_info"

                        ></div>

                    <div
                        class="product-image"
                        :style="
                            `background-image: url(${item.images.medium_image_url});`
                        "
                        v-else
                    ></div>

                        </a>
                    </div>
                    <div class="col-9 no-padding card-body align-vertical-top">
                        <div class="no-padding">
                            <div
                                class="fs16 text-nowrap fw6"
                                v-html="item.name"
                            ></div>

                            <div v-if="sellerInfo" class="seller-info" :id ="`mini-cart-seller-info-${item.id}`" style="margin-bottom: 10px;">
                                <div v-if="sellerInfo[item.product_id]['seller'] != 0" >
                                    Sold By : <a :href="`${$root.baseUrl}/marketplace/seller/profile/${sellerInfo[item.product_id]['seller'].url}`">@{{sellerInfo[item.product_id]['seller']['shop_title']}} [<i class="material-icons" style="width: 12px; font-size: 10px;">star_rate</i>@{{sellerInfo[item.product_id]['rating']}}]</a>
                                </div>
                             </div>

                            <div class="fs18 card-current-price fw6">
                                <div class="display-inbl">
                                    <label class="fw5">@{{
                                        __('checkout.qty')
                                    }}</label>
                                    <input
                                        type="text"
                                        disabled
                                        :value="item.quantity"
                                        class="ml5"
                                    />
                                </div>
                                <span class="card-total-price fw6">
                                    @{{
                                        isTaxInclusive == '1'
                                            ? item.base_total_with_tax
                                            : item.base_total
                                    }}
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="modal-footer">
                <h5 class="col-6 text-left fw6">
                   @{{ subtotalText }}
                </h5>

                <h5 class="col-6 text-right fw6 no-padding">
                    @{{
                        isTaxInclusive == '1'
                            ? cartInformation.base_grand_total
                            : cartInformation.base_sub_total
                    }}
                </h5>
            </div>

            <div class="modal-footer">
                <a
                    class="col text-left fs16 link-color remove-decoration"
                    :href="viewCartRoute"
                    >@{{ viewCartText }}</a
                >

                <div class="col text-right no-padding">
                    <a :href="checkoutRoute" @click="checkMinimumOrder($event)">
                        <button type="button" class="theme-btn fs16 fw6">
                            @{{ checkoutText }}
                        </button>
                    </a>
                </div>
            </div>
        </div>
    </div>
 </script>

 <script>
    Vue.component('mp-mini-cart', {
        template: '#mp-mini-cart-template',
         props: [
            'isTaxInclusive',
            'viewCartRoute',
            'checkoutRoute',
            'checkMinimumOrderRoute',
            'cartText',
            'viewCartText',
            'checkoutText',
            'subtotalText'
         ],

         data: function () {
             return {
                 cartItems: [],
                 cartInformation: [],
                 sellerInfo: '',
                 sellerProduct: false
             }
         },

         mounted: function () {
             this.getMiniCartDetails();
         },

         watch: {
             '$root.miniCartKey': function () {
                 this.getMiniCartDetails();
             }
         },

         methods: {
             getMiniCartDetails: function () {
                 this.$http.get(`${this.$root.baseUrl}/mini-cart`)
                 .then(response => {
                     if (response.data.status) {
                        this.cartItems = response.data.mini_cart.cart_items;
                        this.cartInformation = response.data.mini_cart.cart_details;
                        this.getSellerInfo()
                     }
                 })
                 .catch(exception => {
                     console.log(this.__('error.something_went_wrong'));
                 });
             },

             getSellerInfo: function () {

                 this.$http.post(`${this.$root.baseUrl}/marketplace/seller-info`, this.cartItems)
                 .then(response => {
                     if (response.status == 200) {
                        this.sellerInfo = response.data;
                        console.log()
                     }
                 })
                 .catch(exception => {

                     console.log(this.__('error.something_went_wrong'));
                 });
             },

             removeProduct: function (productId) {
                 this.$http.delete(`${this.$root.baseUrl}/cart/remove/${productId}`)
                 .then(response => {
                     this.cartItems = this.cartItems.filter(item => item.id != productId);

                     window.showAlert(`alert-${response.data.status}`, response.data.label, response.data.message);
                 })
                 .catch(exception => {
                     console.log(this.__('error.something_went_wrong'));
                 });
             },

            checkMinimumOrder: function(e) {
                e.preventDefault();

                this.$http.post(this.checkMinimumOrderRoute).then(({ data }) => {
                    if (!data.status) {
                        window.showAlert(`alert-warning`, 'Warning', data.message);
                    } else {
                        window.location.href = this.checkoutRoute;
                    }
                });
              }
         }
     });
 </script>
 @endpush