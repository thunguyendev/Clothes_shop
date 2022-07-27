<?php

namespace App\Services;
use Illuminate\Support\Facades\Storage;

class UploadService {

    const PRODUCT_UPLOAD_PATH = 'public/products/';

    public function upload($path, $file) {
        $name = time().'_'.$file->getClientOriginalExtension();
       
        $fullName = "$name.".$file->extension();

        $file->storeAs("$path", $fullName );

        $fullPath = $path.$fullName ;

        return Storage::url($fullPath);
    }

    public function delete($path){
        return Storage::disk('public')->delete($path);
    }

}