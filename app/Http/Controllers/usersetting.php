<?php

namespace App\Http\Controllers;

use Facade\Ignition\Exceptions\ViewExceptionWithSolution;
use Illuminate\Http\Request;

class usersetting extends Controller
{
    public function users(){
        $usersAdmin = ['a','b','c','d'];
        return view('layouts.usersetting',compact('usersAdmin'));
    }
    public function main(){
        $news= 'سلام گل های توی خونه';
        return view('layouts.settingmain',compact('news'));
    }
}
