<?php

namespace App\Http\Controllers;

use App\Models\Cash_Register;
use Illuminate\Http\Request;

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
            $cashRegister = Cash_Register::where('sal_id', $sal_id)->get();
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
            ]);
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
           
   
                $cashRegister = new CashRegister;
                $cashRegister = $cashRegister->create($request->all());
          
           
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
          
            ]);
        }
    }
    
    public function indexCashRegister($sal_id)
    {
        try {
            $cashRegister = Cash_Register::all()->where('$sal_id',$sal_id);
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
            ]);
        }
    }

  /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param $sal_id
     * @return JsonResponse
     */
    public function update(Request $request, $sal_id)
    {
        try {
            DB::beginTransaction();
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
            ]);
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
             ]);
         }
     }
    
    
}