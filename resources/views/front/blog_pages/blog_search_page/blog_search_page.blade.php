@extends('front._layouts._layout')
@section('seo_title', 'Bootstrap Blog - B4 Template by Bootstrap Temple')
@section('content')
    <div class="container">
        <div class="row">
            <!-- Latest Posts -->
            <main class="posts-listing col-lg-8">
                <div class="container">
                    <h2 class="mb-3">Search results for "cubes"</h2>
                    @include('front.blog_pages.blog_search_page.partials.found_posts')
                    <!-- Pagination -->
                    @include('front.blog_pages.blog_search_page.partials.pagination')
                </div>
            </main>
            <aside class="col-lg-4">
                <!-- Widget [Search Bar Widget]-->
                @include('front.blog_pages.partials.search_posts')
                <!-- Widget [Latest Posts Widget]        -->
                @include('front.blog_pages.partials.latest_posts')
                <!-- Widget [Categories Widget]-->
                @include('front.blog_pages.partials.categories')
                <!-- Widget [Tags Cloud Widget]-->
                @include('front.blog_pages.partials.tags')
            </aside>
        </div>
    </div>
@endsection
