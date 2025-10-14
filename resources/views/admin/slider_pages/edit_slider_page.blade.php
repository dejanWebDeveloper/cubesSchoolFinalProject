@extends('admin._layouts._layout')

@section('content')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Slider Form</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{route('admin.index.index')}}">Home</a></li>
                        <li class="breadcrumb-item"><a href="{{route('admin.sliders.index')}}">Slider Data</a></li>
                        <li class="breadcrumb-item active">Slider Form</li>
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
                            <h3 class="card-title">Slider Form</h3>
                        </div>
                        <!-- /.card-header -->
                        <!-- form start -->
                        <form role="form" id="edit-slider" enctype="multipart/form-data"
                              action="{{route('admin.sliders.update', ['slider'=>$sliderForEdit->id])}}"
                              method="post">
                            @csrf
                            @method('PUT')
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Heading</label>
                                            <input name="heading" type="text"
                                                   class="form-control @error('heading') is-invalid @enderror"
                                                   placeholder="Enter Slider Heading"
                                                   value="{{old('heading', $sliderForEdit->heading)}}">
                                            <div>
                                                @error('heading')
                                                <div class="alert alert-danger">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label>URL</label>
                                            <input name="url" type="url"
                                                   class="form-control @error('url') is-invalid @enderror"
                                                   placeholder="Enter Website Url"
                                                   value="{{old('url', $sliderForEdit->url)}}">
                                            <div>
                                                @error('url')
                                                <div class="alert alert-danger">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label>Button Name</label>
                                            <input name="button_name" type="text"
                                                   class="form-control @error('button_name') is-invalid @enderror"
                                                   placeholder="Enter Button Name"
                                                   value="{{old('button_name', $sliderForEdit->button_name)}}">
                                            <div>
                                                @error('button_name')
                                                <div class="alert alert-danger">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label>Choose New Photo</label>
                                            <input type="hidden" id="delete_photo1" name="delete_photo1" value="0">
                                            <input id="photo-input1"
                                                   name="background"
                                                   type="file"
                                                   class="form-control @error('background') is-invalid @enderror">
                                            @error('background')
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
                                                                 src="{{ $sliderForEdit->sliderImageUrl() }}"
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
                                <a href="{{route('admin.sliders.index')}}" class="btn btn-outline-secondary">Cancel</a>
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
    <!-- /.content -->
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
                $('#edit-slider').validate({
                    "rules": {
                        "ignore" : [],
                        "heading": {
                            "required": true,
                            "minlength": 5,
                            "maxlength": 100
                        },
                        "url": {
                            "required": true,
                            "url": true
                        },
                        "button-name": {
                            "required": true,
                            "minlength": 3,
                            "maxlength": 15
                        }
                    },
                    "messages": {
                        "heading": {
                            "required": "Please enter slider heading",
                            "minlength": "Heading must be over 5 characters",
                            "maxlength": "Enter no more than 100 characters"
                        },
                        "url": {
                            "required": "Please enter url to website",
                            "url": "Please enter valide url"
                        },
                        "button-name": {
                            "required": "Please enter button name",
                            "minlength": "Button name must be over 3 characters",
                            "maxlength": "Enter no more than 15 characters"
                        }
                    },
                    "errorClass": "is-invalid"
                });
                $.validator.addMethod("url", function(value, element) {
                    return this.optional(element) || /^(https?:\/\/)(localhost(:[0-9]+)?|[a-z0-9.-]+\.[a-z]{2,})(\/.*)?$/i.test(value);
                }, "Please enter valide url");
            });
        </script>
    @endpush
@endsection
