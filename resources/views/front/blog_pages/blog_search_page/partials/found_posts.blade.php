<div class="row">
    @php
        // Pripremi regex za označavanje (case-insensitive)
        $highlight = function ($text, $query) {
            return preg_replace('/(' . preg_quote($query, '/') . ')/i', '<mark>$1</mark>', $text);
        };
    @endphp
    @if($results->count())
        @foreach($results as $post)
            <div class="post col-xl-6">
                <div class="post-thumbnail">
                    <a href="{{route('blog_post_page', ['id'=>$post->id, 'slug'=>$post->slug])}}"><img src="{{$post->imageUrl()}}" alt="..." class="img-fluid">
                    </a>
                </div>
                <div class="post-details">
                    <div class="post-meta d-flex justify-content-between">
                        <div class="date meta-last">{{$post->created_at->format('d M | Y')}}</div>
                        <div class="category">
                            @if($post->category)
                                <a href="{{ route('blog_category_page', ['id' => $post->category->id, 'slug' => $post->category->slug]) }}">
                                    {{ $post->category->name }}
                                </a>
                            @else
                                <a>Uncategorized</a>
                            @endif
                        </div>
                    </div>
                    <a href="{{route('blog_post_page', ['id'=>$post->id, 'slug'=>$post->slug])}}">
                        <h3 class="h4">{!! $highlight($post->heading, $query) !!}</h3></a>
                    <p class="text-muted">{!! $highlight(Str::limit($post->text, 120), $query) !!}</p>
                    <footer class="post-footer d-flex align-items-center">
                        <a href="{{route('blog_author_page', ['id'=>$post->author->id, 'slug'=>$post->author->slug])}}" class="author d-flex align-items-center flex-wrap">
                            <div class="avatar"><img src="{{$post->author->authorImageUrl()}}" alt="..." class="img-fluid">
                            </div>
                            <div class="title"><span>{{$post->author->name}}</span>
                            </div>
                        </a>
                        <div class="date"><i class="icon-clock"></i>{{$post->created_at->diffForHumans()}}</div>
                        <div class="comments meta-last"><i class="icon-comment"></i>{{$post->comments_count}}</div>
                    </footer>
                </div>
            </div>
        @endforeach

    @else
        <p>No results</p>
@endif
