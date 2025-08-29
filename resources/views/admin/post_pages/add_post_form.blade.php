@extends('admin._layouts._layout')

@section('content')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Products Form</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item"><a href="#">Products</a></li>
                        <li class="breadcrumb-item active">Products Form</li>
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
                            <h3 class="card-title">Product Form</h3>
                        </div>
                        <!-- /.card-header -->
                        <!-- form start -->
                        <form role="form">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Brand</label>
                                            <select class="form-control">
                                                <option value="">-- Choose Brand --</option>
                                                <option value="">Brand 1</option>
                                                <option value="">Brand 2</option>
                                                <option value="">Brand 3</option>
                                                <option value="">Brand 4</option>
                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <label>Product Category</label>
                                            <select class="form-control">
                                                <option value="">-- Choose Category --</option>
                                                <option value="">Category 1</option>
                                                <option value="">Category 2</option>
                                                <option value="">Category 3</option>
                                                <option value="">Category 4</option>
                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <label>Name</label>
                                            <input type="text" class="form-control" placeholder="Enter name">
                                        </div>
                                        <div class="form-group">
                                            <label>Description</label>
                                            <textarea class="form-control" placeholder="Enter Description">
                        </textarea>
                                        </div>

                                        <div class="form-group">
                                            <label>Price</label>
                                            <div class="input-group">
                                                <input type="number" class="form-control" placeholder="Enter price">
                                                <div class="input-group-append">
                                                    <span class="input-group-text">$</span>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label>Old Price</label>
                                            <div class="input-group">
                                                <input type="number" class="form-control" placeholder="Enter old prace">
                                                <div class="input-group-append">
                                                    <span class="input-group-text">$</span>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label>Sizes</label>
                                            <div>
                                                <div class="form-check form-check-inline">
                                                    <input class="form-check-input" type="checkbox" id="size-checkbox-1">
                                                    <label class="form-check-label" for="size-checkbox-1">XS</label>
                                                </div>
                                                <div class="form-check form-check-inline">
                                                    <input class="form-check-input" type="checkbox" id="size-checkbox-2">
                                                    <label class="form-check-label" for="size-checkbox-2">S</label>
                                                </div>
                                                <div class="form-check form-check-inline">
                                                    <input class="form-check-input" type="checkbox" id="size-checkbox-3">
                                                    <label class="form-check-label" for="size-checkbox-3">M</label>
                                                </div>
                                                <div class="form-check form-check-inline">
                                                    <input class="form-check-input" type="checkbox" id="size-checkbox-4">
                                                    <label class="form-check-label" for="size-checkbox-4">L</label>
                                                </div>
                                                <div class="form-check form-check-inline">
                                                    <input class="form-check-input" type="checkbox" id="size-checkbox-5">
                                                    <label class="form-check-label" for="size-checkbox-5">XL</label>
                                                </div>
                                                <div class="form-check form-check-inline">
                                                    <input class="form-check-input" type="checkbox" id="size-checkbox-6">
                                                    <label class="form-check-label" for="size-checkbox-6">XXL</label>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label>Choose New Photo 1</label>
                                            <input type="file" class="form-control">
                                        </div>
                                        <div class="form-group">
                                            <label>Choose New Photo 2</label>
                                            <input type="file" class="form-control">
                                        </div>
                                    </div>
                                    <div class="offset-md-1 col-md-5">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label>Photo 1</label>

                                                    <div class="text-right">
                                                        <button type="button" class="btn btn-sm btn-outline-danger">
                                                            <i class="fas fa-remove"></i>
                                                            Delete Photo
                                                        </button>
                                                    </div>
                                                    <div class="text-center">
                                                        <img src="https://via.placeholder.com/400x600" alt="" class="img-fluid">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label>Photo 2</label>

                                                    <div class="text-right">
                                                        <button type="button" class="btn btn-sm btn-outline-danger">
                                                            <i class="fas fa-remove"></i>
                                                            Delete Photo
                                                        </button>
                                                    </div>
                                                    <div class="text-center">
                                                        <img src="https://via.placeholder.com/400x600" alt="" class="img-fluid">
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
@endsection
