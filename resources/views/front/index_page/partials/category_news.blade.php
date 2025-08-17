<section class="featured-posts no-padding-top">
    <div class="container">
        <!-- Post 1 || 3 -->
        @foreach($importantPosts as $importantPost)
            @if($loop->iteration > 1)
                @break
            @endif
                <div class="row d-flex align-items-stretch">
                    <div class="text col-lg-7">
                        <div class="text-inner d-flex align-items-center">
                            <div class="content">
                                <header class="post-header">
                                    <div class="category">
                                        <a href="blog-category.html">{{$importantPost->category->name}}</a>
                                    </div>
                                    <a href="blog-post.html">
                                        <h2 class="h4">{{$importantPost->heading}}</h2>
                                    </a>
                                </header>
                                <p>{{$importantPost->text}}
                                </p>
                                <footer class="post-footer d-flex align-items-center">
                                    <a href="blog-author.html" class="author d-flex align-items-center flex-wrap">
                                        <div class="avatar">
                                            <img src="{{$importantPost->author->authorImageUrl()}}" alt="..."
                                                 class="img-fluid">
                                        </div>
                                        <div class="title">
                                            <span>{{$importantPost->author->name}}</span>
                                        </div>
                                    </a>
                                    <div class="date">
                                        <i class="icon-clock"></i>{{$importantPost->created_at->format('H:i d, M Y')}}
                                    </div>
                                    <div class="comments">
                                        <i class="icon-comment"></i>{{$importantPost->views}}
                                    </div>
                                </footer>
                            </div>
                        </div>
                    </div>
                    <div class="image col-lg-5">
                        <img src="{{$importantPost->imageUrl()}}" alt="...">
                    </div>
                    @endforeach
                </div>
        <!-- Post 2-->
        @foreach($importantPosts as $importantPost)
            @if($loop->iteration <= 1)
                @continue
                    @endif
                        @if($loop->iteration > 2)
                            @break
                        @endif
                <div class="row d-flex align-items-stretch">
                    <div class="image col-lg-5">
                        <img src="{{$importantPost->imageUrl()}}" alt="...">
                    </div>
                    <div class="text col-lg-7">
                        <div class="text-inner d-flex align-items-center">
                            <div class="content">
                                <header class="post-header">
                                    <div class="category"><a
                                            href="blog-category.html">{{$importantPost->category->name}}</a></div>
                                    <a href="blog-post.html">
                                        <h2 class="h4">{{$importantPost->heading}}</h2></a>
                                </header>
                                <p>{{$importantPost->text}}</p>
                                <footer class="post-footer d-flex align-items-center"><a href="blog-author.html"
                                                                                         class="author d-flex align-items-center flex-wrap">
                                        <div class="avatar"><img src="{{$importantPost->author->authorImageUrl()}}"
                                                                 alt="..." class="img-fluid"></div>
                                        <div class="title"><span>{{$importantPost->author->name}}</span></div>
                                    </a>
                                    <div class="date"><i
                                            class="icon-clock"></i>{{$importantPost->created_at->format('H:i d, M Y')}}
                                    </div>
                                    <div class="comments"><i class="icon-comment"></i>{{$importantPost->views}}</div>
                                </footer>
                            </div>
                        </div>
                    </div>
                </div>

        @endforeach
        @foreach($importantPosts as $importantPost)
            @if($loop->iteration < 3)
                @continue
                    @endif
                <!-- Post                            -->
                <div class="row d-flex align-items-stretch">
                    <div class="text col-lg-7">
                        <div class="text-inner d-flex align-items-center">
                            <div class="content">
                                <header class="post-header">
                                    <div class="category"><a
                                            href="blog-category.html">{{$importantPost->category->name}}</a></div>
                                    <a href="blog-post.html">
                                        <h2 class="h4">{{$importantPost->heading}}</h2></a>
                                </header>
                                <p>{{$importantPost->text}}</p>
                                <footer class="post-footer d-flex align-items-center"><a href="blog-author.html"
                                                                                         class="author d-flex align-items-center flex-wrap">
                                        <div class="avatar"><img src="{{$importantPost->author->authorImageUrl()}}"
                                                                 alt="..." class="img-fluid"></div>
                                        <div class="title"><span>{{$importantPost->author->name}}</span></div>
                                    </a>
                                    <div class="date"><i
                                            class="icon-clock"></i>{{$importantPost->created_at->format('H:i d, M Y')}}
                                    </div>
                                    <div class="comments"><i class="icon-comment"></i>{{$importantPost->views}}</div>
                                </footer>
                            </div>
                        </div>
                    </div>
                    <div class="image col-lg-5"><img src="{{$importantPost->imageUrl()}}" alt="..."></div>
                </div>
        @endforeach
    </div>
</section>
