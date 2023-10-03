<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\CategorySaveRequest;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class CategoryController extends Controller
{
    public function list()
    {
        $categories = Category::all();
        return view('admin.category.list', compact('categories'));
    }
    public function add()
    {
        return view('admin.category.add ');
    }
    public function save(CategorySaveRequest  $request)
    {
        $category = new Category();
        $category->catName = $request->catName;
        $category->catSlug = $request->catSlug;
        $file = $request->catImage;
        if ($request->hasFile('catImage')) {
            $fileExtension = $file->getClientOriginalExtension(); // Lấy phần mở rộng của file (vd: jpg, png)
            $fileName = time(); // Tạo tên file dựa trên thời gian
            $newFileName = $fileName . '.' . $fileExtension; // Tên file mới
            // Lưu file vào thư mục storage/app/public/categoryImage với tên mới
            $request->file('catImage')->storeAs('public/categoryImage', $newFileName);
            // Gán trường catImage của đối tượng category với tên mới
            $category->catImage = $newFileName;
        }
        try {
            $category->save();
            return redirect()->back()->with('success', 'Category added successfully!');
        } catch (\Exception $th) {
            $image = 'public/categoryImage/' . $category->catImage;
            Storage::delete($image);
            return redirect()->back()->with('error', 'An error occurred while adding category.');
        }
    }

    public function edit($catSlug)
    {
        $category = Category::where('catSlug', $catSlug)->first();

        if (!$category) {
            return redirect()->route('category-list')->with('');
        }

        return view('admin.category.edit', compact('category'));
    }


    public function update($catSlug, Request $request)
    {
        try {
            // Tìm danh mục bằng catSlug
            $category = Category::where('catSlug', $catSlug)->firstOrFail();

            // Kiểm tra nếu yêu cầu chứa tệp ảnh mới
            if ($request->hasFile('new_image')) {
                // Xóa hình ảnh cũ (nếu có)
                if ($category->catImage) {
                    Storage::delete('public/categoryImage/' . $category->catImage);
                }

                $file = $request->file('new_image');
                $fileExtension = $file->getClientOriginalExtension();
                $fileName = time();
                $newFileName = $fileName . '.' . $fileExtension;
                $file->storeAs('public/categoryImage', $newFileName);
                $category->catImage = $newFileName;
            }

            // Gán giá trị cho các thuộc tính khác của danh mục
            $category->catName = $request->catName;
            $category->catSlug = $request->catSlug;

            $category->save();

            return redirect()->route('category-list')->with('success', 'Category updated successfully!');
        } catch (\Exception $th) {
            // Trong trường hợp lưu cơ sở dữ liệu thất bại, hãy xóa hình ảnh mới (nếu có)
            if ($request->hasFile('new_image')) {
                Storage::delete('public/categoryImage/' . $newFileName);
            }
            return redirect()->route('category-list')->with('error', 'Category could not be updated!');
        }
    }
    public function delete($id)
    {
        // check xem sản phẩm có thuộc danh mục hay không
        $checkproduct = Product::where('category_id', $id)->first();
        if ($checkproduct) {
            return redirect()->back()->with('error', 'You can not delete this category because it is already have product.');
        }
        $category = Category::FindOrFail($id);
        $image = 'public/categoryImage/' . $category->catImage;
        Storage::delete($image);
        $category->delete();
        return redirect()->back()->with('success', 'Category deleted successfully!');
    }
}
