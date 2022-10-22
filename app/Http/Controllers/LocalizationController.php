<?php

namespace App\Http\Controllers;

use Config;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Session;

class LocalizationController extends Controller
{
    public function lang($locale)
    {
        if(array_key_exists($locale, Config::get('languages'))){
            Session::put('applocale',$locale);
        }
        return redirect()->back();
    }
}
