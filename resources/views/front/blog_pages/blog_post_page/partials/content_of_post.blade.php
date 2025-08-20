<div class="post-meta d-flex justify-content-between">
    <div class="category">
        <a href="{{route('blog_category_page', ['name'=>$singlePost->category->name])}}">{{$singlePost->category->name}}</a>
    </div>
</div>
<h1>{{$singlePost->heading}}
    <a href="#"><i class="fa fa-bookmark-o"></i>
    </a>
</h1>
<div class="post-footer d-flex align-items-center flex-column flex-sm-row">
    <a href="{{route('blog_author_page', ['name'=>$singlePost->author->name])}}" class="author d-flex align-items-center flex-wrap">
        <div class="avatar"><img src="{{$singlePost->author->authorImageUrl()}}" alt="..." class="img-fluid"></div>
        <div class="title">
            <span>{{$singlePost->author->name}}</span>
        </div>
    </a>
    <div class="d-flex align-items-center flex-wrap">
        <div class="date"><i class="icon-clock"></i>{{$singlePost->created_at->diffForHumans()}}</div>
        <div class="views"><i class="icon-eye"></i>{{$singlePost->views}}</div>
        <div class="comments meta-last"><a href="#post-comments"><i class="icon-comment"></i>{{$singlePost->comments_count}}</a></div>
    </div>
</div>
<div class="post-body">
    <p class="lead"></p>
    <p>{{$singlePost->text}}</p>
    <p> <img src="{{$singlePost->imageUrl()}}" alt="..." class="img-fluid"></p>
    <h3>{{$singlePost->preheading}}</h3>
    <p>{{$singlePost->text}}</p>
    <blockquote class="blockquote">
        <p>{{$singlePost->text}}</p>
        <footer class="blockquote-footer">Someone famous in
            <cite title="Source Title">Source Title</cite>
        </footer>
    </blockquote>
    <p>{{$singlePost->text}}</p>
</div>
