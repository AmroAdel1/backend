@extends("layouts.app")

@section("title") Todo List @endsection

@section("content")
<style>
    .page-header {
        margin-bottom: 2rem;
    }

    .todo-card {
        background: white;
        border-radius: 0.5rem;
        box-shadow: 0 1px 3px rgba(0,0,0,0.1);
        overflow: hidden;
    }

    .todo-card-header {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
        padding: 1.5rem;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    .todo-table {
        width: 100%;
        margin: 0;
    }

    .todo-table thead {
        background-color: #f8f9fa;
    }

    .todo-table th {
        padding: 1rem;
        font-weight: 600;
        text-transform: uppercase;
        font-size: 0.75rem;
        letter-spacing: 0.05em;
        color: #6b7280;
        border-bottom: 2px solid #e5e7eb;
        vertical-align: middle;  /* Add this */
    }

    .todo-table td {
        padding: 1rem;
        border-bottom: 1px solid #f3f4f6;
        vertical-align: middle;
    }

    .todo-table tbody tr:hover {
        background-color: #f9fafb;
    }

    .priority-badge {
        display: inline-block;
        padding: 0.25rem 0.75rem;
        border-radius: 9999px;
        font-size: 0.75rem;
        font-weight: 600;
        text-transform: uppercase;
    }

    .priority-low {
        background-color: #dbeafe;
        color: #1e40af;
    }

    .priority-medium {
        background-color: #fef3c7;
        color: #92400e;
    }

    .priority-high {
        background-color: #fee2e2;
        color: #991b1b;
    }

    .status-badge {
        display: inline-flex;
        align-items: center;
        gap: 0.25rem;
        padding: 0.25rem 0.75rem;
        border-radius: 9999px;
        font-size: 0.875rem;
        font-weight: 500;
    }

    .status-completed {
        background-color: #d1fae5;
        color: #065f46;
    }

    .status-pending {
        background-color: #fef3c7;
        color: #92400e;
    }

    .action-btn {
        padding: 0.375rem 0.75rem;
        margin: 0 0.125rem;
        border-radius: 0.375rem;
        font-size: 0.875rem;
        border: none;
        cursor: pointer;
        transition: all 0.2s;
        text-decoration: none;  /* Add this */
        display: inline-block;  /* Add this */
    }

    .btn-show {
        background-color: #3b82f6;
        color: white;
    }

    .btn-show:hover {
        background-color: #2563eb;
    }

    .btn-edit {
        background-color: #8b5cf6;
        color: white;
    }

    .btn-edit:hover {
        background-color: #7c3aed;
    }

    .btn-toggle {
        background-color: #10b981;
        color: white;
    }

    .btn-toggle:hover {
        background-color: #059669;
    }

    .btn-delete {
        background-color: #ef4444;
        color: white;
    }

    .btn-delete:hover {
        background-color: #dc2626;
    }

    .empty-state {
        text-align: center;
        padding: 4rem 2rem;
    }

    .empty-state i {
        font-size: 4rem;
        color: #d1d5db;
        margin-bottom: 1rem;
    }

    .empty-state h3 {
        color: #6b7280;
        margin-bottom: 0.5rem;
    }

    .empty-state p {
        color: #9ca3af;
        margin-bottom: 1.5rem;
    }

    .empty-state a {
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
    }

    .todo-title {
        font-weight: 600;
        color: #111827;
        margin-bottom: 0.25rem;
    }

    .due-date {
        display: flex;
        align-items: center;
        gap: 0.5rem;
        font-size: 0.875rem;
        color: #6b7280;
    }

    .due-date.overdue {
        color: #dc2626;
        font-weight: 600;
    }

    .stats-row {
        display: flex;
        gap: 1rem;
        margin-bottom: 2rem;
    }

    .stat-card {
        flex: 1;
        background: white;
        padding: 1.5rem;
        border-radius: 0.5rem;
        box-shadow: 0 1px 3px rgba(0,0,0,0.1);
        display: flex;
        align-items: center;
        gap: 1rem;
    }

    .stat-icon {
        width: 3rem;
        height: 3rem;
        border-radius: 0.5rem;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.5rem;
    }

    .stat-content h3 {
        margin: 0;
        font-size: 1.875rem;
        font-weight: 700;
    }

    .stat-content p {
        margin: 0;
        color: #6b7280;
        font-size: 0.875rem;
    }

    .action-buttons-wrapper {
        display: flex;
        gap: 0.25rem;
        flex-wrap: wrap;
        justify-content: center;
    }

    @media (max-width: 991px) {
        /* Tablet: Keep 4 buttons in row with smaller size */
        .action-btn {
            padding: 0.5rem 0.5rem;
            min-width: 38px;
            min-height: 38px;
            margin: 0;
        }

        .action-buttons-wrapper {
            gap: 0.25rem;
        }
    }

    @media (max-width: 767px) {
        /* Mobile: Force 2x2 grid layout */
        .action-buttons-wrapper {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 0.5rem;
            max-width: 180px;
            margin: 0 auto;
        }

        .action-btn {
            padding: 0.625rem;
            width: 100%;
            min-width: 0;
        }
    }

    @media (max-width: 480px) {
        /* Very small mobile: Slightly larger buttons */
        .action-buttons-wrapper {
            max-width: 160px;
            gap: 0.5rem;
        }

        .action-btn {
            padding: 0.75rem;
        }
    }
</style>

{{-- Statistics Row --}}
<div class="stats-row">
    <div class="stat-card">
        <div class="stat-icon" style="background-color: #dbeafe; color: #2563eb;">
            <i class="bi bi-list-task"></i>
        </div>
        <div class="stat-content">
            <h3>{{ $todos->count() }}</h3>
            <p>Total Todos</p>
        </div>
    </div>

    <div class="stat-card">
        <div class="stat-icon" style="background-color: #d1fae5; color: #059669;">
            <i class="bi bi-check-circle"></i>
        </div>
        <div class="stat-content">
            <h3>{{ $todos->where('is_completed', true)->count() }}</h3>
            <p>Completed</p>
        </div>
    </div>

    <div class="stat-card">
        <div class="stat-icon" style="background-color: #fef3c7; color: #d97706;">
            <i class="bi bi-clock-history"></i>
        </div>
        <div class="stat-content">
            <h3>{{ $todos->where('is_completed', false)->count() }}</h3>
            <p>Pending</p>
        </div>
    </div>
</div>

{{-- Main Todo Card --}}
<div class="todo-card">
    <div class="todo-card-header">
        <div>
            <h2 class="mb-0"><i class="bi bi-list-check"></i> My Todos</h2>
            <small style="opacity: 0.9;">Manage your tasks efficiently</small>
        </div>
        <a href="{{ route('todos.create') }}" class="btn btn-light">
            <i class="bi bi-plus-circle"></i> Create Todo
        </a>
    </div>

    <div class="card-body p-0">
        @if($todos->count() > 0)
            <table class="todo-table">
                <thead>
                    <tr>
                        <th>TASK</th>
                        <th>DUE DATE</th>
                        <th>STATUS</th>
                        <th>PRIORITY</th>
                        <th style="text-align: center;">ACTIONS</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($todos as $todo)
                        <tr>
                            <td>
                                <div class="todo-title">{{ $todo->title }}</div>
                                {{-- @if($todo->description) --}}
                                <small class="text-muted">{{ Str::limit($todo->description, 60) }}</small>
                                {{-- @endif --}}
                            </td>
                            <td>
                                {{-- @if($todo->due_date) --}}
                                @php
                                    $isOverdue = !$todo->is_completed && $todo->due_date < now();
                                @endphp
                                <div class="due-date {{ $isOverdue ? 'overdue' : '' }}">
                                    <i class="bi bi-calendar-event"></i>
                                    {{ $todo->due_date->format('M d, Y') }}
                                    @if($isOverdue)
                                        <span class="badge bg-danger">Overdue</span>
                                    @endif
                                </div>
                                {{-- @else
                                    <span class="text-muted">No due date</span>
                                @endif --}}
                            </td>
                            <td>
                                @if($todo->is_completed)
                                    <span class="status-badge status-completed">
                                        <i class="bi bi-check-circle-fill"></i> Completed
                                    </span>
                                @else
                                    <span class="status-badge status-pending">
                                        <i class="bi bi-clock"></i> Pending
                                    </span>
                                @endif
                            </td>
                            <td>
                                <span class="priority-badge priority-{{ $todo->priority }}">
                                    {{ ucfirst($todo->priority) }}
                                </span>
                            </td>
                            <td style="text-align: center;">    <!-- (most to least frequently used) -->
                                <div class="action-buttons-wrapper">
                                    <a href="{{ route('todos.show', $todo->id) }}" class="action-btn btn-show" title="View Details">
                                        <i class="bi bi-eye"></i>
                                    </a>

                                    <a href="{{ route('todos.edit', $todo->id) }}" class="action-btn btn-edit" title="Edit">
                                        <i class="bi bi-pencil"></i>
                                    </a>

                                    <form method="POST" action="{{ route('todos.toggle', $todo->id) }}" style="display: inline;">
                                        @csrf
                                        @method('PATCH')
                                        <button type="submit" class="action-btn btn-toggle" title="Toggle Complete">
                                            <i class="bi bi-{{ $todo->is_completed ? 'arrow-counterclockwise' : 'check2' }}"></i>
                                        </button>
                                    </form>

                                    <form method="POST" action="{{ route('todos.destroy', $todo->id) }}" style="display: inline;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="action-btn btn-delete"
                                                onclick="return confirm('Are you sure you want to delete this todo?')"
                                                title="Delete">
                                            <i class="bi bi-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @else
            <div class="empty-state">
                <i class="bi bi-inbox"></i>
                <h3>No todos yet</h3>
                <p>Start by creating your first todo to stay organized!</p>
                <a href="{{ route('todos.create') }}" class="btn btn-primary">
                    <i class="bi bi-plus-circle"></i> Create Your First Todo
                </a>
            </div>
        @endif
    </div>
</div>
@endsection
