@extends('admin.master')
@section('content')
    <div class="col-md-12 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title">Admin Manager</h4>
                <p class="card-description">Add Employee</p>
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
                <form action="{{ route('user-save') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="form-group">
                        <label for="exampleInputUsername">Username</label>
                        <input type="text" class="form-control" id="exampleInputUsername" placeholder="Username"
                            name="username">
                    </div>
                    <div class="form-group">
                        <label for="exampleInputName">Name</label>
                        <input type="text" class="form-control" id="exampleInputName" placeholder="Name" name="name">
                    </div>
                    <div class="form-group">
                        <label for="image">Upload Image Employee</label>
                        <input type="file" class="form-control" id="image" name="image" required>
                    </div>
                    <div class="form-group">
                        <label for="exampleInputEmail">Email</label>
                        <input type="email" class="form-control" id="exampleInputEmail" placeholder="Email"
                            name="email">
                    </div>
                    <div class="form-group">
                        <label for="exampleInputRole">Role</label>
                        <select class="form-control" id="exampleInputRole" name="role">
                            <option value="1">Admin</option>
                            <option value="2" selected>Employee</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="exampleInputMobile">Mobile</label>
                        <input type="text" class="form-control" id="exampleInputMobile" placeholder="Mobile"
                            name="mobile">
                    </div>
                    <div class="form-group">
                        <label for="exampleInputPassword2">Password</label>
                        <input type="password" class="form-control" id="exampleInputPassword2" placeholder="Password"
                            name="password">
                    </div>
                    <div class="form-group">
                        <label for="exampleInputPassword2">Re Password</label>
                        <input type="password" class="form-control" id="exampleInputRePassword2" placeholder="Re Password"
                            name="repassword">
                    </div>
                    <div class="form-check form-check-flat form-check-primary">
                        <label class="form-check-label">
                            <input type="checkbox" class="form-check-input"> Remember me
                        </label>
                    </div>
                    <button type="submit" class="btn btn-primary">Submit</button>
                    <button class="btn btn-light">Cancel</button>
                </form>
            </div>
        </div>
    </div>
@endsection
