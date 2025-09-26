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
                            <h3 class="card-title">Search Categories</h3>
                            <div class="card-tools">
                                <a href="{{route('admin_categories_add_category')}}" class="btn btn-success">
                                    <i class="fas fa-plus-square"></i>
                                    Add new Category
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
                                        <label>Name</label>
                                        <input style="height: 40px;" type="text" name="name" class="form-control"
                                               placeholder="Search by Name">
                                    </div>
                                    <div class="col-md-3 form-group">
                                        <label>Description</label>
                                        <input style="height: 40px;" type="text" name="description" class="form-control"
                                               placeholder="Search by Description">
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
                            <h3 class="card-title">All Categories</h3>
                            <div class="card-tools">
                            </div>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">
                            <table id="categories-table" class="table table-bordered">
                                <thead>
                                <tr>
                                    <th class="text-center">#</th>
                                    <th>Name</th>
                                    <th>Description</th>
                                    <th class="text-center">Priority</th>
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

    <div class="modal fade" id="delete-modal">
        <div class="modal-dialog">
            <div class="modal-content">
                <form id="delete-category" method="post" action="{{route('admin_categories_delete_category')}}">
                    @csrf
                    <input type="hidden" name="category_for_delete_id" value="">
                    <div class="modal-header">
                        <h4 class="modal-title">Delete Category</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <p>Are you sure you want to delete category?</p>
                        <strong><p id="category_for_delete_name"></p></strong>
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
            $('#categories-table').DataTable({
                serverSide: true,
                processing: true,
                ajax: {
                    url: "{{ route('admin_categories_datatable') }}",
                    type: "post",
                    data: function (d) {
                        d._token = "{{ csrf_token() }}";
                        d.name = $('input[name=name]').val();
                        d.description = $('input[name=description]').val();
                    }
                },
                order: [[3, "asc"]],
                columns: [
                    {data: "id", name: "id", className: 'text-center'},
                    {data: "name", name: "Name"},
                    {data: "description", name: "Description"},
                    {data: "priority", name: "Priority", searchable: false, className: 'text-center'},
                    {data: "created_at", name: "Created_at", searchable: false, className: 'text-center'},
                    {data: "actions", name: "Actions", orderable: false, searchable: false, className: 'text-center'}
                ],
                pageLength: 10,
                lengthMenu: [5, 10, 20]
            });

            // reload table when filter was changed
            $('#entities-filter-form input, #entities-filter-form select').on('change keyup', function () {
                $('#categories-table').DataTable().ajax.reload();
            });
            //delete category
            // Open modal and enter data
            $('#categories-table').on('click', "[data-action='delete']", function () {
                let id = $(this).attr('data-id');
                let name = $(this).attr('data-name');

                $("#delete-modal [name='category_for_delete_id']").val(id);
                $('#delete-modal p#category_for_delete_name').html(name);
            });

            // Click on button for delete
            $('#delete-category').on('submit', function (e) {
                e.preventDefault();
                let categoryId = parseInt($("#delete-modal [name='category_for_delete_id']").val()); // take ID from hidden modal input

                $.ajax({
                    url: "{{ route('admin_categories_delete_category') }}",
                    type: "post",
                    data: {
                        _token: "{{ csrf_token() }}",
                        category_for_delete_id: categoryId
                    },
                    success: function () {
                        // hide modal
                        $('#delete-modal').modal('hide');
                        toastr.success('Category Successfully Deleted.');
                        // Reload celog DataTables
                        $('#categories-table').DataTable().ajax.reload(null, false);
                    },
                    error: function(xhr) {
                        console.log(xhr.responseJSON); // ovde ćeš videti koja validacija pada
                        toastr.error('Error: ' + JSON.stringify(xhr.responseJSON));
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
