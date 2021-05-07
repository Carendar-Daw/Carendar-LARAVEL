<?php

namespace App\Http\Controllers;

use App\Models\Language;
use Illuminate\Http\Request;
use Exception;
use Illuminate\Support\Facades\DB;

class LanguageController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        try{
        $language = Language::all();
        return response()->json([
            'status' => 200,
            'message' => "Exitoso",
            'language' => $language,
  
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
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        try {
            DB::beginTransaction();
           
            if (Language::where('sal_id', $request->sal_id)->exists()) {
                return response()->json([
                    'status' => 400,
                    'message' => "Ya hay un language creado",
                ]);
               }else{
                $language = new Language;
                $language = $language->create($request->all());  
               }  
           
            DB::commit();
            return response()->json([
                'status' => 200,
                'message' => "Exitoso",
                'language' => $language,
  
            ]);
        } catch (Exception $e) {
            DB::rollBack();
            return response()->json([
                'status' => 500,
                'message' => "Error at creating language",
                'error' => $e->getMessage()
          
            ],500);
        }

    }
    public function indexLanguage($sal_id)
    {
        try {
            $language = Language::where('sal_id',$sal_id)->first();
            return response()->json([
                'status' => 200,
                'message' => "Exitoso",
                    'language' => $language,
                
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
            $languages = Language::where('sal_id', $sal_id)->first();

            $languages->update(array_merge($request->all(), ['sal_id' => $sal_id]));
            DB::commit();
            return response()->json([
                'status' => 200,
                'message' => "Exitoso",
                'languages' => $languages,
   
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
     * @param  \App\Models\Language  $language
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, $sal_id)
    {
        try {
             DB::beginTransaction();
             $sal_id = $request->get('sal_id');
             $languages = Language::where('sal_id', $sal_id);
             $languages->delete();
             DB::commit();
             return response()->json([
                 'status' => 200,
                 'message' => "Exitoso languages delete",
 
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
