<div class="post-comments" id="post-comments">
    <header>
        <h3 class="h6">Post Comments<span class="no-of-comments">({{$singlePost->comments_count}})</span></h3>
    </header>
    @foreach($comments as $comment)
    <div id="comments-view" class="comment">
        <div class="comment-header d-flex justify-content-between">
            <div class="user d-flex align-items-center">
                <div class="image">
                    <img src="{{url('/themes/front/img/user.svg')}}" alt="..." class="img-fluid rounded-circle">
                </div>
                <div class="title"><strong>{{$comment->name}}</strong><span class="date">{{ $comment->created_at->format('F Y') }}</span></div>
            </div>
        </div>
        <div class="comment-body">
            <p>{{ $comment->comment }}</p>
        </div>
    </div>
    @endforeach
</div>
