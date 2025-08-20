<div class="post-tags">
    @foreach($singlePostTags as $tag)
        <a href="{{route('blog_tag_page', ['name'=>$tag->name])}}" class="tag">#{{$tag->name}}</a>
    @endforeach
</div>
