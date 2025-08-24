@extends('admin._layouts._layout')

@section('content')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Product Categories Form</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item"><a href="#">Product Categories</a></li>
                        <li class="breadcrumb-item active">Product Categories Form</li>
                    </ol>
                </div>
            </div>
        </div><!-- /.container-fluid -->
    </section>
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">All Product Categories</h3>
                            <div class="card-tools">
                                <form class="btn-group">
                                    <button class="btn btn-outline-success">
                                        <i class="fas fa-check"></i>
                                        Save Order
                                    </button>
                                    <button class="btn btn-outline-danger">
                                        <i class="fas fa-remove"></i>
                                        Cancel
                                    </button>
                                </form>
                                <button class="btn btn-outline-secondary">
                                    <i class="fas fa-sort"></i>
                                    Change Order
                                </button>
                                <a href="categories-form.html" class="btn btn-success">
                                    <i class="fas fa-plus-square"></i>
                                    Add new Category
                                </a>
                            </div>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">
                            <table class="table table-bordered">
                                <thead>
                                <tr>
                                    <th style="width: 10%">#</th>
                                    <th style="width: 30%;">Name</th>
                                    <th style="width: 30%;">Description</th>
                                    <th class="text-center">Created At</th>
                                    <th class="text-center">Last Change</th>
                                    <th class="text-center">Actions</th>
                                </tr>
                                </thead>
                                <tbody id="sort-list">
                                <tr>
                                    <td>
                        <span class="btn btn-outline-secondary">
                          <i class="fas fa-sort"></i>
                        </span>
                                        1.
                                    </td>
                                    <td>
                                        <strong>Category 1</strong>
                                    </td>
                                    <td>
                                        Category 1 Description
                                    </td>
                                    <td class="text-center">2020-02-02 12:00:00</td>
                                    <td class="text-center">2020-02-02 12:00:00</td>
                                    <td class="text-center">
                                        <div class="btn-group">
                                            <a href="#" class="btn btn-info">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            <button type="button" class="btn btn-info" data-toggle="modal" data-target="#delete-modal">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td>2.</td>
                                    <td>
                                        <strong>Category 2</strong>
                                    </td>
                                    <td>
                                        Category 2 Description
                                    </td>
                                    <td class="text-center">2020-02-02 12:00:00</td>
                                    <td class="text-center">2020-02-02 12:00:00</td>
                                    <td class="text-center">
                                        <div class="btn-group">
                                            <a href="#" class="btn btn-info">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            <button type="button" class="btn btn-info" data-toggle="modal" data-target="#delete-modal">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td>3.</td>
                                    <td>
                                        <strong>Category 3</strong>
                                    </td>
                                    <td>
                                        Category 3 Description
                                    </td>
                                    <td class="text-center">2020-02-02 12:00:00</td>
                                    <td class="text-center">2020-02-02 12:00:00</td>
                                    <td class="text-center">
                                        <div class="btn-group">
                                            <a href="#" class="btn btn-info">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            <button type="button" class="btn btn-info" data-toggle="modal" data-target="#delete-modal">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td>4.</td>
                                    <td>
                                        <strong>Category 4</strong>
                                    </td>
                                    <td>
                                        Category 4 Description
                                    </td>
                                    <td class="text-center">2020-02-02 12:00:00</td>
                                    <td class="text-center">2020-02-02 12:00:00</td>
                                    <td class="text-center">
                                        <div class="btn-group">
                                            <a href="#" class="btn btn-info">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            <button type="button" class="btn btn-info" data-toggle="modal" data-target="#delete-modal">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td>5.</td>
                                    <td>
                                        <strong>Category 5</strong>
                                    </td>
                                    <td>
                                        Category 5 Description
                                    </td>
                                    <td class="text-center">2020-02-02 12:00:00</td>
                                    <td class="text-center">2020-02-02 12:00:00</td>
                                    <td class="text-center">
                                        <div class="btn-group">
                                            <a href="#" class="btn btn-info">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            <button type="button" class="btn btn-info" data-toggle="modal" data-target="#delete-modal">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td>6.</td>
                                    <td>
                                        <strong>Category 6</strong>
                                    </td>
                                    <td>
                                        Category 6 Description
                                    </td>
                                    <td class="text-center">2020-02-02 12:00:00</td>
                                    <td class="text-center">2020-02-02 12:00:00</td>
                                    <td class="text-center">
                                        <div class="btn-group">
                                            <a href="#" class="btn btn-info">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            <button type="button" class="btn btn-info" data-toggle="modal" data-target="#delete-modal">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td>7.</td>
                                    <td>
                                        <strong>Category 7</strong>
                                    </td>
                                    <td>
                                        Category 7 Description
                                    </td>
                                    <td class="text-center">2020-02-02 12:00:00</td>
                                    <td class="text-center">2020-02-02 12:00:00</td>
                                    <td class="text-center">
                                        <div class="btn-group">
                                            <a href="#" class="btn btn-info">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            <button type="button" class="btn btn-info" data-toggle="modal" data-target="#delete-modal">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </div>
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
                    <h4 class="modal-title">Delete Category</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <p>Are you sure you want to delete category?</p>
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
@endsection
