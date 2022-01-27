<div class="profile-left-block">

    <div class="content">

        <div class="profile-logo-block">
            @if ($logo = $seller->logo_url)
                <img src="{{ $logo }}" />
            @else
                <img src="{{ asset('themes/velocity/assets/images/default-velocity-logo.png') }}" />
            @endif
        </div>

        <div class="profile-information-block">

            <div class="row">

                @if (request()->route()->getName() != 'marketplace.seller.show')

                    <a href="{{ route('marketplace.seller.show', $seller->url) }}" class="shop-title">{{ $seller->shop_title }}</a>

                    @if (! is_null($seller->shop_title))
                        <label class="shop-address">{{ $seller->city . ', '. $seller->state . ' (' . core()->country_name($seller->country) . ')' }}</label>
                    @endif

                @else

                    <h2 class="shop-title">{{ $seller->shop_title }}</h2>

                    @if ($seller->country)
                        <a target="_blank" href="https://www.google.com/maps/place/{{ $seller->city . ', '. $seller->state . ', ' . core()->country_name($seller->country) }}" class="shop-address">{{ $seller->city . ', '. $seller->state . ' (' . core()->country_name($seller->country) . ')' }}</a>
                    @endif

                @endif

            </div>

            <div class="row social-links" style="margin-bottom: 5px;">
                @if ($seller->facebook)
                    <a href="https://www.facebook.com/{{$seller->facebook}}" target="_blank">
                        <i class="icon social-icon mp-facebook-icon"></i>
                    </a>
                @endif

                @if ($seller->twitter)
                    <a href="https://www.twitter.com/{{$seller->twitter}}" target="_blank">
                        <i class="icon social-icon mp-twitter-icon"></i>
                    </a>
                @endif

                @if ($seller->instagram)
                    <a href="https://www.instagram.com/{{$seller->instagram}}" target="_blank"><i class="icon social-icon mp-instagram-icon"></i></a>
                @endif

                @if ($seller->pinterest)
                    <a href="https://www.pinterest.com/{{$seller->pinterest}}" target="_blank"><i class="icon social-icon mp-pinterest-icon"></i></a>
                @endif

                @if ($seller->skype)
                    <a href="https://www.skype.com/{{$seller->skype}}" target="_blank">
                        <i class="icon social-icon mp-skype-icon"></i>
                    </a>
                @endif

                @if ($seller->linked_in)
                    <a href="https://www.linkedin.com/{{$seller->linked_in}}" target="_blank">
                        <i class="icon social-icon mp-linked-in-icon"></i>
                    </a>
                @endif

                @if ($seller->youtube)
                    <a href="https://www.youtube.com/{{$seller->youtube}}" target="_blank">
                        <i class="icon social-icon mp-youtube-icon"></i>
                    </a>
                @endif
            </div>

            <div class="row">

                <?php $reviewRepository = app('Webkul\Marketplace\Repositories\ReviewRepository') ?>

                <?php $productRepository = app('Webkul\Marketplace\Repositories\ProductRepository') ?>

                <div class="review-info">
                    <span class="number">
                        {{ $reviewRepository->getAverageRating($seller) }}
                    </span>

                    <div class="star-review">
                        <star-ratings
                            ratings="{{ ceil($reviewRepository->getAverageRating($seller)) }}"
                        push-class="mr5"
                        ></star-ratings>
                    </div>

                    <div class="total-reviews">
                        <a href="{{ route('marketplace.reviews.index', $seller->url) }}">
                            {{
                                __('marketplace::app.shop.sellers.profile.total-rating', [
                                        'total_rating' => $reviewRepository->getTotalRating($seller),
                                        'total_reviews' => $reviewRepository->getTotalReviews($seller),
                                    ])
                            }}
                        </a>
                    </div>
                </div>
            </div>


        </div>
    </div>
</div>

