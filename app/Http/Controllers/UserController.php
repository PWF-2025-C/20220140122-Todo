<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index()
    {
        $search = request('search'); 
        if ($search) {
            $user = User::with('todos')->where(function ($query) use ($search) {
                $query->where('name', 'like', '%' . $search . '%')
                    ->orWhere('email', 'like', '%' . $search . '%');
            })->where('id', '!=', 1)
            ->orderBy('name')
            ->paginate(10); 
        } else {
            $user = User::with('todos')->where('id', '!=', 1)
                        ->orderBy('name')
                        ->paginate(10);
        }
    
        return view('user.index', compact('user'));
    }

    public function create(){
        return view("user.create");
    }

    public function edit(){
        return view('user.index', compact('user'));
    }

    public function makeadmin(User $user)
    {
        $user->timestamps = false;
        $user->is_admin = true;
        $user->save();
        return back()->with('success', 'Make admin successfully!');
    }

    public function removeadmin(User $user)
    {
        if ($user->id != 1) {
            $user->timestamps = false;
            $user->is_admin = false;
            $user->save();
            return back()->with('success', 'Remove admin successfully!');
        } else {
            return redirect()->route('user.index');
        }
    }

    public function destroy(User $user)
    {
        if ($user->id != 1) {
            $user->delete();
            return back()->with('success', 'Delete user successfully!');
        } else {
            return redirect()->route('user.index')->with('danger', 'Delete user failed!');
        }
    }
}
