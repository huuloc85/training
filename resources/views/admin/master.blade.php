<!DOCTYPE html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Connect Plus</title>
    <link rel="stylesheet" href="{{ asset('admin/assets/vendors/mdi/css/materialdesignicons.min.css') }}">
    <link rel="stylesheet" href="{{ asset('admin/assets/vendors/flag-icon-css/css/flag-icon.min.css') }}">
    <link rel="stylesheet" href="{{ asset('admin/assets/vendors/css/vendor.bundle.base.css') }}">

    <!-- Plugin css for this page -->
    <link rel="stylesheet" href="{{ asset('admin/assets/vendors/font-awesome/css/font-awesome.min.css') }}">
    <link rel="stylesheet" href="{{ asset('admin/assets/vendors/bootstrap-datepicker/bootstrap-datepicker.min.css') }}">
    <!-- End plugin css for this page -->
    <!-- inject:css -->
    <!-- endinject -->
    <!-- Layout styles -->
    <link rel="stylesheet" href="{{ asset('admin/assets/css/style.css') }}">
    <!-- End layout styles -->
    <link rel="shortcut icon" href="{{ asset('admin/assets/images/favicon.png') }}" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@10">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>

</head>

<body>

    <div class="container-scroller">
        <!-- partial:partials/_navbar.html -->
        @include('admin.layout.header')
        <!-- partial -->
        <div class="container-fluid page-body-wrapper">
            <!-- partial:partials/_sidebar.html -->
            @include('admin.layout.sidebar')

            <div class="main-panel">
                @yield('content')
                @include('admin.layout.footer')
            </div>
            <!-- partial -->
            <!-- main-panel ends -->
        </div>
        <!-- page-body-wrapper ends -->
    </div>
    <!-- page-body-wrapper ends -->
    <!-- container-scroller -->
    <!-- plugins:js -->
    <script src="{{ asset('admin/assets/vendors/js/vendor.bundle.base.js') }}"></script>
    <!-- endinject -->
    <!-- Plugin js for this page -->
    <script src="{{ asset('admin/assets/vendors/chart.js/Chart.min.js') }}"></script>
    <script src="{{ asset('admin/assets/vendors/jquery-circle-progress/js/circle-progress.min.js') }}"></script>
    <script src="{{ asset('admin/assets/js/jquery.cookie.js') }}" type="text/javascript"></script>
    <!-- End plugin js for this page -->
    <!-- inject:js -->
    <script src="{{ asset('admin/assets/js/off-canvas.js') }}"></script>
    <script src="{{ asset('admin/assets/js/hoverable-collapse.js') }}"></script>
    <script src="{{ asset('admin/assets/js/misc.js') }}"></script>
    <!-- endinject -->
    <!-- Custom js for this page -->
    <script src="{{ asset('admin/assets/js/dashboard.js') }}"></script>
    <!-- End custom js for this page -->

    <!-- Bootstrap JS -->
    <!-- jQuery library -->
    <script>
        $(document).ready(function() {
            $('#updateUserForm').on('submit', function(e) {
                e.preventDefault();

                // Lấy URL và dữ liệu biểu mẫu
                const form = $(this);
                const url = form.attr('action');
                const formData = new FormData(this);

                // Gửi yêu cầu AJAX đến máy chủ
                $.ajax({
                    url: url,
                    method: 'POST',
                    data: formData,
                    processData: false,
                    contentType: false,
                    success: function(response) {
                        console.log(response);
                        // Xử lý thành công và hiển thị thông báo
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
                        // Xử lý lỗi
                        Swal.fire({
                            icon: 'error',
                            title: 'Oops...',
                            text: 'Something went wrong!',
                            footer: '<a href="#">Why do I have this issue?</a>'
                        });
                    }
                });
            });
        });
    </script>
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
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const categoryForm = document.getElementById('categoryForm');

            categoryForm.addEventListener('submit', function(e) {
                e.preventDefault();

                Swal.fire({
                    title: 'Confirm Submission',
                    text: 'Are you sure you want to add this category?',
                    icon: 'question',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes',
                    cancelButtonText: 'No',
                }).then((result) => {
                    if (result.isConfirmed) {
                        // Submit the form using AJAX
                        $.ajax({
                            url: categoryForm.getAttribute('action'),
                            method: 'POST',
                            data: new FormData(categoryForm),
                            processData: false,
                            contentType: false,
                            success: function(response) {
                                Swal.fire({
                                    icon: 'success',
                                    title: 'Success',
                                    text: response.message,
                                }).then((result) => {
                                    if (result.isConfirmed) {
                                        // Redirect or perform an action after successful submission
                                        window.location.href =
                                            "{{ route('category-list') }}";
                                    }
                                });
                            },
                            error: function(xhr) {
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Oops...',
                                    text: 'Something went wrong!',
                                    footer: '<a href="#">Why do I have this issue?</a>',
                                });
                            },
                        });
                    }
                });
            });
        });
    </script>




</body>

</html>
