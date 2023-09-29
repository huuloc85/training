@extends('admin.master')

@section('content')
    <div class="col-md-12 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title">Edit Product</h4>
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
                <form action="{{ route('product-update', $pro->proSlug) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    <div class="form-group">
                        <label for="proName">Product Name</label>
                        <input type="text" class="form-control @error('proName') is-invalid @enderror" id="proName"
                            name="proName" value="{{ $pro->proName }}" required>
                        @error('proName')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="proSlug">Product Slug</label>
                        <input type="text" class="form-control @error('proSlug') is-invalid @enderror" id="proSlug"
                            name="proSlug" value="{{ $pro->proSlug }}" required>
                        @error('proSlug')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="proDetail">Product Detail</label>
                        <textarea class="form-control @error('proDetail') is-invalid @enderror" id="proDetail" name="proDetail" rows="4"
                            required>{{ $pro->proDetail }}</textarea>
                        @error('proDetail')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="proPrice">Product Price</label>
                        <input type="text" class="form-control @error('proPrice') is-invalid @enderror" id="proPrice"
                            name="proPrice" value="{{ $pro->proPrice }}" required>
                        @error('proPrice')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="proQuantity">Product Quantity</label>
                        <input type="number" class="form-control @error('proQuantity') is-invalid @enderror"
                            id="proQuantity" name="proQuantity" value="{{ $pro->proQuantity }}" required>
                        @error('proQuantity')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="image">Product Image:</label>
                        <input type="hidden" value="{{ $pro->proImage }}" id="old_image" name="old_image"><br>
                        <img src="{{ asset('storage/productImage/' . $pro->proImage) }}"
                            style="height: 100px; width: 100px;"><br>
                        <input type="file" class="form-control @error('new_image') is-invalid @enderror" id="new_image"
                            name="new_image">
                        @error('new_image')
                            <div class="text text-danger">{{ $message }}</div>
                        @enderror
                        <br>
                    </div>

                    <!-- Add a dropdown to select the category -->
                    <div class="form-group">
                        <label for="category_id">Category</label>
                        <select class="form-control @error('category_id') is-invalid @enderror" id="category_id"
                            name="category_id" required>
                            @foreach ($cat as $categories)
                                <option value="{{ $categories->id }}"
                                    {{ $categories->id == $pro->category_id ? 'selected' : '' }}>
                                    {{ $categories->catName }}
                                </option>
                            @endforeach
                        </select>
                        @error('category_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <button type="submit" class="btn btn-primary">Update Product</button>
                </form>
            </div>
        </div>
    </div>
@endsection
