@extends('admin.master')

@section('content')
    <div class="col-md-12 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title">Add Product</h4>

                @if (Session::has('success'))
                    <div class="alert alert-success" role="alert">
                        {{ Session::get('success') }}
                    </div>
                @endif

                @if (Session::has('error'))
                    <div class="alert alert-error" role="alert">
                        {{ Session::get('error') }}
                    </div>
                @endif

                <form action="{{ route('product-save') }}" method="POST" enctype="multipart/form-data">
                    @csrf

                    <div class="form-group">
                        <label for="proName">Product Name</label>
                        <input type="text" class="form-control" id="proName" name="proName" required>
                    </div>

                    <div class="form-group">
                        <label for="proSlug">Product Slug</label>
                        <input type="text" class="form-control" id="proSlug" name="proSlug" required>
                    </div>

                    <div class="form-group">
                        <label for="proDetail">Product Detail</label>
                        <textarea class="form-control" id="proDetail" name="proDetail" rows="4" required></textarea>
                    </div>

                    <div class="form-group">
                        <label for="proPrice">Product Price</label>
                        <input type="text" class="form-control" id="proPrice" name="proPrice" required>
                    </div>

                    <div class="form-group">
                        <label for="proQuantity">Product Quantity</label>
                        <input type="number" class="form-control" id="proQuantity" name="proQuantity" required>
                    </div>

                    <div class="form-group">
                        <label for="proImage">Product Image</label>
                        <input type="file" class="form-control" id="proImage" name="proImage" required>
                    </div>

                    <!-- Add a dropdown to select the category -->
                    <div class="form-group">
                        <label for="category_id">Category</label>
                        <select class="form-control" id="category_id" name="category_id" required>
                            @foreach ($cat as $category)
                                <option value="{{ $category->id }}">{{ $category->catName }}</option>
                            @endforeach
                        </select>
                    </div>

                    <button type="submit" class="btn btn-primary">Add Product</button>
                </form>
            </div>
        </div>
    </div>
@endsection
