<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Cloth;
use Illuminate\Http\Request;

class ProductsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // return response()->json([
        //     "status" => true,
        //     "post"=>[],
        // ]);
        return Cloth::all();

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $cloth = Cloth::create($request->all());
        return response()->json([
            'status'=>true,
            'message'=>"Create cloth successfully",
            'cloth'=> $cloth
        ], 200);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Cloth  $cloth
     * @return \Illuminate\Http\Response
     */
    public function show(Cloth $cloth)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Cloth  $cloth
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Cloth $cloth, $id)
    {
        $cloth = Cloth::find($id);
        if(!$cloth) {
            return response()->json([
                'status'=>false,
                'message'=>"Update false",
            ], 404);
        }
        $cloth->update($request->all());
     
        return response()->json([
            'status'=>true,
            'message'=>"Update cloth successfully",
            'cloth'=> $cloth
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Cloth  $cloth
     * @return \Illuminate\Http\Response
     */
    public function destroy(Cloth $cloth, $id)
    {
        $cloth = Cloth::find($id);
        $cloth->delete();

        if(!$cloth) {
            return response()->json([
                'status'=>false,
                'message'=>"Update false",
            ], 404);
        }

        return response()->json([
            'status' => true,
            'message' => "Delete successfully",
        ], 200);
    }
}
