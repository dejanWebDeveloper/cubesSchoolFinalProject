<div class="widget categories">
    <header>
        <h3 class="h6">Categories</h3>
    </header>
@foreach($allCategoriesForBlogPartial as $category)
    <div class="item d-flex justify-content-between">
        <a href="blog-category.html">{{$category->name}}</a>
        <span>{{$category->posts()->count()}}</span>
    </div>
    @endforeach
</div>
