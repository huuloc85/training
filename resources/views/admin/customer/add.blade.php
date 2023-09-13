@extends('admin.master')
@section('content')
    <div class="content-wrapper">
        <div class="row">
            <div class="col-md-12 grid-margin stretch-card">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title">Add New Customer</h4>
                        <form class="forms-sample" action="{{ route('customer-save') }}" method="post">
                            @csrf
                            <div class="form-group">
                                <label for="name">Name</label>
                                <input type="text" class="form-control @error('name') is-invalid @enderror"
                                    id="name" name="name" placeholder="Name" required>
                                @error('name')
                                    <div class="text text-danger">{{ $message }}</div>
                                @enderror
                                <br>
                            </div>
                            <div class="form-group">
                                <label for="mobile">Mobile</label>
                                <input type="text" class="form-control @error('mobile') is-invalid @enderror"
                                    id="mobile" name="mobile" placeholder="Mobile" required>
                                @error('mobile')
                                    <div class="text text-danger">{{ $message }}</div>
                                @enderror
                                <br>
                            </div>
                            <div class="form-group">
                                <label for="email">Email</label>
                                <input type="email" class="form-control @error('email') is-invalid @enderror"
                                    id="email" name="email" placeholder="Email" required>
                                @error('email')
                                    <div class="text text-danger">{{ $message }}</div>
                                @enderror
                                <br>
                            </div>
                            <div class="form-group">
                                <label for="email">Address</label>
                                <input type="text" class="form-control @error('address') is-invalid @enderror"
                                    id="address" name="address" placeholder="address" required>
                                @error('address')
                                    <div class="text text-danger">{{ $message }}</div>
                                @enderror
                                <br>
                            </div>
                            <div class="form-group">
                                <label for="name">Password</label>
                                <input type="password" class="form-control @error('password') is-invalid @enderror"
                                    id="password" name="password" placeholder="Password" required>
                                @error('password')
                                    <div class="text text-danger">{{ $message }}</div>
                                @enderror
                                <br>
                            </div>
                            <!-- Add other fields here as needed -->
                            <button type="submit" class="btn btn-primary mr-2">Add Customer</button>
                            <a href="{{ route('customer-list') }}" class="btn btn-light">Back</a>
                        </form>c
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
