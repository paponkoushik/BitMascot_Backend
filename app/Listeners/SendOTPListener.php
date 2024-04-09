<?php

namespace App\Listeners;

use App\Events\SendOTPEvent;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Mail;

class SendOTPListener
{
    use InteractsWithQueue;
    public function __construct()
    {
        //
    }

    public function handle(SendOTPEvent $event): void
    {
        $user = $event->user;
        $otp = $event->otp;

        Mail::to($user->email)->send(new OTPMail($otp));
    }
}
