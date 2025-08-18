<div class="widget search">
    <header>
        <h3 class="h6">Search the blog</h3>
    </header>
    <form method="get" action="{{route('blog_search_page')}}">
        <div class="form-group">
            <input type="search" name="search" id="search" placeholder="What are you looking for?">
            <button type="submit" class="submit"><i class="icon-search-1"></i></button>
        </div>
    </form>
</div>
