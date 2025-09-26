<section class="featured-posts no-padding-top">
    <div class="container">
        @foreach($importantPosts as $loopIndex => $importantPost)
            <div class="row d-flex align-items-stretch">
                <!-- first post -->
                @if($loop->first)
                    <div class="text col-lg-7">
                        <div class="text-inner d-flex align-items-center">
                            <div class="content">
                                <header class="post-header">
                                    <div class="category">
                                        @if($importantPost->category)
                                            <a href="{{ route('blog_category_page', ['id' => $importantPost->category->id, 'slug' => $importantPost->category->slug]) }}">
                                                {{ $importantPost->category->name }}
                                            </a>
                                        @else
                                            <a>Uncategorized</a>
                                        @endif
                                    </div>
                                    <a href="{{route('blog_post_page', ['id'=>$importantPost->id, 'slug'=>$importantPost->slug])}}">
                                        <h2 class="h4">{{ $importantPost->heading }}</h2>
                                    </a>
                                </header>
                                <p>{{ $importantPost->preheading }}</p>
                                <footer class="post-footer d-flex align-items-center">
                                    <a href="{{route('blog_author_page', ['id'=>$importantPost->author->id, 'slug'=>$importantPost->author->slug])}}" class="author d-flex align-items-center flex-wrap">
                                        <div class="avatar">
                                            <img src="{{ $importantPost->author->authorImageUrl() }}" alt="..."
                                                 class="img-fluid">
                                        </div>
                                        <div class="title"><span>{{ $importantPost->author->name }}</span></div>
                                    </a>
                                    <div class="date">
                                        <i class="icon-clock"></i>{{ $importantPost->created_at->diffForHumans()}}
                                    </div>
                                    <div class="comments">
                                        <i class="icon-comment"></i>{{$importantPost->comments_count}}
                                    </div>
                                </footer>
                            </div>
                        </div>
                    </div>
                    <div class="image col-lg-5">
                        <img src="{{ $importantPost->imageUrl() }}" alt="...">
                    </div>
                    <!-- second post -->
                @elseif($loop->iteration == 2)
                    <div class="image col-lg-5">
                        <img src="{{ $importantPost->imageUrl() }}" alt="...">
                    </div>
                    <div class="text col-lg-7">
                        <div class="text-inner d-flex align-items-center">
                            <div class="content">
                                <header class="post-header">
                                    <div class="category">
                                        @if($importantPost->category)
                                            <a href="{{ route('blog_category_page', ['id' => $importantPost->category->id, 'slug' => $importantPost->category->slug]) }}">
                                                {{ $importantPost->category->name }}
                                            </a>
                                        @else
                                            <a>Uncategorized</a>
                                        @endif
                                    </div>
                                    <a href="{{route('blog_post_page', ['id'=>$importantPost->id, 'slug'=>$importantPost->slug])}}">
                                        <h2 class="h4">{{ $importantPost->heading }}</h2>
                                    </a>
                                </header>
                                <p>{{ $importantPost->preheading }}</p>
                                <footer class="post-footer d-flex align-items-center">
                                    <a href="{{route('blog_author_page', ['id'=>$importantPost->author->id, 'slug'=>$importantPost->author->slug])}}" class="author d-flex align-items-center flex-wrap">
                                        <div class="avatar">
                                            <img src="{{ $importantPost->author->authorImageUrl() }}" alt="..."
                                                 class="img-fluid">
                                        </div>
                                        <div class="title"><span>{{ $importantPost->author->name }}</span></div>
                                    </a>
                                    <div class="date">
                                        <i class="icon-clock"></i>{{ $importantPost->created_at->diffForHumans()}}
                                    </div>
                                    <div class="comments">
                                        <i class="icon-comment"></i>{{$importantPost->comments_count}}
                                    </div>
                                </footer>
                            </div>
                        </div>
                    </div>
                    <!-- third post -->
                @else
                    <div class="text col-lg-7">
                        <div class="text-inner d-flex align-items-center">
                            <div class="content">
                                <header class="post-header">
                                    <div class="category">
                                        @if($importantPost->category)
                                            <a href="{{ route('blog_category_page', ['id' => $importantPost->category->id, 'slug' => $importantPost->category->slug]) }}">
                                                {{ $importantPost->category->name }}
                                            </a>
                                        @else
                                            <a>Uncategorized</a>
                                        @endif
                                    </div>
                                    <a href="{{route('blog_post_page', ['id'=>$importantPost->id, 'slug'=>$importantPost->slug])}}">
                                        <h2 class="h4">{{ $importantPost->heading }}</h2>
                                    </a>
                                </header>
                                <p>{{ $importantPost->preheading }}</p>
                                <footer class="post-footer d-flex align-items-center">
                                    <a href="{{route('blog_author_page', ['id'=>$importantPost->author->id, 'slug'=>$importantPost->author->slug])}}" class="author d-flex align-items-center flex-wrap">
                                        <div class="avatar">
                                            <img src="{{ $importantPost->author->authorImageUrl() }}" alt="..."
                                                 class="img-fluid">
                                        </div>
                                        <div class="title"><span>{{ $importantPost->author->name }}</span></div>
                                    </a>
                                    <div class="date">
                                        <i class="icon-clock"></i>{{ $importantPost->created_at->diffForHumans()}}
                                    </div>
                                    <div class="comments">
                                        <i class="icon-comment"></i>{{$importantPost->comments_count}}
                                    </div>
                                </footer>
                            </div>
                        </div>
                    </div>
                    <div class="image col-lg-5">
                        <img src="{{ $importantPost->imageUrl() }}" alt="...">
                    </div>
                @endif
            </div>
        @endforeach
    </div>
</section>
