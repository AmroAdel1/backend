@extends('layouts.app')

@section('title') All Posts @endsection
@section('content')

<h1 class="page-title">
    <i class="fa fa-newspaper"></i> All Blog Posts
</h1>

<div class="mb-3">
    <a href="{{ route('posts.create') }}" class="btn btn-success">
        <i class="fa fa-plus-circle"></i> Create New Post
    </a>
</div>

@if($posts->isEmpty())
    <div class="empty-state">
        <i class="fa fa-inbox"></i>
        <h3>No posts yet</h3>
        <p>Create your first blog post to get started!</p>
        <a href="{{ route('posts.create') }}" class="btn btn-success mt-3">
            <i class="fa fa-plus-circle"></i> Create First Post
        </a>
    </div>
@else
    <div class="table-responsive">
        <table class="table">
            <thead>
                <tr>
                    <th>#</th>
                    <th>TITLE</th>
                    <th>POSTED BY</th>
                    <th>CREATED AT</th>
                    <th>ACTIONS</th>
                </tr>
            </thead>
            <tbody>
                @foreach($posts as $post)
                    <tr>
                        <td><strong>{{ $post->id }}</strong></td>
                        <td><strong>{{ $post->title }}</strong></td>
                        <td>
                            <i class="fa fa-user"></i> {{ $post->user ? $post->user->name : 'N/A' }}
                        </td>
                        <td>
                            <i class="fa fa-calendar"></i> {{ $post->created_at->format('M d, Y') }}
                        </td>
                        <td>
                            <div class="action-buttons">
                                <a href="{{ route('posts.show', $post->id) }}" class="btn btn-success btn-sm">
                                    <i class="fa fa-eye"></i> View
                                </a>
                                <a href="{{ route('posts.edit', $post->id) }}" class="btn btn-primary btn-sm">
                                    <i class="fa fa-edit"></i> Edit
                                </a>
                                <form method="post" action="{{ route('posts.destroy', $post->id) }}" style="display:inline" onsubmit="return confirm('Are you sure you want to delete this post?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm">
                                        <i class="fa fa-trash"></i> Delete
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <div class="mt-3" style="color: #6b7280; font-size: 0.9rem;">
        <i class="fa fa-info-circle"></i> Showing {{ $posts->count() }} post(s)
    </div>
@endif

@endsection
