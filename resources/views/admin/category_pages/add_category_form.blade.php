@extends('admin._layouts._layout')

@section('content')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Categories Form</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{route('admin_index_page')}}">Home</a></li>
                        <li class="breadcrumb-item"><a href="{{route('admin_categories_page')}}">Categories</a></li>
                        <li class="breadcrumb-item active">Categories Form</li>
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
                    <div class="card card-primary">
                        <div class="card-header">
                            <h3 class="card-title">Category Form</h3>
                        </div>
                        <!-- /.card-header -->
                        <!-- form start -->
                        <form role="form" id="store-category" enctype="multipart/form-data" action="{{route('admin_categories_store_category')}}" method="post">
                            @csrf
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Name</label>
                                            <input name="name" type="text" class="form-control @error('name') is-invalid @enderror"
                                                   placeholder="Enter Name" value="{{old('name')}}">
                                            <div>
                                                @error('name')
                                                <div class="alert alert-danger">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label>Description</label>
                                            <input name="description" type="text" class="form-control @error('description') is-invalid @enderror"
                                                   placeholder="Enter Description" value="{{old('description')}}">
                                            <div>
                                                @error('description')
                                                <div class="alert alert-danger">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label>Priority</label>
                                            <input name="priority" type="number" class="form-control @error('priority') is-invalid @enderror"
                                                   placeholder="Enter Priority" value="{{old('priority')}}">
                                            <div>
                                                @error('priority')
                                                <div class="alert alert-danger">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- /.card-body -->
                            <div class="card-footer">
                                <button type="submit" class="btn btn-primary">Save</button>
                                <a href="{{route('admin_categories_page')}}" class="btn btn-outline-secondary">Cancel</a>
                            </div>
                        </form>
                    </div>
                    <!-- /.card -->
                </div>
                <!-- /.col -->
            </div>
            <!-- /.row -->
        </div><!-- /.container-fluid -->
    </section>
@endsection
@push('footer_script')
    <script type="text/javascript"
            src="https://cdn.jsdelivr.net/npm/jquery-validation@1.19.5/dist/jquery.validate.min.js"></script>
    <script type="text/javascript"
            src="https://cdn.jsdelivr.net/npm/jquery-validation@1.19.5/dist/additional-methods.min.js"></script>
    <script>
        $(document).ready(function () {
            $('#store-category').validate({
                ignore: [],
                rules: {
                    name: {
                        required: true,
                        minlength: 5,
                        maxlength: 50
                    },
                    description: {
                        required: true,
                        minlength: 15,
                        maxlength: 100
                    },
                    priority: {
                        number: true,
                        max: 10
                    }
                },
                messages: {
                    name: {
                        required: "Please enter category name",
                        minlength: "Name must be at least 5 characters",
                        maxlength: "Enter no more than 50 characters"
                    },
                    description: {
                        required: "Please enter category description",
                        minlength: "Description must be at least 15 characters",
                        maxlength: "Enter no more than 100 characters"
                    },
                    priority: {
                        number: "Value for priority must be a number",
                        max: "Max value for priority is 10"
                    }
                },
                errorClass: "is-invalid",
                errorPlacement: function (error, element) {
                    error.insertAfter(element);
                }
            });
        });
    </script>
@endpush
