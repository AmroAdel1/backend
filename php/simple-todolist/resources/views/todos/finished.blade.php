@extends("layouts.app")

@section("title") Completed Todos @endsection

@section("content")
<style>
    .page-header {
        margin-bottom: 2rem;
    }

    .finished-card {
        background: white;
        border-radius: 0.5rem;
        box-shadow: 0 1px 3px rgba(0,0,0,0.1);
        overflow: hidden;
    }

    .finished-card-header {
        background: linear-gradient(135deg, #10b981 0%, #059669 100%);
        color: white;
        padding: 1.5rem;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    .header-content h2 {
        margin: 0;
        font-size: 1.875rem;
        font-weight: 700;
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }

    .header-content p {
        margin: 0.5rem 0 0;
        opacity: 0.9;
        font-size: 0.875rem;
    }

    .completion-stats {
        text-align: right;
    }

    .completion-stats .big-number {
        font-size: 2.5rem;
        font-weight: 700;
        line-height: 1;
    }

    .completion-stats .label {
        font-size: 0.875rem;
        opacity: 0.9;
    }

    .filter-bar {
        background-color: #f9fafb;
        padding: 1rem 1.5rem;
        border-bottom: 1px solid #e5e7eb;
        display: flex;
        justify-content: space-between;
        align-items: center;
        flex-wrap: wrap;
        gap: 1rem;
    }

    .filter-group {
        display: flex;
        gap: 0.5rem;
        align-items: center;
    }

    .filter-btn {
        padding: 0.5rem 1rem;
        border: 2px solid #e5e7eb;
        background-color: white;
        color: #6b7280;
        border-radius: 0.375rem;
        font-size: 0.875rem;
        font-weight: 500;
        cursor: pointer;
        transition: all 0.2s;
    }

    .filter-btn:hover {
        border-color: #10b981;
        color: #10b981;
    }

    .filter-btn.active {
        background-color: #10b981;
        border-color: #10b981;
        color: white;
    }

    .todo-list {
        padding: 1.5rem;
    }

    .todo-item {
        background-color: #f9fafb;
        border: 2px solid #e5e7eb;
        border-radius: 0.5rem;
        padding: 1.25rem;
        margin-bottom: 1rem;
        transition: all 0.2s;
        position: relative;
        overflow: hidden;
    }

    .todo-item:hover {
        border-color: #10b981;
        box-shadow: 0 4px 6px rgba(16, 185, 129, 0.1);
        transform: translateY(-2px);
    }

    .todo-item::before {
        content: '';
        position: absolute;
        left: 0;
        top: 0;
        bottom: 0;
        width: 4px;
        background: linear-gradient(180deg, #10b981 0%, #059669 100%);
    }

    .todo-item-header {
        display: flex;
        justify-content: space-between;
        align-items: start;
        margin-bottom: 0.75rem;
        gap: 1rem;
    }

    .todo-item-title {
        display: flex;
        align-items: start;
        gap: 0.75rem;
        flex: 1;
    }

    .checkmark {
        width: 24px;
        height: 24px;
        background-color: #10b981;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        flex-shrink: 0;
        margin-top: 0.125rem;
    }

    .todo-title-text {
        flex: 1;
    }

    .todo-title-text h3 {
        margin: 0 0 0.25rem;
        font-size: 1.125rem;
        font-weight: 600;
        color: #111827;
        text-decoration: line-through;
        opacity: 0.7;
    }

    .completion-date {
        font-size: 0.875rem;
        color: #059669;
        font-weight: 500;
        display: flex;
        align-items: center;
        gap: 0.25rem;
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

    .todo-item-description {
        color: #6b7280;
        font-size: 0.875rem;
        line-height: 1.5;
        margin-bottom: 0.75rem;
        padding-left: 2rem;
        text-decoration: line-through;
        opacity: 0.7;
    }

    .todo-item-footer {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding-left: 2rem;
        flex-wrap: wrap;
        gap: 0.5rem;
    }

    .todo-meta {
        display: flex;
        gap: 1.5rem;
        font-size: 0.875rem;
        color: #6b7280;
        flex-wrap: wrap;
    }

    .meta-item {
        display: flex;
        align-items: center;
        gap: 0.375rem;
    }

    .todo-actions {
        display: flex;
        gap: 0.5rem;
    }

    .action-btn {
        padding: 0.375rem 0.75rem;
        border-radius: 0.375rem;
        font-size: 0.875rem;
        border: none;
        cursor: pointer;
        transition: all 0.2s;
        display: flex;
        align-items: center;
        gap: 0.375rem;
        font-weight: 500;
    }

    .btn-view {
        background-color: #3b82f6;
        color: white;
    }

    .btn-view:hover {
        background-color: #2563eb;
    }

    .btn-undo {
        background-color: #f59e0b;
        color: white;
    }

    .btn-undo:hover {
        background-color: #d97706;
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
        font-size: 5rem;
        color: #d1d5db;
        margin-bottom: 1rem;
    }

    .empty-state h3 {
        color: #6b7280;
        margin-bottom: 0.5rem;
        font-size: 1.5rem;
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

    .achievement-banner {
        background: linear-gradient(135deg, #fbbf24 0%, #f59e0b 100%);
        color: white;
        padding: 1rem 1.5rem;
        border-radius: 0.5rem;
        margin-bottom: 1.5rem;
        display: flex;
        align-items: center;
        gap: 1rem;
        box-shadow: 0 4px 6px rgba(245, 158, 11, 0.3);
    }

    .achievement-banner i {
        font-size: 2rem;
    }

    .achievement-banner .content {
        flex: 1;
    }

    .achievement-banner h4 {
        margin: 0 0 0.25rem;
        font-size: 1.125rem;
        font-weight: 700;
    }

    .achievement-banner p {
        margin: 0;
        font-size: 0.875rem;
        opacity: 0.9;
    }

    @media (max-width: 768px) {
    .filter-btn {
        padding: 0.5rem 0.75rem;
        font-size: 0.813rem;
    }

    .filter-btn i {
        font-size: 1rem;
    }
}

    @media (max-width: 480px) {
        .filter-group {
            width: 100%;
        }

        .filter-btn {
            flex: 1;
            justify-content: center;
            min-width: 0;
        }
    }
</style>

{{-- Achievement Banner for high completion rate --}}
@if($completedTodos->count() >= 3)   <!-- 5 -->
<div class="achievement-banner">
    <i class="bi bi-trophy-fill"></i>
    <div class="content">
        <h4>🎉 Great Job!</h4>
        <p>You've completed {{ $completedTodos->count() }} task{{ $completedTodos->count() > 1 ? 's' : '' }}. Keep up the excellent work!</p>
    </div>
</div>
@endif

<div class="finished-card">
    <div class="finished-card-header">
        <div class="header-content">
            <h2>
                <i class="bi bi-check-circle-fill"></i>
                Completed Todos
            </h2>
            <p>Your accomplishments and finished tasks</p>
        </div>
        <div class="completion-stats">
            <div class="big-number">{{ $completedTodos->count() }}</div>
            <div class="label">Completed</div>
        </div>
    </div>

    <div class="filter-bar">
        <div class="filter-group">
            <span style="font-size: 0.875rem; color: #6b7280; font-weight: 500;">Sort by:</span>
            <button class="filter-btn active recent">
                <i class="bi bi-clock-history "></i> Recent
            </button>
            <button class="filter-btn priority">
                <i class="bi bi-flag"></i> Priority
            </button>
            <button class="filter-btn due-date">
                <i class="bi bi-calendar"></i> Due Date
            </button>
        </div>
        <a href="{{ route('todos.index') }}" class="btn btn-sm btn-outline-success">
            <i class="bi bi-arrow-left"></i> Back to All Todos
        </a>
    </div>

    <div class="todo-list" id="todo-list">
        @if($completedTodos->count() > 0)
            @foreach ($completedTodos as $todo)
                <div class="todo-item"
                    data-priority="{{ $todo->priority }}"
                    data-priority-value="{{ $todo->priority === 'high' ? 3 : ($todo->priority === 'medium' ? 2 : 1) }}"
                    data-due-date="{{ $todo->due_date ? $todo->due_date->format('Y-m-d') : '9999-12-31' }}"
                    data-updated="{{ $todo->updated_at->timestamp }}">
                    <div class="todo-item-header">
                        <div class="todo-item-title">
                            <div class="checkmark">
                                <i class="bi bi-check-lg"></i>
                            </div>
                            <div class="todo-title-text">
                                <h3>{{ $todo->title }}</h3>
                                <div class="completion-date">
                                    <i class="bi bi-check-circle"></i>
                                    Completed {{ $todo->updated_at->diffForHumans() }}
                                </div>
                            </div>
                        </div>
                        <span class="priority-badge priority-{{ $todo->priority }}">
                            {{ ucfirst($todo->priority) }}
                        </span>
                    </div>

                    {{-- @if($todo->description) --}}
                    <div class="todo-item-description">
                        {{ Str::limit($todo->description, 120) }}
                    </div>
                    {{-- @endif --}}

                    <div class="todo-item-footer">
                        <div class="todo-meta">
                            {{-- @if($todo->due_date) --}}
                            <div class="meta-item">
                                <i class="bi bi-calendar-check"></i>
                                <span>Due: {{ $todo->due_date->format('M d, Y') }}</span>
                            </div>
                            {{-- @endif --}}
                            <div class="meta-item">
                                <i class="bi bi-clock"></i>
                                <span>Created {{ $todo->created_at->diffForHumans() }}</span>
                            </div>
                        </div>

                        <div class="todo-actions">
                            <a href="{{ route('todos.show', $todo->id) }}" class="action-btn btn-view" title="View Details">
                                <i class="bi bi-eye"></i>
                            </a>

                            <form method="POST" action="{{ route('todos.toggle', $todo->id) }}" style="display: inline;">
                                @csrf
                                @method('PATCH')
                                <button type="submit" class="action-btn btn-undo" title="Mark as Incomplete">
                                    <i class="bi bi-arrow-counterclockwise"></i>
                                </button>
                            </form>

                            <form method="POST" action="{{ route('todos.destroy', $todo->id) }}" style="display: inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit"
                                        class="action-btn btn-delete"
                                        onclick="return confirm('Are you sure you want to delete this completed todo?')"
                                        title="Delete">
                                    <i class="bi bi-trash"></i>
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            @endforeach
        @else
            <div class="empty-state">
                <i class="bi bi-clipboard-check"></i>
                <h3>No completed todos yet</h3>
                <p>Start checking off your tasks to see them here!</p>
                <a href="{{ route('todos.index') }}" class="btn btn-success">
                    <i class="bi bi-list-task"></i> View All Todos
                </a>
            </div>
        @endif
    </div>
</div>

@push('scripts')
<script>
    const todoList = document.getElementById('todo-list');

    document.querySelectorAll('.filter-btn').forEach(btn => {
        btn.addEventListener('click', function() {
            // Update active button
            document.querySelectorAll('.filter-btn').forEach(b => b.classList.remove('active'));
            this.classList.add('active');

            // Sort based on button class
            if(this.classList.contains('recent')) {
                sortByRecent();
            }
            else if(this.classList.contains('priority')) {
                sortByPriority();
            }
            else if(this.classList.contains('due-date')) {
                sortByDueDate();
            }
        });
    });

    function sortByRecent() {
        const items = Array.from(document.querySelectorAll('.todo-item'));
        const sorted = items.sort((a, b) => {
            const timeA = parseInt(a.dataset.updated);     // dataset is a custom attribute // access all custom attributes
            const timeB = parseInt(b.dataset.updated);
            return timeB - timeA; // Most recent first
        });
        reorderItems(sorted);
    }

    function sortByPriority() {
        const items = Array.from(document.querySelectorAll('.todo-item'));
        const sorted = items.sort((a, b) => {
            const priorityA = parseInt(a.dataset.priorityValue);
            const priorityB = parseInt(b.dataset.priorityValue);
            return priorityB - priorityA; // High to low
        });
        reorderItems(sorted);
    }

    function sortByDueDate() {
        const items = Array.from(document.querySelectorAll('.todo-item'));
        const sorted = items.sort((a, b) => {
            const dateA = a.dataset.dueDate;
            const dateB = b.dataset.dueDate;
            return dateA.localeCompare(dateB); // Earliest first
        });
        reorderItems(sorted);
    }

    function reorderItems(sortedItems) {
        sortedItems.forEach(item => {
            todoList.appendChild(item);
        });
    }
    // // Simple filter button interaction (for demonstration)
    // document.querySelectorAll('.filter-btn').forEach(btn => {
    //     //console.log('Setting up listener for:', btn.textContent);
    //     btn.addEventListener('click', function() {      // click button to run function and display its properties
    //         //console.log('🔥 BUTTON CLICKED! 🔥');
    //         document.querySelectorAll('.filter-btn').forEach(b => b.classList.remove('active'));
    //         this.classList.add('active');
    //         console.log(btn);
    //         console.dir(btn);   // display button properties
    //         //console.log('Active button:', btn);
    //         if(btn.classList.contains('recent')){}
    //         else if(btn.classList.contains('priority')){}
    //         else if(btn.classList.contains('due-date')){}
    //     });
    // });
    // //console.log('✅ All event listeners attached!');
</script>
@endpush
@endsection
