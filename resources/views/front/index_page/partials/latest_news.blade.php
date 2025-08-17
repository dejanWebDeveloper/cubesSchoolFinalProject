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
                        <a href="blog-post.html">
                            <img src="{{ $latestPostSlider->imageUrl() }}" alt="..." class="img-fluid">
                        </a>
                    </div>
                    <div class="post-details">
                        <div class="post-meta d-flex justify-content-between">
                            <div class="date">{{ $latestPostSlider->created_at->format('H:i d, M Y') }}</div>
                            <div class="category">
                                <a href="blog-category.html">{{ $latestPostSlider->category->name }}</a>
                            </div>
                        </div>
                        <a href="blog-post.html">
                            <h3 class="h4">{{ $latestPostSlider->heading }}</h3>
                        </a>
                        <p class="text-muted">{{ $latestPostSlider->text }}</p>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</section>
