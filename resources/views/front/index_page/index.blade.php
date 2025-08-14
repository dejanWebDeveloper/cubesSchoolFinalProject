@extends('front._layouts._layout')
@section('seo_title', 'Bootstrap Blog - B4 Template by Bootstrap Temple')
@section('content')
    <!-- Hero Section-->
    @include('front.index_page.partials.slider')
    <!-- Intro Section-->
    @include('front.index_page.partials.title')
    @include('front.index_page.partials.category_news')
    <!-- Divider Section-->
    @include('front.index_page.partials.recommendation')
    <!-- Latest Posts -->
    @include('front.index_page.partials.latest_news')
    <!-- Gallery Section-->
    @include('front.index_page.partials.bottom_gallery')
@endsection

@push('footer_script')
    <script src="{{url('themes/front/plugins/owl-carousel2/owl.carousel.min.js')}}"></script>
    <script>
        $("#index-slider").owlCarousel({
            "items": 1,
            "loop": true,
            "autoplay": true,
            "autoplayHoverPause": true
        });

        $("#latest-posts-slider").owlCarousel({
            "items": 1,
            "loop": true,
            "autoplay": true,
            "autoplayHoverPause": true
        });
    </script>
@endpush

