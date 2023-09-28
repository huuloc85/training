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



        <div class="row">
            <span id="orderStatus{{ $order->order_id }}"
                class="text-{{ $order->order->status === 'Đã nhận đơn' ? 'danger' : 'success' }} {{ $order->order->status === 'Đã nhận đơn' ? '' : 'd-none' }}"
                data-status="{{ $order->order->status }}">
                {{ $order->order->status }}
            </span>
        </div>


        <!-- Đơn hàng chưa được duyệt đơn, hiển thị button -->
        <div class="row mb-3"> <!-- Thêm margin dưới cho dòng này -->
            <div class="col-md-12">
                @php
                    $allOrdersReceived = true;
                    foreach ($orderDetail as $order) {
                        if ($order->order->status !== 'Đã nhận đơn') {
                            $allOrdersReceived = false;
                            break;
                        }
                    }
                @endphp
                @if ($allOrdersReceived)
                    <button id="approveAllOrders" class="btn btn-success" data-order-received="true">Duyệt tất cả đơn hàng
                        đã
                        nhận đơn</button>
                @endif
            </div>
        </div>

        <script>
            // Lấy tham chiếu đến nút "Duyệt tất cả đơn hàng đã nhận đơn"
            var approveButton = document.getElementById("approveAllOrders");

            // Lấy tất cả các thẻ span chứa trạng thái đơn hàng
            var orderStatusElements = document.querySelectorAll('[data-status]');

            // Xử lý sự kiện khi click vào nút "Duyệt tất cả đơn hàng đã nhận đơn"
            approveButton.addEventListener("click", function() {
                // Duyệt qua tất cả các thẻ span và thay đổi trạng thái
                orderStatusElements.forEach(function(element) {
                    element.textContent = 'Đã duyệt đơn'; // Thay đổi trạng thái thành "Đã duyệt"
                    element.classList.remove('text-danger');
                    element.classList.add('text-success'); // Bỏ class 'text-danger' nếu có
                });
            });
        </script>

        <!-- Div để hiển thị trạng thái duyệt đơn -->
        <div class="row mb-3"> <!-- Thêm margin dưới cho dòng này -->
            <div class="col-md-12">
                <div id="overallStatus" class="mt-3"></div>
            </div>
        </div>
    </div>

    <script>
        $(document).ready(function() {
            $('#approveAllOrders').click(function() {
                // Gửi Ajax request để duyệt tất cả đơn hàng đã nhận đơn
                $.ajax({
                    url: "{{ route('approve-all-orders') }}?_=" + Date.now(),
                    // Điều này cần phù hợp với URL của route xử lý duyệt tất cả đơn hàng
                    method: 'POST',
                    data: {
                        _token: "{{ csrf_token() }}"
                    },
                    success: function(response) {
                        // Ẩn cả cột <th>Status</th>
                        $('table thead th:last-child, table tbody td:last-child').hide();

                        // Lặp qua từng dòng trong bảng
                        $('table tbody tr').each(function() {
                            // Tìm phần tử con có lớp CSS "status-column" trong dòng hiện tại
                            var statusColumn = $(this).find('.status-column');

                            // Cập nhật giá trị status trong phần tử "orderStatus" thành "Đã duyệt đơn"
                            var orderStatusElement = statusColumn.find('span');
                            if (orderStatusElement.length) {
                                orderStatusElement.text('Đã duyệt đơn');
                                orderStatusElement.removeClass('text-danger').addClass(
                                    'text-success');
                            }

                        });

                        // Cập nhật trạng thái duyệt đơn tổng quan
                        $('#overallStatus').html(
                            '<p class="text-success">Tất cả đơn hàng đã được duyệt</p>');
                        $('#approveAllOrders').hide();

                    },
                    error: function(error) {
                        console.log(error);
                        alert('Lỗi khi duyệt đơn hàng');
                    }
                });
            });
        });
    </script>
    <div class="row">
        <div class="col-md-12 d-flex justify-content-center align-items-center">
            <a href="{{ route('order-list') }}" class="btn btn-primary">Back to Order List</a>
        </div>
    </div>
@endsection
