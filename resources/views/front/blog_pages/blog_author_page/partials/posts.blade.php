<div class="row">
    <!-- post -->
    @foreach($authorPosts as $authorPost)
        <div class="post col-xl-6">
            <div class="post-thumbnail">
                <a href="blog-post.html"><img src="{{$authorPost->imageUrl()}}" alt="..." class="img-fluid">
                </a>
            </div>
            <div class="post-details">
                <div class="post-meta d-flex justify-content-between">
                    <div class="date meta-last">{{$authorPost->created_at->format('d M | Y')}}</div>
                    <div class="category"><a href="blog-category.html">{{$authorPost->category->name}}</a></div>
                </div>
                <a href="blog-post.html">
                    <h3 class="h4">{{$authorPost->heading}}</h3></a>
                <p class="text-muted">{{$authorPost->text}}</p>
                <footer class="post-footer d-flex align-items-center"><a href="{{route('blog_author_page', ['name'=>$authorPost->author->name])}}"
                                                                         class="author d-flex align-items-center flex-wrap">
                        <div class="avatar"><img src="{{$authorPost->author->authorImageUrl()}}" alt="..." class="img-fluid">
                        </div>
                        <div class="title"><span>{{$authorPost->author->name}}</span></div>
                    </a>
                    <div class="date"><i class="icon-clock"></i>{{$authorPost->created_at->diffForHumans()}}</div>
                    <div class="comments meta-last"><i class="icon-comment"></i>{{$authorPost->comments_count}}</div>
                </footer>
            </div>
        </div>
    @endforeach
</div>
