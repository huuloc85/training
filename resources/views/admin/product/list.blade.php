@extends('admin.master')

@section('content')
    <div class="content-wrapper">
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <h3 class="card-title">Product List</h3>

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

                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Product Name</th>
                                        <th>Product Slug</th>
                                        <th>Price</th>
                                        <th>Quantity</th>
                                        <th>Image</th>
                                        {{-- <th>Photo Detail</th> --}}
                                        <th>Details</th>
                                        <th>Category</th>
                                        <th>Added By</th>
                                        <th>Updated By</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($products as $key => $product)
                                        <tr>
                                            <td>{{ $key + 1 }}</td>
                                            <td>{{ $product->proName }}</td>
                                            <td>{{ $product->proSlug }}</td>
                                            <td>{{ number_format($product->proPrice, 0, '.', ',') }} VNĐ</td>
                                            <td>
                                                @if ($product->proQuantity == 0)
                                                    Hết hàng
                                                @else
                                                    {{ $product->proQuantity }}
                                                @endif
                                            </td>

                                            <td><img src="{{ asset('storage/productImage/' . $product->proImage) }}"
                                                    style="height: 100px; width: 100px;"></td>

                                            <td>{{ $product->proDetail }}</td>
                                            <td>{{ $product->category->catName }}</td>
                                            <td>
                                                <p>By: {{ $product->userAdded->name }}</p>
                                                <p>At: {{ $product->created_at->format('Y-m-d H:i:s') }} </p>
                                            </td>
                                            <td>
                                                <p>By: {{ $product->userUpdated->name }}</p>
                                                <p>Last updated at: {{ $product->updated_at->format('Y-m-d H:i:s') }}
                                                </p>
                                            </td>

                                            <td>
                                                <a href="{{ route('product-edit', $product->proSlug) }}"
                                                    class="btn btn-primary">Edit</a>
                                                <a href="#" class="btn btn-danger" data-toggle="modal"
                                                    data-target="#deleteModal{{ $product->id }}">Delete</a>
                                                <!-- Modal -->
                                                <div class="modal fade" id="deleteModal{{ $product->id }}" tabindex="-1"
                                                    role="dialog" aria-labelledby="deleteModalLabel{{ $product->id }}"
                                                    aria-hidden="true">
                                                    <div class="modal-dialog" role="document">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h5 class="modal-title"
                                                                    id="deleteModalLabel{{ $product->id }}">
                                                                    Confirm Deletion</h5>
                                                                <button type="button" class="close" data-dismiss="modal"
                                                                    aria-label="Close">
                                                                    <span aria-hidden="true">&times;</span>
                                                                </button>
                                                            </div>
                                                            <div class="modal-body">
                                                                <p>Are you sure you want to delete this product?
                                                                </p>
                                                            </div>
                                                            <div class="modal-footer">
                                                                <button type="button" class="btn btn-secondary"
                                                                    data-dismiss="modal">Cancel</button>
                                                                <form action="{{ route('product-delete', $product->id) }}"
                                                                    method="POST">
                                                                    @method('DELETE')
                                                                    @csrf
                                                                    <button type="submit"
                                                                        class="btn btn-danger">Delete</button>
                                                                </form>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
                                                <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
                                                <script>
                                                    $(document).ready(function() {});
                                                </script>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
