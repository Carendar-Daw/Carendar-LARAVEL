<?php

namespace App\Http\Controllers;

use App\Models\Appointment;
use App\Models\Customer;
use App\Models\Services_By_Appointment;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AppointmentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return JsonResponse
     */
    public function index (Request $request)
    {
        try {
            $sal_id = $request->get('sal_id');
            // $appointment = Appointment::where('sal_id', $sal_id)->get();
            $appointment = DB::table('appointments')
                ->select('appointments.*','cus_name','services__by__appointments.*','services.ser_description',DB::raw("SUM(services.ser_time) as app_time"))
                ->join('customers','appointments.cus_id','=','customers.cus_id')
                ->leftjoin('services__by__appointments','appointments.app_id','=','services__by__appointments.app_id')
                ->leftjoin('services', 'services.ser_id','=','services__by__appointments.ser_id')
                ->where('appointments.sal_id',$sal_id)
                ->groupBy('appointments.app_id')
                ->get();
            return response()->json([
                'status' => 200,
                'message' => "Exitoso",
                'appointments' => $appointment,
            ]);
        } catch (Exception $e) {
            return response()->json([
                'status' => 500,
                'message' => "Error",
                'error' => $e->getMessage(),
            ],500);
        }

    }
    /**
     * Display a listing of the resource.
     *
     * @return JsonResponse
     */
    public function indexAppointmentByCustomer(Request $request, $cus_id)
    {
        try {
            $sal_id = $request->get('sal_id');
            $appointment = Appointment::where('cus_id',$cus_id)->where('sal_id', $sal_id)->limit(10)->get();
            return response()->json([
                'status' => 200,
                'message' => "Exitoso",
                 'appointments' => $appointment,
            ]);
        } catch (Exception $e) {
            return response()->json([
                'status' => 500,
                'message' => "Error",
                'data' => [
                    'error' => $e->getMessage(),
                ]
            ],500);
        }

    }


    /**
     * Show the form for creating a new resource.
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function create(Request $request)
    {
        try {
            DB::beginTransaction();
            $sal_id = $request->get('sal_id');
            $app_date=$request->get('app_date');
            $app_state=$request->get('app_state');
            $cus_id=$request->get('cus_id');
            $app_color=$request->get('app_color');


            $app_services = $request->get('app_services');

            $appointment = new Appointment();
            $appointment->sal_id = $sal_id;

            $services_by_appointments = new Services_By_Appointment();




            // $appointment = $appointment->create(array_merge($request->all(), ['sal_id' => $sal_id]));
            $appointment = $appointment->create([
                'app_date'=>$app_date,
                'app_state'=>$app_state,
                'cus_id'=>$cus_id,
                'sal_id' => $sal_id,
                'app_color'=>$app_color
                ]);

            foreach ($app_services as $service){
                $services_by_appointments->create([
                    'app_id' => $appointment->app_id,
                    'ser_id' => $service
                ]);
            }

            DB::commit();
            return response()->json([
                'status' => 200,
                'message' => "Exitoso",
            ]);
        } catch (Exception $e) {
            DB::rollBack();
            return response()->json([
                'status' => 500,
                'message' => "Error while creating an appointment",
                'data' => [
                    'error' => $e->getMessage(),
                ]
            ],500);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param $sal_id
     * @return JsonResponse
     */
    public function update(Request $request, $app_id)
    {
        try {
            DB::beginTransaction();

            $app_date=$request->get('app_date');
            $app_state=$request->get('app_state');
            $cus_id=$request->get('cus_id');
            $app_color=$request->get('app_color');

            $app_services = $request->get('app_services');

            $sal_id = $request->get('sal_id');
            $appointment = Appointment::where('sal_id', $sal_id)->where('app_id',$app_id)->first();
            $appointment->update([
                'sal_id' => $sal_id,
                'app_date'=>$app_date,
                'app_state'=>$app_state,
                'cus_id'=>$cus_id,
                'app_color'=>$app_color
            ]);

            // Services_By_Appointment::where('app_id',$app_id);
            $services_by_appointments = new Services_By_Appointment();

            $sba = Services_By_Appointment::where('app_id',$app_id);
            $sba->delete();

                foreach ($app_services as $service){
                    $services_by_appointments->create([
                        'app_id' => $appointment->app_id,
                        'ser_id' => $service
                    ]);
                }


            DB::commit();
            return response()->json([
                'status' => 200,
                'message' => "Exitoso",
                'appointment' => $appointment,
            ]);
        }catch (Exception $e){
            DB::rollBack();
            return response()->json([
                'status' => $app_id,
                'message' => $e->getLine(),
                'error' => $e->getMessage(),
            ],500);
        }
    }
    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param $sal_id
     * @return JsonResponse
     */
    public function delete(Request $request, $app_id)
    {
        try {
            DB::beginTransaction();
            $sal_id = $request->get('sal_id');
            $appointment = Appointment::where('sal_id', $sal_id)->where('app_id',$app_id)->first();
            $appointment->delete();
            DB::commit();
            return response()->json([
                'status' => 200,
                'message' => "Exitoso",
                'appointment' => $appointment,
            ]);
        }catch (Exception $e){
            DB::rollBack();
            return response()->json([
                'status' => 500,
                'message' => "Error",
                'error' => $e->getMessage(),
            ],500);
        }
    }
}
