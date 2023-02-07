<?php

namespace App\Http\Controllers\UI;

use App\Models\Category;
use App\Http\Controllers\Controller;

class WelcomeController extends Controller
{
    public function index(){
           $specials =Category::where('name','special')->first();
      
        return view('welcome',get_defined_vars());
    }

    public function thankyou()
    {
        return view('ui.thankyou');
    }
}
