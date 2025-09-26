@push('head_link')
    <!--css link za dataTable plugin-->
    <link rel="stylesheet" href="https://cdn.datatables.net/2.3.2/css/dataTables.dataTables.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.css"
          integrity="sha512-3pIirOrwegjM6erE5gPSwkUzO+3cTjpnV9lexlNZqvupR64iZBnOOTiiLPb9M36zpMScbmUNIcHUqKD47M719g=="
          crossorigin="anonymous" referrerpolicy="no-referrer"/>
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet"/>
    <style>
        .select2-container--default .select2-selection--single {
            height: 40px;
        }

        .select2-container--default .select2-selection--multiple {
            min-height: 40px;
            font-size: 16px;
        }
    </style>
@endpush
@extends('admin._layouts._layout')

@section('content')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Products</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{route('admin_index_page')}}">Home</a></li>
                        <li class="breadcrumb-item active">Posts</li>
                    </ol>
                </div>
            </div>
        </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Search Products</h3>
                            <div class="card-tools">
                                <a href="{{route('admin_posts_add_post')}}" class="btn btn-success">
                                    <i class="fas fa-plus-square"></i>
                                    Add New Post
                                </a>
                            </div>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">
                            @if(session()->has('system_message'))
                                <div id="system-message" class="alert alert-success" role="alert">
                                    {{session()->pull('system_message')}}
                                </div>
                            @endif
                            <form id="entities-filter-form">
                                <div class="row">
                                    <div class="col-md-3 form-group">
                                        <label>Heading</label>
                                        <input style="height: 40px;" type="text" name="heading" class="form-control"
                                               placeholder="Search by heading">
                                    </div>
                                    <div class="col-md-2 form-group">
                                        <label>Category</label>
                                        <select id="select-category" name="category_id" class="form-control">
                                            <option></option>
                                            @foreach($categories as $category)
                                                <option value="{{$category->id}}">{{$category->name}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-md-2 form-group">
                                        <label>Author</label>
                                        <select id="select-author" name="author_id" class="form-control">
                                            <option></option>
                                            @foreach($authors as $author)
                                                <option value="{{$author->id}}">{{$author->name}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-md-2 form-group">
                                        <label>Tags</label>
                                        <select id="select-tags" name="tags_id[]" class="form-control" multiple>
                                            @foreach($tags as $tag)
                                                <option value="{{$tag->id}}">{{$tag->name}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-md-1 form-group">
                                        <label>Enable</label>
                                        <select id="select-enable" name="enable" class="form-control">
                                            <option></option>
                                            <option value="1">Yes</option>
                                            <option value="0">No</option>
                                        </select>
                                    </div>
                                    <div class="col-md-1 form-group">
                                        <label>Important</label>
                                        <select id="select-important" name="important" class="form-control">
                                            <option></option>
                                            <option value="1">Yes</option>
                                            <option value="0">No</option>
                                        </select>
                                    </div>
                                </div>
                            </form>
                        </div>
                        <!-- /.card-body -->
                        <div class="card-footer clearfix">

                        </div>
                    </div>
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">All Products</h3>
                            <div class="card-tools">

                            </div>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">
                            <table id="posts-table" class="table table-bordered">
                                <thead>
                                <tr>
                                    <th class="text-center">#</th>
                                    <th class="text-center">Photo</th>
                                    <th style="width: 20%;">Heading</th>
                                    <th class="text-center">Enable</th>
                                    <th class="text-center">Important</th>
                                    <th class="text-center">Category</th>
                                    <th class="text-center">Comments</th>
                                    <th class="text-center">Views</th>
                                    <th class="text-center">Author</th>
                                    <th class="text-center">Created At</th>
                                    <th class="text-center">Actions</th>
                                </tr>
                                </thead>
                                <tbody>
                                <!-- script code of dataTable -->
                                </tbody>
                            </table>
                        </div>
                        <!-- /.card-body -->
                        <div class="card-footer clearfix">

                        </div>
                    </div>
                    <!-- /.card -->
                </div>
                <!-- /.col -->
            </div>
            <!-- /.row -->
        </div><!-- /.container-fluid -->
    </section>

    <!-- enable/disable -->
    <div class="modal fade" id="disable-modal">
        <div class="modal-dialog">
            <div class="modal-content">
                <form id="disable-post" method="post" action="{{route('admin_posts_disable_post')}}">
                    @csrf
                    <input type="hidden" name="post_for_disable_id" value="">
                    <div class="modal-header">
                        <h4 class="modal-title">Disable Post</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <p>Are you sure you want to disable post?</p>
                        <strong><p id="post_for_disable_name"></p></strong>
                    </div>
                    <div class="modal-footer justify-content-between">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-danger">
                            <i class="fas fa-minus-circle"></i>
                            Disable
                        </button>
                    </div>
                </form>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>
    <!-- /.modal -->

    <div class="modal fade" id="enable-modal">
        <div class="modal-dialog">
            <div class="modal-content">
                <form id="enable-post" method="post" action="{{route('admin_posts_enable_post')}}">
                    @csrf
                    <input type="hidden" name="post_for_enable_id" value="">
                    <div class="modal-header">
                        <h4 class="modal-title">Enable Post</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <p>Are you sure you want to enable post?</p>
                        <strong><p id="post_for_enable_name"></p></strong>
                    </div>
                    <div class="modal-footer justify-content-between">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-success">
                            <i class="fas fa-check"></i>
                            Enable
                        </button>
                    </div>
                </form>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>

    <!-- important/unimportant -->
    <div class="modal fade" id="unimportant-modal">
        <div class="modal-dialog">
            <div class="modal-content">
                <form id="be_unimportant-post" method="post" action="{{route('admin_posts_be_unimportant_post')}}">
                    @csrf
                    <input type="hidden" name="post_be_unimportant_id" value="">
                    <div class="modal-header">
                        <h4 class="modal-title">Post Be Unimportant</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <p>Are you sure you want to change status to unimportant?</p>
                        <strong><p id="post_be_unimportant_name"></p></strong>
                    </div>
                    <div class="modal-footer justify-content-between">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-danger">
                            <i class="fas fa-minus-circle"></i>
                            Yes
                        </button>
                    </div>
                </form>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>
    <!-- /.modal -->

    <div class="modal fade" id="important-modal">
        <div class="modal-dialog">
            <div class="modal-content">
                <form id="be_important-post" method="post" action="{{route('admin_posts_be_important_post')}}">
                    @csrf
                    <input type="hidden" name="post_be_important_id" value="">
                    <div class="modal-header">
                        <h4 class="modal-title">Post Be Important</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <p>Are you sure you want to change status to important?</p>
                        <strong><p id="post_be_important_name"></p></strong>
                    </div>
                    <div class="modal-footer justify-content-between">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-danger">
                            <i class="fas fa-minus-circle"></i>
                            Yes
                        </button>
                    </div>
                </form>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>

    <!-- /.content -->
    <div class="modal fade" id="delete-modal">
        <div class="modal-dialog">
            <div class="modal-content">
                <form id="delete-post" method="post" action="{{route('admin_posts_delete_post')}}">
                    @csrf
                    <input type="hidden" name="post_for_delete_id" value="">
                    <div class="modal-header">
                        <h4 class="modal-title">Delete Post</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <p>Are you sure you want to delete post?</p>
                        <strong><p id="post_for_delete_name"></p></strong>
                    </div>
                    <div class="modal-footer justify-content-between">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-danger">Delete</button>
                    </div>
                </form>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>
    <!-- /.modal -->
@endsection
@push('footer_script')
    <script src="https://cdn.datatables.net/2.3.2/js/dataTables.min.js"></script>
    <script type="text/javascript"
            src="https://cdn.jsdelivr.net/npm/jquery-validation@1.19.5/dist/jquery.validate.min.js"></script>
    <script type="text/javascript"
            src="https://cdn.jsdelivr.net/npm/jquery-validation@1.19.5/dist/additional-methods.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"
            integrity="sha512-VEd+nq25CkR676O+pLBnDW09R7VQX9Mdiij052gVCp5yVH3jGtH70Ho/UUv4mJDsEdTvqRCFZg0NKGiojGnUCw=="
            crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script>
        $(document).ready(function () {
            $('#select-author').select2({
                placeholder: "Select Author",
                allowClear: true
            });
            $('#select-category').select2({
                placeholder: "Select Category",
                allowClear: true
            });
            $('#select-tags').select2({
                placeholder: "Select Tags",
                allowClear: true
            });
            $('#select-enable').select2({
                placeholder: "Y/N",
                allowClear: true
            });
            $('#select-important').select2({
                placeholder: "Y/N",
                allowClear: true
            });
            //plugin za data tables
            $('#posts-table').DataTable({
                serverSide: true,
                processing: true,
                ajax: {
                    url: "{{ route('admin_posts_datatable') }}",
                    type: "post",
                    data: function (d) {
                        d._token = "{{ csrf_token() }}";
                        d.heading = $('input[name=heading]').val();
                        d.category_id = $('select[name=category_id]').val();
                        d.author_id = $('select[name=author_id]').val();
                        d.enable = $('select[name=enable]').val();
                        d.important = $('select[name=important]').val();
                        d.tags_id = $('select[name="tags_id[]"]').val();
                    }
                },
                order: [[9, "desc"]],
                columns: [
                    {data: "id", name: "id", className: 'text-center'},
                    {data: "photo", name: "Photo", orderable: false, searchable: false, className: 'text-center'},
                    {data: "heading", name: "Heading"},
                    {data: "enable", name: "Enable", orderable: false, className: 'text-center'},
                    {data: "important", name: "Important", orderable: false, className: 'text-center'},
                    {data: "category", name: "Category", className: 'text-center'},
                    {data: "comments", name: "Comments", searchable: false, className: 'text-center'},
                    {data: "views", name: "Views", searchable: false, className: 'text-center'},
                    {data: "author", name: "Author", className: 'text-center'},
                    {data: "created_at", name: "Created_at", searchable: false, className: 'text-center'},
                    {data: "actions", name: "Actions", orderable: false, searchable: false, className: 'text-center'}
                ],
                pageLength: 15,
                lengthMenu: [5, 10, 15, 40, 100]
            });

            // reload table when filter was changed
            $('#entities-filter-form input, #entities-filter-form select').on('change keyup', function () {
                $('#posts-table').DataTable().ajax.reload();
            });

            //enable/disable
            //disable slider
            $('#posts-table').on('click', "[data-action='disable']", function () {
                let id = $(this).attr('data-id');
                let name = $(this).attr('data-name');

                $("#disable-modal [name='post_for_disable_id']").val(id);
                $('#disable-modal p#post_for_disable_name').html(name);
            });
            $('#disable-post').on('submit', function (e) {
                e.preventDefault();
                let postId = $("#disable-modal [name='post_for_disable_id']").val(); // take ID from hidden modal input

                $.ajax({
                    url: "{{ route('admin_posts_disable_post') }}",
                    type: "post",
                    data: {
                        _token: "{{ csrf_token() }}",
                        post_for_disable_id: postId
                    },
                    success: function () {
                        // hide modal
                        $('#disable-modal').modal('hide');
                        toastr.success('Post Successfully Disabled.');
                        // Reload all DataTables
                        $('#posts-table').DataTable().ajax.reload(null, false);
                    }
                });
            });
            //enable user
            $('#posts-table').on('click', "[data-action='enable']", function () {
                let id = $(this).attr('data-id');
                let name = $(this).attr('data-name');

                $("#enable-modal [name='post_for_enable_id']").val(id);
                $('#enable-modal p#post_for_enable_name').html(name);
            });
            $('#enable-post').on('submit', function (e) {
                e.preventDefault();
                let postId = $("#enable-modal [name='post_for_enable_id']").val(); // take ID from hidden modal input

                $.ajax({
                    url: "{{ route('admin_posts_enable_post') }}",
                    type: "post",
                    data: {
                        _token: "{{ csrf_token() }}",
                        post_for_enable_id: postId
                    },
                    success: function () {
                        // hide modal
                        $('#enable-modal').modal('hide');
                        toastr.success('Post Successfully Enabled.');
                        // Reload dataTables
                        $('#posts-table').DataTable().ajax.reload(null, false);
                    }
                });
            });
            //important/unimportant
            $('#posts-table').on('click', "[data-action='unimportant']", function () {
                let id = $(this).attr('data-id');
                let name = $(this).attr('data-name');

                $("#unimportant-modal [name='post_be_unimportant_id']").val(id);
                $('#unimportant-modal p#post_be_unimportant_name').html(name);
            });
            $('#be_unimportant-post').on('submit', function (e) {
                e.preventDefault();
                let postId = $("#unimportant-modal [name='post_be_unimportant_id']").val(); // take ID from hidden modal input

                $.ajax({
                    url: "{{ route('admin_posts_be_unimportant_post') }}",
                    type: "post",
                    data: {
                        _token: "{{ csrf_token() }}",
                        post_be_unimportant_id: postId
                    },
                    success: function () {
                        // hide modal
                        $('#unimportant-modal').modal('hide');
                        toastr.success('Post Successfully Change Status to Unimportant.');
                        // Reload all DataTables
                        $('#posts-table').DataTable().ajax.reload(null, false);
                    }
                });
            });
            //be important post
            $('#posts-table').on('click', "[data-action='important']", function () {
                let id = $(this).attr('data-id');
                let name = $(this).attr('data-name');

                $("#important-modal [name='post_be_important_id']").val(id);
                $('#important-modal p#post_be_important_name').html(name);
            });
            $('#be_important-post').on('submit', function (e) {
                e.preventDefault();
                let postId = $("#important-modal [name='post_be_important_id']").val(); // take ID from hidden modal input

                $.ajax({
                    url: "{{ route('admin_posts_be_important_post') }}",
                    type: "post",
                    data: {
                        _token: "{{ csrf_token() }}",
                        post_be_important_id: postId
                    },
                    success: function () {
                        // hide modal
                        $('#important-modal').modal('hide');
                        toastr.success('Post Successfully Change Status to Important.');
                        // Reload all DataTables
                        $('#posts-table').DataTable().ajax.reload(null, false);
                    }
                });
            });
            //delete post
            // Open modal and enter data
            $('#posts-table').on('click', "[data-action='delete']", function () {
                let id = $(this).attr('data-id');
                let name = $(this).attr('data-name');

                $("#delete-modal [name='post_for_delete_id']").val(id);
                $('#delete-modal p#post_for_delete_name').html(name);
            });

            // Click on button for delete
            $('#delete-post').on('submit', function (e) {
                e.preventDefault();
                let postId = $("#delete-modal [name='post_for_delete_id']").val(); // take ID from hidden modal input

                $.ajax({
                    url: "{{ route('admin_posts_delete_post') }}",
                    type: "post",
                    data: {
                        _token: "{{ csrf_token() }}",
                        post_for_delete_id: postId
                    },
                    success: function () {
                        // hide modal
                        $('#delete-modal').modal('hide');
                        toastr.success('Post Successfully Deleted.');
                        // Reload celog DataTables umesto ručnog uklanjanja reda
                        $('#posts-table').DataTable().ajax.reload(null, false);
                    }
                });
            });
        });
        //system-message disappear after 2s
        document.addEventListener('DOMContentLoaded', function () {
            const msg = document.getElementById('system-message');
            if(msg){
                setTimeout(() => {
                    msg.style.transition = "opacity 0.5s ease";
                    msg.style.opacity = 0;
                    setTimeout(() => msg.remove(), 500); // uklanja iz DOM-a nakon fade out
                }, 2000);
            }
        });
    </script>
@endpush
