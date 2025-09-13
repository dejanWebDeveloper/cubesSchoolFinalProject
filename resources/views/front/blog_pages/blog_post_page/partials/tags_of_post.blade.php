<div class="post-tags">
    @foreach($singlePostTags as $tag)
        <a href="{{route('blog_tag_page', ['id'=>$tag->id, 'slug'=>$tag->slug])}}" class="tag">#{{$tag->name}}</a>
    @endforeach
</div>
