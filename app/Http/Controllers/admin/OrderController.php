<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\OrderSaveRequest;
use App\Http\Requests\OrderUpdateRequest;
use App\Jobs\SendOrderApprovalEmail;
use App\Mail\OrderApproved;
use App\Models\Product;
use App\Models\Customer;
use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\OrderDetail;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

class OrderController extends Controller
{
    public function list()
    {
        // Lấy danh sách đơn hàng từ CSDL và trả về view để hiển thị
        $orders = Order::All();
        return view('admin.order.list', compact('orders'));
    }

    public function add()
    {
        $products = Product::all();
        $customers = Customer::all();
        // Hiển thị view để thêm đơn hàng mới
        return view('admin.order.add', compact('products', 'customers'));
    }

    public function save(OrderSaveRequest $request)
    {
        try {
            // Tìm sản phẩm theo ID
            $product = Product::find($request->product_id);

            // Kiểm tra xem sản phẩm có sẵn đủ số lượng không
            if ($product->proQuantity < $request->quantity) {
                return redirect()->route('order-list')->with('error', 'Số lượng sản phẩm không đủ.');
            }

            // Lưu đơn hàng
            $order = new Order();
            $order->customer_id = $request->customer_id;
            $order->total = $request->quantity * $product->proPrice;
            $order->note = $request->note;
            $order->status = $request->status;
            $order->save();

            // Lưu chi tiết đơn hàng
            $orderDetail = new OrderDetail();
            $orderDetail->order_id = $order->id;
            $orderDetail->product_id = $product->id; // Lấy ID sản phẩm từ đối tượng sản phẩm
            $orderDetail->quantity = $request->quantity;
            $orderDetail->total = $request->quantity * $product->proPrice;
            $orderDetail->save();

            // Cập nhật số lượng sản phẩm
            $product->proQuantity -= $request->quantity;
            $product->save();

            return redirect()->route('order-list')->with('success', 'Đã thêm đơn hàng thành công!');
        } catch (\Exception $th) {
            return redirect()->route('order-list')->with('error', 'Đã xảy ra lỗi khi thêm đơn hàng.');
        }
    }



    public function show($id)
    {

        $orderDetail = OrderDetail::where('order_id', $id)->get();
        return view('admin.order.detail', compact('orderDetail'));
    }

    public function edit($id)
    {
        $order = Order::findOrFail($id);
        return view('admin.order.edit', compact('order'));
    }


    public function update(OrderUpdateRequest  $request, $id)
    {
        // Xử lý cập nhật thông tin đơn hàng vào CSDL
        $order = Order::findOrFail($id);
        $order->customer_id = $request->customer_id;
        $order->order_date = $request->order_date;
        $order->total_amount = $request->total_amount;
        $order->save();

        return redirect()->route('admin.order.list')->with('success', 'Order updated successfully!');
    }

    public function delete($id)
    {
        // Xóa đơn hàng dựa trên $id từ CSDL
        $orderDetail = OrderDetail::where('order_id', $id)->delete();
        $order = Order::findOrFail($id);
        $order->delete();

        return redirect()->route('order-list')->with('success', 'Order deleted successfully!');
    }

    public function approveOrder($id)
    {
        // Xử lý duyệt đơn hàng
        $order = Order::find($id);

        if (!$order) {
            // Xử lý trường hợp không tìm thấy đơn hàng
            return response()->json(['status' => 'Lỗi', 'message' => 'Không tìm thấy đơn hàng.']);
        }

        // Kiểm tra trạng thái đơn hàng đã duyệt
        if ($order->status === 'Đã duyệt đơn') {
            // Đơn hàng đã duyệt, không cần thực hiện gì cả
            return response()->json(['status' => 'Đã duyệt đơn', 'message' => 'Đơn hàng đã được duyệt.']);
        }

        // Đánh dấu đơn hàng đã duyệt
        $order->status = 'Đã duyệt đơn';
        $order->save();

        // Gửi job vào hàng đợi để gửi email
        // $employeeData = [
        //     'name' => $user->name,
        //     'email' => $user->email,
        //     'password' => $request->password,
        // ];
        SendOrderApprovalEmail::dispatch($order);

        return response()->json(['status' => 'Đã duyệt đơn', 'message' => 'Đơn hàng đã được duyệt.']);
    }
}
