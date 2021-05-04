<?php

namespace App\Http\Controllers;

use App\Models\Tours;
use Illuminate\Http\Request;

class ToursController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $tours = Tours::all();
        return response()->json([
            'status' => 200,
            'message' => "Exitoso",
            'tours' => $tours,
  
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
           
   
                $tours = new Tours;
                $tours = $tours->create($request->all());
          
           
            DB::commit();
            return response()->json([
                'status' => 200,
                'message' => "Exitoso",
                'tours' => $tours,
  
            ]);
        } catch (Exception $e) {
            DB::rollBack();
            return response()->json([
                'status' => 500,
                'message' => "Error at creating tours",
                'error' => $e->getMessage()
          
            ]);
        }
    }


    /**
     * Display the specified resource.
     *
     * @param  $sal_id
     * @return \Illuminate\Http\Response
     */
    public function show($sal_id)
    {
        try {
            $sal_id = $request->get('sal_id');
            $tours = Tours::where('sal_id', $sal_id)->first();
            return response()->json([
                'status' => 200,
                'message' => "Exitoso",
                'tours' => $tours,

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
     * @param  \Illuminate\Http\Request  $request
     * @param   $sal_id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $sal_id)
    {
        try {
            DB::beginTransaction();
            $sal_id = $request->get('sal_id');
            $tours = Tours::where('sal_id', $sal_id)->first();
            $tours->sal_id = $sal_id;
            $tours->update(array_merge($request->all(), ['sal_id' => $sal_id]));
            DB::commit();
            return response()->json([
                'status' => 200,
                'message' => "Exitoso",
                'tours' => $tours,
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
     * @param  $sal_id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, $sal_id)
    {
        {
            try {
                DB::beginTransaction();
                $sal_id = $request->get('sal_id');
                $tours = Tours::where('sal_id', $sal_id)->first();
                $tours->delete();
                DB::commit();
                return response()->json([
                    'status' => 200,
                    'message' => "Exitoso",
                    'tours' => $tours,
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
}
