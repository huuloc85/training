@extends('admin.master')
@section('content')
    <!-- partial -->
    <div class="content-wrapper">
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <h3 class="card-title">User List</h3>
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
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Name</th>
                                        <th>Email </th>
                                        <th>Photo</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($users as $key => $user)
                                        <tr>
                                            <td>{{ $key + 1 }}</td>
                                            <td>{{ $user->name }}</td>
                                            <td>{{ $user->email }}</td>
                                            <td><img src="{{ asset('storage/images/' . $user->photo) }}"
                                                    style="height: 100px; width: 100px;">
                                            </td>
                                            <td>
                                                <a href="{{ route('user-edit', $user->id) }}"
                                                    class="btn btn-primary">Edit</a>
                                                <a href="#" class="btn btn-danger" data-toggle="modal"
                                                    data-target="#deleteModal{{ $user->id }}">Delete</a>
                                                <!-- Modal -->
                                                <div class="modal fade" id="deleteModal{{ $user->id }}" tabindex="-1"
                                                    role="dialog" aria-labelledby="deleteModalLabel{{ $user->id }}"
                                                    aria-hidden="true">
                                                    <div class="modal-dialog" role="document">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h5 class="modal-title"
                                                                    id="deleteModalLabel{{ $user->id }}">
                                                                    Confirm Deletion</h5>
                                                                <button type="button" class="close" data-dismiss="modal"
                                                                    aria-label="Close">
                                                                    <span aria-hidden="true">&times;</span>
                                                                </button>
                                                            </div>
                                                            <div class="modal-body">
                                                                <p>Are you sure you want to delete this user?
                                                                </p>
                                                            </div>
                                                            <div class="modal-footer">
                                                                <button type="button" class="btn btn-secondary"
                                                                    data-dismiss="modal">Cancel</button>
                                                                <form action="{{ route('user-delete', $user->id) }}"
                                                                    method="POST">
                                                                    @method('DELETE')
                                                                    @csrf
                                                                    <button type="submit"
                                                                        class="btn btn-danger">Delete</button>
                                                                </form>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
                                                <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
                                                <script>
                                                    $(document).ready(function() {});
                                                </script>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                            <div class="pagination-wrapper">
                                {{ $users->appends(request()->all())->links() }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
