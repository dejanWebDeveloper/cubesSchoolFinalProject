<div class="widget tags">
    <header>
        <h3 class="h6">Tags</h3>
    </header>
    <ul class="list-inline">
     @foreach($allTagsForBlogPartial as $tag)
        <li class="list-inline-item"><a href="blog-tag.html" class="tag">#{{$tag->name}}</a></li>
        @endforeach
    </ul>
</div>
