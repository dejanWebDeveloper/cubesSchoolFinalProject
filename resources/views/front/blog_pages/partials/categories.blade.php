<div class="widget categories">
    <header>
        <h3 class="h6">Categories</h3>
    </header>
@foreach($allCategoriesForBlogPartial as $category)
    <div class="item d-flex justify-content-between">
        <a href="{{route('blog_category_page', ['name'=>$category->name])}}">{{$category->name}}</a>
        <span>{{$category->posts_count}}</span>
    </div>
    @endforeach
</div>
