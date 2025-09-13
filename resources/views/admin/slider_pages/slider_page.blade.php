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
                    </div>
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">All Slider Data</h3>
                            <div class="card-tools">
                            </div>
                            <div class="card-tools">
                                <a href="{{route('admin_sliders_add_slider')}}" class="btn btn-success">
                                    <i class="fas fa-plus-square"></i>
                                    Add New Slider Data
                                </a>
                            </div>
                        </div>
                        @if(session()->has('system_message'))
                            <div class="alert alert-success" role="alert">
                                {{session()->pull('system_message')}}
                            </div>
                        @endif
                        <!-- /.card-header -->
                        <div class="card-body">
                            <table id="sliders-table" class="table table-bordered">
                                <thead>
                                <tr>
                                    <th style="width: 10px">#</th>
                                    <th class="text-center">Background</th>
                                    <th>Heading</th>
                                    <th>Url</th>
                                    <th>Button Name</th>
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
    <div class="modal fade" id="disable-modal">
        <div class="modal-dialog">
            <div class="modal-content">
                <form id="disable-slider" method="post" action="{{route('admin_sliders_disable_slider')}}">
                    @csrf
                    <input type="hidden" name="slider_for_disable_id" value="">
                    <div class="modal-header">
                        <h4 class="modal-title">Disable Slide</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <p>Are you sure you want to disable slide?</p>
                        <strong><p id="slider_for_disable_name"></p></strong>
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
                <form id="enable-slider" method="post" action="{{route('admin_sliders_enable_slider')}}">
                    @csrf
                    <input type="hidden" name="slider_for_enable_id" value="">
                    <div class="modal-header">
                        <h4 class="modal-title">Enable Slide</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <p>Are you sure you want to enable slide?</p>
                        <strong><p id="slider_for_enable_name"></p></strong>
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
    <div class="modal fade" id="delete-modal">
        <div class="modal-dialog">
            <div class="modal-content">
                <form id="delete-slider" method="post" action="{{route('admin_sliders_delete_slider')}}">
                    @csrf
                    <input type="hidden" name="slider_for_delete_id" value="">
                    <div class="modal-header">
                        <h4 class="modal-title">Delete Slider</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <p>Are you sure you want to delete slider?</p>
                        <strong><p id="slider_for_delete_name"></p></strong>
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
    <script>
        $(document).ready(function () {
            //plugin za data tables
            $('#sliders-table').DataTable({
                serverSide: true,
                processing: true,
                ajax: {
                    url: "{{ route('admin_sliders_datatable') }}",
                    type: "post",
                    data: function (d) {
                        d._token = "{{ csrf_token() }}";
                    }
                },
                order: [[5, "desc"]],
                columns: [
                    {data: "id", name: "id"},
                    {data: "background", name: "Background", orderable: false, searchable: false},
                    {data: "heading", name: "Heading"},
                    {data: "url", name: "URL", orderable: false, searchable: false},
                    {data: "button_name", name: "Button Name", orderable: false, searchable: false},
                    {data: "created_at", name: "Created_at", searchable: false},
                    {data: "actions", name: "Actions", orderable: false, searchable: false}
                ],
                pageLength: 5,
                lengthMenu: [5, 10, 20]
            });
            //disable slider
            $('#sliders-table').on('click', "[data-action='disable']", function () {
                let id = $(this).attr('data-id');
                let name = $(this).attr('data-name');

                $("#disable-modal [name='slider_for_disable_id']").val(id);
                $('#disable-modal p#slider_for_disable_name').html(name);
            });
            $('#disable-slider').on('submit', function (e) {
                e.preventDefault();
                let sliderId = $("#disable-modal [name='slider_for_disable_id']").val(); // take ID from hidden modal input

                $.ajax({
                    url: "{{ route('admin_sliders_disable_slider') }}",
                    type: "post",
                    data: {
                        _token: "{{ csrf_token() }}",
                        slider_for_disable_id: sliderId
                    },
                    success: function () {
                        // hide modal
                        $('#disable-modal').modal('hide');
                        toastr.success('Slider Successfully Disabled.');
                        // Reload all DataTables
                        $('#sliders-table').DataTable().ajax.reload(null, false);
                    }
                });
            });
            //enable user
            $('#sliders-table').on('click', "[data-action='enable']", function () {
                let id = $(this).attr('data-id');
                let name = $(this).attr('data-name');

                $("#enable-modal [name='slider_for_enable_id']").val(id);
                $('#enable-modal p#slider_for_enable_name').html(name);
            });
            $('#enable-slider').on('submit', function (e) {
                e.preventDefault();
                let sliderId = $("#enable-modal [name='slider_for_enable_id']").val(); // take ID from hidden modal input

                $.ajax({
                    url: "{{ route('admin_sliders_enable_slider') }}",
                    type: "post",
                    data: {
                        _token: "{{ csrf_token() }}",
                        slider_for_enable_id: sliderId
                    },
                    success: function () {
                        // hide modal
                        $('#enable-modal').modal('hide');
                        toastr.success('Slider Successfully Enabled.');
                        // Reload dataTables
                        $('#sliders-table').DataTable().ajax.reload(null, false);
                    }
                });
            });
            //delete slider
            // Open modal and enter data
            $('#sliders-table').on('click', "[data-action='delete']", function () {
                let id = $(this).attr('data-id');
                let name = $(this).attr('data-name');

                $("#delete-modal [name='slider_for_delete_id']").val(id);
                $('#delete-modal p#slider_for_delete_name').html(name);
            });

            // Click on button for delete
            $('#delete-slider').on('submit', function (e) {
                e.preventDefault();
                let sliderId = $("#delete-modal [name='slider_for_delete_id']").val(); // take ID from hidden modal input

                $.ajax({
                    url: "{{ route('admin_sliders_delete_slider') }}",
                    type: "post",
                    data: {
                        _token: "{{ csrf_token() }}",
                        slider_for_delete_id: sliderId
                    },
                    success: function () {
                        // hide modal
                        $('#delete-modal').modal('hide');
                        toastr.success('Slider Successfully Deleted.');
                        // Reload DataTables
                        $('#sliders-table').DataTable().ajax.reload(null, false);
                    }
                });
            });
        });
    </script>
@endpush
