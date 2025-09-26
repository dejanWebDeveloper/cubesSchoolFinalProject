@push('head_link')
    <!--css link za dataTable plugin-->
    <link rel="stylesheet" href="https://cdn.datatables.net/2.3.2/css/dataTables.dataTables.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.css"
          integrity="sha512-3pIirOrwegjM6erE5gPSwkUzO+3cTjpnV9lexlNZqvupR64iZBnOOTiiLPb9M36zpMScbmUNIcHUqKD47M719g=="
          crossorigin="anonymous" referrerpolicy="no-referrer"/>
@endpush
@extends('admin._layouts._layout')

@section('content')
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Search Comments</h3>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">
                            <form id="entities-filter-form">
                                <div class="row">
                                    <div class="col-md-3 form-group">
                                        <label>Name</label>
                                        <input style="height: 40px;" type="number" name="post_id" class="form-control"
                                               placeholder="Search by Id">
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
                            <h3 class="card-title">All Comments</h3>
                            <div class="card-tools">
                            </div>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">
                            <table id="comments-table" class="table table-bordered">
                                <thead>
                                <tr>
                                    <th class="text-center">#</th>
                                    <th>Comment</th>
                                    <th>Post</th>
                                    <th class="text-center">PostId</th>
                                    <th class="text-center">Enable</th>
                                    <th class="text-center">Created At</th>
                                    <th class="text-center">Actions</th>
                                </tr>
                                </thead>
                                <tbody>

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
    <!-- Disable modal -->
    <div class="modal fade" id="disable-modal">
        <div class="modal-dialog">
            <div class="modal-content">
                <form id="disable-comment" method="post" action="{{route('admin_comments_disable_comment')}}">
                    @csrf
                    <input type="hidden" name="comment_for_disable_id" value="">
                    <div class="modal-header">
                        <h4 class="modal-title">Disable Comment</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <p>Are you sure you want to disable comment?</p>
                        <strong><p id="comment_for_disable_name"></p></strong>
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
    </div>
<!-- Enable modal -->
    <div class="modal fade" id="enable-modal">
        <div class="modal-dialog">
            <div class="modal-content">
                <form id="enable-comment" method="post" action="{{route('admin_comments_enable_comment')}}">
                    @csrf
                    <input type="hidden" name="comment_for_enable_id" value="">
                    <div class="modal-header">
                        <h4 class="modal-title">Enable Comment</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <p>Are you sure you want to enable comment?</p>
                        <strong><p id="comment_for_enable_name"></p></strong>
                    </div>
                    <div class="modal-footer justify-content-between">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-danger">
                            <i class="fas fa-minus-circle"></i>
                            Enable
                        </button>
                    </div>
                </form>
            </div>
            <!-- /.modal-content -->
        </div>
    </div>
        <!-- /.modal -->

        <!-- /.modal -->
        @endsection
        @push('footer_script')
            <script src="https://cdn.datatables.net/2.3.2/js/dataTables.min.js"></script>
            <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"
                    integrity="sha512-VEd+nq25CkR676O+pLBnDW09R7VQX9Mdiij052gVCp5yVH3jGtH70Ho/UUv4mJDsEdTvqRCFZg0NKGiojGnUCw=="
                    crossorigin="anonymous" referrerpolicy="no-referrer"></script>
            <script>
                $(document).ready(function () {
                    //plugin za data tables
                    $('#comments-table').DataTable({
                        serverSide: true,
                        processing: true,
                        ajax: {
                            url: "{{ route('admin_comments_datatable_comments') }}",
                            type: "post",
                            data: function (d) {
                                d._token = "{{ csrf_token() }}";
                                d.post_id = $('input[name=post_id]').val();
                            }
                        },
                        order: [[5, "desc"]],
                        columns: [
                            {data: "id", name: "id", className: 'text-center'},
                            {data: "comment", name: "Comment"},
                            {data: "post", name: "Post", orderable: false},
                            {data: "post_id", name: "PostId", searchable: false, className: 'text-center'},
                            {data: "enable", name: "Enable", searchable: false, orderable: false, className: 'text-center'},
                            {data: "created_at", name: "Created_at", searchable: false, className: 'text-center'},
                            {data: "actions", name: "Actions", orderable: false, searchable: false, className: 'text-center'}
                        ],
                        pageLength: 10,
                        lengthMenu: [5, 10, 20, 40]
                    });

                    // reload table when filter was changed
                    $('#entities-filter-form input, #entities-filter-form select').on('change keyup', function () {
                        $('#comments-table').DataTable().ajax.reload();
                    });

                    $('#comments-table').on('click', "[data-action='disable']", function () {
                        let id = $(this).attr('data-id');
                        let name = $(this).attr('data-name');

                        $("#disable-modal [name='comment_for_disable_id']").val(id);
                        $('#disable-modal p#comment_for_disable_name').html(name);
                    });

                    // Click on button for disable
                    $('#disable-comment').on('submit', function (e) {
                        e.preventDefault();
                        let commentId = $("#disable-modal [name='comment_for_disable_id']").val(); // take ID from hidden modal input

                        $.ajax({
                            url: "{{ route('admin_comments_disable_comment') }}",
                            type: "post",
                            data: {
                                _token: "{{ csrf_token() }}",
                                comment_for_disable_id: commentId
                            },
                            success: function () {
                                // hide modal
                                $('#disable-modal').modal('hide');
                                toastr.success('Comment Successfully Disabled.');
                                // Reload celog DataTables umesto ručnog uklanjanja reda
                                $('#comments-table').DataTable().ajax.reload(null, false);
                            }
                        });
                    });

                    $('#comments-table').on('click', "[data-action='enable']", function () {
                        let id = $(this).attr('data-id');
                        let name = $(this).attr('data-name');

                        $("#enable-modal [name='comment_for_enable_id']").val(id);
                        $('#enable-modal p#comment_for_enable_name').html(name);
                    });

                    // Click on button for enable
                    $('#enable-comment').on('submit', function (e) {
                        e.preventDefault();
                        let commentId = $("#enable-modal [name='comment_for_enable_id']").val(); // take ID from hidden modal input

                        $.ajax({
                            url: "{{ route('admin_comments_enable_comment') }}",
                            type: "post",
                            data: {
                                _token: "{{ csrf_token() }}",
                                comment_for_enable_id: commentId
                            },
                            success: function () {
                                // hide modal
                                $('#enable-modal').modal('hide');
                                toastr.success('Comment Successfully Enabled.');
                                // Reload celog DataTables umesto ručnog uklanjanja reda
                                $('#comments-table').DataTable().ajax.reload(null, false);
                            }
                        });
                    });
                });
            </script>
    @endpush
