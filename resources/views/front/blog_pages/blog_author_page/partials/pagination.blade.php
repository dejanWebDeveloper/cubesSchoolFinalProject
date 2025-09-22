<nav aria-label="Page navigation example">
    {{ $authorPosts->withQueryString()->links('pagination::bootstrap-4') }}
</nav>
