<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class staticPage extends Controller
{
    public function about($emp = null , $id = null){

//        return view('about')->with('emp' , $emp);
        return view('pages.about',compact(['emp' , 'id']));
    }
}
