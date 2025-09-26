@extends('admin._layouts._layout')

@section('content')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Users Form</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{route('admin_index_page')}}">Home</a></li>
                        <li class="breadcrumb-item"><a href="{{route('admin_users_page')}}">Users</a></li>
                        <li class="breadcrumb-item active">Users Form</li>
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
                            <h3 class="card-title">User Form</h3>
                        </div>
                        <!-- /.card-header -->
                        <!-- form start -->
                        <form role="form" id="store-user" enctype="multipart/form-data"
                              action="{{route('admin_users_store_user')}}" method="post">
                            @csrf
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Name</label>
                                            <input name="name" type="text"
                                                   class="form-control @error('name') is-invalid @enderror"
                                                   placeholder="Enter Name" value="{{old('name')}}">
                                            <div>
                                                @error('name')
                                                <div class="alert alert-danger">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label>Email</label>
                                            <div class="input-group">
                                                <input name="email" type="email"
                                                       class="form-control @error('email') is-invalid @enderror"
                                                       placeholder="Enter Email" value="{{old('email')}}">
                                                <div class="input-group-append">
                                                    <span class="input-group-text">
                                                     @
                                                     </span>
                                                </div>
                                            </div>
                                            <div>
                                                @error('email')
                                                <div class="alert alert-danger">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label for="password">Password</label>
                                            <div class="input-group">
                                                <input class="form-control @error('password') is-invalid @enderror"
                                                       type="password" name="password" id="password"
                                                       placeholder="Enter Password" required>
                                                <div class="input-group-append">
                                                    <div class="input-group-text">
                                                        <span class="fas fa-lock"></span>
                                                    </div>
                                                </div>
                                            </div>
                                            <div>
                                                @error('password')
                                                <div class="alert alert-danger">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label for="password_confirmation">Confirm Password</label>
                                            <div class="input-group">
                                                <input
                                                    class="form-control @error('password_confirmation') is-invalid @enderror"
                                                    type="password" name="password_confirmation"
                                                    placeholder="Confirm Password"
                                                    id="password_confirmation" required>
                                                <div class="input-group-append">
                                                    <div class="input-group-text">
                                                        <span class="fas fa-lock"></span>
                                                    </div>
                                                </div>
                                            </div>
                                            <div>
                                                @error('password_confirmation')
                                                <div class="alert alert-danger">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label>Phone</label>
                                            <div class="input-group">
                                                <input name="phone" type="text"
                                                       class="form-control @error('phone') is-invalid @enderror"
                                                       placeholder="Enter phone" value="{{old('phone')}}">
                                                <div class="input-group-append">
                                                    <span class="input-group-text">
                                                     <i class="fas fa-phone"></i>
                                                     </span>
                                                </div>
                                            </div>
                                            <div>
                                                @error('phone')
                                                <div class="alert alert-danger">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label>Choose New Photo</label>
                                            <input id="photo-input1" name="profile_photo" type="file"
                                                   class="form-control @error('profile_photo') is-invalid @enderror"
                                                   placeholder="User photo" value="{{old('profile_photo')}}">
                                            <div>
                                                @error('profile_photo')
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
                                                        <button type="button" onclick="clearImage1()"
                                                                class="btn btn-sm btn-outline-danger">
                                                            <i class="fas fa-remove"></i>
                                                            Delete Photo
                                                        </button>
                                                    </div>
                                                    <div class="text-center">
                                                        <img id="photoPreview1" src="#" alt="Preview"
                                                             style="padding-top: 10px; display: none; width: 305px;">
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
                                <a href="{{route('admin_users_page')}}"
                                   class="btn btn-outline-secondary">Cancel</a>
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
            document.getElementById("photo-input1").value = "";  // reset file input
            document.getElementById("photoPreview1").src = "#"; // reset src
            document.getElementById("photoPreview1").style.display = "none"; // sakrij preview
        }

        $(document).ready(function () {
            $('#store-user').validate({
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
                        "required": "Please enter user email",
                        "email": "Please enter valide email"
                    },
                    "password": {
                        "required": "Please enter valide password",
                        "minlength": "Password must be over 5 characters",
                        "pwcheck": "Password must contain one uppercase letter, one number, and one special character"
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
