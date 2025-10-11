@push('head_link')
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet"/>
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
                        <form role="form" id="edit-post" enctype="multipart/form-data"
                              action="{{route('admin_posts_edit_post', ['postForEdit'=>$postForEdit])}}" method="post">
                            @csrf
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Heading</label>
                                            <input name="heading" type="text"
                                                   class="form-control @error('heading') is-invalid @enderror"
                                                   placeholder="Enter Heading"
                                                   value="{{old('heading', $postForEdit->heading)}}">
                                            <div>
                                                @error('heading')
                                                <div class="alert alert-danger">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label>Preheading</label>
                                            <input name="preheading" type="text"
                                                   class="form-control @error('preheading') is-invalid @enderror"
                                                   placeholder="Enter Preheading"
                                                   value="{{old('preheading', $postForEdit->preheading)}}">
                                            <div>
                                                @error('preheading')
                                                <div class="alert alert-danger">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label>Post Category</label>
                                            <select id="select-category" class="form-control" name="category_id">
                                                <option value="">-- Select Category --</option>
                                                @foreach($contentForEdit['categories'] as $category)
                                                    <option value="{{ $category->id }}"
                                                        {{ old('category_id', $postForEdit->category_id ?? '') == $category->id ? 'selected' : '' }}>
                                                        {{ $category->name }}
                                                    </option>
                                                @endforeach
                                            </select>

                                            <div>
                                                @error('category_id')
                                                <div class="alert alert-danger">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label>Author</label>
                                            <select id="select-author"
                                                    name="author_id"
                                                    class="form-control @error('author_id') is-invalid @enderror">
                                                <option value="">-- Select Author --</option>
                                                @foreach($contentForEdit['authors'] as $author)
                                                    <option value="{{ $author->id }}"
                                                        {{ old('author_id', $postForEdit->author_id ?? '') == $author->id ? 'selected' : '' }}>
                                                        {{ $author->name }}
                                                    </option>
                                                @endforeach
                                            </select>

                                            <div>
                                                @error('author_id')
                                                <div class="alert alert-danger">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label>Tags</label>
                                            <select class="form-control @error('tags') is-invalid @enderror"
                                                    name="tags[]"
                                                    id="select-tags"
                                                    multiple>
                                                @foreach($contentForEdit['tags'] as $tag)
                                                    <option value="{{ $tag->id }}"
                                                        {{ in_array($tag->id, old('tags', $postForEdit->tags->pluck('id')->toArray())) ? 'selected' : '' }}>
                                                        {{ $tag->name }}
                                                    </option>
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
                                            <input type="hidden" id="delete_photo1" name="delete_photo1" value="0">
                                            <input id="photo-input1"
                                                   name="first-photo"
                                                   type="file"
                                                   class="form-control @error('first-photo') is-invalid @enderror">
                                            @error('first-photo')
                                            <div class="alert alert-danger">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <div class="form-group">
                                            <label for="post-text" class="form-label">Input Text</label>
                                            <textarea type="text"
                                                      class="form-control @error('text') is-invalid @enderror"
                                                      name="text"
                                                      id="post-text">{{old('text', $postForEdit->text ?? '')}}</textarea>
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
                                                        <button type="button" onclick="clearImage1()"
                                                                class="btn btn-sm btn-outline-danger">
                                                            <i class="fas fa-remove"></i>
                                                            Delete Photo
                                                        </button>
                                                    </div>
                                                    <div class="text-center">
                                                        <div class="text-center">
                                                            <img id="photoPreview1"
                                                                 src="{{ $postForEdit->imageUrl() }}" alt="Preview"
                                                                 style="padding-top: 10px; max-width: 305px;">
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
                                <a href="{{route('admin_posts_page')}}" class="btn btn-outline-secondary">Cancel</a>
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
            document.getElementById('photo-input1').addEventListener('change', function (event) {
                const input = event.target;
                const preview1 = document.getElementById('photoPreview1');
                const deleteField = document.getElementById("delete_photo1");
                if (input.files && input.files[0]) {
                    const reader = new FileReader();

                    reader.onload = function (e) {
                        preview1.src = e.target.result;
                        preview1.style.display = 'block';
                        deleteField.value = 0;
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

                CKEDITOR.replace('post-text', {
                    height: 600,
                    filebrowserImageBrowseUrl: '/laravel-filemanager?type=Images',
                    filebrowserImageUploadUrl: '/laravel-filemanager/upload?type=Images&_token={{ csrf_token() }}',
                    filebrowserBrowseUrl: '/laravel-filemanager?type=Files',
                    filebrowserUploadUrl: '/laravel-filemanager/upload?type=Files&_token={{ csrf_token() }}'
                });

                $('#edit-post').validate({
                    "rules": {
                        "ignore": [],
                        "heading": {
                            "required": true,
                            "minlength": 20,
                            "maxlength": 255
                        },
                        "preheading": {
                            "required": true,
                            "minlength": 50,
                            "maxlength": 500
                        },
                        "category": {
                            "required": true
                        },
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
                            "minlength": "Your heading must be over 20 characters",
                            "maxlength": "Enter no more than 255 characters"
                        },
                        "preheading": {
                            "required": "Please enter post preheading",
                            "minlength": "Your description must be longer than 50 characters",
                            "maxlength": "Your description cannot be longer than 500 characters"
                        },
                        "category": {
                            "required": "Please enter some category"
                        },
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
