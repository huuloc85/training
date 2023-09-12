<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
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
        return view('admin.category.add');
    }
    public function save(Request $request)
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

    public function edit($catSlug)
    {
        $category = Category::where('catSlug', $catSlug)->first();

        if (!$category) {
            return redirect()->back()->with('error', 'Category not found!');
        }

        return view('admin.category.edit', compact('category'));
    }

    public function update($catSlug, Request $request)
    {
        $category = Category::where('catSlug', $catSlug)->first();

        if (!$category) {
            return redirect()->back()->with('error', 'Category not found!');
        }

        // Kiểm tra nếu yêu cầu chứa tệp ảnh mới
        if ($request->hasFile('new_image')) {
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

        try {
            $category->save();

            return redirect()->back()->with('success', 'Category updated successfully!');
        } catch (\Exception $th) {
            if ($request->hasFile('new_image')) {
                $image = 'public/categoryImage/' . $newFileName;
                Storage::delete($image);
            }

            return redirect()->back()->with('error', 'Category could not be updated!');
        }
    }
}
