<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\AddProductRequest;
use App\Http\Requests\EditProductRequest;
use Jenssegers\Mongodb\Eloquent\Model as Model;
use App\Models\Cloth;


class TestController extends Controller
{
    public function index(){
        $data = Cloth::all();

        return view('pages.product', compact('data'));
    }

    public function admin(){
        $data = Cloth::all();

        return view('welcome', compact('data'));
    }
    public function form($_id = false){
        if($_id){
            $data = Post::findOrFail($_id);
            return view('cloth.form', compact('data'));
        }
        return view('cloth.form');
    }

    public function save(Request $request){
        $data = new Cloth($request->all());
    
        if($data->save()){
            return redirect()->route('home');
        }
        return back();
    }

    public function update(Request $request, $_id){
        $data = Cloth::findOrFail($_id);
        $data->name = $request->name;
        $data->category = $request->category;
        $data->price = $request->price;
        $data->description = $request->description;
        $data->quantity = $request->quantity;

    
        if($data->save()){
            return redirect()->route('home');
        }
        return back();
    }


    /**Edit***** */
    public function editCloth($_id)
    {

        $data = Cloth::where('_id', $_id)->first();
        return view('cloth.editForm', compact(('data')));
    }

    public function postEditProduct(EditProductRequest $request)
    {
        $_id=$request->_id;
        $product = Cloth::find($_id);
        if ($request->hasFile('image')) {
            $file=$request->file('image');
            $fileName=$file->getClientOriginalName('image');
            $file->move('image/product', $fileName);
        }

        if ($request->file('image')!=null) {
            $product->image->$fileName;
        }

        $product->name = $request->name;
        $product->category = $request->category;

        $product->price = $request->price;
        $product->description = $request->description;
        $product->quantity = $request->quantity;
        $product->image = $file_name;
        if($product->save()){
            return redirect()->route('home');
        }
        return back();
    }

    /**Add */
    public function postAddProduct(AddProductRequest $request)
    {
        $product = new Cloth();
        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $fileName = $file->getClientOriginalName('image');
            $file->move('image/product', $fileName);
        }

        $file_name = null;
        if ($request->file('image') != null) {
            $file_name = $request->file('image')->getClientOriginalName();
        }

        $product->name = $request->name;
        $product->category = $request->category;

        $product->price = $request->price;
        $product->description = $request->description;
        $product->quantity = $request->quantity;
        $product->image = $file_name;


        if($product->save()){
            return redirect()->route('home');
        }
        return back();

    }
    


///Ajax
public function deleteProduct($_id){
    $product = Cloth::find($_id);
    $product->delete();
    return response()->json(['success'=>'San pham da duoc xoa']);
}





    /**Edit***** */
    // public function editCloth(Request $request, $_id)
    // {

    //     $data = Cloth::findOrFail($_id);
    //     $data->name = $request->name;
    //     $data->category = $request->category;
    //     $data->price = $request->price;
    //     $data->description = $request->description;
    //     $data->quantity = $request->quantity;
    
    //     if($data->save()){
    //         return redirect()->route('home');
    //     }
    //     return back();
    //     return view('cloth.editForm', compact(('data')));
    // }{}

    public function delete($_id){
        $data = Cloth::destroy($_id);
        if($data){
            return redirect()->route('home');
        }else{
            dd('Error delete this cloth');
        }
    }
    
}


