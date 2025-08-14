@extends('front._layouts._layout')
@section('content')
<!-- Hero Section-->
<div id="index-slider" class="owl-carousel">
    <section style="background: url(img/featured-pic-1.jpeg); background-size: cover; background-position: center center" class="hero">
        <div class="container">
            <div class="row">
                <div class="col-lg-7">
                    <h1>Bootstrap 4 Blog - A free template by Bootstrap Temple</h1>
                    <a href="blog-post.html" class="hero-link">Discover More</a>
                </div>
            </div>
        </div>
    </section>
    <section style="background: url(img/featured-pic-2.jpeg); background-size: cover; background-position: center center" class="hero">
        <div class="container">
            <div class="row">
                <div class="col-lg-7">
                    <h1>Bootstrap 4 Blog - Some other title in slide</h1>
                    <a href="blog-category.html" class="hero-link">Checkout More</a>
                </div>
            </div>
        </div>
    </section>
    <section style="background: url(img/featured-pic-3.jpeg); background-size: cover; background-position: center center" class="hero">
        <div class="container">
            <div class="row">
                <div class="col-lg-7">
                    <h1>This is third slide, there will be more!</h1>
                    <a href="blog-tag.html" class="hero-link">Findout More</a>
                </div>
            </div>
        </div>
    </section>
</div>

<!-- Intro Section-->
<section class="intro">
    <div class="container">
        <div class="row">
            <div class="col-lg-8">
                <h2 class="h3">Some great intro here</h2>
                <p class="text-big">Place a nice <strong>introduction</strong> here <strong>to catch reader's attention</strong>.</p>
            </div>
        </div>
    </div>
</section>
<section class="featured-posts no-padding-top">
    <div class="container">
        <!-- Post-->
        <div class="row d-flex align-items-stretch">
            <div class="text col-lg-7">
                <div class="text-inner d-flex align-items-center">
                    <div class="content">
                        <header class="post-header">
                            <div class="category"><a href="blog-category.html">Business</a></div><a href="blog-post.html">
                                <h2 class="h4">Alberto Savoia Can Teach You About Interior</h2></a>
                        </header>
                        <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrude consectetur adipisicing elit, sed do eiusmod tempor incididunt.</p>
                        <footer class="post-footer d-flex align-items-center"><a href="blog-author.html" class="author d-flex align-items-center flex-wrap">
                                <div class="avatar"><img src="img/avatar-1.jpg" alt="..." class="img-fluid"></div>
                                <div class="title"><span>John Doe</span></div></a>
                            <div class="date"><i class="icon-clock"></i> 2 months ago</div>
                            <div class="comments"><i class="icon-comment"></i>12</div>
                        </footer>
                    </div>
                </div>
            </div>
            <div class="image col-lg-5"><img src="img/featured-pic-1.jpeg" alt="..."></div>
        </div>
        <!-- Post        -->
        <div class="row d-flex align-items-stretch">
            <div class="image col-lg-5"><img src="img/featured-pic-2.jpeg" alt="..."></div>
            <div class="text col-lg-7">
                <div class="text-inner d-flex align-items-center">
                    <div class="content">
                        <header class="post-header">
                            <div class="category"><a href="blog-category.html">Business</a></div><a href="blog-post.html">
                                <h2 class="h4">Alberto Savoia Can Teach You About Interior</h2></a>
                        </header>
                        <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrude consectetur adipisicing elit, sed do eiusmod tempor incididunt.</p>
                        <footer class="post-footer d-flex align-items-center"><a href="blog-author.html" class="author d-flex align-items-center flex-wrap">
                                <div class="avatar"><img src="img/avatar-2.jpg" alt="..." class="img-fluid"></div>
                                <div class="title"><span>John Doe</span></div></a>
                            <div class="date"><i class="icon-clock"></i> 2 months ago</div>
                            <div class="comments"><i class="icon-comment"></i>12</div>
                        </footer>
                    </div>
                </div>
            </div>
        </div>
        <!-- Post                            -->
        <div class="row d-flex align-items-stretch">
            <div class="text col-lg-7">
                <div class="text-inner d-flex align-items-center">
                    <div class="content">
                        <header class="post-header">
                            <div class="category"><a href="blog-category.html">Business</a></div><a href="blog-post.html">
                                <h2 class="h4">Alberto Savoia Can Teach You About Interior</h2></a>
                        </header>
                        <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrude consectetur adipisicing elit, sed do eiusmod tempor incididunt.</p>
                        <footer class="post-footer d-flex align-items-center"><a href="blog-author.html" class="author d-flex align-items-center flex-wrap">
                                <div class="avatar"><img src="img/avatar-3.jpg" alt="..." class="img-fluid"></div>
                                <div class="title"><span>John Doe</span></div></a>
                            <div class="date"><i class="icon-clock"></i> 2 months ago</div>
                            <div class="comments"><i class="icon-comment"></i>12</div>
                        </footer>
                    </div>
                </div>
            </div>
            <div class="image col-lg-5"><img src="img/featured-pic-3.jpeg" alt="..."></div>
        </div>
    </div>
</section>
<!-- Divider Section-->
<section style="background: url(img/divider-bg.jpg); background-size: cover; background-position: center bottom" class="divider">
    <div class="container">
        <div class="row">
            <div class="col-md-7">
                <h2>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua</h2>
                <a href="contact.html" class="hero-link">Contact Us</a>
            </div>
        </div>
    </div>
</section>
<!-- Latest Posts -->
<section class="latest-posts">
    <div class="container">
        <header>
            <h2>Latest from the blog</h2>
            <p class="text-big">Lorem ipsum dolor sit amet, consectetur adipisicing elit.</p>
        </header>
        <div class="owl-carousel" id="latest-posts-slider">
            <div class="row">
                <div class="post col-md-4">
                    <div class="post-thumbnail"><a href="blog-post.html"><img src="img/blog-1.jpg" alt="..." class="img-fluid"></a></div>
                    <div class="post-details">
                        <div class="post-meta d-flex justify-content-between">
                            <div class="date">20 May | 2016</div>
                            <div class="category"><a href="blog-category.html">Business</a></div>
                        </div><a href="blog-post.html">
                            <h3 class="h4">Ways to remember your important ideas</h3></a>
                        <p class="text-muted">Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore.</p>
                    </div>
                </div>
                <div class="post col-md-4">
                    <div class="post-thumbnail"><a href="blog-post.html"><img src="img/blog-2.jpg" alt="..." class="img-fluid"></a></div>
                    <div class="post-details">
                        <div class="post-meta d-flex justify-content-between">
                            <div class="date">20 May | 2016</div>
                            <div class="category"><a href="blog-category.html">Technology</a></div>
                        </div><a href="blog-post.html">
                            <h3 class="h4">Diversity in Engineering: Effect on Questions</h3></a>
                        <p class="text-muted">Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore.</p>
                    </div>
                </div>
                <div class="post col-md-4">
                    <div class="post-thumbnail"><a href="blog-post.html"><img src="img/blog-3.jpg" alt="..." class="img-fluid"></a></div>
                    <div class="post-details">
                        <div class="post-meta d-flex justify-content-between">
                            <div class="date">20 May | 2016</div>
                            <div class="category"><a href="blog-category.html">Financial</a></div>
                        </div><a href="blog-post.html">
                            <h3 class="h4">Alberto Savoia Can Teach You About Interior</h3></a>
                        <p class="text-muted">Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore.</p>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="post col-md-4">
                    <div class="post-thumbnail"><a href="blog-post.html"><img src="img/blog-2.jpg" alt="..." class="img-fluid"></a></div>
                    <div class="post-details">
                        <div class="post-meta d-flex justify-content-between">
                            <div class="date">20 May | 2016</div>
                            <div class="category"><a href="blog-category.html">Technology</a></div>
                        </div><a href="blog-post.html">
                            <h3 class="h4">Diversity in Engineering: Effect on Questions</h3></a>
                        <p class="text-muted">Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore.</p>
                    </div>
                </div>
                <div class="post col-md-4">
                    <div class="post-thumbnail"><a href="blog-post.html"><img src="img/blog-3.jpg" alt="..." class="img-fluid"></a></div>
                    <div class="post-details">
                        <div class="post-meta d-flex justify-content-between">
                            <div class="date">20 May | 2016</div>
                            <div class="category"><a href="blog-category.html">Financial</a></div>
                        </div><a href="blog-post.html">
                            <h3 class="h4">Alberto Savoia Can Teach You About Interior</h3></a>
                        <p class="text-muted">Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore.</p>
                    </div>
                </div>
                <div class="post col-md-4">
                    <div class="post-thumbnail"><a href="blog-post.html"><img src="img/blog-1.jpg" alt="..." class="img-fluid"></a></div>
                    <div class="post-details">
                        <div class="post-meta d-flex justify-content-between">
                            <div class="date">20 May | 2016</div>
                            <div class="category"><a href="blog-category.html">Business</a></div>
                        </div><a href="blog-post.html">
                            <h3 class="h4">Ways to remember your important ideas</h3></a>
                        <p class="text-muted">Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore.</p>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="post col-md-4">
                    <div class="post-thumbnail"><a href="blog-post.html"><img src="img/blog-1.jpg" alt="..." class="img-fluid"></a></div>
                    <div class="post-details">
                        <div class="post-meta d-flex justify-content-between">
                            <div class="date">20 May | 2016</div>
                            <div class="category"><a href="blog-category.html">Business</a></div>
                        </div><a href="blog-post.html">
                            <h3 class="h4">Ways to remember your important ideas</h3></a>
                        <p class="text-muted">Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore.</p>
                    </div>
                </div>
                <div class="post col-md-4">
                    <div class="post-thumbnail"><a href="blog-post.html"><img src="img/blog-2.jpg" alt="..." class="img-fluid"></a></div>
                    <div class="post-details">
                        <div class="post-meta d-flex justify-content-between">
                            <div class="date">20 May | 2016</div>
                            <div class="category"><a href="blog-category.html">Technology</a></div>
                        </div><a href="blog-post.html">
                            <h3 class="h4">Diversity in Engineering: Effect on Questions</h3></a>
                        <p class="text-muted">Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore.</p>
                    </div>
                </div>
                <div class="post col-md-4">
                    <div class="post-thumbnail"><a href="blog-post.html"><img src="img/blog-3.jpg" alt="..." class="img-fluid"></a></div>
                    <div class="post-details">
                        <div class="post-meta d-flex justify-content-between">
                            <div class="date">20 May | 2016</div>
                            <div class="category"><a href="blog-category.html">Financial</a></div>
                        </div><a href="blog-post.html">
                            <h3 class="h4">Alberto Savoia Can Teach You About Interior</h3></a>
                        <p class="text-muted">Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- Gallery Section-->
<section class="gallery no-padding">
    <div class="row">
        <div class="mix col-lg-3 col-md-3 col-sm-6">
            <div class="item">
                <a href="img/gallery-1.jpg" data-fancybox="gallery" class="image">
                    <img src="img/gallery-1.jpg" alt="gallery image alt 1" class="img-fluid" title="gallery image title 1">
                    <div class="overlay d-flex align-items-center justify-content-center"><i class="icon-search"></i></div>
                </a>
            </div>
        </div>
        <div class="mix col-lg-3 col-md-3 col-sm-6">
            <div class="item">
                <a href="img/gallery-2.jpg" data-fancybox="gallery" class="image">
                    <img src="img/gallery-2.jpg" alt="gallery image alt 2" class="img-fluid" title="gallery image title 2">
                    <div class="overlay d-flex align-items-center justify-content-center"><i class="icon-search"></i></div>
                </a>
            </div>
        </div>
        <div class="mix col-lg-3 col-md-3 col-sm-6">
            <div class="item">
                <a href="img/gallery-3.jpg" data-fancybox="gallery" class="image">
                    <img src="img/gallery-3.jpg" alt="gallery image alt 3" class="img-fluid" title="gallery image title 3">
                    <div class="overlay d-flex align-items-center justify-content-center"><i class="icon-search"></i></div>
                </a>
            </div>
        </div>
        <div class="mix col-lg-3 col-md-3 col-sm-6">
            <div class="item">
                <a href="img/gallery-4.jpg" data-fancybox="gallery" class="image">
                    <img src="img/gallery-4.jpg" alt="gallery image alt 4" class="img-fluid" title="gallery image title 4">
                    <div class="overlay d-flex align-items-center justify-content-center"><i class="icon-search"></i></div>
                </a>
            </div>
        </div>

    </div>
</section>
@endsection

@push('footer_script')
<script src="{{url('themes/front/plugins/owl-carousel2/owl.carousel.min.js')}}"></script>
<script>
    $("#index-slider").owlCarousel({
        "items": 1,
        "loop": true,
        "autoplay": true,
        "autoplayHoverPause": true
    });

    $("#latest-posts-slider").owlCarousel({
        "items": 1,
        "loop": true,
        "autoplay": true,
        "autoplayHoverPause": true
    });
</script>
@endpush

