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
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Search Users</h3>
                            <div class="card-tools">
                                <a href="{{route('admin_users_add_user')}}" class="btn btn-success">
                                    <i class="fas fa-plus-square"></i>
                                    Add new User
                                </a>
                            </div>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">
                            @if(session()->has('system_message'))
                                <div class="alert alert-success" role="alert">
                                    {{session()->pull('system_message')}}
                                </div>
                            @endif
                            <form id="entities-filter-form">
                                <div class="row">
                                    <div class="col-md-1 form-group">
                                        <label>Status</label>
                                        <select id="select-status" name="status" class="form-control">
                                            <option></option>
                                            <option value="1">Enabled</option>
                                            <option value="0">Disabled</option>
                                        </select>
                                    </div>
                                    <div class="col-md-3 form-group">
                                        <label>Email</label>
                                        <input name="email" type="text" class="form-control" placeholder="Search by email">
                                    </div>
                                    <div class="col-md-3 form-group">
                                        <label>Name</label>
                                        <input name="name" type="text" class="form-control" placeholder="Search by name">
                                    </div>
                                    <div class="col-md-3 form-group">
                                        <label>Phone</label>
                                        <input name="phone" type="text" class="form-control" placeholder="Search by phone">
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
                            <h3 class="card-title">All Users</h3>
                            <div class="card-tools">

                            </div>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">
                            <table id="users-table" class="table text-center table-bordered">
                                <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Status</th>
                                    <th>Photo</th>
                                    <th>Email</th>
                                    <th>Name</th>
                                    <th>Phone</th>
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
    <!-- /.modal -->
    <div class="modal fade" id="disable-modal">
        <div class="modal-dialog">
            <div class="modal-content">
                <form id="disable-user" method="post" action="{{route('admin_users_disable_user')}}">
                    @csrf
                    <input type="hidden" name="user_for_disable_id" value="">
                    <div class="modal-header">
                        <h4 class="modal-title">Disable User</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <p>Are you sure you want to disable user?</p>
                        <strong><p id="user_for_disable_name"></p></strong>
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
                <form id="enable-user" method="post" action="{{route('admin_users_enable_user')}}">
                    @csrf
                    <input type="hidden" name="user_for_enable_id" value="">
                    <div class="modal-header">
                        <h4 class="modal-title">Enable User</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <p>Are you sure you want to enable user?</p>
                        <strong><p id="user_for_enable_name"></p></strong>
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
            $('#select-status').select2({
                placeholder: "Status",
                allowClear: true
            });
            //plugin za data tables
            $('#users-table').DataTable({
                serverSide: true,
                processing: true,
                ajax: {
                    url: "{{ route('admin_users_datatable') }}",
                    type: "post",
                    data: function (d) {
                        d._token = "{{ csrf_token() }}";
                        d.name = $('input[name=name]').val();
                        d.email = $('input[name=email]').val();
                        d.phone = $('input[name=phone]').val();
                        d.status = $('select[name=status]').val();
                    }
                },
                order: [[6, "asc"]],
                columns: [
                    {data: "id", name: "id"},
                    {data: "status", name: "Status"},
                    {data: "profile_photo", name: "Photo", orderable: false, searchable: false},
                    {data: "email", name: "Email"},
                    {data: "name", name: "Name"},
                    {data: "phone", name: "Phone"},
                    {data: "created_at", name: "Created_at", searchable: false},
                    {data: "actions", name: "Actions", orderable: false, searchable: false}
                ],
                pageLength: 10,
                lengthMenu: [5, 10, 20]
            });

            // reload table when filter was changed
            $('#entities-filter-form input, #entities-filter-form select').on('change keyup', function () {
                $('#users-table').DataTable().ajax.reload();
            });
            //$('#select-status').change(function () {
              //  table.draw();
            //});
            //disable user
            // Open modal and enter data
            $('#users-table').on('click', "[data-action='disable']", function () {
                let id = $(this).attr('data-id');
                let name = $(this).attr('data-name');

                $("#disable-modal [name='user_for_disable_id']").val(id);
                $('#disable-modal p#user_for_disable_name').html(name);
            });

            // Click on button for disable
            $('#disable-user').on('submit', function (e) {
                e.preventDefault();
                let userId = $("#disable-modal [name='user_for_disable_id']").val(); // take ID from hidden modal input

                $.ajax({
                    url: "{{ route('admin_users_disable_user') }}",
                    type: "post",
                    data: {
                        _token: "{{ csrf_token() }}",
                        user_for_disable_id: userId
                    },
                    success: function () {
                        // hide modal
                        $('#disable-modal').modal('hide');
                        toastr.success('User Successfully Disabled.');
                        // Reload celog DataTables umesto ručnog uklanjanja reda
                        $('#users-table').DataTable().ajax.reload(null, false);
                    }
                });
            });
            //enable user
            $('#users-table').on('click', "[data-action='enable']", function () {
                let id = $(this).attr('data-id');
                let name = $(this).attr('data-name');

                $("#enable-modal [name='user_for_enable_id']").val(id);
                $('#enable-modal p#user_for_enable_name').html(name);
            });

            // Click on button for enable
            $('#enable-user').on('submit', function (e) {
                e.preventDefault();
                let userId = $("#enable-modal [name='user_for_enable_id']").val(); // take ID from hidden modal input

                $.ajax({
                    url: "{{ route('admin_users_enable_user') }}",
                    type: "post",
                    data: {
                        _token: "{{ csrf_token() }}",
                        user_for_enable_id: userId
                    },
                    success: function () {
                        // hide modal
                        $('#enable-modal').modal('hide');
                        toastr.success('User Successfully Enabled.');
                        // Reload dataTables
                        $('#users-table').DataTable().ajax.reload(null, false);
                    }
                });
            });
        });
    </script>
@endpush
