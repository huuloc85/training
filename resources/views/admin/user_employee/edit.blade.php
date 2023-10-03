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
                <form id="updateUserForm" action="{{ route('user-update', $user->id) }}" method="POST"
                    enctype="multipart/form-data">
                    @csrf
                    <div class="form-group">
                        <label for="exampleInputUsername">Username</label>
                        <input type="text" class="form-control @error('username') is-invalid @enderror"
                            id="exampleInputUsername" placeholder="Username" name="username" value="{{ $user->username }}">
                        @error('username')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="exampleInputName">Name</label>
                        <input type="text" class="form-control @error('name') is-invalid @enderror" id="exampleInputName"
                            placeholder="Name" name="name" value="{{ $user->name }}">
                        @error('name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="image">Upload Image Employee:</label>
                        <input type="hidden" value="{{ $user->photo }}" id="old_image" name="old_image"><br>
                        <img src="{{ asset('storage/user/' . $user->photo) }}" style="height: 100px; width: 100px;">
                        <input type="file" class="form-control @error('new_image') is-invalid @enderror" id="new_image"
                            name="new_image">
                        @error('new_image')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="exampleInputEmail">Email</label>
                        <input type="email" class="form-control @error('email') is-invalid @enderror"
                            id="exampleInputEmail" placeholder="Email" name="email" value="{{ $user->email }}">
                        @error('email')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="exampleInputRole">Role</label>
                        <select class="form-control" id="exampleInputRole" name="role" readonly>
                            <option value="1" @if ($user->role === 1) selected @endif>Admin</option>
                            <option value="2" @if ($user->role === 2) selected @endif>Employee</option>
                        </select>
                    </div>
                    <script>
                        document.getElementById('exampleInputRole').onchange = function() {
                            this.value = '{{ $user->role }}';
                        };
                    </script>
                    <div class="form-group">
                        <label for="exampleInputMobile">Mobile</label>
                        <input type="text" class="form-control @error('mobile') is-invalid @enderror"
                            id="exampleInputMobile" placeholder="Mobile" name="mobile" value="{{ $user->mobile }}">
                        @error('mobile')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <button type="submit" class="btn btn-primary">Update</button>
                    <a href="{{ route('user-list') }}" class="btn btn-light">Cancel</a>
                </form>
            </div>
        </div>
    </div>
@endsection
