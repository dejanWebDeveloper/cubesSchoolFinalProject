<div class="posts-nav d-flex justify-content-between align-items-stretch flex-column flex-md-row">
        @if($prevPost)
            <a href="{{route('blog_post_page', ['heading'=>$prevPost->heading])}}"
               class="prev-post text-left d-flex align-items-center">
                <div class="icon prev">
                    <i class="fa fa-angle-left"></i>
                </div>
                <div class="text">
                    <strong class="text-primary">Previous Post </strong>
                    <h6>{{ $prevPost->heading }}</h6>
                </div>
            </a>
        @else
            <strong class="text-primary">There is no previous post</strong>
        @endif
        @if($nextPost)
                <a href="{{route('blog_post_page', ['heading'=>$nextPost->heading])}}"
                   class="next-post text-right d-flex align-items-center justify-content-end">
                    <div class="text">
                        <strong class="text-primary">Next Post </strong>
                        <h6>{{ $nextPost->heading }}</h6>
                    </div>
                    <div class="icon next">
                        <i class="fa fa-angle-right"> </i>
                    </div>
                </a>
        @else
            <strong class="text-primary">There is no next post</strong>
        @endif
    </div>
