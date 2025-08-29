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
                                    <th style="width: 10px">#</th>
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
    <!-- /.content -->

    <div class="modal fade" id="delete-modal">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Delete Post</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <p>Are you sure you want to delete post?</p>
                    <strong></strong>
                </div>
                <div class="modal-footer justify-content-between">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btn-danger">Delete</button>
                </div>
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
                    {data: "id", name: "id"},
                    {data: "photo", name: "Photo", orderable: false, searchable: false},
                    {data: "heading", name: "Heading"},
                    {data: "enable", name: "Enable", orderable: false},
                    {data: "important", name: "Important", orderable: false},
                    {data: "category", name: "Category"},
                    {data: "comments", name: "Comments", searchable: false},
                    {data: "views", name: "Views", searchable: false},
                    {data: "author", name: "Author"},
                    {data: "created_at", name: "Created_at", searchable: false},
                    {data: "actions", name: "Actions", orderable: false, searchable: false}
                ],
                pageLength: 15,
                lengthMenu: [5, 10, 15, 40, 100]
            });

            // reload tabele kada se promeni filter
            $('#entities-filter-form input, #entities-filter-form select').on('change keyup', function () {
                $('#posts-table').DataTable().ajax.reload();
            });
        });
    </script>
@endpush
