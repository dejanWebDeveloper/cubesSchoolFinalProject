<footer class="main-footer">
    <div class="container">
        <div class="row">
            <div class="col-md-4">
                <div class="logo">
                    <h6 class="text-white">Bootstrap Blog</h6>
                </div>
                <div class="contact-details">
                    <p>53 Broadway, Broklyn, NY 11249</p>
                    <p>Phone: (020) 123 456 789</p>
                    <p>Email: <a href="mailto:info@company.com">Info@Company.com</a></p>
                    <ul class="social-menu">
                        <li class="list-inline-item"><a href="https://www.facebook.com/?locale=sr_RS"><i
                                    class="fa fa-facebook"></i></a></li>
                        <li class="list-inline-item"><a href="https://x.com/"><i class="fa fa-twitter"></i></a></li>
                        <li class="list-inline-item"><a href="https://www.instagram.com/"><i
                                    class="fa fa-instagram"></i></a></li>
                        <li class="list-inline-item"><a href="https://www.behance.net/"><i
                                    class="fa fa-behance"></i></a></li>
                        <li class="list-inline-item"><a href="https://www.pinterest.com/"><i
                                    class="fa fa-pinterest"></i></a></li>
                    </ul>
                </div>
            </div>
            <div class="col-md-4">
                <div class="menus d-flex">
                    <ul class="list-unstyled">
                        <li><a href="{{route('index_page')}}">Home</a></li>
                        <li><a href="{{route('blog_page')}}">Blog</a></li>
                        <li><a href="{{route('contact_page')}}">Contact</a></li>
                        <li><a href="{{route('admin_index_page')}}">Login</a></li>
                    </ul>
                    <ul class="list-unstyled">
                        @foreach($footerCategories as $footerCategory)
                            <li><a href="{{route('blog_category_page', ['id'=>$footerCategory->id ,'slug'=>$footerCategory->slug])}}">{{$footerCategory->name}}</a></li>
                        @endforeach
                    </ul>
                </div>
            </div>
            <div class="col-md-4">
                <div class="latest-posts">
                    @foreach($latestFooterPosts as $latestFooterPost)
                    <a href="{{route('blog_post_page', ['id'=>$latestFooterPost->id ,'slug'=>$latestFooterPost->slug])}}">
                        <div class="post d-flex align-items-center">
                            <div class="image">
                                <img src="{{$latestFooterPost->additionalImageUrl()}}" alt="..." class="img-fluid">
                            </div>
                            <div class="title">
                                <strong>{{$latestFooterPost->heading}}</strong>
                                <span class="date last-meta">{{$latestFooterPost->created_at->format('F d, Y')}}</span>
                            </div>
                        </div>
                    </a>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
    <div class="copyrights">
        <div class="container">
            <div class="row">
                <div class="col-md-6">
                    <p>&copy; 2017. All rights reserved. Your great site.</p>
                </div>
                <div class="col-md-6 text-right">
                    <p>Template By <a href="https://bootstrapious.com/p/bootstrap-carousel" class="text-white">Bootstrapious</a>
                        <!-- Please do not remove the backlink to Bootstrap Temple unless you purchase an attribution-free license @ Bootstrap Temple or support us at http://bootstrapious.com/donate. It is part of the license conditions. Thanks for understanding :)                         -->
                    </p>
                </div>
            </div>
        </div>
    </div>
</footer>
