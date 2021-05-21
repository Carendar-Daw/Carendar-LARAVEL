<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Http\Controllers\AppointmentController;
use Illuminate\Support\Facades\Storage;
use App\Models\Appointment;
use App\Models\Customer;
use Illuminate\Support\Facades\DB;

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
        parent::construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
            $today = date('Y-m-d');
            $today .= " 00:00:00";
            $tomorrow = strtotime ( '+1 day' , strtotime ( $today ) ) ;
            $tomorrow = date ( 'Y-m-j' , $tomorrow); 
            $tomorrow .= " 00:00:00";
            $appointments = DB::table("appointments")->where('app_date','>', $today);
            //$arrayCustomers = null;
            Storage::disk('local')->append('archivo.txt', $appointments);
            Storage::disk('local')->append('variables.txt', [$today, $tomorrow]);
            foreach ($appointments as $a) {
                //$arrayCustomers= Customer::where('cus_id',$a->cus_id);
                
                }    
                
 
        }
        }
    
                
        
    
        
    
    

