@extends('admin.master')
@section('content')
    <div class="col-md-12 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title text-center">Change Information Employee</h4>
                @if (Session::has('error'))
                    <div class="alert alert-danger" role="alert">
                        {{ Session::get('error') }}
                    </div>
                @endif
                @if (Session::has('success'))
                    <div class="alert alert-success" role="alert">
                        {{ Session::get('success') }}
                    </div>
                @endif
                <form action="{{ route('updateInfor') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="form-group">
                        <label for="exampleInputUsername">Username</label>
                        <input type="text" class="form-control" id="exampleInputUsername" placeholder="Username"
                            name="username" value="{{ old('username', $user->username) }}">
                        @error('username')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="exampleInputName">Name</label>
                        <input type="text" class="form-control" id="exampleInputName" placeholder="Name" name="name"
                            value="{{ $user->name }}">
                        @error('name')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="image">Upload Image Employee:</label>
                        <input type="hidden" value="{{ $user->photo }}" id="old_image" name="old_image"><br>
                        <img src="{{ asset('storage/user/' . $user->photo) }}" style="height: 100px; width: 100px;">
                        <input type="file" class="form-control" id="new_image" name="new_image">
                        @error('new_image')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="exampleInputEmail">Email</label>
                        <input type="email" class="form-control" id="exampleInputEmail" placeholder="Email" name="email"
                            value="{{ old('email', $user->email) }}">
                        @error('email')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="exampleInputRole">Role</label>
                        <select class="form-control" id="exampleInputRole" name="role"
                            {{ Auth::user()->role == 2 ? 'disabled' : '' }}>
                            <option value="1" {{ Auth::user()->role == 1 ? 'selected' : '' }}>Admin</option>
                            <option value="2" {{ Auth::user()->role == 2 ? 'selected' : '' }}>Employee</option>
                        </select>
                        @error('role')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="exampleInputMobile">Mobile</label>
                        <input type="text" class="form-control" id="exampleInputMobile" placeholder="Mobile"
                            name="mobile" value="{{ $user->mobile }}">
                        @error('mobile')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>

                    <button type="submit" class="btn btn-primary btn-block">Change</button>
                    <a href="{{ route('admin.index') }}" class="btn btn-light btn-block">Cancel</a>
                </form>
            </div>
        </div>
    </div>
@endsection
