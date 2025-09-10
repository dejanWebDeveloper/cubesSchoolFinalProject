<div class="btn-group">
    <a href="{{route('admin_sliders_edit_slider_page', ['slug'=>$row->slug])}}" class="btn btn-info">
        <i class="fas fa-edit"></i>
    </a>
    <button data-id="{{$row->id}}" data-name="{{$row->heading}}" data-action="delete"
            type="button" class="btn btn-info" data-toggle="modal" data-target="#delete-modal">
        <i class="fas fa-trash"></i>
    </button>
</div>
