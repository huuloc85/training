@extends('admin.master')

@section('content')
    <div class="col-md-12 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title">Add Product</h4>
                @if (Session::has('success'))
                    <div class="alert alert-success" role="alert">
                        {{ Session::get('success') }}
                    </div>
                @endif

                @if (Session::has('error'))
                    <div class="alert alert-error" role="alert">
                        {{ Session::get('error') }}
                    </div>
                @endif
                <form action="{{ route('product-save') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="form-group">
                        <label for="proName">Product Name</label>
                        <input type="text" class="form-control @error('proName') is-invalid @enderror" id="proName"
                            name="proName" required>
                        @error('proName')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="proSlug">Product Slug</label>
                        <input type="text" class="form-control @error('proSlug') is-invalid @enderror" id="proSlug"
                            name="proSlug" required>
                        @error('proSlug')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="proDetail">Product Detail</label>
                        <textarea class="form-control @error('proDetail') is-invalid @enderror" id="proDetail" name="proDetail" rows="4"
                            required></textarea>
                        @error('proDetail')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="proPrice">Product Price</label>
                        <input type="text" class="form-control @error('proPrice') is-invalid @enderror" id="proPrice"
                            name="proPrice" required>
                        @error('proPrice')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="proQuantity">Product Quantity</label>
                        <input type="number" class="form-control @error('proQuantity') is-invalid @enderror"
                            id="proQuantity" name="proQuantity" required>
                        @error('proQuantity')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="proImage">Product Image</label>
                        <input type="file" class="form-control" id="proImage" name="proImage" required>
                        <div id="imagePreview"></div>
                    </div>
                    <script>
                        document.addEventListener("DOMContentLoaded", function() {
                            const proImageInput = document.getElementById("proImage");
                            const imagePreview = document.getElementById("imagePreview");

                            proImageInput.addEventListener("change", function() {
                                const file = proImageInput.files[0];

                                if (file) {
                                    const reader = new FileReader();

                                    reader.onload = function(e) {
                                        const img = document.createElement("img");
                                        img.src = e.target.result;
                                        img.style.width = '150px';
                                        img.style.height = "auto";

                                        // Tạo biểu tượng (icon) xoá
                                        const deleteIcon = document.createElement("i");
                                        deleteIcon.classList.add("fa", "fa-trash", "delete-icon");
                                        deleteIcon.style.cursor = "pointer";
                                        deleteIcon.addEventListener("click", function() {
                                            imagePreview.innerHTML =
                                                ""; // Xóa hình ảnh và biểu tượng (icon) xoá
                                            proImageInput.value = ""; // Xóa tệp đã chọn trong input file
                                        });

                                        // Thêm hình ảnh và biểu tượng (icon) vào phần tử "imagePreview"
                                        imagePreview.innerHTML = "";
                                        imagePreview.appendChild(img);
                                        imagePreview.appendChild(deleteIcon);
                                    };

                                    reader.readAsDataURL(file);
                                } else {
                                    imagePreview.innerHTML =
                                        ""; // Xóa hình ảnh và biểu tượng (icon) nếu không có tệp nào được chọn
                                }
                            });
                        });
                    </script>

                    <div class="form-group">
                        <label for="photo">Product Images Detail</label>
                        <input type="file" class="form-control @error('photo') is-invalid @enderror" id="photo"
                            name="photo[]" multiple required>
                        @error('photo')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        <div id="image-preview">
                        </div>
                    </div>
                    <script>
                        const imageInput = document.getElementById('photo');
                        const imagePreview = document.getElementById('image-preview');

                        imageInput.addEventListener('change', (e) => {
                            const files = e.target.files;

                            for (let i = 0; i < files.length; i++) {
                                const imageContainer = document.createElement('div');
                                imageContainer.className = 'image-container';

                                const img = document.createElement('img');
                                img.src = URL.createObjectURL(files[i]);

                                // Thiết lập chiều rộng cố định cho hình ảnh
                                img.style.width = '150px';

                                const deleteIcon = document.createElement('i');
                                deleteIcon.className = 'fa fa-trash delete-icon';

                                // Thêm sự kiện click để xoá ảnh khi bấm vào biểu tượng xoá
                                deleteIcon.addEventListener('click', () => {
                                    imagePreview.removeChild(imageContainer);
                                });

                                imageContainer.appendChild(img);
                                imageContainer.appendChild(deleteIcon);

                                imagePreview.appendChild(imageContainer);
                            }
                        });
                    </script>

                    <style>
                        .image-container {
                            display: inline-block;
                            /* Để các hình ảnh được xếp cạnh nhau */
                            margin: 10px;
                            /* Khoảng cách giữa các hình ảnh */
                        }

                        .image-container img {
                            width: 150px;
                            /* Chiều rộng cố định của hình ảnh */
                            height: auto;
                            /* Để duy trì tỷ lệ khung hình ban đầu */
                        }
                    </style>


                    <!-- Add a dropdown to select the category -->
                    <div class="form-group">
                        <label for="category_id">Category</label>
                        <select class="form-control @error('category_id') is-invalid @enderror" id="category_id"
                            name="category_id" required>
                            @foreach ($cat as $category)
                                <option value="{{ $category->id }}">{{ $category->catName }}</option>
                            @endforeach
                        </select>
                        @error('category_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <button type="submit" class="btn btn-primary">Add Product</button>
                </form>
            </div>
        </div>
    </div>
@endsection
