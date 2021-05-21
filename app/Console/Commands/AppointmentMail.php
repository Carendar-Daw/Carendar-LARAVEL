<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Http\Controllers\AppointmentController;
use Illuminate\Support\Facades\Storage;
use App\Models\Appointment;
use App\Models\Customer;


class AppointmentMail extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'Mail:Appointment';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Sends an email when you have an appointment that day';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function construct()
    {
        //parent::construct();
    }

    /**
     * Execute the console command.
     *
     * @return void
     */
    public function handle()
    {
        $today = date('Y-m-d');
        $tomorrow = strtotime('+1 day', strtotime($today));
        $tomorrow = date('Y-m-j', $tomorrow);
        $appointments = Appointment::whereBetween('app_date', [$today, $tomorrow])->get();
        $arrayCustomers = null;
        foreach ($appointments as $a) {
            $arrayCustomers[] = Customer::where('cus_id', $a->cus_id)->get();
        }
        $arrayMails = null;
        foreach ($arrayCustomers as $a) {
            //$arrayMails[] = $a->cus_email;
           Storage::disk('local')->append('archivo.txt', $a->cus_email);
        }
        
        AppointmentController::sendAppointmentEmail($arrayMails);
    }

    
    }

