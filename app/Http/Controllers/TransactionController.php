<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TransactionController extends Controller
{
    public function list(Request $request)
    {
        try {
            $sal_id = $request->get('sal_id');
            $cashRegister = Transaction::where('sal_id',$sal_id)->first();
            return response()->json([
                'status' => 200,
                'message' => "Exitoso",
                'cashRegister' => $cashRegister,

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
     * Show the form for creating a new resource.
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function create(Request $request)
    {

        try {
            DB::beginTransaction();
            $sal_id = $request->get('sal_id');
            $app_id = $request->get('app_id');
            $cus_id = $request->get('cus_id');
            $tra_total = $request->get('tra_total');
            $tra_received = $request->get('tra_recieved');
            $transaction = new Transaction;

            $transaction = $transaction->create([
                'sal_id'=>$sal_id,
                'app_id'=>$app_id,
                'cus_id'=>$cus_id,
                'tra_total' => $tra_total,
                'tra_received'=>$tra_received
            ]);

            DB::commit();
            return response()->json([
                'status' => 200,
                'message' => "Exitoso",
                'transaction' => $transaction,
            ]);
        } catch (Exception $e) {
            DB::rollBack();
            return response()->json([
                'status' => 500,
                'message' => "Error at creating stock",
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param $sto_id
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request, $tra_id)
    {
        try {
            DB::beginTransaction();
            $sal_id = $request->get('sal_id');
            if (Transaction::where('sal_id', $sal_id)->where('tra_id', $tra_id)->exists()) {
                $stock = Transaction::where('sal_id', $sal_id)->where('tra_id', $tra_id)->first();
                $app_id = $request->get('app_id');
                $cus_id = $request->get('cus_id');
                $tra_total = $request->get('tra_total');
                $tra_received = $request->get('tra_received');
                $stock->update([
                    'app_id' => $app_id,
                    'cus_id' => $cus_id,
                    'tra_total' => $tra_total,
                    'tra_received' => $tra_received
                ]);

                DB::commit();
                return response()->json([
                    'status' => 200,
                    'message' => "Exitoso",
                    'stock' => $stock,
                ]);
            } else {
                return response()->json([
                    'status' => 400,
                    'message' => "Error, no se encuentra el producto",
                ], 400);
            }
        } catch (Exception $e) {
            DB::rollBack();
            return response()->json([
                'status' => 500,
                'message' => "Error",
                'error' => $e->getMessage(),
            ], 500);
        }
    }
}
