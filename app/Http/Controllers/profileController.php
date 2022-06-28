<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class profileController extends Controller
{
    public function index(){
        return "profile";
    }
    public function userView($id,$code){
//        return view('pages.user')->with('id',$id,'code',$code);
//        return view('pages.user',compact(['id','code']));
        $names = ['reza','moein','hasan','moradi'];
        return view('pages.user',compact('names'));

    }
}
