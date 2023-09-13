@extends('admin.master')
@section('content')
    <div class="content-wrapper">
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <h3 class="card-title">Category List</h3>
                        @if (Session::has('error'))
                            <div class="alert alert-danger" role="alert">
                                {{ Session::get('error') }}
                            </div>
                        @endif
                        @if (Session::has('success'))
                            <div class="alert alert-success" role="alert">
                                {{ Session::get('success') }}
                            </div>
                        @endif
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>Category ID</th>
                                    <th>Category Name</th>
                                    <th>Category Slug</th>
                                    <th>Category Image</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($categories as $key => $category)
                                    <tr>
                                        <td>{{ $key + 1 }}</td>
                                        <td>{{ $category->catName }}</td>
                                        <td>{{ $category->catSlug }}</td>
                                        <td><img src="{{ asset('storage/categoryImage/' . $category->catImage) }}"
                                                style="height: 100px; width: 100px;">
                                        </td>
                                        <td>
                                            <a href="{{ route('category-edit', $category->catSlug) }}"
                                                class="btn btn-primary">Edit</a>

                                            <!-- Delete Form -->
                                            <a href="#" class="btn btn-danger"
                                                onclick="deleteCategory({{ $category->id }})">Delete</a>

                                            <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
                                            <script>
                                                function deleteCategory(categoryId) {
                                                    Swal.fire({
                                                        title: 'Confirm Deletion',
                                                        text: 'Are you sure you want to delete this category?',
                                                        icon: 'warning',
                                                        showCancelButton: true,
                                                        confirmButtonColor: '#d33',
                                                        cancelButtonColor: '#3085d6',
                                                        confirmButtonText: 'Delete',
                                                    }).then((result) => {
                                                        if (result.isConfirmed) {
                                                            // Send an AJAX request to delete the category
                                                            $.ajax({
                                                                url: "{{ route('category-delete', ':id') }}".replace(':id', categoryId),
                                                                method: 'DELETE',
                                                                data: {
                                                                    _token: '{{ csrf_token() }}'
                                                                },
                                                                success: function(response) {
                                                                    Swal.fire({
                                                                        icon: 'success',
                                                                        title: 'Success',
                                                                        text: response.message,
                                                                    }).then((result) => {
                                                                        if (result.isConfirmed) {
                                                                            // Redirect or perform an action after successful deletion
                                                                            window.location.href = "{{ route('category-list') }}";
                                                                        }
                                                                    });
                                                                },
                                                                error: function(xhr) {
                                                                    Swal.fire({
                                                                        icon: 'error',
                                                                        title: 'Oops...',
                                                                        text: 'Something went wrong!',
                                                                        footer: '<a href="#">Why do I have this issue?</a>',
                                                                    });
                                                                },
                                                            });
                                                        }
                                                    });
                                                }
                                            </script>


                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                        {{-- <div style="float: right; margin:20px">
                            {{ $categories->appends(request()->all())->links() }}
                        </div> --}}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
