<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    public function list()
    {
        $products = Product::all();
        return view('admin.product.list', compact('products'));
        $products = Product::with('category', 'userAdded', 'userUpdated')->get();
    }

    public function add()
    {
        $cat = Category::all();
        return view('admin.product.add', compact('cat'));
    }

    public function save(Request $request)
    {
        $product = new Product();
        $product->proName = $request->proName;
        $product->proSlug = $request->proSlug;
        $product->proPrice = $request->proPrice;
        $product->proDetail = $request->proDetail;
        $product->proQuantity = $request->proQuantity;
        $product->category_id = $request->category_id;
        $product->user_added = Auth::user()->id; // Lấy ID của người đăng nhập làm người thêm sản phẩm
        $product->user_updated = Auth::user()->id; // Đặt người cập nhật ban đầu là người đăng nhập

        // Xử lý tải lên hình ảnh
        if ($request->hasFile('proImage')) {
            $file = $request->file('proImage');
            $fileExtension = $file->getClientOriginalExtension(); // Lấy phần mở rộng của file (vd: jpg, png)
            $fileName = time(); // Tạo tên file dựa trên thời gian
            $newFileName = $fileName . '.' . $fileExtension; // Tên file mới
            // Lưu file vào thư mục storage/app/public/categoryImage với tên mới
            $file->storeAs('public/productImage', $newFileName);
            // Gán trường proImage của đối tượng product với tên mới
            $product->proImage = $newFileName;
        }

        try {
            $product->save();
            return redirect()->back()->with('success', 'Product added successfully!');
        } catch (\Exception $th) {
            if (isset($product->proImage)) {
                $imagePath = 'public/productImage/' . $product->proImage;
                Storage::delete($imagePath);
            }
            return redirect()->back()->with('error', 'An error occurred while adding product.');
        }
    }
    public function edit($proSlug)
    {
        $cat = Category::get();
        $pro = Product::where('proSlug', '=', $proSlug)->first();

        if (!$pro) {
            // Xử lý khi không tìm thấy sản phẩm với proSlug cụ thể
            // Ví dụ: return redirect()->route('product-list')->with('error', 'Product not found.');
        }

        return view('admin.product.edit', compact('pro', 'cat'));
    }

    public function update(Request $request, $proSlug)
    {
        try {
            // Tìm sản phẩm bằng proSlug
            $product = Product::where('proSlug', $proSlug)->firstOrFail();

            // Kiểm tra nếu yêu cầu chứa tệp ảnh mới
            if ($request->hasFile('proImage')) {
                // Xóa hình ảnh cũ (nếu có)
                if ($product->proImage) {
                    Storage::delete('public/productImage/' . $product->proImage);
                }

                $file = $request->file('proImage');
                $fileExtension = $file->getClientOriginalExtension();
                $fileName = time();
                $newFileName = $fileName . '.' . $fileExtension;
                $file->storeAs('public/productImage', $newFileName);
                $product->proImage = $newFileName;
            }

            // Gán giá trị cho các thuộc tính khác của sản phẩm
            $product->proName = $request->proName;
            $product->proSlug = $request->proSlug;
            $product->proDetail = $request->proDetail;
            $product->proPrice = $request->proPrice;
            $product->proQuantity = $request->proQuantity;
            $product->category_id = $request->category_id; // Sửa tên trường là category_id

            // Cập nhật người cập nhật sản phẩm
            $product->user_updated = Auth::user()->id;

            // Lưu sản phẩm
            $product->save();

            return redirect()->route('product-list')->with('success', 'Product updated successfully!');
        } catch (\Exception $th) {
            // Trong trường hợp lưu cơ sở dữ liệu thất bại, hãy xóa hình ảnh mới (nếu có)
            if ($request->hasFile('proImage')) {
                Storage::delete('public/productImage/' . $newFileName);
            }
            return redirect()->route('product-list')->with('error', 'Product could not be updated!');
        }
    }

    public function delete($id)
    {
        try {
            // Tìm sản phẩm bằng ID
            $product = Product::findOrFail($id);

            // // Kiểm tra xem sản phẩm có hóa đơn nào sử dụng nó không
            // $hasOrders = $product->orders()->exists();

            // if ($hasOrders) {
            //     return redirect()->back()->with('error', 'You cannot delete this product because it is already associated with an order.');
            // }

            // Xóa hình ảnh nếu có
            if ($product->proImage) {
                Storage::delete('public/productImage/' . $product->proImage);
            }

            // Xóa sản phẩm
            $product->delete();

            return redirect()->back()->with('success', 'Product deleted successfully!');
        } catch (\Exception $th) {
            return redirect()->back()->with('error', 'Failed to delete product.');
        }
    }
}
