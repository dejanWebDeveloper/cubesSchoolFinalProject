<div class="btn-group">
    <a href="{{route('blog_post_page', ['id'=>$row->post->id, 'slug'=>$row->post->slug])}}" class="btn btn-info" target="_blank">
        <i class="fas fa-eye"></i>
    </a>
    @if($row->enable == 0)
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
