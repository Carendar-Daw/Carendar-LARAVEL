<?php

namespace App\Http\Controllers;

use App\Models\Stock;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class StockController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return JsonResponse
     */
    public function index(Request $request): JsonResponse
    {

        $sal_id = $request->get('sal_id');
        $stock = Stock::where('sal_id', $sal_id)->get();
         return response()->json([
            'status' => 200,
            'message' => "Exitoso",
            'stock' => $stock,
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
                $stock = new Stock;
                $stock->sal_id = $sal_id;
                $stock = $stock->create(array_merge($request->all(), ['sal_id' => $sal_id]));


            DB::commit();
            return response()->json([
                'status' => 200,
                'message' => "Exitoso",
                'stock' => $stock,
            ]);
        } catch (Exception $e) {
            DB::rollBack();
            return response()->json([
                'status' => 500,
                'message' => "Error at creating stock",
                'error' => $e->getMessage()
            ],500);
        }

    }



    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  $sto_id
     * @return JsonResponse
     */
    public function update(Request $request, $sto_id)
    {
        try {
            DB::beginTransaction();
            $sal_id = $request->get('sal_id');
            if(Stock::where('sal_id', $sal_id)->where('sto_id', $sto_id)->exists()){
             $stock = Stock::where('sal_id', $sal_id)->where('sto_id', $sto_id)->first();
             $stock->update($request->all());
             DB::commit();
                 return response()->json([
                        'status' => 200,
                        'message' => "Exitoso",
                        'stock' => $stock,
                 ]);
            }else{
                 return response()->json([
                        'status' => 400,
                        'message' => "Error, no se encuentra el producto",
                 ],400);
            }

        }catch (Exception $e){
            DB::rollBack();
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
    public function indexStock($sto_id)
    {
        try {
            $stock = Stock::all()->where('$sto_id',$sto_id);
            return response()->json([
                'status' => 200,
                'message' => "Exitoso",
                'data' => [
                    'stock' => $stock,
                ]
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
     * Remove the specified resource from storage.
     *
     * @param $sto_id
     * @return JsonResponse
     */
    public function destroy(Request $request,$sto_id)
    {
        try {
             DB::beginTransaction();
              $sal_id = $request->get('sal_id');

              if(Stock::where('sal_id', $sal_id)->where('sto_id', $sto_id)->exists()){
                 $stock = Stock::where('sal_id', $sal_id)->where('sto_id', $sto_id)->first();
                 $stock->delete();
             }else{
                 return response()->json([
                       'status' => 400,
                       'message' => "Error, no se encuentra el producto",
                       ]);
             }

             DB::commit();
             return response()->json([
                 'status' => 200,
                 'message' => "Exitoso stock delete",
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
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function listStockByServicesByAppointment($sto_id)
        {
        try {
            $stock = Stock_By_Services_Appointment::all()->where('sto_id',$sto_id);
            return response()->json([
                'status' => 200,
                'message' => "Exitoso",
                'stock' => $stock,

            ]);
        } catch (Exception $e) {
            return response()->json([
                'status' => 500,
                'message' => "Error",
                'error' => $e->getMessage(),

            ],500);
        }

    }

}
