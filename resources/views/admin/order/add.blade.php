@extends('admin.master')
@section('content')
    <div class="content-wrapper">
        <div class="row">
            <div class="container mt-3" style="margin-top: 20px">
                <h2>Add New Order</h2>
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
                <!-- Add success message display logic here -->
                <form action="{{ route('order-save') }}" method="post">
                    @csrf
                    <div class="form-group">
                        <label for="customer_id">Customer</label>
                        <select name="customer_id" id="customer"
                            class="form-control  @error('customer_id') is-invalid @enderror">
                            @foreach ($customers as $customer)
                                <option value="{{ $customer->id }}">{{ $customer->name }}</option>
                            @endforeach
                        </select>
                        @error('customer_id')
                            <div class="text text-danger">{{ $message }}</div>
                        @enderror
                        <br>
                    </div>

                    <div class="form-group">
                        <label for="product">Product:</label>
                        <select name="product_id" id="product"
                            class="form-control  @error('product_id') is-invalid @enderror">
                            @foreach ($products as $product)
                                <option value="{{ $product->id }}">{{ $product->proName }}</option>
                            @endforeach
                        </select>
                        @error('product_id')
                            <div class="text text-danger">{{ $message }}</div>
                        @enderror
                        <br>
                    </div>

                    <div class="form-group">
                        <label for="id">Quantity</label>
                        <input type="number" class="form-control  @error('quantity') is-invalid @enderror" id="quantity"
                            name="quantity" required>
                        @error('quantity')
                            <div class="text text-danger">{{ $message }}</div>
                        @enderror
                        <br>
                    </div>
                    <div class="form-group">
                        <label for="note">Note</label>
                        <input type="text" class="form-control @error('note') is-invalid @enderror" id="note"
                            name="note" required>
                        @error('note')
                            <div class="text text-danger">{{ $message }}</div>
                        @enderror
                        <br>
                    </div>
                    <div class="form-group">
                        <label for="status">Trạng thái</label>
                        <input type="text" class="form-control" id="status" name="status" required readonly
                            value="">
                        <br>
                        <label><input type="checkbox" name="status_checkbox" value="Đã nhận đơn"
                                onclick="updateStatus(this)"> Đã nhận đơn</label>
                        @if (Auth::user()->role == 1)
                            <label><input type="checkbox" name="status_checkbox" value="Đã duyệt đơn"
                                    onclick="updateStatus(this)"> Đã duyệt đơn</label>
                        @endif
                    </div>

                    <script>
                        function updateStatus(checkbox) {
                            const statusField = document.getElementById('status');

                            // Kiểm tra vai trò của người dùng
                            const isAdmin = {{ Auth::user()->role == 1 ? 'true' : 'false' }};

                            if (isAdmin || checkbox.value !== "Đã nhận đơn") {
                                if (checkbox.checked) {
                                    statusField.value = checkbox.value;

                                    // Uncheck các checkbox khác
                                    const checkboxes = document.querySelectorAll('input[type="checkbox"]');
                                    checkboxes.forEach(otherCheckbox => {
                                        if (otherCheckbox !== checkbox) {
                                            otherCheckbox.checked = false;
                                        }
                                    });
                                } else {
                                    statusField.value = '';
                                }
                            }
                        }
                    </script>

                    <!-- Add other fields here as needed -->
                    <button type="submit" class="btn btn-primary">Add Order</button>
                    <a href="{{ route('order-list') }}" class="btn btn-danger">Back</a>
                </form>
            </div>
        </div>
    </div>
@endsection
