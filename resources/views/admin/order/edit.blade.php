@extends('admin.master')
@section('content')
    <div class="content-wrapper">
        <div class="row">
            <div class="col-md-12 grid-margin stretch-card">
                <div class="card">
                    <div class="card-body">
                        <h2>Update Order</h2>
                        <!-- Display success message if available -->
                        @if (Session::has('success'))
                            <div class="alert alert-success" role="alert">
                                {{ Session::get('success') }}
                            </div>
                        @endif
                        <form action="{{ route('order-update', $order->id) }}" method="POST">
                            @csrf
                            @method('PUT')
                            <div class="mb-3 mt-3">
                                <label for="id">Order ID:</label>
                                <input type="text" class="form-control" id="id" name="id"
                                    value="{{ $order->id }}" readonly>
                            </div>
                            <div class="mb-3 mt-3">
                                <label for="customer_id">Customer ID:</label>
                                <input type="text" class="form-control" id="customer_id" name="custom_id"
                                    value="{{ $order->customer_id }}" readonly>
                            </div>
                            <div class="mb-3 mt-3">
                                <label for="order_date">Order Date:</label>
                                <input type="date" class="form-control" id="order_date" name="order_date"
                                    value="{{ $order->order_date }}">
                            </div>
                            <div class="mb-3 mt-3">
                                <label for="total_amount">Total Amount:</label>
                                <input type="text" class="form-control" id="total_amount" name="total_amount"
                                    value="{{ $order->total_amount }}">
                            </div>
                            <!-- Add other fields here as needed -->
                            <button type="submit" class="btn btn-primary">Update</button>
                            <a href="{{ url('admin/order-list') }}" class="btn btn-danger">Back</a>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
