@extends('admin.master')
@section('content')
    <div class="content-wrapper">
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <h3 class="card-title">Order List</h3>
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
                                        <th>Order ID</th>
                                        <th>Customer Name</th>
                                        <th>Customer Email</th>
                                        <th>Customer Phone</th>
                                        <th>Date</th>
                                        <th>Total Amount</th>
                                        <th>Note</th>
                                        <th>Status</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($orders as $key => $order)
                                        <tr>
                                            <td>{{ $key + 1 }}</td>
                                            <td>{{ $order->customer->name }}</td>
                                            <td>{{ $order->customer->email }}</td>
                                            <td>{{ $order->customer->mobile }}</td>
                                            <td>{{ $order->created_at }}</td>
                                            <td>{{ number_format($order->total) }} VND</td>
                                            <td>{{ $order->note }}</td>
                                            <td>
                                                <style>
                                                    .custom-badge {
                                                        font-size: 15px;
                                                        padding: 10px 20px;
                                                    }
                                                </style>
                                                <span
                                                    class="badge custom-badge {{ $order->status === 'Đã nhận đơn' ? 'bg-danger' : 'bg-success' }}">
                                                    {{ $order->status }}
                                                </span>
                                            </td>
                                            <td>
                                                <a href="{{ route('order-detail', $order->id) }}"
                                                    class="btn btn-primary">Show</a>

                                                <!-- Delete Form -->
                                                <a href="#" class="btn btn-danger" data-toggle="modal"
                                                    data-target="#deleteModal{{ $order->id }}">Delete</a>
                                                <div class="modal fade" id="deleteModal{{ $order->id }}" tabindex="-1"
                                                    role="dialog" aria-labelledby="deleteModalLabel{{ $order->id }}"
                                                    aria-hidden="true">
                                                    <div class="modal-dialog" role="document">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h5 class="modal-title"
                                                                    id="deleteModalLabel{{ $order->id }}">
                                                                    Confirm Deletion</h5>
                                                                <button type="button" class="close" data-dismiss="modal"
                                                                    aria-label="Close">
                                                                    <span aria-hidden="true">&times;</span>
                                                                </button>
                                                            </div>
                                                            <div class="modal-body">
                                                                <p>Are you sure you want to delete this order?</p>
                                                            </div>
                                                            <div class="modal-footer">
                                                                <button type="button" class="btn btn-secondary"
                                                                    data-dismiss="modal">Cancel</button>
                                                                <form action="{{ route('order-delete', $order->id) }}"
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
                                                <!-- End Modal -->
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
