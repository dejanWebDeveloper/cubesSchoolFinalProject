@push('head_link')
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <style>
        .select2-container--default .select2-selection--single {
            height: 35px;
        }
        .select2-container--default .select2-selection--multiple {
            min-height: 35px;
            font-size: 16px;
        }
    </style>
@endpush
@extends('admin._layouts._layout')

@section('content')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Post Form</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{route('admin_index_page')}}">Home</a></li>
                        <li class="breadcrumb-item"><a href="{{route('admin_posts_page')}}">Posts</a></li>
                        <li class="breadcrumb-item active">Post Form</li>
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
                            <h3 class="card-title">Post Form</h3>
                        </div>
                        <!-- /.card-header -->
                        <!-- form start -->
                        <form role="form" id="store-post" enctype="multipart/form-data" action="{{route('admin_posts_store_post')}}" method="post">
                            @csrf
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Heading</label>
                                            <input name="heading" type="text" class="form-control @error('heading') is-invalid @enderror"
                                                   placeholder="Heading of Post" value="{{old('heading')}}">
                                            <div>
                                                @error('heading')
                                                <div class="alert alert-danger">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label>Preheading</label>
                                            <input name="preheading" type="text" class="form-control @error('preheading') is-invalid @enderror"
                                                   placeholder="Preheading of Post" value="{{old('preheading')}}">
                                            <div>
                                                @error('preheading')
                                                <div class="alert alert-danger">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label>Post Category</label>
                                            <select id="select-category" class="form-control">
                                                <option></option>
                                                @foreach($categories as $category)
                                                <option value="{{$category->id}}">{{$category->name}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <label>Author</label>
                                            <select id="select-author" name="author" class="form-control @error('author') is-invalid @enderror">
                                                <option></option>
                                                @foreach($authors as $author)
                                                    <option value="{{$author->id}}">{{$author->name}}</option>
                                                @endforeach
                                            </select>
                                            <div>
                                                @error('author')
                                                <div class="alert alert-danger">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label>Tags</label>
                                            <select class="form-control @error('tags') is-invalid @enderror" name="tags[]" id="select-tags" multiple>
                                                @foreach($tags as $tag)
                                                    <option value="{{$tag->id}}">{{$tag->name}}</option>
                                                @endforeach
                                            </select>
                                            <div>
                                                @error('tags')
                                                <div class="alert alert-danger">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label>Choose New Photo 1</label>
                                            <input id="photo-input1" name="first-photo" type="file" class="form-control @error('first-photo') is-invalid @enderror"
                                                   placeholder="Article photo" value="{{old('first-photo')}}">
                                            <div>
                                                @error('first-photo')
                                                <div class="alert alert-danger">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label>Choose New Photo 2</label>
                                            <input id="photo-input2" name="second-photo" type="file" class="form-control @error('second-photo') is-invalid @enderror"
                                                   placeholder="Article photo" value="{{old('second-photo')}}">
                                            <div>
                                                @error('second-photo')
                                                <div class="alert alert-danger">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label for="post-text" class="form-label">Input Text</label>
                                            <textarea type="text" class="form-control @error('text') is-invalid @enderror"
                                                      name="text" id="post-text">{{old('text')}}</textarea>
                                            <div>
                                                @error('text')
                                                <div class="alert alert-danger">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                    <div class="offset-md-1 col-md-5">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label>Photo 1</label>

                                                    <div class="text-right">
                                                        <button type="button" onclick="clearImage1()" class="btn btn-sm btn-outline-danger">
                                                            <i class="fas fa-remove"></i>
                                                            Delete Photo
                                                        </button>
                                                    </div>
                                                    <div class="text-center">
                                                        <img id="photoPreview1" src="#" alt="Preview" style="padding-top: 10px; display: none; max-width: 305px;">

                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label>Photo 2</label>

                                                    <div class="text-right">
                                                        <button type="button" onclick="clearImage2()" class="btn btn-sm btn-outline-danger">
                                                            <i class="fas fa-remove"></i>
                                                            Delete Photo
                                                        </button>
                                                    </div>
                                                    <div class="text-center">
                                                        <img id="photoPreview2" src="#" alt="Preview" style="padding-top: 10px; display: none; max-width: 305px;">
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
                                <a href="products-index.html" class="btn btn-outline-secondary">Cancel</a>
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
        <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
        <script src="https://cdn.ckeditor.com/4.22.1/standard/ckeditor.js"></script>
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
            document.getElementById('photo-input2').addEventListener('change', function(event) {
                const input = event.target;
                const preview2 = document.getElementById('photoPreview2');

                if (input.files && input.files[0]) {
                    const reader = new FileReader();

                    reader.onload = function(e) {
                        preview2.src = e.target.result;
                        preview2.style.display = 'block';

                    }
                    reader.readAsDataURL(input.files[0]);
                }
            });
                function clearImage1() {
                document.getElementById("photo-input1").value = "";  // reset file input
                document.getElementById("photoPreview1").src = "#"; // reset src
                document.getElementById("photoPreview1").style.display = "none"; // sakrij preview
            }

                function clearImage2() {
                document.getElementById("photo-input2").value = "";
                document.getElementById("photoPreview2").src = "#";
                document.getElementById("photoPreview2").style.display = "none";
            }

            $(document).ready(function () {
                $('#select-author').select2({
                    placeholder: "Select Author",
                    allowClear: true
                });
                $('#select-category').select2({
                    placeholder: "Select Category",
                    allowClear: true
                });
                $('#select-tags').select2({
                    placeholder: "Select Tags",
                    allowClear: true
                });

                CKEDITOR.replace('text');
                CKEDITOR.config.height = 600;

                $('#store-post').validate({
                    "rules": {
                        "ignore" : [],
                        "heading": {
                            "required": true,
                            "minlength": 3,
                            "maxlength": 100
                        },
                        "preheading": {
                            "required": true,
                            "minlength": 5,
                            "maxlength": 200
                        },
                        //"category": {
                          //  "required": true
                        //},
                        "tags[]": {
                            "required": true
                        },
                        "text": {
                            "required": true,
                            "minlength": 50,
                            "maxlength": 1000
                        }
                    },
                    "messages": {
                        "heading": {
                            "required": "Please enter post heading",
                            "minlength": "Your heading must be over 3 characters",
                            "maxlength": "Enter no more than 100 characters"
                        },
                        "preheading": {
                            "required": "Please enter post preheading",
                            "minlength": "Your description must be longer than 5 characters",
                            "maxlength": "Your description cannot be longer than 200 characters"
                        },
                        //"category": {
                          //  "required": "Please enter some category"
                        //},
                        "tags[]": {
                            "required": "Please enter some tags"
                        },
                        "text": {
                            "required": "What do you want to say to us",
                            "minlength": "Your text must be over 50 characters",
                            "maxlength": "Enter no more than 1000 characters"
                        }
                    },
                    "errorClass": "is-invalid"
                });
            });
        </script>
    @endpush
@endsection
