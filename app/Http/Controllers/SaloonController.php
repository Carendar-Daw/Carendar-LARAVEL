<?php

namespace App\Http\Controllers;

use App\Mail\WelcomeMailable;
use App\Models\Services_By_Appointment;
use App\Models\Cash_Register;
use App\Models\Stock;
use App\Models\Customer;
use App\Models\Saloon;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;

class SaloonController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return JsonResponse
     */
    public function index($id_auth): JsonResponse
    {
        $saloons = Saloon::where('auth0_id', $id_auth)->first();
        return response()->json([
            'status' => 200,
            'message' => "Exitoso",
            'saloons' => $saloons,
        ]);
    }

    public function checkIfSaloonExistsAuth($id_auth, $request)
        {
            if(Saloon::where('auth0_id', $id_auth)->exists()){
              $saloons = Saloon::where('auth0_id', $id_auth)->first();
              return $saloons;
            }else if(Saloon::where('sal_email', $request->sal_email)->exists()){
             $saloons = Saloon::where('sal_email', $request->sal_email)->first();
             $saloons->auth0_id = $id_auth;
             $saloons->save();
             return $saloons;
            }else{
               $saloon = new Saloon;
               $saloon = $saloon->create($request->all());
               return $saloon;
            }
        }

    /**
     * Show the form for creating a new resource.
     *
     * @return JsonResponse
     */
    public function create(Request $request)
    {
        try {
            DB::beginTransaction();
            $sal_id = $request->get('sal_id');
           if (Saloon::where('sal_id', $sal_id)->exists()) {
            $saloons = Saloon::where('sal_id', $sal_id)->first();
            return response()->json([
                'status' => 400,
                'message' => "Ya hay un saloon con estas credenciales",
                'saloon' => $saloons,
            ]);
           }else{
                $saloon = new Saloon;
                $saloon = $saloon->create($request->all());
           }
            DB::commit();
            return response()->json([
                'status' => 200,
                'message' => "Exitoso",
                 'saloons' => $saloon,
            ]);
        } catch (Exception $e) {
            DB::rollBack();
            return response()->json([
                'status' => 500,
                'message' => "Error at creating saloon",
                'data' => [
                    'error' => $e->getMessage()
                ]
            ],500);
        }

    }
    /*public function sendWelcomeEmail()
    {
        $mail = new WelcomeMailable;
        Mail::to('alvaroarpal@gmail.com')->send($mail);
    }*/

    /**
     * Display the specified resource.
     *
     * @param $sal_id
     * @return JsonResponse
     */
    public function show(Request $request)
    {
        try {

            $sal_id = $request->get('sal_id');
             $saloon = Saloon::find($sal_id);
            return ($saloon !== null) ?
                response()->json([
                    'status' => 200,
                    'message' => "Exitoso",
                    'saloon' => $saloon,
                ])
                :
                response()->json([
                    'status' => 500,
                    'message' => "No se encontró un salón con id: " . $sal_id,
                    'data' => []
                ],500);

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
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param $sal_id
     * @return JsonResponse
     */
    public function update(Request $request)
    {
        try {
            DB::beginTransaction();
            $sal_id = $request->get('sal_id');
            if($saloon = Saloon::where('sal_id', $sal_id)->first()){
            $saloon->update($request->all());
             DB::commit();
             return response()->json([
              'status' => 200,
              'message' => "Exitoso",
              'data' => [
              'saloon' => $saloon,
                ]
              ]);
            }

        }catch (Exception $e){
            DB::rollBack();
            return response()->json([
                'status' => 500,
                'message' => "Error",
                'data' => [
                    'error' => $e->getMessage(),
                ]
            ],500);
        }
    }

      public function statistics(Request $request) {


        try {
            DB::beginTransaction();
            $sal_id = $request->get('sal_id');
            $servicesByAppointment = Services_By_Appointment::select('services.ser_id', 'services.ser_description', DB::raw('COUNT(services__by__appointments.ser_id) as numTotal'))
                                                              ->join('services', 'services.ser_id', '=', 'services__by__appointments.ser_id')
                                                              ->where('services.sal_id', '=', $sal_id)
                                                              ->groupBy('services.ser_id')
                                                              ->whereBetween('services__by__appointments.created_at', [$request->minTime, $request->maxTime])
                                                              ->orderBy('numTotal', 'desc')
                                                              ->limit(5)
                                                              ->get();

            $customer = Customer::select(DB::raw('COUNT(customers.cus_id) as numTotal'))
                                                                        ->where('customers.sal_id', '=', $sal_id)
                                                                        ->whereBetween('customers.created_at', [$request->minTime, $request->maxTime])
                                                                        ->first();
            $products = Stock::select(DB::raw('SUM(stocks.sto_pvp) as Total'))
                                                                        ->where('stocks.sal_id', '=', $sal_id)
                                                                        ->whereBetween('stocks.created_at', [$request->minTime, $request->maxTime])
                                                                        ->first();

            $earningsByMonth = Cash_Register::select(DB::raw('SUM(cas_current) as earning, MonthName(created_at) as month'))
                                                                          ->where('cash__registers.sal_id', '=', $sal_id)
                                                                          ->groupBy(DB::raw("MONTH(created_at)"))
                                                                          ->get();

             DB::commit();
             return [
                    'status' => 200,
                    'message' => $request->body,
                    'servicesPie' => $servicesByAppointment,
                    'customer' => $customer,
                    'products' => $products,
                    'earningsByMonth' => $earningsByMonth
             ];
        }catch (Exception $e){
            DB::rollBack();
            return response()->json([
                'status' => 500,
                'message' => "Error",
                'data' => [
                    'error' => $e->getMessage(),
                ]
        ],500);
      }
    }


}
