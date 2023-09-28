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


        <div class="row" id="orderStatus">
            <div class="col-md-12">
                <table class="table">
                    <tbody>
                        @foreach ($orderDetail as $order)
                            <tr>
                                <td> Tình trạng đơn hàng: {{ $order->order->status }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div id="approveAllOrders">
                    <button class="btn btn-success" data-order-received="true">Duyệt tất cả đơn hàng đã nhận đơn</button>
                </div>
            </div>
        </div>
        <!-- Div để hiển thị trạng thái duyệt đơn -->
        <div class="row">
            <div class="col-md-12">
                <div id="overallStatus" class="mt-3"></div>
            </div>
        </div>
        <script>
            $(document).ready(function() {
                $('#approveAllOrders').click(function() {
                    // Gửi Ajax request để duyệt tất cả đơn hàng đã nhận đơn
                    $.ajax({
                        url: "{{ route('approve-all-orders') }}", // Đặt URL tương ứng với route của bạn
                        method: 'POST',
                        data: {
                            _token: "{{ csrf_token() }}"
                        },
                        success: function(response) {
                            console.log('AJAX request successful');
                            {
                                // Lấy giá trị trạng thái từ biến PHP và truyền vào JavaScript
                                // var orderStatus = "{{ $order->status }}";

                                // Cập nhật trạng thái đơn hàng thành "Đã duyệt đơn"
                                updateOrderStatus("Đã duyệt đơn");

                                // Cập nhật trạng thái duyệt đơn tổng quan
                                $('#overallStatus').html(
                                    '<p class="text-success">Tất cả đơn hàng đã được duyệt</p>');
                                $('#approveAllOrders').hide();
                            }
                        },
                        error: function(error) {
                            console.log(error);
                            alert('Lỗi khi duyệt đơn hàng');
                        }
                    });
                });
                @foreach ($orderDetail as $order)
                    var orderStatus = "{{ $order->order->status }}";
                    if (orderStatus == "Đã nhận đơn") {
                        $("#orderStatus").show(); // Hiển thị div nếu đã nhận đơn
                        $("#approveAllOrders").show(); // Hiển thị button nếu đã nhận đơn
                    } else if (orderStatus == "Đã duyệt đơn") {
                        $("#orderStatus").hide(); // Ẩn div nếu đã duyệt đơn
                        $("#approveAllOrders").hide(); // Ẩn button nếu đã duyệt đơn
                    }
                @endforeach
                // Hàm để cập nhật trạng thái đơn hàng
                function updateOrderStatus(newStatus) {
                    var orderStatusElement = $('#orderStatus');
                    orderStatusElement.html('<p class="text-success">Tình trạng đơn hàng: ' + newStatus + '</p>');
                }
            });
        </script>
    </div>
    <div class="row">
        <div class="col-md-12 d-flex justify-content-center align-items-center">
            <a href="{{ route('order-list') }}" class="btn btn-primary">Back to Order List</a>
        </div>
    </div>
@endsection
