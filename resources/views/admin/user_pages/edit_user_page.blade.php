@extends('admin._layouts._layout')

@section('content')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>User Form</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{route('admin_index_page')}}">Home</a></li>
                        <li class="breadcrumb-item"><a href="{{route('admin_users_page')}}">Users</a></li>
                        <li class="breadcrumb-item active">User Form</li>
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
                            <h3 class="card-title">Change your profile info</h3>
                            <div class="card-tools">
                                <a href="{{route('admin_users_edit_user_password_page')}}" class="btn btn-outline-warning">
                                    <i class="fas fa-lock-open"></i>
                                    Change Password
                                </a>
                            </div>
                        </div>
                        <!-- /.card-header -->
                        <!-- form start -->
                        <form role="form" id="edit-user" enctype="multipart/form-data"
                              action="{{route('admin_users_edit_user_data')}}"
                              method="post">
                            @csrf
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Email</label>
                                            <div>
                                               <strong>{{Auth::user()->email}}</strong>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label>Name</label>
                                            <input name="name" type="text"
                                                   class="form-control @error('name') is-invalid @enderror"
                                                   placeholder="Name of User"
                                                   value="{{old('name', Auth::user())}}">
                                            <div>
                                                @error('name')
                                                <div class="alert alert-danger">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label>Phone</label>
                                            <input name="phone" type="text"
                                                   class="form-control @error('phone') is-invalid @enderror"
                                                   placeholder="Phone of Author"
                                                   value="{{old('phone', Auth::user())}}">
                                            <div>
                                                @error('phone')
                                                <div class="alert alert-danger">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label>Choose New Photo</label>
                                            <input type="hidden" id="delete_photo1" name="delete_photo1" value="0">
                                            <input id="photo-input1"
                                                   name="first-photo"
                                                   type="file"
                                                   class="form-control @error('first-photo') is-invalid @enderror">
                                            @error('first-photo')
                                            <div class="alert alert-danger">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="offset-md-1 col-md-5">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label>Photo</label>
                                                    <div class="text-right">
                                                        <button type="button" onclick="clearImage1()"
                                                                class="btn btn-sm btn-outline-danger">
                                                            <i class="fas fa-remove"></i>
                                                            Delete Photo
                                                        </button>
                                                    </div>
                                                    <div class="text-center">
                                                        <div class="text-center">
                                                            <img id="photoPreview1"
                                                                 src="{{ Auth::user()->userImageUrl() }}"
                                                                 alt="Preview"
                                                                 style="padding-top: 10px; width: 305px;">
                                                        </div>
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
                                <a href="{{route('admin_users_page')}}" class="btn btn-outline-secondary">Cancel</a>
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
        document.getElementById('photo-input1').addEventListener('change', function (event) {
            const input = event.target;
            const preview1 = document.getElementById('photoPreview1');

            if (input.files && input.files[0]) {
                const reader = new FileReader();

                reader.onload = function (e) {
                    preview1.src = e.target.result;
                    preview1.style.display = 'block';

                }
                reader.readAsDataURL(input.files[0]);
            }
        });

        function clearImage1() {
            const input = document.getElementById("photo-input1");
            const preview = document.getElementById("photoPreview1");
            const deleteField = document.getElementById("delete_photo1");

            // Clear file input
            input.value = "";

            // Hide preview
            preview.src = "#";
            preview.style.display = "none";

            // Tell server to delete the existing photo
            deleteField.value = 1;
        }

        $(document).ready(function () {
            $('#edit-user').validate({
                "rules": {
                    "ignore": [],
                    "name": {
                        "required": true,
                        "minlength": 5,
                        "maxlength": 50
                    },
                    "email": {
                        "required": true,
                        "email": true
                    },
                    "password": {
                        "required": true,
                        "minlength": 8,
                        "pwcheck": true
                    },
                    "password_confirmation": {
                        "required": true,
                        "equalTo": "#password"
                    },
                    "phone": {
                        "required": true,
                        "minlength": 8,
                        "maxlength": 20
                    }
                },
                "messages": {
                    "name": {
                        "required": "Please enter user name",
                        "minlength": "Name must be over 5 characters",
                        "maxlength": "Enter no more than 50 characters"
                    },
                    "email": {
                        "required": "Please enter authors email",
                        "email": "Please enter valide email"
                    },
                    "password": {
                        "required": "Please enter valide password",
                        "minlength": "Password must be over 5 characters",
                        "pwcheck": "Password must contain one uppercase letter, one number, and one special character."
                    },
                    "password_confirmation": {
                        "required": "Please confirm entered password",
                        "equalTo": "Please confirm entered password"
                    },
                    "phone": {
                        "required": "Please enter user phone",
                        "minlength": "Value must be over 8 characters",
                        "maxlength": "Enter no more than 20 characters"
                    }
                },
                "errorClass": "is-invalid",
                errorPlacement: function (error, element) {
                    error.insertAfter(element);
                }
            });
            $.validator.addMethod("pwcheck", function (value) {
                return /[A-Z]/.test(value)   // veliko slovo
                    && /[0-9]/.test(value)   // broj
                    && /[!@#$%^&*]/.test(value); // specijalni znak
            });
        });
    </script>
@endpush

