<div class="btn-group">
    <a href="{{route('admin_sliders_edit_slider_page', ['id'=>$row->id, 'slug'=>$row->slug])}}" class="btn btn-info">
        <i class="fas fa-edit"></i>
    </a>
    <button data-id="{{$row->id}}" data-name="{{$row->heading}}" data-action="delete"
            type="button" class="btn btn-info" data-toggle="modal" data-target="#delete-modal">
        <i class="fas fa-trash"></i>
    </button>
    @if($row->status == 0)
        <button data-id="{{$row->id}}" data-name="{{$row->heading}}" type="button" data-action="enable"
                class="btn btn-info" data-toggle="modal" data-target="#enable-modal">
            <i class="fas fa-check"></i>
        </button>
    @else
        <button data-id="{{$row->id}}" data-name="{{$row->heading}}" type="button" data-action="disable"
                class="btn btn-info" data-toggle="modal" data-target="#disable-modal">
            <i class="fas fa-ban"></i>
        </button>
    @endif
</div>
