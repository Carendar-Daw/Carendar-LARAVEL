<?php

namespace App\Http\Controllers;

use App\Models\Cash_Register;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Exception;
use Illuminate\Support\Facades\DB;


class CashRegisterController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        try {
            $sal_id = $request->get('sal_id');
            $cashRegister = Cash_Register::where('sal_id', $sal_id)->whereDate('created_at', '=', Carbon::today()->toDateString())->first();
            if($cashRegister->cas_state == 'close'){
            return response()->json([
                    'status' => 200,
                    'message' => "Caja ya cerrada",
                    'cashRegister' => null,
            ]);
            }else{
            return response()->json([
                'status' => 200,
                'message' => "Exitoso",
                'cashRegister' => $cashRegister,
            ]);
            }

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
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        try {
            DB::beginTransaction();
            $sal_id = $request->get('sal_id');
            if (Cash_Register::where('sal_id', $request->sal_id)->whereDate('created_at', '=', Carbon::today()->toDateString())->exists()) {
                return response()->json([
                    'status' => 400,
                    'message' => "Ya hay una caja creada",
                ]);
            }else{
                $cashRegister = new Cash_Register;
                $cashRegister->create((array_merge($request->all(), ['sal_id' => $sal_id])));

            }
            DB::commit();
            return response()->json([
                'status' => 200,
                'message' => "Exitoso",
                'cashRegister' => $cashRegister,

            ]);
        } catch (Exception $e) {
            DB::rollBack();
            return response()->json([
                'status' => 500,
                'message' => "Error at creating cashRegister",
                'error' => $e->getMessage()

            ],500);
        }
    }

    public function indexCashRegister($sal_id)
    {
        try {
            $cashRegister = Cash_Register::where('sal_id',$sal_id)->first();
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
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param $sal_id
     * @return JsonResponse
     */
    public function update(Request $request)
    {
        try {
            DB::beginTransaction();
             $sal_id = $request->get('sal_id');
            $cashRegister = Cash_Register::find($sal_id);
            $cashRegister->update($request->all());
            DB::commit();
            return response()->json([
                'status' => 200,
                'message' => "Exitoso",
                'cashRegister' => $cashRegister,

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
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Cash_Register  $cashRegister
     * @return \Illuminate\Http\Response
     */
    public function destroy(Cash_Register $cashRegister, $sal_id)
    {
        try {
             DB::beginTransaction();
             $cashRegister = Cash_Register::find($sal_id);
             $cashRegister->delete();
             DB::commit();
             return response()->json([
                 'status' => 200,
                 'message' => "Exitoso cashRegister delete",

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


}
