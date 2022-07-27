<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class PageController extends Controller {

   public function index(){
      return view('index');
   }

   public function uploadFile(Request $request){

      $data = array();

      $validator = Validator::make($request->all(), [
         'file' => 'required|mimes:png,jpg,jpeg,pdf|max:2048'
      ]);

      if ($validator->fails()) {

         $data['success'] = 0;
         $data['error'] = $validator->errors()->first('file');// Error response

      }else{
         if($request->file('file')) {
             $name = $request->name;
             $file = $request->file('file');
             $filename = time().'_'.$file->getClientOriginalName();

             // File extension
             $extension = $file->getClientOriginalExtension();

             // File upload location
             $location = 'image/product/';

             // Upload file
             $file->move($location,$filename);
             
             // File path
             $filepath = url('image/product/'.$filename);

             // Response
             $data['success'] = 1;
             $data['message'] = 'Uploaded Successfully!';
             $data['filepath'] = $filepath;
             $data['extension'] = $extension;
             $data['name']= $name;
         }else{
             // Response
             $data['success'] = 2;
             $data['message'] = 'File not uploaded.'; 
         }
      }

      return response()->json($data);
   }

}
