@extends('shop::layouts.master')

@section('page_title')
    {{ $page->page_title }}
@endsection

@section('head')
    @isset($page->meta_title)
        <meta name="title" content="{{ $page->meta_title }}" />
    @endisset

    @isset($page->meta_description)
        <meta name="description" content="{{ $page->meta_description }}" />
    @endisset

    @isset($page->meta_keywords)
        <meta name="keywords" content="{{ $page->meta_keywords }}" />
    @endisset
@endsection

@section('full-content-wrapper')
    <div class="page-header page-header-bg"
        style="background-image: url({{ asset('tactical/assets/images/demoes/demo7/banners/banner-top.jpg') }});">
        <div class="container text-left">
            <h1 class="font4 text-white"><span class="text-white">SUCCESS WAY OF</span>OUR HISTORY</h1>
        </div><!-- End .container -->
    </div><!-- End .page-header -->

    <nav aria-label="breadcrumb" class="breadcrumb-nav">
        <div class="container">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="index.html">Home</a></li>
                <li class="breadcrumb-item active" aria-current="page">About Us</li>
            </ol>
        </div><!-- End .container -->
    </nav>

    <div class="about-section">
        <div class="container">
            <h2 class="title">ABOUT US</h2>
            <p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been
                the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley
                of type and scrambled it to make a type specimen book. It has survived not only five centuries,
                but also the leap into electronic typesetting, remaining essentially unchanged. It was
                popularised in the 1960s with the release of Letraset sheets containing.</p>
        </div><!-- End .container -->
    </div><!-- End .about-section -->

    <div class="brands-container brands-container-alt">
        <div class="container">
            <div class="brands-slider owl-carousel owl-theme  nav-outer" data-owl-options="{
                'margin': 50,
                'nav': false,
                'center': false,
                'responsive': {
                    '480': {
                        'items': 2
                    },
                    '576': {
                        'items': 3
                    },
                    '768': {
                        'items': 4
                    },
                    '991': {
                        'items': 4
                    },
                    '1200': {
                        'items': 5,
                        'nav': true
                    }
                }
            }">
                <img src="{{ asset('tactical/assets/images/demoes/demo10/logoes/logo-1.png') }}" width="245" height="45" alt="logo">
                <img src="{{ asset('tactical/assets/images/demoes/demo10/logoes/logo-2.png') }}" width="245" height="45" alt="logo">
                <img src="{{ asset('tactical/assets/images/demoes/demo10/logoes/logo-3.png') }}" width="245" height="45" alt="logo">
                <img src="{{ asset('tactical/assets/images/demoes/demo10/logoes/logo-4.png') }}" width="245" height="45" alt="logo">
                <img src="{{ asset('tactical/assets/images/demoes/demo10/logoes/logo-5.png') }}" width="245" height="45" alt="logo">
                <img src="{{ asset('tactical/assets/images/demoes/demo10/logoes/logo-6.png') }}" width="245" height="45" alt="logo">
            </div><!-- End .brands-slider -->
        </div>
    </div><!-- End .brands-container -->

    <div class="team-section container">
        <h4 class="title-decorate text-center text-dark d-flex align-items-center">OUR TEAM</h4>
        <div class="row justify-content-center">
            <div class="col-6 col-lg-3 col-md-4">
                <div class="team-info">
                    <figure class="zoom-effect">
                        <a href="#">
                            <img src="{{ asset('tactical/assets/images/demoes/demo6/about/team1.jpg') }}"
                                data-zoom-image="{{ asset('tactical/assets/images/demoes/demo6/about/team1.jpg') }}" class="w-100"
                                width="270" height="319" alt="Team" />
                        </a>
                        <h5 class="team-name font4 mb-0">John Doe</h5>

                        <span class="prod-full-screen">
                            <i class="fas fa-search"></i>
                        </span>
                    </figure>
                </div>
            </div><!-- End .col-lg-4 -->

            <div class="col-6 col-lg-3 col-md-4">
                <div class="team-info">
                    <figure class="zoom-effect">
                        <a href="#">
                            <img src="{{ asset('tactical/assets/images/demoes/demo6/about/team2.jpg') }}"
                                data-zoom-image="{{ asset('tactical/assets/images/demoes/demo6/about/team2.jpg') }}" class="w-100"
                                width="270" height="319" alt="Team" />
                        </a>

                        <h5 class="team-name font4 mb-0">Jessica Doe</h5>
                        <span class="prod-full-screen">
                            <i class="fas fa-search"></i>
                        </span>
                    </figure>
                </div>
            </div><!-- End .col-lg-4 -->

            <div class="col-6 col-lg-3 col-md-4">
                <div class="team-info">
                    <figure class="zoom-effect">
                        <a href="#">
                            <img src="{{ asset('tactical/assets/images/demoes/demo6/about/team3.jpg') }}"
                                data-zoom-image="{{ asset('tactical/assets/images/demoes/demo6/about/team3.jpg') }}" class="w-100"
                                width="270" height="319" alt="Team" />
                        </a>

                        <h5 class="team-name font4 mb-0">Rick Edward Doe</h5>
                        <span class="prod-full-screen">
                            <i class="fas fa-search"></i>
                        </span>
                    </figure>
                </div>
            </div><!-- End .col-lg-4 -->

            <div class="col-6 col-lg-3 col-md-4">
                <div class="team-info">
                    <figure class="zoom-effect">
                        <a href="#">
                            <img src="{{ asset('tactical/assets/images/demoes/demo6/about/team6.jpg') }}"
                                data-zoom-image="{{ asset('tactical/assets/images/demoes/demo6/about/team6.jpg') }}" class="w-100"
                                width="270" height="319" alt="Team" />
                        </a>
                        <h5 class="team-name font4 mb-0">Melissa Doe</h5>
                        <span class="prod-full-screen">
                            <i class="fas fa-search"></i>
                        </span>
                    </figure>
                </div>
            </div><!-- End .col-lg-4 -->
        </div><!-- End .row -->
    </div>
@endsection