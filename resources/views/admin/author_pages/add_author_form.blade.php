@extends('admin._layouts._layout')

@section('content')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Authors Form</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{route('admin.index.index')}}">Home</a></li>
                        <li class="breadcrumb-item"><a href="{{route('admin.authors.index')}}">Authors</a></li>
                        <li class="breadcrumb-item active">Authors Form</li>
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
                            <h3 class="card-title">Author Form</h3>
                        </div>
                        <!-- /.card-header -->
                        <!-- form start -->
                        <form role="form" id="store-author" enctype="multipart/form-data" action="{{route('admin.authors.store')}}" method="post">
                            @csrf
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Name</label>
                                            <input name="name" type="text" class="form-control @error('name') is-invalid @enderror"
                                                   placeholder="Name of Author" value="{{old('name')}}">
                                            <div>
                                                @error('name')
                                                <div class="alert alert-danger">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label>Email</label>
                                            <input name="email" type="email" class="form-control @error('email') is-invalid @enderror"
                                                   placeholder="Email Adress of Author" value="{{old('email')}}">
                                            <div>
                                                @error('email')
                                                <div class="alert alert-danger">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label>Choose New Photo</label>
                                            <input id="photo-input1" name="first-photo" type="file" class="form-control @error('first-photo') is-invalid @enderror"
                                                   placeholder="Authors photo" value="{{old('first-photo')}}">
                                            <div>
                                                @error('first-photo')
                                                <div class="alert alert-danger">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                    <div class="offset-md-1 col-md-5">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label>Photo</label>
                                                    <div class="text-right">
                                                        <button type="button" onclick="clearImage1()" class="btn btn-sm btn-outline-danger">
                                                            <i class="fas fa-remove"></i>
                                                            Delete Photo
                                                        </button>
                                                    </div>
                                                    <div class="text-center">
                                                        <img id="photoPreview1" src="#" alt="Preview" style="padding-top: 10px; display: none; width: 305px;">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- /.card-body -->
                            <div class="card-footer">
                                <button type="submit" class="btn btn-primary">Save</button>
                                <a href="{{route('admin.authors.index')}}" class="btn btn-outline-secondary">Cancel</a>
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
        document.getElementById('photo-input1').addEventListener('change', function(event) {
            const input = event.target;
            const preview1 = document.getElementById('photoPreview1');

            if (input.files && input.files[0]) {
                const reader = new FileReader();

                reader.onload = function(e) {
                    preview1.src = e.target.result;
                    preview1.style.display = 'block';

                }
                reader.readAsDataURL(input.files[0]);
            }
        });
        function clearImage1() {
            document.getElementById("photo-input1").value = "";  // reset file input
            document.getElementById("photoPreview1").src = "#"; // reset src
            document.getElementById("photoPreview1").style.display = "none"; // sakrij preview
        }
        $(document).ready(function () {
            $('#store-author').validate({
                "rules": {
                    "ignore" : [],
                    "name": {
                        "required": true,
                        "minlength": 5,
                        "maxlength": 50
                    },
                    "email": {
                        "required": true,
                        "email": true
                    }
                },
                "messages": {
                    "name": {
                        "required": "Please enter author's name",
                        "minlength": "Name must be over 5 characters",
                        "maxlength": "Enter no more than 50 characters"
                    },
                    "email": {
                        "required": "Please enter authors email",
                        "email": "Please enter valide email"
                    }
                },
                "errorClass": "is-invalid"
            });
        });
    </script>
@endpush
