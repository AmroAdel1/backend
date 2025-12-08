@extends("layouts.app")

@section("title") Edit Todo @endsection

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
        background: linear-gradient(135deg, #8b5cf6 0%, #ec4899 100%);
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
        border-color: #8b5cf6;
        box-shadow: 0 0 0 3px rgba(139, 92, 246, 0.1);
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

    .form-check {
        padding: 1rem;
        background-color: #f9fafb;
        border-radius: 0.5rem;
        border: 2px solid #e5e7eb;
        display: flex;
        align-items: center;
        gap: 0.75rem;
        transition: all 0.2s;
        padding-left: 1.95rem; /* Add a bit more left padding */
    }

    .form-check-input {
        width: 1.5rem;
        height: 1.5rem;
        cursor: pointer;
        margin: 0; /* Remove default margin */
        flex-shrink: 0; /* Prevent checkbox from shrinking */
    }

    .form-check-input:checked {
        background-color: #10b981;
        border-color: #10b981;
    }

    .form-check-label {
        font-weight: 500;
        color: #374151;
        cursor: pointer;
        margin: 0;
        display: flex;
        align-items: center;
        gap: 0.5rem;
        flex: 1; /* Make label take full width so it's easier to click */
    }

    .form-check-label:hover {
        color: #1f2937; /* Slight color change on hover */
    }

    .btn-group-actions {
        display: flex;
        gap: 1rem;
        margin-top: 2rem;
        padding-top: 2rem;
        border-top: 2px solid #f3f4f6;
    }

    .btn-primary {
        background: linear-gradient(135deg, #8b5cf6 0%, #ec4899 100%);
        border: none;
        padding: 0.75rem 2rem;
        font-weight: 600;
        flex: 1;
    }

    .btn-primary:hover {
        transform: translateY(-1px);
        box-shadow: 0 4px 12px rgba(139, 92, 246, 0.4);
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

    .info-box {
        background-color: #dbeafe;
        border-left: 4px solid #3b82f6;
        padding: 1rem;
        border-radius: 0.5rem;
        margin-bottom: 1.5rem;
    }

    .info-box p {
        margin: 0;
        color: #1e40af;
        font-size: 0.875rem;
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }
</style>

<div class="form-card">
    <div class="form-card-header">
        <h1><i class="bi bi-pencil-square"></i> Edit Todo</h1>
        <p>Update your task details</p>
    </div>

    <div class="form-card-body">
        <form method="POST" action="{{ route('todos.update', $todo->id) }}">
            @csrf
            @method('PUT')

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
                       placeholder="Enter todo title"
                       value="{{ old('title', $todo->title) }}">
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
                          placeholder="Add more details about this task...">{{ old('description', $todo->description) }}</textarea>
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
                               value="{{ old('due_date', $todo->due_date?->format('Y-m-d')) }}">  <!-- Set the value to the existing due date if it exists -->
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
                            <option value="low" {{ old('priority', $todo->priority) == 'low' ? 'selected' : '' }}>
                                🔵 Low Priority
                            </option>
                            <option value="medium" {{ old('priority', $todo->priority) == 'medium' ? 'selected' : '' }}>
                                🟡 Medium Priority
                            </option>
                            <option value="high" {{ old('priority', $todo->priority) == 'high' ? 'selected' : '' }}>
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

            {{-- Completion Status --}}
            <div class="form-group">
                <div class="form-check">
                    <input class="form-check-input"
                           type="checkbox"
                           id="is_completed"
                           name="is_completed"
                           value="1"
                           {{ old('is_completed', $todo->is_completed) ? 'checked' : '' }}>  <!-- Set the value to 1 to indicate completion -->
                    <label class="form-check-label" for="is_completed">
                        <i class="bi bi-check-circle"></i>
                        Mark this todo as completed
                    </label>
                </div>
            </div>

            {{-- Action Buttons --}}
            <div class="btn-group-actions">
                <a href="{{ route('todos.index') }}" class="btn btn-secondary">
                    <i class="bi bi-x-circle"></i> Cancel
                </a>
                <button type="submit" class="btn btn-primary">
                    <i class="bi bi-save"></i> Update Todo
                </button>
            </div>
        </form>
    </div>
</div>

@push('scripts')
<script>
    // Auto-resize textarea
    const textarea = document.getElementById('description');
    if (textarea) {
        textarea.addEventListener('input', function() {
            this.style.height = 'auto';
            this.style.height = (this.scrollHeight) + 'px';
        });
        // Trigger once on load
        textarea.dispatchEvent(new Event('input'));
    }
</script>
@endpush
@endsection
