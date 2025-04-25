<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    
    public function index(){
        return view("user.index");
    }
    public function create(){
        return view("user.create");
    }
    public function edit(){
        $search = request('search');
        
        if ($search) {
            $users = User::where(function ($query) use ($search) {
                $query->where('name', 'like', '%' . $search . '%')
                    ->orWhere('email', 'like', '%' . $search . '%');
            })
            ->orderBy('name')
            ->where('id', '!=', 1)
            ->paginate(20)
            ->withQueryString();
        } else {
            $users = User::where('id', '!=', 1)
                ->orderBy('name')
                ->paginate(10);
        }
        
        return view('user.index', compact('users'));
    }
}
