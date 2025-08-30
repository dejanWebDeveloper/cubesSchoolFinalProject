<div class="widget tags">
    <header>
        <h3 class="h6">Tags</h3>
    </header>
    <ul class="list-inline">
     @foreach($allTagsForBlogPartial as $tag)
        <li class="list-inline-item"><a href="{{route('blog_tag_page', ['slug'=>$tag->slug])}}" class="tag">#{{$tag->name}}</a></li>
        @endforeach
    </ul>
</div>
