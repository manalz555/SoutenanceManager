<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class indexController
{
     public function index(){
        return view('index');
    }
}