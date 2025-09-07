<div class="btn-group">
    @if ($row->id == Auth::id())
    <a href="{{route('admin_users_edit_user_page')}}" class="btn btn-info">
        <i class="fas fa-edit"></i>
    </a>
    @endif
    @if($row->status == 0)
    <button data-id="{{$row->id}}" data-name="{{$row->name}}" type="button" data-action="enable"
            class="btn btn-info" data-toggle="modal" data-target="#enable-modal">
        <i class="fas fa-check"></i>
    </button>
    @else
    <button data-id="{{$row->id}}" data-name="{{$row->name}}" type="button" data-action="disable"
            class="btn btn-info" data-toggle="modal" data-target="#disable-modal">
        <i class="fas fa-ban"></i>
    </button>
    @endif
</div>
