<?php

namespace App\Http\Controllers;

use App\Models\Saloon;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;

class SaloonController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return JsonResponse
     */
    public function index(): JsonResponse
    {
        $saloons = Saloon::all();
        return response()->json([
            'status' => 200,
            'message' => "Exitoso",
            'data' => [
                'saloons' => $saloons,
            ]
        ]);
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
            $saloon = new Saloon;
            $saloon = $saloon->create($request->all());

           /*
            $saloon->sal_name = $request->sal_name;
            $saloon->sal_location = $request->sal_location;
            $saloon->sal_email = $request->sal_email;
            $saloon->sal_phone = $request->sal_phone;
            $saloon->sal_appointment_delay = $request->sal_appointment_delay;
            $saloon->save();
           */

            DB::commit();
            return response()->json([
                'status' => 200,
                'message' => "Exitoso",
                'data' => [
                    'saloons' => $saloon,
                ]
            ]);
        } catch (Exception $e) {
            DB::rollBack();
            return response()->json([
                'status' => 500,
                'message' => "Error at creating saloon",
                'data' => [
                    'error' => $e->getMessage()
                ]
            ]);
        }

    }


    /**
     * Display the specified resource.
     *
     * @param $sal_id
     * @return JsonResponse
     */
    public function show($sal_id)
    {
        try {
            $saloon = Saloon::find($sal_id);

            return ($saloon !== null) ?
                response()->json([
                    'status' => 200,
                    'message' => "Exitoso",
                    'data' => [
                        'saloon' => $saloon,
                    ]
                ])
                :
                response()->json([
                    'status' => 500,
                    'message' => "No se encontró un salón con id: " . $sal_id,
                    'data' => []
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
            $saloon = Saloon::find($sal_id);
            $saloon->update($request->all());
            DB::commit();
            return response()->json([
                'status' => 200,
                'message' => "Exitoso",
                'data' => [
                    'saloon' => $saloon,
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
