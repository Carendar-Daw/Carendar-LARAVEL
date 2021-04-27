<?php

namespace App\Http\Controllers;

use App\Models\Appointment;
use App\Models\Customer;
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
    public function indexSaloon($sal_id)
    {
        try {
            $appointment = Appointment::all()->where('sal_id',$sal_id);
            $customer = Customer::all();
            return response()->json([
                'status' => 200,
                'message' => "Exitoso",
                'data' => [
                    'appointments' => $appointment,
                    'customers' => $customer
                ]
            ]);
        } catch (Exception $e) {
            return response()->json([
                'status' => 500,
                'message' => "Error",
                'data' => [
                    'error' => $e->getMessage(),
                ]
            ]);
        }

    }
    /**
     * Display a listing of the resource.
     *
     * @return JsonResponse
     */
    public function indexCustomer($cus_id)
    {
        try {
            $appointment = Appointment::all()->where('cus_id',$cus_id);
            return response()->json([
                'status' => 200,
                'message' => "Exitoso",
                'data' => [
                    'appointments' => $appointment,
                ]
            ]);
        } catch (Exception $e) {
            return response()->json([
                'status' => 500,
                'message' => "Error",
                'data' => [
                    'error' => $e->getMessage(),
                ]
            ]);
        }

    }

    /**
     * Display the specified resource.
     *
     * @param $app_id
     * @return JsonResponse
     */
    public function show($app_id)
    {
        try {
            $appointment = Appointment::find($app_id);
            return response()->json([
                'status' => 200,
                'message' => "Exitoso",
                'data' => [
                    'appointment' => $appointment,
                ]
            ]);
        } catch (Exception $e) {
            return response()->json([
                'status' => 500,
                'message' => "Error",
                'data' => [
                    'error' => $e->getMessage(),
                ]
            ]);
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
            $appointment = new Appointment();
            $appointment = $appointment->create($request->all());
            /*
            $customer->cus_email = $request->cus_email;
            $customer->cus_color_preference = $request->cus_color_preference;
            $customer->cus_name = $request->cus_name;
            $customer->cus_born_date = $request->cus_born_date;
            $customer->cus_phone = $request->cus_phone;
            $customer->save();
            */
            DB::commit();
            return response()->json([
                'status' => 200,
                'message' => "Exitoso",
                'data' => [
                    'saloon' => $appointment,
                ]
            ]);
        } catch (Exception $e) {
            DB::rollBack();
            return response()->json([
                'status' => 500,
                'message' => "Error while creating an appointment",
                'data' => [
                    'error' => $e->getMessage(),
                ]
            ]);
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
            $appointment = Appointment::find($app_id);
            $appointment->update($request->all());
            DB::commit();
            return response()->json([
                'status' => 200,
                'message' => "Exitoso",
                'data' => [
                    'appointment' => $appointment,
                ]
            ]);
        }catch (Exception $e){
            DB::rollBack();
            return response()->json([
                'status' => 500,
                'message' => "Error",
                'data' => [
                    'error' => $e->getMessage(),
                ]
            ]);
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
            $appointment = Appointment::find($app_id);
            $appointment->delete();
            DB::commit();
            return response()->json([
                'status' => 200,
                'message' => "Exitoso",
                'data' => [
                    'appointment' => $appointment,
                ]
            ]);
        }catch (Exception $e){
            DB::rollBack();
            return response()->json([
                'status' => 500,
                'message' => "Error",
                'data' => [
                    'error' => $e->getMessage(),
                ]
            ]);
        }
    }
}
