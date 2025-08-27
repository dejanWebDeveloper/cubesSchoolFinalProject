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
                                <a href="users-form.html" class="btn btn-success">
                                    <i class="fas fa-plus-square"></i>
                                    Add new User
                                </a>
                            </div>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">
                            <form id="entities-filter-form">
                                <div class="row">
                                    <div class="col-md-1 form-group">
                                        <label>Status</label>
                                        <select class="form-control">
                                            <option>-- All --</option>
                                            <option value="">enabled</option>
                                            <option value="">disabled</option>
                                        </select>
                                    </div>
                                    <div class="col-md-3 form-group">
                                        <label>Email</label>
                                        <input type="text" class="form-control" placeholder="Search by email">
                                    </div>
                                    <div class="col-md-3 form-group">
                                        <label>Name</label>
                                        <input type="text" class="form-control" placeholder="Search by name">
                                    </div>
                                    <div class="col-md-3 form-group">
                                        <label>Phone</label>
                                        <input type="text" class="form-control" placeholder="Search by phone">
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
                            <table class="table table-bordered">
                                <thead>
                                <tr>
                                    <th style="width: 10px">#</th>
                                    <th style="width: 20px">Status</th>
                                    <th class="text-center">Photo</th>
                                    <th>Email</th>
                                    <th>Name</th>
                                    <th>Phone</th>
                                    <th class="text-center">Created At</th>
                                    <th class="text-center">Actions</th>
                                </tr>
                                </thead>
                                <tbody>
                                <tr>
                                    <td>#1</td>
                                    <td class="text-center">
                                        <span class="text-success">enabled</span>
                                    </td>
                                    <td class="text-center">
                                        <img src="https://via.placeholder.com/200" style="max-width: 80px;">
                                    </td>
                                    <td>
                                        user1@example.com
                                    </td>
                                    <td>
                                        <strong>User 1</strong>
                                    </td>
                                    <td>
                                        +38165555777
                                    </td>
                                    <td class="text-center">2020-02-02 12:00:00</td>
                                    <td class="text-center">
                                        <div class="btn-group">
                                            <a href="#" class="btn btn-info">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            <button type="button" class="btn btn-info" data-toggle="modal" data-target="#disable-modal">
                                                <i class="fas fa-minus-circle"></i>
                                            </button>
                                            <button type="button" class="btn btn-info" data-toggle="modal" data-target="#delete-modal">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td>#2</td>
                                    <td class="text-center">
                                        <span class="text-danger">disabled</span>
                                    </td>
                                    <td class="text-center">
                                        <img src="https://via.placeholder.com/200" style="max-width: 80px;">
                                    </td>
                                    <td>
                                        user2@example.com
                                    </td>
                                    <td>
                                        <strong>User 2</strong>
                                    </td>
                                    <td>
                                        +38165555666
                                    </td>
                                    <td class="text-center">2020-02-02 12:00:00</td>
                                    <td class="text-center">
                                        <div class="btn-group">
                                            <a href="#" class="btn btn-info">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            <button type="button" class="btn btn-info" data-toggle="modal" data-target="#enable-modal">
                                                <i class="fas fa-check"></i>
                                            </button>
                                            <button type="button" class="btn btn-info" data-toggle="modal" data-target="#delete-modal">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td>#3</td>
                                    <td class="text-center">
                                        <span class="text-success">enabled</span>
                                    </td>
                                    <td class="text-center">
                                        <img src="https://via.placeholder.com/200" style="max-width: 80px;">
                                    </td>
                                    <td>
                                        MOJNALOG@example.com
                                    </td>
                                    <td>
                                        <strong>MOJE IME</strong>
                                    </td>
                                    <td>
                                        +38165555888
                                    </td>
                                    <td class="text-center">2020-02-02 12:00:00</td>
                                    <td class="text-center">

                                    </td>
                                </tr>
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
                    <h4 class="modal-title">Delete User</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <p>Are you sure you want to delete user?</p>
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
    <div class="modal fade" id="disable-modal">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Disable User</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <p>Are you sure you want to disable user?</p>
                    <strong></strong>
                </div>
                <div class="modal-footer justify-content-between">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btn-danger">
                        <i class="fas fa-minus-circle"></i>
                        Disable
                    </button>
                </div>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>
    <!-- /.modal -->

    <div class="modal fade" id="enable-modal">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Enable User</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <p>Are you sure you want to enable user?</p>
                    <strong></strong>
                </div>
                <div class="modal-footer justify-content-between">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btn-success">
                        <i class="fas fa-check"></i>
                        Enable
                    </button>
                </div>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>
    <!-- /.modal -->
@endsection
