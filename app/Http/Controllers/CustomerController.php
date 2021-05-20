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
    public function index(Request $request)
    {
        try {
            $sal_id = $request->get('sal_id');
            $customers = Customer::where('sal_id', $sal_id)->get();
            return response()->json([
                'status' => 200,
                'message' => "Exitoso",
                'customers' => $customers,
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
     * Display the specified resource.
     *
     * @param $cus_id
     * @return JsonResponse
     */
    public function show($cus_id)
    {
        try {
            $customer = Customer::where('cus_id',$cus_id)->first();
            return response()->json([
                'status' => 200,
                'message' => "Exitoso",
                'customers' => $customer,
            ]);
        } catch (Exception $e) {
            return response()->json([
                'status' => 500,
                'message' => "Error",
                'error' => $e->getMessage(),
            ],500);
        }
    }
//https://eu.ui-avatars.com/api/?name=Alvaro+Arcal&background=0D8ABC&color=fff
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
            $customers = Customer::where('sal_id', $sal_id)->where('cus_email', $request->cus_email)->first();
            if($customers){
            return response()->json([
                   'status' => 400,
                  'message' => "Ya existe este usuario",
            ],400);
            }
            $customer = new Customer();
            if($request->cus_photo == 'defaultAvatar.jpg'){
                $theImage = 'defaultAvatar.jpg';
            }else{
                $theImage = Customer::setImage($request->cus_photo, $request->cus_email);
            }
            if($request->cus_color_preference){
                $color = $request->cus_color_preference;
            }else{
            $color = '#8265a7';
            }


            $customer = $customer->create(array_merge($request->all(), ['sal_id' => $sal_id], ['cus_photo' => $theImage], ['cus_color_preference' => $color]));

            DB::commit();
            return response()->json([
                'status' => 200,
                'message' => "Exitoso",
                'customers' => $customer,

            ]);
        } catch (Exception $e) {
            DB::rollBack();
            return response()->json([
                'status' => 500,
                'message' => "Error while creating a customer",
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
    public function update(Request $request, $cus_id)
    {
        try {

            DB::beginTransaction();
            $sal_id = $request->get('sal_id');
            $customer = Customer::where('sal_id', $sal_id)->where('cus_id',$cus_id)->first();
            if($request->cus_photo == $customer->cus_photo){
                 $theImage = $customer->cus_photo;
            }else{
                 Customer::deleteImagen($customer->cus_photo);
                 $theImage = Customer::setImage($request->cus_photo, $request->cus_email);
            }

            $customer->update(array_merge($request->all(), ['sal_id' => $sal_id], ['cus_photo' => $theImage]));
            DB::commit();
            return response()->json([
                'status' => 200,
                'message' => "Exitoso",
                'customer' => $customer,
            ]);
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
     public function destroy(Request $request, $cus_id)
        {
            try {
                DB::beginTransaction();
                $sal_id = $request->get('sal_id');
                $customer = Customer::where('sal_id', $sal_id)->where('cus_id', $cus_id)->first();
                $customer->delete();
                DB::commit();
                return response()->json([
                    'status' => 200,
                    'message' => "Exitoso",
                    'customer' => $customer,
                ]);
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
