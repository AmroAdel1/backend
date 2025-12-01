@extends('layouts.app')

@section('title') Edit Post @endsection
@section('content')

<div class="mb-3">
    <a href="{{ route('posts.index') }}" class="btn btn-outline-secondary">
        <i class="fa fa-arrow-left"></i> Back to Posts
    </a>
</div>

<h1 class="page-title">
    <i class="fa fa-edit"></i> Edit Post
</h1>

@if ($errors->any())
    <div class="alert alert-danger">
        <h5><i class="fa fa-exclamation-triangle"></i> Please fix the following errors:</h5>
        <ul style="margin: 0.5rem 0 0 1.5rem;">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<div class="card">
    <div class="card-header">
        <i class="fa fa-pen"></i> Update Post Details
    </div>
    <div class="card-body">
        <form method="post" action="{{ route('posts.update', $post->id) }}">
            @csrf
            @method('PUT')

            <div class="mb-3">
                <label class="form-label">
                    <i class="fa fa-heading"></i> Title <span style="color: #ef4444;">*</span>
                </label>
                <input
                    type="text"
                    class="form-control"
                    name="title"
                    value="{{ old('title', $post->title) }}">
            </div>

            <div class="mb-3">
                <label class="form-label">
                    <i class="fa fa-align-left"></i> Description <span style="color: #ef4444;">*</span>
                </label>
                <textarea
                    class="form-control"
                    rows="6"
                    name="desc">{{ old('desc', $post->description) }}</textarea>
            </div>

            <div class="mb-4">
                <label class="form-label">
                    <i class="fa fa-user"></i> Post Created By <span style="color: #ef4444;">*</span>
                </label>
                <select class="form-select" name="posted_by">
                    <option value="">-- Select Author --</option>
                    @foreach($users as $user)
                        <option @selected(old('posted_by', $post->user_id) == $user->id) value="{{ $user->id }}">
                            {{ $user->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div style="display: flex; gap: 0.75rem; flex-wrap: wrap;">
                <button type="submit" class="btn btn-primary">
                    <i class="fa fa-save"></i> Update Post
                </button>
                <a href="{{ route('posts.show', $post->id) }}" class="btn btn-success">
                    <i class="fa fa-eye"></i> View Post
                </a>
                <a href="{{ route('posts.index') }}" class="btn btn-secondary">
                    <i class="fa fa-times"></i> Cancel
                </a>
            </div>
        </form>
    </div>
</div>

@endsection
