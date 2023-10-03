<?php

namespace App\Mail;

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class OrderApproved extends Mailable
{
    use Queueable, SerializesModels;

    public $order;

    public function __construct($order)
    {
        $this->order = $order;
    }

    public function build()
    {
        return $this->from('Admin@gmail.com')
            ->subject('Đơn hàng #' . $this->order->id . ' đã được duyệt')
            ->view('admin.mail.email-order'); // Tạo tệp view tương ứng
    }
}
