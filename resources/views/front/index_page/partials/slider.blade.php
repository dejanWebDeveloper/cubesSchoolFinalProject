<div id="index-slider" class="owl-carousel">
    @foreach($sliderData as $oneSlider)
    <section style="background: url({{$oneSlider->sliderImageUrl()}}); background-size: cover; background-position: center center" class="hero">
        <div class="container">
            <div class="row">
                <div class="col-lg-7">
                    <h1>{{$oneSlider->heading}}</h1>
                    <a href="{{$oneSlider->url}}" class="hero-link">{{$oneSlider->button_name}}</a>
                </div>
            </div>
        </div>
    </section>
    @endforeach
</div>
