<div class="row">
    <!-- post -->
    @foreach($tagPosts as $tagPost)
        <div class="post col-xl-6">
            <div class="post-thumbnail">
                <a href="{{route('blog_post_page', ['id'=>$tagPost->id, 'slug'=>$tagPost->slug])}}"><img src="{{$tagPost->imageUrl()}}" alt="..." class="img-fluid">
                </a>
            </div>
            <div class="post-details">
                <div class="post-meta d-flex justify-content-between">
                    <div class="date meta-last">{{$tagPost->created_at->format('d M | Y')}}</div>
                    <div class="category">
                        @if($tagPost->category)
                            <a href="{{ route('blog_category_page', ['id' => $tagPost->category->id, 'slug' => $tagPost->category->slug]) }}">
                                {{ $tagPost->category->name }}
                            </a>
                        @else
                            <a>Uncategorized</a>
                        @endif
                    </div>
                </div>
                <a href="{{route('blog_post_page', ['id'=>$tagPost->id, 'slug'=>$tagPost->slug])}}">
                    <h3 class="h4">{{$tagPost->heading}}</h3></a>
                <p class="text-muted">{{$tagPost->text}}</p>
                <footer class="post-footer d-flex align-items-center"><a href="{{route('blog_author_page', ['id'=>$tagPost->author->id, 'slug'=>$tagPost->author->slug])}}"
                                                                         class="author d-flex align-items-center flex-wrap">
                        <div class="avatar"><img src="{{$tagPost->author->authorImageUrl()}}" alt="..." class="img-fluid">
                        </div>
                        <div class="title"><span>{{$tagPost->author->name}}</span></div>
                    </a>
                    <div class="date"><i class="icon-clock"></i>{{$tagPost->created_at->diffForHumans()}}</div>
                    <div class="comments meta-last"><i class="icon-comment"></i>{{$tagPost->comments_count}}</div>
                </footer>
            </div>
        </div>
    @endforeach
</div>
