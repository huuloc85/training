@extends('admin.master')
@section('content')
    <div class="content-wrapper">
        <div class="row">
            <div class="col-md-12 grid-margin stretch-card">
                <div class="card">
                    <div class="card-body">
                        <h3 class="card-title">Order Detail</h3>
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>Order ID</th>
                                    <th>Product Name</th>
                                    <th>Product Price</th>
                                    <th>Product Image</th>
                                    <th>Quantity</th>
                                    <th>Total Amount</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($orderDetail as $order)
                                    <tr data-status="{{ $order->order->status }}">
                                        <td>{{ $order->order_id }}</td>
                                        <td>{{ $order->product->proName }}</td>
                                        <td>{{ number_format($order->product->proPrice) }} VND</td>
                                        <td><img src="{{ asset('storage/productImage/' . $order->product->proImage) }}"
                                                style="height: 100px; width: 100px;"></td>
                                        <td>{{ $order->quantity }}</td>
                                        <td>{{ number_format($order->total) }} VND</td>
                                        <!-- Đoạn HTML -->
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        @foreach ($orderDetail as $order)
            <div class="row">
                <div class="col-md-12">
                    <div class="card mb-3">
                        <div class="card-body">
                            @if ($order->order->status != 'Đã duyệt đơn')
                                <button class="btn btn-success approve-order text-uppercase"
                                    data-order-id="{{ $order->id }}">Duyệt đơn
                                    hàng</button>
                            @endif
                            <div class="order-status mt-3">
                                <div class="status" id="status-{{ $order->id }}">
                                    @if ($order->order->status == 'Đã nhận đơn')
                                        <p class="h3 font-weight-bold text-primary text-uppercase">Tình trạng đơn hàng: Đã
                                            nhận đơn</p>
                                    @elseif ($order->order->status == 'Đã duyệt đơn')
                                        <p class="h3 font-weight-bold text-success text-uppercase">Tình trạng đơn hàng: Đã
                                            duyệt đơn</p>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach



        <!-- Đoạn mã JavaScript -->
        <script>
            $(document).ready(function() {
                $('.approve-order').click(function() {
                    var orderId = $(this).data('order-id');
                    var approveOrderUrl = "/admin/order/approve-order/" + orderId;

                    $.ajax({
                        url: approveOrderUrl,
                        method: 'POST',
                        data: {
                            _token: "{{ csrf_token() }}",
                            order_id: orderId
                        },
                        success: function(response) {
                            console.log('AJAX request successful');
                            var newStatus = response.status;
                            var statusElement = $('#status-' + orderId);

                            if (newStatus === 'Đã duyệt đơn') {
                                statusElement.html(
                                    '<p class="h3 font-weight-bold text-success text-uppercase">Tình trạng đơn hàng: ' +
                                    newStatus + '</p>');
                                $('.order[data-order-id="' + orderId + '"] .approve-order').hide();
                            } else {
                                statusElement.html(
                                    '<p class="h3 font-weight-bold text-success text-danger">Lỗi khi duyệt đơn hàng</p>'
                                );
                            }
                        },
                        error: function(error) {
                            console.log(error);
                            var statusElement = $('#status-' + orderId);
                            statusElement.html(
                                '<p class="font-weight-bold text-danger">Lỗi khi duyệt đơn hàng</p>'
                            );
                        }
                    });
                });
            });
        </script>
    </div>
    <div class="row">
        <div class="col-md-12 d-flex justify-content-center align-items-center">
            <a href="{{ route('order-list') }}" class="btn btn-primary">Back to Order List</a>
        </div>
    </div>
@endsection
