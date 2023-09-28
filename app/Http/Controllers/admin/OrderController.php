<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Customer;
use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\OrderDetail;
use Illuminate\Support\Facades\Auth;

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

    public function save(Request $request)
    {
        $product = Product::find($request->product_id);
        //save order
        $order = new Order();
        $order->customer_id   = $request->customer_id;
        $order->total = $request->quantity * $product->proPrice;
        // $order->date_at = $request->date_at;
        $order->note = $request->note;
        $order->status = $request->status;
        $order->save();

        //save order detail
        $orderDetail = new OrderDetail();
        $orderDetail->order_id = $order->id;
        $orderDetail->product_id = $request->product_id;
        $orderDetail->quantity = $request->quantity;
        $orderDetail->total = $request->quantity * $product->proPrice;
        $orderDetail->save();
        // dd($order);

        return redirect()->route('order-list')->with('success', 'Order added successfully!');
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


    public function update(Request $request, $id)
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
    public function approveAllOrders(Request $request)
    {
        try {
            // Lấy tất cả các đơn hàng đã nhận đơn
            $orders = Order::where('status', 'Đã nhận đơn')->get();

            // Duyệt qua từng đơn hàng và cập nhật trạng thái thành "Đã duyệt đơn"
            foreach ($orders as $order) {
                $order->status = 'Đã duyệt đơn'; // Cập nhật giá trị cột status
                $order->save(); // Lưu thay đổi vào cơ sở dữ liệu
            }

            // Trả về phản hồi JSON trống
            return response()->json([], 200);
        } catch (\Exception $e) {
            // Xử lý lỗi nếu có
            return response()->json([], 500);
        }
    }
}
