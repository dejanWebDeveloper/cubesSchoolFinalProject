<div class="post-tags">
    @foreach($singlePostTags as $tag)
        <a href="{{route('blog_tag_page', ['slug'=>$tag->slug])}}" class="tag">#{{$tag->name}}</a>
    @endforeach
</div>
