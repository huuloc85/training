<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;
use App\Mail\EmployeeRegistrationMail;

class SendEmployeeRegistrationEmail implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $employeeData;

    public function __construct($employeeData)
    {
        $this->employeeData = $employeeData;
    }

    public function handle()
    {
        Mail::to($this->employeeData['email'])->send(new EmployeeRegistrationMail($this->employeeData));
    }
}
