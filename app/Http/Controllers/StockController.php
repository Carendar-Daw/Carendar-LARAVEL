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
    public function index(): JsonResponse
    {
        $stock = Stock::all();
        return response()->json([
            'status' => 200,
            'message' => "Exitoso",
            'data' => [
                'stock' => $stock,
            ]
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


            $stock = new Stock();
            $stock = $stock->create($request->all());


            DB::commit();
            return response()->json([
                'status' => 200,
                'message' => "Exitoso",
                'data' => [
                    'stock' => $stock,
                ]
            ]);
        } catch (Exception $e) {
            DB::rollBack();
            return response()->json([
                'status' => 500,
                'message' => "Error at creating stock",
                'data' => [
                    'error' => $e->getMessage()
                ]
            ]);
        }

    }



    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  Stock  $stock
     * @return JsonResponse
     */
    public function update(Request $request, $ser_id)
    {
        try {
            DB::beginTransaction();
            $stock = Stock::find($ser_id);
            $stock->update($request->all());
            DB::commit();
            return response()->json([
                'status' => 200,
                'message' => "Exitoso",
                'data' => [
                    'stock' => $stock,
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
            ]);
        }

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param $ser_id
     * @return JsonResponse
     */
    public function destroy($ser_id)
    {
        try {
            DB::beginTransaction();
            $stock = Stock::find($ser_id);
            $stock->delete();
            DB::commit();
            return response()->json([
                'status' => 200,
                'message' => "Exitoso item delete",
                'data'=>[
                    'item'=>$stock
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
