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
            'services' => $services,
<<<<<<< HEAD
  
=======
        
>>>>>>> 7165bc2581af9d09e59e866f4de2435f46e0a3d9
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
           
   
                $services = new Services;
                $services = $services->create($request->all());
          
           
            DB::commit();
            return response()->json([
                'status' => 200,
                'message' => "Exitoso",
                'services' => $services,
<<<<<<< HEAD
  
=======
 
>>>>>>> 7165bc2581af9d09e59e866f4de2435f46e0a3d9
            ]);
        } catch (Exception $e) {
            DB::rollBack();
            return response()->json([
                'status' => 500,
                'message' => "Error at creating services",
                'error' => $e->getMessage()
<<<<<<< HEAD
          
=======
   
>>>>>>> 7165bc2581af9d09e59e866f4de2435f46e0a3d9
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
            $services = Services::find($ser_id);
            $services->update($request->all());
            DB::commit();
            return response()->json([
                'status' => 200,
                'message' => "Exitoso",
                'services' => $services,
<<<<<<< HEAD
   
=======

>>>>>>> 7165bc2581af9d09e59e866f4de2435f46e0a3d9
            ]);
        }catch (Exception $e){
            DB::rollBack();
            return response()->json([
                'status' => 500,
                'message' => "Error",
                'error' => $e->getMessage(),
<<<<<<< HEAD

=======
  
>>>>>>> 7165bc2581af9d09e59e866f4de2435f46e0a3d9
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
                'error' => $e->getMessage(),
<<<<<<< HEAD
=======
      
>>>>>>> 7165bc2581af9d09e59e866f4de2435f46e0a3d9
            ]);
        }
    }
}
