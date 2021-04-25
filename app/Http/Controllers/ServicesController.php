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
    public function index(Request $request): JsonResponse
    {

        $sal_id = $request->get('sal_id');
        $services = Services::where('sal_id', $sal_id)->get();
        return response()->json([
            'status' => 200,
            'message' => "Exitoso",
            'services' => $services,

        ]);
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
                $services = new Services;
                $services->sal_id = $sal_id;
                $services = $services->create(array_merge($request->all(), ['sal_id' => $sal_id]));

           
            DB::commit();
            return response()->json([
                'status' => 200,
                'message' => "Exitoso",
                'services' => $services,

            ]);
        } catch (Exception $e) {
            DB::rollBack();
            return response()->json([
                'status' => 500,
                'message' => "Error at creating services",
                'error' => $e->getMessage()

            ]);
        }

    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param $ser_id
     * @return JsonResponse
     */
    public function update(Request $request, $ser_id)
    {
        try {
            DB::beginTransaction();
            $sal_id = $request->get('sal_id');

            $services = Services::find($ser_id)->where('sal_id', $sal_id)->get();
            var_dump($services);
            exit;
            $services->update($request->all());
            DB::commit();
            return response()->json([
                'status' => 200,
                'message' => "Exitoso",
                'services' => $services,

            ]);
        }catch (Exception $e){
            DB::rollBack();
            return response()->json([
                'status' => 500,
                'message' => "Error",
                'error' => $e->getMessage(),

            ]);
        }


    }

    /**
     * Display a listing of the resource.
     *
     * @return JsonResponse
     */
    public function indexService($sto_id)
    {
        try {
            $services = Services::all()->where('$sto_id',$sto_id);
            return response()->json([
                'status' => 200,
                'message' => "Exitoso",
                'service' => $services,
   
            ]);
        } catch (Exception $e) {
            return response()->json([
                'status' => 500,
                'message' => "Error",
                'error' => $e->getMessage(),
            
            ]);
        }

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param $ser_id
     * @return JsonResponse
     */
    public function destroy(Request $request, $ser_id)
    {
       try {
            DB::beginTransaction();
             $sal_id = $request->get('sal_id');

            if(Services::find($ser_id)->where('sal_id', $sal_id)->exists()){
                $services = Services::find($ser_id)->where('sal_id', $sal_id);
                $services->delete();
            }else{
                return response()->json([
                      'status' => 400,
                      'message' => "No tienes este servicio",
                      ]);
            }

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
                'error' => $e->getMessage(),
            ]);
        }
    }
}
