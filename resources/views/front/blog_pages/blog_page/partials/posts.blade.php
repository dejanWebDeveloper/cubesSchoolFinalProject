<div class="row">
    <!-- post -->
    @foreach($blogPosts as $blogPost)
        <div class="post col-xl-6">
            <div class="post-thumbnail">
                <a href="{{route('blog_post_page', ['heading'=>$blogPost->heading])}}"><img src="{{$blogPost->imageUrl()}}" alt="..." class="img-fluid">
                </a>
            </div>
            <div class="post-details">
                <div class="post-meta d-flex justify-content-between">
                    <div class="date meta-last">{{$blogPost->created_at->format('d M | Y')}}</div>
                    <div class="category"><a href="{{route('blog_category_page', ['name'=>$blogPost->category->name])}}">{{$blogPost->category->name}}</a></div>
                </div>
                <a href="{{route('blog_post_page', ['heading'=>$blogPost->heading])}}">
                    <h3 class="h4">{{$blogPost->heading}}</h3></a>
                <p class="text-muted">{{$blogPost->text}}</p>
                <footer class="post-footer d-flex align-items-center"><a href="{{route('blog_author_page', ['name'=>$blogPost->author->name])}}"
                                                                         class="author d-flex align-items-center flex-wrap">
                        <div class="avatar"><img src="{{$blogPost->author->authorImageUrl()}}" alt="..." class="img-fluid">
                        </div>
                        <div class="title"><span>{{$blogPost->author->name}}</span></div>
                    </a>
                    <div class="date"><i class="icon-clock"></i>{{$blogPost->created_at->diffForHumans()}}</div>
                    <div class="comments meta-last"><i class="icon-comment"></i>{{$blogPost->comments_count}}</div>
                </footer>
            </div>
        </div>
    @endforeach
</div>
