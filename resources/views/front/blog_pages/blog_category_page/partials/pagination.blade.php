<nav aria-label="Page navigation example">
    {{ $blogPosts->withQueryString()->links('pagination::bootstrap-4') }}
</nav>
