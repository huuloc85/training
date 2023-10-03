@extends('admin.master')
@section('content')
    <div class="content-wrapper">
        <div class="row">
            <div class="col-md-12 grid-margin stretch-card">
                <div class="card">
                    <div class="card-body">
                        <h3 class="card-title">Customer List</h3>
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
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>Customer ID</th>
                                        <th>Name</th>
                                        <th class="text-nowrap">Mobile</th>
                                        <th>Email</th>
                                        <th>Address</th>
                                        <th>Total Amount</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($customers as $key => $customer)
                                        <tr>
                                            <td>{{ $key + 1 }}</td>
                                            <td>{{ $customer->name }}</td>
                                            <td class="text-nowrap">(+84)
                                                {{ substr(chunk_split(ltrim($customer->mobile, '0'), 3, ' '), 0, -1) }}</td>
                                            <td>{{ $customer->email }}</td>
                                            <td>{{ $customer->address }}</td>
                                            <td>{{ number_format($customer->total) }}</td>
                                            <td>
                                                <a href="{{ route('customer-edit', $customer->id) }}"
                                                    class="btn btn-primary">Edit</a>
                                                <a href="#" class="btn btn-danger" data-toggle="modal"
                                                    data-target="#deleteModal{{ $customer->id }}">Delete</a>
                                            </td>
                                        </tr>

                                        <!-- Delete Form -->
                                        <div class="modal fade" id="deleteModal{{ $customer->id }}" tabindex="-1"
                                            role="dialog" aria-labelledby="deleteModalLabel{{ $customer->id }}"
                                            aria-hidden="true">
                                            <div class="modal-dialog" role="document">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="deleteModalLabel{{ $customer->id }}">
                                                            Confirm Deletion</h5>
                                                        <button type="button" class="close" data-dismiss="modal"
                                                            aria-label="Close">
                                                            <span aria-hidden="true">&times;</span>
                                                        </button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <p>Are you sure you want to delete this customer?</p>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary"
                                                            data-dismiss="modal">Cancel</button>
                                                        <form action="{{ route('customer-delete', $customer->id) }}"
                                                            method="POST">
                                                            @method('DELETE')
                                                            @csrf
                                                            <button type="submit" class="btn btn-danger">Delete</button>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- End Modal -->
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
