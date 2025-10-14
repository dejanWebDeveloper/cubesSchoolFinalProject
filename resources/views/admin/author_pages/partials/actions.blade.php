<div class="btn-group">
    <a href="{{route('blog_author_page', ['id'=>$row->id, 'slug'=>$row->slug])}}" class="btn btn-info" target="_blank">
        <i class="fas fa-eye"></i>
    </a>
    <a href="{{route('admin.authors.edit', ['id'=>$row->id, 'slug'=>$row->slug])}}" class="btn btn-info">
        <i class="fas fa-edit"></i>
    </a>
    <button data-id="{{$row->id}}" data-name="{{$row->name}}" data-action="delete"
            type="button" class="btn btn-info" data-toggle="modal" data-target="#delete-modal">
        <i class="fas fa-trash"></i>
    </button>
</div>
