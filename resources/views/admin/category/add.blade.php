@extends('admin.master')
@section('content')
    <div class="content-wrapper">
        <div class="row">
            <div class="container mt-3" style="margin-top: 20px">
                <h2>Add New Category</h2>
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
                <form action="{{ route('category-save') }}" method="post" enctype="multipart/form-data">
                    @csrf
                    <div class="form-group">
                        <label for="catName">Category Name</label>
                        <input type="text" class="form-control @error('catName') is-invalid @enderror" id="catName"
                            name="catName" required>
                        @error('catName')
                            <div class="text text-danger">{{ $message }}</div>
                        @enderror
                        <br>
                    </div>
                    <div class="form-group">
                        <label for="catSlug">Category Slug</label>
                        <input type="text" class="form-control @error('catSlug') is-invalid @enderror" id="catSlug"
                            name="catSlug" required>
                        @error('catSlug')
                            <div class="text text-danger">{{ $message }}</div>
                        @enderror
                        <br>
                    </div>
                    <div class="form-group">
                        <label for="catImage">Category Image</label>
                        <input type="file" class="form-control-file @error('catImage') is-invalid @enderror"
                            id="catImage" name="catImage" accept="image/*" required>
                        @error('catImage')
                            <div class="text text-danger">{{ $message }}</div>
                        @enderror
                        <br>
                    </div>
                    <!-- Add other fields here as needed -->
                    <button type="submit" class="btn btn-primary">Add Category</button>
                    <a href="{{ route('category-list') }}" class="btn btn-danger">Back</a>
                </form>
            </div>
        </div>
    </div>
@endsection
