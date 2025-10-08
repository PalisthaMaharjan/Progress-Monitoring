@extends('layouts.app')

@section('title', 'Edit Project')

@section('content')
<div class="container-fluid mx-auto">
    <div class="mb-4">
        <h2 class="h2 fw-bold text-dark mb-2">Edit Project</h2>
        <p class="text-muted">Update project information</p>
    </div>

    <div class="card">
        <div class="card-body">
            <form action="{{ route('projects.update', $project) }}" method="POST">
                @csrf
                @method('PUT')
                @include('projects._form')

                <div class="d-flex gap-3 mt-4">
                    <button type="submit" class="btn btn-primary px-4 py-2">
                        Update Project
                    </button>
                    <a href="{{ route('projects.index') }}" class="btn btn-outline-primary px-4 py-2">
                        Cancel
                    </a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
