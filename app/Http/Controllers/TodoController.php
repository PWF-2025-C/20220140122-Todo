<?php

namespace App\Http\Controllers;

use App\Models\Todo;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class TodoController extends Controller
{
    public function view(){
        //  $todos =Todo::where('user_id', Auth::id())->get();
        $todos = Todo::all();
        dd($todos);
    return view('todo.index'); 
    }

}