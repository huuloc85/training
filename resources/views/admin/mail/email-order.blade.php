<!DOCTYPE html>
<html>

<head>
    <title>Đơn hàng đã được duyệt</title>
</head>

<body>
    <p>Xin chào {{ $order->customer->name }},</p>
    <p>Chúng tôi xin thông báo rằng đơn hàng của bạn có số hóa đơn {{ $order->id }} đã được duyệt.</p>
    <p>Thông tin đơn hàng:</p>
    <ul>
        <li>Tổng tiền: {{ number_format($order->total, 0, ',', '.') }} đ</li>
        <li>Ngày đặt hàng: {{ $order->created_at->format('d/m/Y H:i') }}</li>
        <li>Sản phẩm(s):</li>
        <ul>
            @foreach ($order->orderDetails as $orderDetail)
                <li>{{ $orderDetail->product->proName }} - Số lượng: {{ $orderDetail->quantity }}</li>
            @endforeach
        </ul>
    </ul>
    <p>Xin cảm ơn bạn đã mua hàng tại cửa hàng chúng tôi. Chúng tôi rất hân hạnh được phục vụ bạn.</p>
</body>

</html>
