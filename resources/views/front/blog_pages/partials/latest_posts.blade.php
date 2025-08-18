<div class="widget latest-posts">
    <header>
        <h3 class="h6">Latest Posts</h3>
    </header>
    <div class="blog-posts">
        @foreach($latestPostsForBlogPartial as $post)
        <a href="blog-post.html">
            <div class="item d-flex align-items-center">
                <div class="image">
                    <img src="{{$post->imageUrl()}}" alt="..." class="img-fluid">
                </div>
                <div class="title"><strong>{{$post->heading}}</strong>
                    <div class="d-flex align-items-center">
                        <div class="views"><i class="icon-eye"></i>{{$post->views}}</div>
                        <div class="comments"><i class="icon-comment"></i>{{$post->comments_count}}</div>
                    </div>
                </div>
            </div>
        </a>
        @endforeach
    </div>
</div>
