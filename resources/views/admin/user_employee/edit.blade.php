@extends('admin.master')
@section('content')
    <div class="col-md-12 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title">Admin Manager</h4>
                <p class="card-description">Edit Employee</p>
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
                <form action="{{ route('user-update', $user->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="form-group">
                        <label for="exampleInputUsername">Username</label>
                        <input type="text" class="form-control" id="exampleInputUsername" placeholder="Username"
                            name="username" value="{{ $user->username }}">
                    </div>
                    <div class="form-group">
                        <label for="exampleInputName">Name</label>
                        <input type="text" class="form-control" id="exampleInputName" placeholder="Name" name="name"
                            value="{{ $user->name }}">
                    </div>
                    <div class="form-group">
                        <label for="image">Upload Image Employee:</label>
                        <input type="hidden" value="{{ $user->photo }}" id="old_image" name="old_image"><br>
                        <img src="{{ asset('storage/user/' . $user->photo) }}" style="height: 100px; width: 100px;">
                        <input type="file" class="form-control" id="new_image" name="new_image">
                    </div>

                    <div class="form-group">
                        <label for="exampleInputEmail">Email</label>
                        <input type="email" class="form-control" id="exampleInputEmail" placeholder="Email" name="email"
                            value="{{ $user->email }}">
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
                            name="mobile" value="{{ $user->mobile }}">
                    </div>
                    <button type="submit" class="btn btn-primary">Update</button>
                    <button class="btn btn-light">Cancel</button>
                </form>
            </div>
        </div>
    </div>
@endsection
