<p>Xin chào {{ $employeeData['name'] }},</p>
<p>Bạn đã được đăng ký làm nhân viên mới.</p>
<p>Dưới đây là email của bạn:</p>
<p>{{ $employeeData['email'] }}</p>
<p>Dưới đây là mật khẩu của bạn:</p>
<p>{{ $employeeData['password'] }}</p>
<p>Vui lòng thay đổi mật khẩu của bạn để tăng tính bảo mật hơn</p>
<a href="{{ route('show-change-password') }}">Nhấn vào đây để đổi mật khẩu</a>
