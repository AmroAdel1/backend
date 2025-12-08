@extends("layouts.app")

@section("title") {{ $todo->title }} @endsection

@section("content")
<style>
    .detail-card {
        background: white;
        border-radius: 0.5rem;
        box-shadow: 0 1px 3px rgba(0,0,0,0.1);
        overflow: hidden;
        max-width: 900px;
        margin: 0 auto;
    }

    .detail-card-header {
        background: linear-gradient(135deg, #06b6d4 0%, #3b82f6 100%);
        color: white;
        padding: 2rem;
    }

    .detail-title {
        display: flex;
        align-items: start;
        gap: 1rem;
        margin-bottom: 1rem;
    }

    .detail-title h1 {
        margin: 0;
        font-size: 2rem;
        font-weight: 700;
        flex: 1;
    }

    .status-badge-large {
        padding: 0.5rem 1rem;
        border-radius: 9999px;
        font-size: 0.875rem;
        font-weight: 600;
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        background-color: rgba(255, 255, 255, 0.2);
    }

    .detail-meta {
        display: flex;
        gap: 2rem;
        flex-wrap: wrap;
        opacity: 0.95;
    }

    .meta-item {
        display: flex;
        align-items: center;
        gap: 0.5rem;
        font-size: 0.875rem;
    }

    .detail-card-body {
        padding: 2rem;
    }

    .info-section {
        margin-bottom: 2rem;
    }

    .info-section-title {
        font-weight: 600;
        color: #374151;
        margin-bottom: 1rem;
        display: flex;
        align-items: center;
        gap: 0.5rem;
        font-size: 1.125rem;
    }

    .info-content {
        background-color: #f9fafb;
        padding: 1.5rem;
        border-radius: 0.5rem;
        border: 1px solid #e5e7eb;
        color: #4b5563;
        line-height: 1.6;
    }

    .info-content.empty {
        color: #9ca3af;
        font-style: italic;
    }

    .detail-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
        gap: 1.5rem;
        margin-bottom: 2rem;
    }

    .detail-item {
        background-color: #f9fafb;
        padding: 1.25rem;
        border-radius: 0.5rem;
        border: 1px solid #e5e7eb;
    }

    .detail-item-label {
        font-size: 0.75rem;
        text-transform: uppercase;
        letter-spacing: 0.05em;
        color: #6b7280;
        font-weight: 600;
        margin-bottom: 0.5rem;
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }

    .detail-item-value {
        font-size: 1.125rem;
        font-weight: 600;
        color: #111827;
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }

    .priority-badge-large {
        padding: 0.5rem 1rem;
        border-radius: 0.375rem;
        font-size: 0.875rem;
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

    .action-bar {
        display: flex;
        gap: 1rem;
        padding-top: 2rem;
        border-top: 2px solid #f3f4f6;
        flex-wrap: wrap;
    }

    .btn-action {
        flex: 1;
        min-width: 150px;
        padding: 0.75rem 1.5rem;
        border-radius: 0.5rem;
        font-weight: 600;
        border: none;
        cursor: pointer;
        transition: all 0.2s;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 0.5rem;
    }

    .btn-back {
        background-color: #f3f4f6;
        color: #374151;
    }

    .btn-back:hover {
        background-color: #e5e7eb;
    }

    .btn-edit {
        background-color: #8b5cf6;
        color: white;
    }

    .btn-edit:hover {
        background-color: #7c3aed;
        transform: translateY(-1px);
    }

    .btn-toggle {
        background-color: #10b981;
        color: white;
    }

    .btn-toggle:hover {
        background-color: #059669;
        transform: translateY(-1px);
    }

    .btn-delete {
        background-color: #ef4444;
        color: white;
        text-decoration: none;
    }

    .btn-delete:hover {
        background-color: #dc2626;
        transform: translateY(-1px);
        color: white;
    }

    .alert-overdue {
        background-color: #fee2e2;
        border-left: 4px solid #dc2626;
        padding: 1rem;
        border-radius: 0.5rem;
        margin-bottom: 1.5rem;
        display: flex;
        align-items: center;
        gap: 0.75rem;
        color: #991b1b;
    }

    .alert-overdue i {
        font-size: 1.5rem;
    }

    .timestamps {
        display: flex;
        gap: 2rem;
        padding: 1rem;
        background-color: #f9fafb;
        border-radius: 0.5rem;
        font-size: 0.875rem;
        color: #6b7280;
        flex-wrap: wrap;
    }

    .timestamp-item {
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }
</style>

<div class="detail-card">
    <div class="detail-card-header">
        <div class="detail-title">
            <h1>{{ $todo->title }}</h1>
            @if($todo->is_completed)
                <span class="status-badge-large">
                    <i class="bi bi-check-circle-fill"></i> Completed
                </span>
            @else
                <span class="status-badge-large">
                    <i class="bi bi-clock"></i> Pending
                </span>
            @endif
        </div>
        <div class="detail-meta">
            <div class="meta-item">
                <i class="bi bi-person-circle"></i>
                <span>{{ $todo->user->name }}</span>
            </div>
            <div class="meta-item">
                <i class="bi bi-calendar-event"></i>
                <span>Due {{ $todo->due_date->format('M d, Y') }}</span>
            </div>
            <div class="meta-item">
                <i class="bi bi-clock-history"></i>
                <span>Created {{ $todo->created_at->diffForHumans() }}</span>
            </div>
        </div>
    </div>

    <div class="detail-card-body">
        {{-- Overdue Alert --}}
        @if(!$todo->is_completed && $todo->due_date && $todo->due_date < now())
            <div class="alert-overdue">
                <i class="bi bi-exclamation-triangle-fill"></i>
                <div>
                    <strong>This task is overdue!</strong>
                    <div>Due date was {{ $todo->due_date->diffForHumans() }}</div>
                </div>
            </div>
        @endif

        {{-- Detail Grid --}}
        <div class="detail-grid">
            <div class="detail-item">
                <div class="detail-item-label">
                    <i class="bi bi-flag"></i>
                    Priority
                </div>
                <div class="detail-item-value">
                    <span class="priority-badge-large priority-{{ $todo->priority }}">
                        {{ ucfirst($todo->priority) }}
                    </span>
                </div>
            </div>

            <div class="detail-item">
                <div class="detail-item-label">
                    <i class="bi bi-calendar-check"></i>
                    Due Date
                </div>
                <div class="detail-item-value">
                        {{ $todo->due_date->format('F d, Y') }}
                        <small class="text-muted">({{ $todo->due_date->diffForHumans() }})</small>
                </div>
            </div>

            <div class="detail-item">
                <div class="detail-item-label">
                    <i class="bi bi-check-square"></i>
                    Status
                </div>
                <div class="detail-item-value">
                    @if($todo->is_completed)
                        <i class="bi bi-check-circle-fill text-success"></i>
                        <span class="text-success">Completed</span>
                    @else
                        <i class="bi bi-clock text-warning"></i>
                        <span class="text-warning">Pending</span>
                    @endif
                </div>
            </div>
        </div>

        {{-- Description Section --}}
        <div class="info-section">
            <div class="info-section-title">
                <i class="bi bi-text-paragraph"></i>
                Description
            </div>
            <div class="info-content {{ $todo->description ? '' : 'empty' }}">
            </div>
        </div>

        {{-- Timestamps --}}
        <div class="timestamps">
            <div class="timestamp-item">
                <i class="bi bi-plus-circle"></i>
                <span>Created: {{ $todo->created_at->format('M d, Y \a\t g:i A') }}</span>
            </div>
            @if($todo->updated_at != $todo->created_at)
                <div class="timestamp-item">
                    <i class="bi bi-pencil-square"></i>
                    <span>Last updated: {{ $todo->updated_at->format('M d, Y \a\t g:i A') }}</span>
                </div>
            @endif
        </div>

        {{-- Action Bar --}}
        <div class="action-bar">
            <a href="{{ route('todos.index') }}" class="btn-action btn-back">
                <i class="bi bi-arrow-left"></i> Back to List
            </a>

            <form method="POST" action="{{ route('todos.toggle', $todo->id) }}" style="flex: 1; min-width: 150px;">
                @csrf
                @method('PATCH')
                <button type="submit" class="btn-action btn-toggle" style="width: 100%;">
                    <i class="bi bi-{{ $todo->is_completed ? 'arrow-counterclockwise' : 'check2' }}"></i>
                    {{ $todo->is_completed ? 'Mark as Pending' : 'Mark as Complete' }}
                </button>
            </form>

            <a href="{{ route('todos.edit', $todo->id) }}" class="btn-action btn-edit">
                <i class="bi bi-pencil"></i> Edit
            </a>

            <form method="POST" action="{{ route('todos.destroy', $todo->id) }}" style="flex: 1; min-width: 150px; margin: 0;">
                @csrf
                @method('DELETE')
                <button type="submit"
                        class="btn-action btn-delete"
                        onclick="return confirm('Are you sure you want to delete this todo? This action cannot be undone.')"
                        style="width: 100%; height: 100%;">
                    <i class="bi bi-trash"></i> Delete
                </button>
            </form>
        </div>
    </div>
</div>
@endsection
