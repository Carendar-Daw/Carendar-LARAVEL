<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class CustomerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return JsonResponse
     */
    public function index()
    {
        $customers= Customer::all();
        return response()->json([
            'status' => 200,
            'message' => "Exitoso",
            'data' => [
                'customers' => $customers,
            ]
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param $cus_id
     * @return JsonResponse
     */
    public function show($cus_id)
    {
        $customer= Customer::find($cus_id);
        return response()->json([
            'status' => 200,
            'message' => "Exitoso",
            'data' => [
                'saloon' => $customer,
            ]
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @param Request $request
     * @return Customer
     */
    public function create(Request $request)
    {
        $customer = new Customer();
        $customer->cus_email = $request->cus_email;
        $customer->cus_color_preference = $request->cus_color_preference;
        $customer->cus_name = $request->cus_name;
        $customer->cus_born_date = $request->cus_born_date;
        $customer->cus_phone  = $request->cus_phone;
        $customer->save();

        return $customer;
    }
}
