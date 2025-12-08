<?php

namespace App\Http\Controllers;

use App\Models\Todo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;  // Add this

class TodoController extends Controller
{
    use AuthorizesRequests;  // Add this line

    public function index()
    {
        // Get only the authenticated user's todos
        $todos = Auth::user()->todos()->latest()->get();
        // $todos = Todo::All();
        return view('todos.index', compact('todos'));
    }

    public function show(Todo $todo)
    {
        // Authorize: ensure user owns this todo    // Check if user can view this todo
        $this->authorize('view', $todo);
        return view('todos.show', compact('todo'));
    }

    public function create()
    {
        // Check if user can create todos
        $this->authorize('create', Todo::class);
        // $todos = Todo::All();
        // $users = User::all();
        return view('todos.create');
    }

    public function store(Request $request)
    {
        $this->authorize('create', Todo::class);

        // validation
        $validated = $request->validate([
            'title' => 'required|string|min:3|max:255',
            'description' => 'nullable|string|min:3',
            'priority' => 'required|in:low,medium,high',
            'due_date' => 'required|date|',
        ]);
        //'user_id' => ['required','exists:users,id']

        // Automatically assign to authenticated user
        $validated['user_id'] = Auth::id();
        $validated['is_completed'] = false;

        // create todo
        Todo::create($validated);

        // redirect
        return redirect()->route('todos.index')
            ->with('success', 'Todo created successfully');

        // get data
        //$data = $request->all();
    }

    public function edit(Todo $todo)
    {
        $this->authorize('update', $todo);
        //$users = User::all();
        return view('todos.edit', compact('todo'));
    }

    public function update(Request $request, Todo $todo)
    {
        $this->authorize('update', $todo);

        // validation
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'priority' => 'required|in:low,medium,high',
            'due_date' => 'nullable|date',
            'is_completed' => 'boolean',
        ]);

        // update todo
        $todo->update($validated);

        // redirect
        return redirect()->route('todos.show', $todo)
            ->with('success', 'Todo updated successfully');

        // get data
        // $data = $request->all();
    }

    public function destroy(Todo $todo)
    {
        $this->authorize('delete', $todo);
        $todo->delete();        // Soft delete

        return redirect()->route('todos.index')
            ->with('success', 'Todo deleted successfully');
    }

    /**
     * Toggle todo completion status
     */
    public function toggleComplete(Todo $todo)  // Toggle todo completion status
    {
        $this->authorize('update', $todo);

        $todo->update([
            'is_completed' => !$todo->is_completed
        ]);

        return back()->with('success', 'Todo status updated!');
    }

    /**
     * Display completed todos
    */
    public function finished()
    {
        $completedTodos = Auth::user()
            ->todos()
            ->where('is_completed', true)
            ->latest('updated_at')
            ->get();
        return view('todos.finished', compact('completedTodos'));
    }
}
