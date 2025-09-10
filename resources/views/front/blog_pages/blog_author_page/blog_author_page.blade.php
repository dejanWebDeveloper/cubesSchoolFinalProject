@extends('front._layouts._layout')
@section('seo_title', $author->name)
@if($author->profile_photo)
    @section('seo_image', $author->authorImageUrl())
@endif
@section('content')
    <div class="container">
        <div class="row">
            <!-- Latest Posts -->
            <main class="posts-listing col-lg-8">
                <div class="container">
                    @include('front.blog_pages.blog_author_page.partials.title')
                    @include('front.blog_pages.blog_author_page.partials.posts')
                    <!-- Pagination -->
                    @include('front.blog_pages.blog_author_page.partials.pagination')
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

