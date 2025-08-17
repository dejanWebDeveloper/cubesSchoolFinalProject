<section class="gallery no-padding">
    <div class="row">
        @for($i = 1; $i <= 4; $i++)
            <div class="mix col-lg-3 col-md-3 col-sm-6">
                <div class="item">
                    <a href="{{ url("/themes/front/img/gallery-$i.jpg") }}" data-fancybox="gallery" class="image">
                        <img src="{{ url("/themes/front/img/gallery-$i.jpg") }}" alt="gallery image alt {{ $i }}" class="img-fluid" title="gallery image title {{ $i }}">
                        <div class="overlay d-flex align-items-center justify-content-center">
                            <i class="icon-search"></i>
                        </div>
                    </a>
                </div>
            </div>
        @endfor
    </div>
</section>
