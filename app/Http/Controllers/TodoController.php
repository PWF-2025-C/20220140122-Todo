<?php

namespace App\Http\Controllers;

use App\Models\Todo;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TodoController extends Controller
{
    public function index()
    {
        $todos = Todo::where('user_id', Auth::id())
                     ->orderBy('created_at', 'desc')
                     ->get();

        $todosCompleted = Todo::where('user_id', Auth::id())
                              ->where('is_done', true)
                              ->count();

        return view('todo.index', compact('todos', 'todosCompleted')); 
    }

    public function create()
    {
        $category = Category::all();
        return view('todo.create', compact('category'));
    }

    public function edit(Todo $todo)
    {
        if (Auth::user()->id == $todo->user_id) {
            $category = Category::all();
            return view('todo.edit', compact('todo', 'category'));
        } else {
            return redirect()->route('todo.index')->with('danger', 'You are not authorized to edit this todo!');
        }
    }

    public function update(Request $request, Todo $todo)
    {
        $request->validate([
            'title' => 'required|max:255',
            'category_id' => 'required|exists:categories,id'
        ]);

        $todo->update([
            'title' => ucfirst($request->title),
            'category_id' => $request->category_id,
        ]);

        return redirect()->route('todo.index')->with('success', 'Todo updated successfully!');
    }

    public function store(Request $request)
{
    $request->validate([
        'title' => 'required|string|max:255',
        'category_id' => 'nullable|exists:categories,id',
    ]);

    Todo::create([
        'title' => ucfirst($request->title),
        'user_id' => Auth::id(),
        'category_id' => $request->category_id,
    ]);

    return redirect()->route('todo.index')->with('success', 'Todo Created Successfully');
}


    public function complete(Todo $todo)
    {
        if ($todo->user_id != Auth::id()) {
            abort(403);
        }

        $todo->is_done = true;
        $todo->save();

        return redirect()->route('todo.index')->with('success', 'Todo marked as complete.');
    }

    public function uncomplete(Todo $todo)
    {
        if ($todo->user_id != Auth::id()) {
            abort(403);
        }

        $todo->is_done = false;
        $todo->save();

        return redirect()->route('todo.index')->with('success', 'Todo marked as uncomplete.');
    }

    public function destroy(Todo $todo)
    {
        if (Auth::id() === $todo->user_id) {
            $todo->delete();
            return redirect()->route('todo.index')->with('success', 'Todo deleted successfully!');
        } else {
            return redirect()->route('todo.index')->with('danger', 'You are not authorized to delete this todo!');
        }
    }

    public function destroyCompleted()
    {
        $todosCompleted = Todo::where('user_id', Auth::id())
                              ->where('is_done', true)
                              ->get();

        foreach ($todosCompleted as $todo) {
            $todo->delete();
        }

        return redirect()->route('todo.index')->with('success', 'All completed todos deleted successfully!');
    }
}
