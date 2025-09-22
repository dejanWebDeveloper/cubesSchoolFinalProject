<nav aria-label="Page navigation example">
    {{ $categoryPosts->withQueryString()->links('pagination::bootstrap-4') }}
</nav>
