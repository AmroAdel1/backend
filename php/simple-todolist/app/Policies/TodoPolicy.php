<?php

namespace App\Policies;

use App\Models\Todo;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class TodoPolicy
{
    use HandlesAuthorization;

    /**
     * Determine if the user can view any todos.
     */
    public function viewAny(User $user)
    {
        // All authenticated users can view their own todos list
        return true;
    }

    /**
     * Determine if the user can view the todo.
     */
    public function view(User $user, Todo $todo)
    {
        // User can only view their own todos
        return $user->id === $todo->user_id;
    }

    /**
     * Determine if the user can create todos.
     */
    public function create(User $user)
    {
        // All authenticated users can create todos
        return true;
    }

    /**
     * Determine if the user can update the todo.
     */
    public function update(User $user, Todo $todo)
    {
        // User can only update their own todos
        return $user->id === $todo->user_id;
    }

    /**
     * Determine if the user can delete the todo.
     */
    public function delete(User $user, Todo $todo)
    {
        // User can only delete their own todos
        return $user->id === $todo->user_id;
    }

    /**
     * Determine if the user can restore the todo.
     */
    public function restore(User $user, Todo $todo)
    {
        // User can only restore their own soft-deleted todos
        return $user->id === $todo->user_id;
    }

    /**
     * Determine if the user can permanently delete the todo.
     */
    public function forceDelete(User $user, Todo $todo)
    {
        // User can only force delete their own todos
        return $user->id === $todo->user_id;
    }
}
