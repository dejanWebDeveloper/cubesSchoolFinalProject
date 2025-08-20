@extends('front._layouts._layout')
@section('seo_title', 'Bootstrap Blog - B4 Template by Bootstrap Temple')
@section('content')
    <div class="container">
        <div class="row">
            <main class="post blog-post col-lg-8">
                <div class="container">
                    <div class="post-single">
                        <div class="post-thumbnail"><img src="{{$singlePost->imageUrl()}}" alt="..." class="img-fluid"></div>
                        <div class="post-details">
                            @include('front.blog_pages.blog_post_page.partials.content_of_post')
                            @include('front.blog_pages.blog_post_page.partials.tags_of_post')
                            @include('front.blog_pages.blog_post_page.partials.pre_next_post')
                            @include('front.blog_pages.blog_post_page.partials.view_comments')
                            @include('front.blog_pages.blog_post_page.partials.entering_comments_form')
                        </div>
                    </div>
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




