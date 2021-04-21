<?php

namespace App\Http\Controllers;


use Exception;
use App\Models\Services;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;

class ServicesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(): JsonResponse
    {
        $services = Services::all();
        return response()->json([
            'status' => 200,
            'message' => "Exitoso",
            'data' => [
                'services' => $services,
            ]
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        try {
            DB::beginTransaction();
           
   
                $services = new Services;
                $services = $services->create($request->all());
          
           
            DB::commit();
            return response()->json([
                'status' => 200,
                'message' => "Exitoso",
                'data' => [
                    'services' => $services,
                ]
            ]);
        } catch (Exception $e) {
            DB::rollBack();
            return response()->json([
                'status' => 500,
                'message' => "Error at creating services",
                'data' => [
                    'error' => $e->getMessage()
                ]
            ]);
        }

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Services  $services
     * @return \Illuminate\Http\Response
     */
    public function show($ser_id)
    {
       //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Services  $services
     * @return \Illuminate\Http\Response
     */
    public function edit(Services $services)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Services  $services
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $ser_id)
    {
        try {
            DB::beginTransaction();
            $services = Services::find($ser_id);
            $services->update($request->all());
            DB::commit();
            return response()->json([
                'status' => 200,
                'message' => "Exitoso",
                'data' => [
                    'services' => $services,
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
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Services  $services
     * @return \Illuminate\Http\Response
     */
    public function destroy($ser_id)
    {
       try {
            DB::beginTransaction();
            $services = Services::find($ser_id);
            $services->delete();
            DB::commit();
            return response()->json([
                'status' => 200,
                'message' => "Exitoso service delete",

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
