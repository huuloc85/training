@extends('admin.master')
@section('content')
    <div class="content-wrapper">
        <div class="row">
            <div class="col-md-12 grid-margin stretch-card">
                <div class="card">
                    <div class="card-body">
                        <h2>Update Category</h2>
                        @if (Session::has('success'))
                            <div class="alert alert-success" role="alert">
                                {{ Session::get('success') }}
                            </div>
                        @endif
                        @if (Session::has('error'))
                            <div class="alert alert-danger" role="alert">
                                {{ Session::get('error') }}
                            </div>
                        @endif
                        <form action="{{ route('category-update', $category->catSlug) }}" method="POST"
                            enctype="multipart/form-data">
                            @csrf
                            @method('PUT')
                            <div class="mb-3 mt-3">
                                <label for="name">Category Name:</label>
                                <input type="text" class="form-control @error('catName') is-invalid @enderror"
                                    id="name" name="catName" value="{{ $category->catName }}">
                                @error('catName')
                                    <div class="text text-danger">{{ $message }}</div>
                                @enderror
                                <br>
                            </div>
                            <div class="mb-3 mt-3">
                                <label for="image">Category Image:</label>
                                <input type="hidden" value="{{ $category->catImage }}" id="old_image" name="old_image"><br>
                                <img src="{{ asset('storage/categoryImage/' . $category->catImage) }}"
                                    style="height: 100px; width: 100px;"><br>
                                <input type="file" class="form-control" id="new_image" name="new_image">
                            </div>
                            <div class="mb-3 mt-3">
                                <label for="slug">Category Slug:</label>
                                <input type="text" class="form-control @error('catSlug') is-invalid @enderror"
                                    id="slug" name="catSlug" value="{{ $category->catSlug }}">
                                @error('catSlug')
                                    <div class="text text-danger">{{ $message }}</div>
                                @enderror
                                <br>
                            </div>
                            <button type="submit" class="btn btn-primary">Update</button>
                            <a href="{{ route('category-list') }}" class="btn btn-danger">Back</a>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
