@extends('layouts.app')

@section('content')
    <div class="login-box">
        <div class="login-logo">
            <a class="text-decoration-none" href="{{route('index_page')}}"><b>Cubes</b>BLOG</a>
        </div>
        <div class="card">
            <div class="card-body login-card-body">
                <p class="login-box-msg">Change your password</p>
                <form role="form" id="edit-user-password"
                      action="{{route('admin_users_edit_user_password')}}"
                      method="post">
                    @csrf
                    <div class="input-group mb-3">
                        <input type="password" class="form-control"
                               placeholder="Old Password" name="old_password" required>
                        <div class="input-group-append">
                            <div class="input-group-text">
                                <span class="fas fa-lock-open"></span>
                            </div>
                        </div>
                    </div>
                    <div class="@error('old_password') is-invalid @enderror"></div>
                    <div>
                        @error('old_password')
                        <div class="alert alert-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="input-group mb-3">
                        <input class="form-control" type="password"
                               placeholder="New Password" name="password" id="password" required>
                        <div class="input-group-append">
                            <div class="input-group-text">
                                <span class="fas fa-lock"></span>
                            </div>
                        </div>
                        <div class="@error('password') is-invalid @enderror"></div>
                        <div>
                            @error('password')
                            <div class="alert alert-danger">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="input-group mb-3">
                        <input class="form-control" type="password"
                               placeholder="Confirm New Password" name="password_confirmation" id="password_confirmation" required>
                        <div class="input-group-append">
                            <div class="input-group-text">
                                <span class="fas fa-lock"></span>
                            </div>
                        </div>
                        <div class="@error('password_confirmation') is-invalid @enderror"></div>
                        <div>
                            @error('password_confirmation')
                            <div class="alert alert-danger">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12">
                            <button type="submit" class="btn btn-primary btn-block">
                                Confirm Password Change
                            </button>
                        </div>
                    </div>
                </form>
                @if (Route::has('admin_users_edit_user_reset_password_page'))
                    <p class="mb-1">
                        <a class="text-decoration-none" href="{{ route('admin_users_edit_user_reset_password_page') }}">{{ __('I forgot my password') }}</a>
                    </p>
                @endif
            </div>
        </div>
    </div>
@endsection
@push('app_script')
    <script type="text/javascript"
            src="https://cdn.jsdelivr.net/npm/jquery-validation@1.19.5/dist/jquery.validate.min.js"></script>
    <script type="text/javascript"
            src="https://cdn.jsdelivr.net/npm/jquery-validation@1.19.5/dist/additional-methods.min.js"></script>
    <script>
        $(document).ready(function () {
            $('#edit-user-password').validate({
                "rules": {
                    "ignore": [],
                    "password": {
                        "required": true,
                        "minlength": 8,
                        "pwcheck": true
                    },
                    "password_confirmation": {
                        "required": true,
                        "equalTo": "#password"
                    }
                },
                "messages": {
                    "password": {
                        "required": "Please enter valide password",
                        "minlength": "Password must be over 5 characters",
                        "pwcheck": "Password must contain one uppercase letter, one number, and one special character"
                    },
                    "password_confirmation": {
                        "required": "Please confirm entered password",
                        "equalTo": "Please confirm entered password"
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

