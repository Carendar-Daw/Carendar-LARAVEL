<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Exception;
use Illuminate\Support\Facades\DB;

class CustomerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return JsonResponse
     */
    public function index()
    {
        try {
            $customers = Customer::all();
            return response()->json([
                'status' => 200,
                'message' => "Exitoso",
                'data' => [
                    'customers' => $customers,
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
     * @param $cus_id
     * @return JsonResponse
     */
    public function show($cus_id)
    {
        try {
            $customer = Customer::find($cus_id);
            return response()->json([
                'status' => 200,
                'message' => "Exitoso",
                'data' => [
                    'saloon' => $customer,
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
            $customer = new Customer();
            $customer = $customer->create($request->all());
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
                    'saloon' => $customer,
                ]
            ]);
        } catch (Exception $e) {
            DB::rollBack();
            return response()->json([
                'status' => 500,
                'message' => "Error while creating a customer",
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
    public function update(Request $request, $sal_id)
    {
        try {
            DB::beginTransaction();
            $customer = Customer::find($sal_id);
            $customer->update($request->all());
            DB::commit();
            return response()->json([
                'status' => 200,
                'message' => "Exitoso",
                'data' => [
                    'customer' => $customer,
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
