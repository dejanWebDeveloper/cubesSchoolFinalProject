<div class="row">
    <!-- post -->
    @foreach($categoryPosts as $categoryPost)
        <div class="post col-xl-6">
            <div class="post-thumbnail">
                <a href="{{route('blog_post_page', ['heading'=>$categoryPost->heading])}}"><img src="{{$categoryPost->imageUrl()}}" alt="..." class="img-fluid">
                </a>
            </div>
            <div class="post-details">
                <div class="post-meta d-flex justify-content-between">
                    <div class="date meta-last">{{$categoryPost->created_at->format('d M | Y')}}</div>
                    <div class="category"><a href="{{route('blog_category_page', ['name'=>$categoryPost->category->name])}}">{{$categoryPost->category->name}}</a></div>
                </div>
                <a href="{{route('blog_post_page', ['heading'=>$categoryPost->heading])}}">
                    <h3 class="h4">{{$categoryPost->heading}}</h3></a>
                <p class="text-muted">{{$categoryPost->text}}</p>
                <footer class="post-footer d-flex align-items-center"><a href="{{route('blog_author_page', ['name'=>$categoryPost->author->name])}}"
                                                                         class="author d-flex align-items-center flex-wrap">
                        <div class="avatar"><img src="{{$categoryPost->author->authorImageUrl()}}" alt="..." class="img-fluid">
                        </div>
                        <div class="title"><span>{{$categoryPost->author->name}}</span></div>
                    </a>
                    <div class="date"><i class="icon-clock"></i>{{$categoryPost->created_at->diffForHumans()}}</div>
                    <div class="comments meta-last"><i class="icon-comment"></i>{{$categoryPost->comments_count}}</div>
                </footer>
            </div>
        </div>
    @endforeach
</div>
