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
                        <input type="text" class="form-control @error('proName') is-invalid @enderror" id="proName"
                            name="proName" required>
                        @error('proName')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="proSlug">Product Slug</label>
                        <input type="text" class="form-control @error('proSlug') is-invalid @enderror" id="proSlug"
                            name="proSlug" required>
                        @error('proSlug')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="proDetail">Product Detail</label>
                        <textarea class="form-control @error('proDetail') is-invalid @enderror" id="proDetail" name="proDetail" rows="4"
                            required></textarea>
                        @error('proDetail')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="proPrice">Product Price</label>
                        <input type="text" class="form-control @error('proPrice') is-invalid @enderror" id="proPrice"
                            name="proPrice" required>
                        @error('proPrice')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="proQuantity">Product Quantity</label>
                        <input type="number" class="form-control @error('proQuantity') is-invalid @enderror"
                            id="proQuantity" name="proQuantity" required>
                        @error('proQuantity')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="proImage">Product Image</label>
                        <input type="file" class="form-control @error('proImage') is-invalid @enderror" id="proImage"
                            name="proImage" required>
                        @error('proImage')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Add a dropdown to select the category -->
                    <div class="form-group">
                        <label for="category_id">Category</label>
                        <select class="form-control @error('category_id') is-invalid @enderror" id="category_id"
                            name="category_id" required>
                            @foreach ($cat as $category)
                                <option value="{{ $category->id }}">{{ $category->catName }}</option>
                            @endforeach
                        </select>
                        @error('category_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <button type="submit" class="btn btn-primary">Add Product</button>
                </form>
            </div>
        </div>
    </div>
@endsection
