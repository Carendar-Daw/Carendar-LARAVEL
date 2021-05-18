<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Http\Controllers\AppointmentController;


class AppointmentMail extends Command
{
    /
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'Mail:Appointment';

    /
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Sends an email when you have an appointment that day';

    /
     * Create a new command instance.
     *
     * @return void
     */
    public function construct()
    {
        parent::construct();
    }

    /
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $customers = getCustomerByAppointmentsByDate();
        foreach ($customers as $c) {
            Mail::raw("{$key} -> {$value}", function ($mail) use ($user) {
                $mail->from('carendar.daw@gmail.com');
                $mail->to($user->email)
                    ->subject('Word of the Day');
            });
        }

        $this->info('Word of the Day sent to All Users');
    }
    }
}