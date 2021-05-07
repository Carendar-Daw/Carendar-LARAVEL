<?php

namespace App\Http\Controllers;

use App\Models\Tours;
use Illuminate\Http\Request;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;

class ToursController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $sal_id = $request->get('sal_id');
        if (Tours::where('sal_id', $sal_id)->exists()) {
            $theTour = Tours::where('sal_id', $sal_id)->first();
            return response()->json([
                'status' => 200,
                'message' => "Exitoso",
                'tours' => $theTour,
            ]);
        } else {
            $tours = new Tours;
            $tours->sal_id = $sal_id;
            $theTour = $tours->save();
        }
        return response()->json([
            'status' => 200,
            'message' => "Exitoso",
            'tours' => $theTour,
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
            if (Tours::where('sal_id', $request->sal_id)->exists()) {
                return response()->json([
                    'status' => 400,
                    'message' => "Ya hay un tour creado",
                ]);
            } else {
                $sal_id = $request->get('sal_id');
                $tours = new Tours;
                $tours = $tours->create(array_merge($request->all(), ['sal_id' => $sal_id]));
            }
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

            ], 500);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param   $sal_id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
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
        } catch (Exception $e) {
            DB::rollBack();
            return response()->json([
                'status' => 500,
                'message' => "Error",
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  $sal_id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, $sal_id)
    { {
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
            } catch (Exception $e) {
                DB::rollBack();
                return response()->json([
                    'status' => 500,
                    'message' => "Error",
                    'data' => [
                        'error' => $e->getMessage(),
                    ]
                ], 500);
            }
        }
    }
}
