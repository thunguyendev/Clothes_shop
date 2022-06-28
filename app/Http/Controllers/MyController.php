<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class MyController extends Controller
{
    public function XinChao($ten){
        echo "Xin chào các bạn ".$ten  ;
    }
}
