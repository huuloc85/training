<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\ProductSaveRequest;
use App\Http\Requests\ProductUpdateRequest;
use App\Models\Category;
use App\Models\Product;
use App\Models\PhotoDetail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    public function list()
    {
        // Truy vấn tất cả sản phẩm với thông tin chi tiết ảnh
        $products = Product::with('category', 'userAdded', 'userUpdated', 'photoDetails')->get();

        return view('admin.product.list', compact('products'));
    }

    public function add()
    {
        $cat = Category::all();
        return view('admin.product.add', compact('cat'));
    }

    public function save(ProductSaveRequest $request)
    {
        try {
            // Tạo đối tượng Product và lưu thông tin sản phẩm
            $product = new Product();
            $product->proName = $request->proName;
            $product->proSlug = $request->proSlug;
            $product->proPrice = $request->proPrice;
            $product->proDetail = $request->proDetail;
            $product->proQuantity = $request->proQuantity;
            $product->category_id = $request->category_id;
            $product->user_added = Auth::user()->id;
            $product->user_updated = Auth::user()->id;

            // Xử lý tải lên hình ảnh sản phẩm
            if ($request->hasFile('proImage')) {
                $file = $request->file('proImage');
                $fileExtension = $file->getClientOriginalExtension();
                $fileName = time();
                $newFileName = $fileName . '.' . $fileExtension;
                $file->storeAs('public/productImage', $newFileName);
                $product->proImage = $newFileName;
            }

            // Lưu sản phẩm vào cơ sở dữ liệu
            $product->save();

            if ($request->hasFile('photo')) {
                foreach ($request->file('photo') as $key => $file) {
                    $photoDetail = new PhotoDetail();

                    $fileExtension = $file->getClientOriginalExtension();
                    $newFileName = $key  . '.' . $fileExtension;

                    $file->storeAs('public/productImageDetails', $newFileName);
                    $product->photoDetails()->saveMany([
                        new PhotoDetail([
                            'photos' => $newFileName,
                        ]),
                    ]);
                }
            }
            return redirect()->back()->with('success', 'Product and photo added successfully!');
        } catch (\Exception $th) {
            dd($th->getMessage());
            // Xử lý ngoại lệ và xóa hình ảnh nếu cần
            if (isset($product->proImage)) {
                $imagePath = 'public/productImage/' . $product->proImage;
                Storage::delete($imagePath);
            }
            if (isset($photoDetail->photos)) {
                $imagePath = 'public/productImageDetails/' . $photoDetail->photos;
                Storage::delete($imagePath);
            }
            return redirect()->back()->with('error', 'An error occurred while adding product and photo.');
        }
    }

    // public function edit($proSlug)
    // {
    //     $cat = Category::get();
    //     $pro = Product::where('proSlug', '=', $proSlug)->first();

    //     if (!$pro) {
    //         // Xử lý khi không tìm thấy sản phẩm với proSlug cụ thể
    //         // Ví dụ: return redirect()->route('product-list')->with('error', 'Product not found.');
    //     }

    //     return view('admin.product.edit', compact('pro', 'cat'));
    // }
    public function edit($proSlug)
    {
        try {
            $cat = Category::get();
            $pro = Product::where('proSlug', '=', $proSlug)->firstOrFail();

            return view('admin.product.edit', compact('pro', 'cat'));
        } catch (\Exception $th) {
            return redirect()->route('product-list')->with('error', 'Product not found.');
        }
    }


    // public function update(ProductUpdateRequest $request, $proSlug)
    // {
    //     try {
    //         // Tìm sản phẩm bằng proSlug
    //         $product = Product::where('proSlug', $proSlug)->firstOrFail();

    //         // Kiểm tra nếu yêu cầu chứa tệp ảnh mới
    //         if ($request->hasFile('proImage')) {
    //             // Xóa hình ảnh cũ (nếu có)
    //             if ($product->proImage) {
    //                 Storage::delete('public/productImage/' . $product->proImage);
    //             }

    //             $file = $request->file('proImage');
    //             $fileExtension = $file->getClientOriginalExtension();
    //             $fileName = time();
    //             $newFileName = $fileName . '.' . $fileExtension;
    //             $file->storeAs('public/productImage', $newFileName);
    //             $product->proImage = $newFileName;
    //         }

    //         // Gán giá trị cho các thuộc tính khác của sản phẩm
    //         $product->proName = $request->proName;
    //         $product->proSlug = $request->proSlug;
    //         $product->proDetail = $request->proDetail;
    //         $product->proPrice = $request->proPrice;
    //         $product->proQuantity = $request->proQuantity;
    //         $product->category_id = $request->category_id; // Sửa tên trường là category_id

    //         // Cập nhật người cập nhật sản phẩm
    //         $product->user_updated = Auth::user()->id;

    //         // Lưu sản phẩm
    //         $product->save();

    //         return redirect()->route('product-list')->with('success', 'Product updated successfully!');
    //     } catch (\Exception $th) {
    //         // Trong trường hợp lưu cơ sở dữ liệu thất bại, hãy xóa hình ảnh mới (nếu có)
    //         if ($request->hasFile('proImage')) {
    //             Storage::delete('public/productImage/' . $newFileName);
    //         }
    //         return redirect()->route('product-list')->with('error', 'Product could not be updated!');
    //     }
    // }
    public function update(ProductUpdateRequest $request, $proSlug)
    {
        try {
            // Tìm sản phẩm bằng proSlug
            $product = Product::where('proSlug', '=', $proSlug)->firstOrFail();
            if ($request->hasFile('new_image')) {
                // Xóa hình ảnh cũ (nếu có)
                if ($product->proImage) {
                    Storage::delete('public/productImage/' . $product->proImage);
                }

                $file = $request->file('new_image');
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

            // Kiểm tra nếu có hình ảnh sản phẩm chi tiết mới được gửi
            if ($request->hasFile('photo')) {
                // Xóa hình ảnh sản phẩm chi tiết cũ
                foreach ($product->photoDetails as $photoDetail) {
                    Storage::delete('public/productImageDetails/' . $photoDetail->photos);
                    $photoDetail->delete();
                }

                // Lưu hình ảnh sản phẩm chi tiết mới
                foreach ($request->file('photo') as $key => $file) {
                    $newFileName = $key . '.' . $file->getClientOriginalExtension();
                    $file->storeAs('public/productImageDetails', $newFileName);
                    $product->photoDetails()->create([
                        'photos' => $newFileName,
                    ]);
                }
            }

            return redirect()->route('product-list')->with('success', 'Product updated successfully!');
        } catch (\Exception $th) {
            return redirect()->route('product-list')->with('error', 'Product could not be updated.');
        }
    }




    public function delete($id)
    {
        try {
            // Tìm sản phẩm bằng ID
            $product = Product::findOrFail($id);

            // Kiểm tra xem sản phẩm có hóa đơn nào sử dụng nó không
            $hasOrders = $product->orders()->exists();

            if ($hasOrders) {
                return redirect()->back()->with('error', 'You cannot delete this product because it is already associated with an order.');
            }

            // Xóa ảnh chi tiết (photoDetails) nếu có
            if ($product->photoDetails) {
                foreach ($product->photoDetails as $photoDetail) {
                    Storage::delete('public/productImageDetails/' . $photoDetail->photos);
                    $photoDetail->delete();
                }
            }

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
