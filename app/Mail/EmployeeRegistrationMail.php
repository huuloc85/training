<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class EmployeeRegistrationMail extends Mailable
{
    public $employeeData;

    public function __construct($employeeData)
    {
        $this->employeeData = $employeeData;
    }

    public function build()
    {
        return $this->from('Admin@gmail.com')
            ->view('admin.mail.sendmail')
            ->subject('Thông tin đăng ký nhân viên mới'); // Đặt chủ đề email ở đây
    }
}
