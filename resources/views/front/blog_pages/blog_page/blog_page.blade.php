@extends('front._layouts._layout')
@section('seo_title', 'Cubes Blog Posts')
@section('content')
    <div class="container">
        <div class="row">
            <!-- Latest Posts -->
            <main class="posts-listing col-lg-8">
                <div class="container">
                    @include('front.blog_pages.blog_page.partials.posts')
                    <!-- Pagination -->
                    @include('front.blog_pages.blog_page.partials.post_pagination')
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
