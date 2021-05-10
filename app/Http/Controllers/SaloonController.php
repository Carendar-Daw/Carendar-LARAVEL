<?php

namespace App\Http\Controllers;

use App\Mail\WelcomeMailable;
use App\Models\Saloon;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;

class SaloonController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return JsonResponse
     */
    public function index($id_auth): JsonResponse
    {
        $saloons = Saloon::where('auth0_id', $id_auth)->first();
        return response()->json([
            'status' => 200,
            'message' => "Exitoso",
            'saloons' => $saloons,
        ]);
    }

    public function checkIfSaloonExistsAuth($id_auth, $request)
        {
            if(Saloon::where('auth0_id', $id_auth)->exists()){
              $saloons = Saloon::where('auth0_id', $id_auth)->first();
              return $saloons;
            }else if(Saloon::where('sal_email', $request->sal_email)->exists()){
             $saloons = Saloon::where('sal_email', $request->sal_email)->first();
             $saloons->auth0_id = $id_auth;
             $saloons->save();
             return $saloons;
            }else{
               $saloon = new Saloon;
               $saloon = $saloon->create($request->all());
               return $saloon;
            }
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
            $sal_id = $request->get('sal_id');
           if (Saloon::where('sal_id', $sal_id)->exists()) {
            $saloons = Saloon::where('sal_id', $sal_id)->first();
            return response()->json([
                'status' => 400,
                'message' => "Ya hay un saloon con estas credenciales",
                'saloon' => $saloons,
            ]);
           }else{
                $saloon = new Saloon;
                $saloon = $saloon->create($request->all());
           }
            DB::commit();
            return response()->json([
                'status' => 200,
                'message' => "Exitoso",
                 'saloons' => $saloon,
            ]);
        } catch (Exception $e) {
            DB::rollBack();
            return response()->json([
                'status' => 500,
                'message' => "Error at creating saloon",
                'data' => [
                    'error' => $e->getMessage()
                ]
            ],500);
        }

    }
    public function sendWelcomeEmail()
    {
        $mail = new WelcomeMailable;
        Mail::to('alvaroarpal@gmail.com')->send($mail);
    }

    /**
     * Display the specified resource.
     *
     * @param $sal_id
     * @return JsonResponse
     */
    public function show(Request $request)
    {
        try {

            $sal_id = $request->get('sal_id');
             $saloon = Saloon::find($sal_id);
            return ($saloon !== null) ?
                response()->json([
                    'status' => 200,
                    'message' => "Exitoso",
                    'saloon' => $saloon,
                ])
                :
                response()->json([
                    'status' => 500,
                    'message' => "No se encontró un salón con id: " . $sal_id,
                    'data' => []
                ],500);

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
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param $sal_id
     * @return JsonResponse
     */
    public function update(Request $request)
    {
        try {
            DB::beginTransaction();
            $sal_id = $request->get('sal_id');
            if($saloon = Saloon::where('sal_id', $sal_id)->first()){
            $saloon->update($request->all());
             DB::commit();
             return response()->json([
              'status' => 200,
              'message' => "Exitoso",
              'data' => [
              'saloon' => $saloon,
                ]
              ]);
            }

        }catch (Exception $e){
            DB::rollBack();
            return response()->json([
                'status' => 500,
                'message' => "Error",
                'data' => [
                    'error' => $e->getMessage(),
                ]
            ],500);
        }
    }
/*
      public function statistics(Request $request) {


        try {
            DB::beginTransaction();
            $sal_id = $request->get('sal_id');

             DB::commit();
             return [
                    'status' => 200,
                    'message' => "Exitoso",
                    'customers' => ,

             ];
        }catch (Exception $e){
            DB::rollBack();
            return response()->json([
                'status' => 500,
                'message' => "Error",
                'data' => [
                    'error' => $e->getMessage(),
                ]
        ],500);
      }
*/

}
