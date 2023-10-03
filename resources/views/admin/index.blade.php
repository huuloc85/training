@extends('admin.master')
@section('content')
    <div class="content-wrapper">
        @if (Session::has('error'))
            <div class="alert alert-danger">
                {{ Session::get('error') }}
            </div>
        @endif

        <div class="dashboard-info">
            <h2 class="mb-4">Dashboard</h2>

            <div class="row">
                <div class="col-md-3">
                    <div class="info-item bg-primary text-white p-3 rounded">
                        <h3>Tổng sản phẩm</h3>
                        <p class="font-weight-bold">{{ $totalProducts }}</p>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="info-item bg-success text-white p-3 rounded">
                        <h3>Tổng danh mục</h3>
                        <p class="font-weight-bold">{{ $totalCategories }}</p>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="info-item bg-info text-white p-3 rounded">
                        <h3>Tổng đơn hàng</h3>
                        <p class="font-weight-bold">{{ $totalOrders }}</p>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="info-item bg-warning text-white p-3 rounded">
                        <h3>Tổng khách hàng</h3>
                        <p class="font-weight-bold">{{ $totalCustomers }}</p>
                    </div>
                </div>
            </div>

            <div class="info-item mt-4">
                <h3>Tổng doanh thu</h3>
                <p><strong>{{ number_format($totalRevenue, 0, ',', '.') }} VNĐ</strong></p>
            </div>


            <div class="info-item mt-4">
                <h3>Top 10 khách hàng mua hàng nhiều nhất:</h3>
                <ul class="list-group">
                    @foreach ($topCustomers as $customer)
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            {{ $customer->name }}
                            <span class="badge badge-primary badge-pill">{{ $customer->orders_count }}</span>
                        </li>
                    @endforeach
                </ul>
            </div>
        </div>
    </div>
@endsection
