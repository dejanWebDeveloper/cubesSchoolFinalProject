<section class="latest-posts">
    <div class="container">
        <header>
            <h2>Latest from the blog</h2>
            <p class="text-big">Lorem ipsum dolor sit amet, consectetur adipisicing elit.</p>
        </header>
        <div class="owl-carousel" id="latest-posts-slider">
            @foreach($latestPostsSlider as $latestPostSlider)
                <div class="post">
                    <div class="post-thumbnail">
                        <a href="{{route('blog_post_page', ['heading'=>$latestPostSlider->heading])}}">
                            <img src="{{ $latestPostSlider->imageUrl() }}" alt="..." class="img-fluid">
                        </a>
                    </div>
                    <div class="post-details">
                        <div class="post-meta d-flex justify-content-between">
                            <div class="date">{{ $latestPostSlider->created_at->format('d M | Y') }}</div>
                            <div class="category">
                                <a href="{{route('blog_category_page', ['name'=>$latestPostSlider->category->name])}}">{{ $latestPostSlider->category->name }}</a>
                            </div>
                        </div>
                        <a href="{{route('blog_post_page', ['heading'=>$latestPostSlider->heading])}}">
                            <h3 class="h4">{{ $latestPostSlider->heading }}</h3>
                        </a>
                        <p class="text-muted">{{ $latestPostSlider->text }}</p>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</section>
