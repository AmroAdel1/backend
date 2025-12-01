@extends('layouts.app')

@section('title') View Post @endsection
@section('content')

<div class="mb-3" style="display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 1rem;">
    <a href="{{ route('posts.index') }}" class="btn btn-outline-secondary">
        <i class="fa fa-arrow-left"></i> Back to Posts
    </a>
    <div style="display: flex; gap: 0.5rem;">
        <a href="{{ route('posts.edit', $post->id) }}" class="btn btn-primary">
            <i class="fa fa-edit"></i> Edit Post
        </a>
        <form method="post" action="{{ route('posts.destroy', $post->id) }}" style="display:inline" onsubmit="return confirm('Are you sure you want to delete this post?');">
            @csrf
            @method('DELETE')
            <button type="submit" class="btn btn-danger">
                <i class="fa fa-trash"></i> Delete Post
            </button>
        </form>
    </div>
</div>

<h1 class="page-title">
    <i class="fa fa-newspaper"></i> Post Details
</h1>

<div class="card">
    <div class="card-header">
        <i class="fa fa-file-alt"></i> Post Information
    </div>
    <div class="card-body">
        <div class="post-meta">
            <span class="badge bg-primary">
                <i class="fa fa-hashtag"></i> ID: {{ $post->id }}
            </span>
            <span class="badge bg-success">
                <i class="fa fa-calendar"></i> {{ $post->created_at->format('M d, Y') }}
            </span>
            @if($post->created_at != $post->updated_at)
                <span class="badge bg-warning text-dark">
                    <i class="fa fa-edit"></i> Updated: {{ $post->updated_at->diffForHumans() }}
                </span>
            @endif
        </div>

        <h2 class="post-title">{{ $post->title }}</h2>

        <div class="post-description">
            <p>{{ $post->description }}</p>
        </div>
    </div>
</div>

<div class="card">
    <div class="card-header">
        <i class="fa fa-user-circle"></i> Author Information
    </div>
    <div class="card-body">
        @if($post->user)
            <div class="info-row">
                <span class="info-label">
                    <i class="fa fa-user"></i> Name:
                </span>
                <span class="info-value">{{ $post->user->name }}</span>
            </div>

            <div class="info-row">
                <span class="info-label">
                    <i class="fa fa-envelope"></i> Email:
                </span>
                <span class="info-value">
                    <a href="mailto:{{ $post->user->email }}" style="color: #667eea; text-decoration: none;">
                        {{ $post->user->email }}
                    </a>
                </span>
            </div>

            <div class="info-row" style="margin-bottom: 0;">
                <span class="info-label">
                    <i class="fa fa-clock"></i> Post Created:
                </span>
                <span class="info-value">
                    {{ $post->created_at->format('F d, Y \a\t g:i A') }}
                    <span style="color: #9ca3af;">({{ $post->created_at->diffForHumans() }})</span>
                </span>
            </div>
        @else
            <div class="empty-state" style="padding: 2rem;">
                <i class="fa fa-user-slash" style="font-size: 2.5rem;"></i>
                <p style="margin-top: 1rem;">Author information not available</p>
            </div>
        @endif
    </div>
</div>

@endsection
