@extends("layouts.app")

@section("title") Create Todo @endsection

@section("content")
<style>
    .form-card {
        background: white;
        border-radius: 0.5rem;
        box-shadow: 0 1px 3px rgba(0,0,0,0.1);
        overflow: hidden;
        max-width: 800px;
        margin: 0 auto;
    }

    .form-card-header {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
        padding: 2rem;
        text-align: center;
    }

    .form-card-header h1 {
        margin: 0;
        font-size: 1.875rem;
        font-weight: 700;
    }

    .form-card-header p {
        margin: 0.5rem 0 0;
        opacity: 0.9;
    }

    .form-card-body {
        padding: 2rem;
    }

    .form-group {
        margin-bottom: 1.5rem;
    }

    .form-label {
        font-weight: 600;
        color: #374151;
        margin-bottom: 0.5rem;
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }

    .form-label i {
        color: #6b7280;
    }

    .form-control, .form-select {
        border: 2px solid #e5e7eb;
        border-radius: 0.5rem;
        padding: 0.75rem;
        font-size: 1rem;
        transition: all 0.2s;
    }

    .form-control:focus, .form-select:focus {
        border-color: #667eea;
        box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1);
        outline: none;
    }

    .form-control.is-invalid, .form-select.is-invalid {
        border-color: #ef4444;
    }

    .invalid-feedback {
        color: #ef4444;
        font-size: 0.875rem;
        margin-top: 0.25rem;
        display: flex;
        align-items: center;
        gap: 0.25rem;
    }

    .form-text {
        font-size: 0.875rem;
        color: #6b7280;
        margin-top: 0.25rem;
    }

    .priority-option {
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }

    .priority-indicator {
        width: 12px;
        height: 12px;
        border-radius: 50%;
    }

    .priority-low { background-color: #3b82f6; }
    .priority-medium { background-color: #f59e0b; }
    .priority-high { background-color: #ef4444; }

    .btn-group-actions {
        display: flex;
        gap: 1rem;
        margin-top: 2rem;
        padding-top: 2rem;
        border-top: 2px solid #f3f4f6;
    }

    .btn-primary {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        border: none;
        padding: 0.75rem 2rem;
        font-weight: 600;
        flex: 1;
    }

    .btn-primary:hover {
        transform: translateY(-1px);
        box-shadow: 0 4px 12px rgba(102, 126, 234, 0.4);
    }

    .btn-secondary {
        background-color: #f3f4f6;
        color: #374151;
        border: none;
        padding: 0.75rem 2rem;
        font-weight: 600;
    }

    .btn-secondary:hover {
        background-color: #e5e7eb;
        color: #1f2937;
    }

    .required {
        color: #ef4444;
    }
</style>

<div class="form-card">
    <div class="form-card-header">
        <h1><i class="bi bi-plus-circle"></i> Create New Todo</h1>
        <p>Add a new task to stay organized</p>
    </div>

    <div class="form-card-body">
        <form method="POST" action="{{ route('todos.store') }}">
            @csrf

            {{-- Title Field --}}
            <div class="form-group">
                <label for="title" class="form-label">
                    <i class="bi bi-card-text"></i>
                    Title <span class="required">*</span>
                </label>
                <input type="text"
                       class="form-control @error('title') is-invalid @enderror"
                       id="title"
                       name="title"
                       placeholder="e.g., Finish project proposal"
                       value="{{ old('title') }}"
                       autofocus>
                @error('title')
                    <div class="invalid-feedback">
                        <i class="bi bi-exclamation-circle"></i> {{ $message }}
                    </div>
                @enderror
            </div>

            {{-- Description Field --}}
            <div class="form-group">
                <label for="description" class="form-label">
                    <i class="bi bi-text-paragraph"></i>
                    Description <span class="required">*</span>
                </label>
                <textarea class="form-control @error('description') is-invalid @enderror"
                          id="description"
                          name="description"
                          rows="4"
                          placeholder="Add more details about this task...">{{ old('description') }}</textarea>
                @error('description')
                    <div class="invalid-feedback">
                        <i class="bi bi-exclamation-circle"></i> {{ $message }}
                    </div>
                @enderror
            </div>

            <div class="row">
                {{-- Due Date Field --}}
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="due_date" class="form-label">
                            <i class="bi bi-calendar-event"></i>
                            Due Date <span class="required">*</span>
                        </label>
                        <input type="date"
                               class="form-control @error('due_date') is-invalid @enderror"
                               id="due_date"
                               name="due_date"
                               value="{{ old('due_date') }}"
                               min="{{ date('Y-m-d') }}">    <!-- Set the minimum date to today's date -->
                        @error('due_date')
                            <div class="invalid-feedback">
                                <i class="bi bi-exclamation-circle"></i> {{ $message }}
                            </div>
                        @enderror
                    </div>
                </div>

                {{-- Priority Field --}}
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="priority" class="form-label">
                            <i class="bi bi-flag"></i>
                            Priority <span class="required">*</span>
                        </label>
                        <select class="form-select @error('priority') is-invalid @enderror"
                                id="priority"
                                name="priority">
                            <option value="low" {{ old('priority') == 'low' ? 'selected' : '' }}>
                                🔵 Low Priority
                            </option>
                            <option value="medium" {{ old('priority', 'medium') == 'medium' ? 'selected' : '' }}>
                                🟡 Medium Priority
                            </option>
                            <option value="high" {{ old('priority') == 'high' ? 'selected' : '' }}>
                                🔴 High Priority
                            </option>
                        </select>
                        @error('priority')
                            <div class="invalid-feedback">
                                <i class="bi bi-exclamation-circle"></i> {{ $message }}
                            </div>
                        @enderror
                    </div>
                </div>
            </div>

            {{-- Action Buttons --}}
            <div class="btn-group-actions">
                <a href="{{ route('todos.index') }}" class="btn btn-secondary">
                    <i class="bi bi-x-circle"></i> Cancel
                </a>
                <button type="submit" class="btn btn-primary">
                    <i class="bi bi-check-circle"></i> Create Todo
                </button>
            </div>
        </form>
    </div>
</div>

@push('scripts')
<script>
    // Auto-resize textarea
    const textarea = document.getElementById('description');   // for better UX
    if (textarea) {
        textarea.addEventListener('input', function() {
            this.style.height = 'auto';
            this.style.height = (this.scrollHeight) + 'px';
        });
    }
</script>
@endpush
@endsection
