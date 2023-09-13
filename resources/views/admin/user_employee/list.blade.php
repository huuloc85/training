@extends('admin.master')
@section('content')
    <div class="col-md-12 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title">User List</h4>
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
                <div class="table-responsive">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Username</th>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Role</th>
                                <th>Mobile</th>
                                <th>Image</th>
                                <th>Action</th>

                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($users as $user)
                                <tr>
                                    <td>{{ $user->id }}</td>
                                    <td>{{ $user->username }}</td>
                                    <td>{{ $user->name }}</td>
                                    <td>{{ $user->email }}</td>
                                    <td>
                                        @if ($user->role == 1)
                                            Admin
                                        @elseif($user->role == 2)
                                            Employee
                                        @endif
                                    </td>
                                    <td>(+84) {{ substr_replace($user->mobile, ' ', 3, 0) }}</td>

                                    <td><img src="{{ asset('storage/user/' . $user->photo) }}"
                                            style="height: 100px; width: 100px;">
                                    </td>
                                    <td>
                                        <a href="{{ route('user-edit', $user->id) }}" class="btn btn-primary">Edit</a>
                                        <a href="#" class="btn btn-danger"
                                            onclick="deleteUser({{ $user->id }})">Delete</a>
                                        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
                                        <script>
                                            function deleteUser(userId) {
                                                Swal.fire({
                                                    title: 'Confirm Deletion',
                                                    text: 'Are you sure you want to delete this user?',
                                                    icon: 'warning',
                                                    showCancelButton: true,
                                                    confirmButtonColor: '#d33',
                                                    cancelButtonColor: '#3085d6',
                                                    confirmButtonText: 'Delete',
                                                }).then((result) => {
                                                    if (result.isConfirmed) {
                                                        // Gửi yêu cầu AJAX để xóa người dùng
                                                        $.ajax({
                                                            url: "{{ route('user-delete', ':id') }}".replace(':id', userId),
                                                            method: 'DELETE',
                                                            data: {
                                                                _token: '{{ csrf_token() }}'
                                                            },

                                                            success: function(response) {
                                                                Swal.fire({
                                                                    icon: 'success',
                                                                    title: 'Success',
                                                                    text: response.message,
                                                                }).then((result) => {
                                                                    if (result.isConfirmed) {
                                                                        // Chuyển hướng hoặc thực hiện hành động sau khi xử lý thành công
                                                                        window.location.href = "{{ route('user-list') }}";
                                                                    }
                                                                });
                                                            },
                                                            error: function(xhr) {
                                                                // Xử lý lỗi và hiển thị thông báo
                                                                Swal.fire({
                                                                    icon: 'error',
                                                                    title: 'Oops...',
                                                                    text: 'Something went wrong!',
                                                                    footer: '<a href="#">Why do I have this issue?</a>'
                                                                });
                                                            }
                                                        });
                                                    }
                                                });
                                            }
                                        </script>

                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection
