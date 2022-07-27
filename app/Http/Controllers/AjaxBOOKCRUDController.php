<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Cloth;
use App\Services\UploadService;

class AjaxBOOKCRUDController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = Cloth::all();
            return view('cloth.ajax-clothes-crud', compact('data'));
    }
    

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
    
        if($request->file('image')){
            $uploadService = new UploadService();
            $uploadedPath = $uploadService->upload(
                UploadService::PRODUCT_UPLOAD_PATH.$request->id.'/',
                $request->file('image')
            );
            
       
            $clothes   =   Cloth::updateOrCreate(
                [
                    '_id' => $request->id
                ],
                [
                    'name' => $request->name, 
                    'category' => $request->category,
                    'price' => $request->price,
                    'description' => $request->description,
                    'quantity' => $request->quantity,
                    'image'=> $uploadedPath
                ]);
        }
         
                    
        return response()->json(['success' => true]);
    }
    
    
    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request)
    {   

        $where = array('_id' => $request->id);
        $clothes  = Cloth::where($where)->first();

        return response()->json($clothes);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        $cloth = Cloth::where('_id',$request->id)->delete();

        return response()->json(['success' => true]);
    }


}