<?php

namespace App\Mail;

use App\Models\Customer;
use App\Models\Saloon;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class WelcomeMailable extends Mailable
{
    use Queueable, SerializesModels;

    public $subject = 'Welcome to Carendar';
    public $customer; 
    public $saloon;
    public $today;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(Customer $cus, Saloon $sal)
    {
        $this->customer = $cus;
        $this->saloon = $sal;
        $this->today = date('d-m-Y');
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('emails.welcome');
    }
}
