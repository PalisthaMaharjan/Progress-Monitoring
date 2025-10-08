@extends('layouts.app')

@section('title', 'Project Details')

@section('content')
<div class="container-fluid mx-auto">
    <div class="mb-4">
        <h2 class="h2 fw-bold text-dark mb-2">Project Details</h2>
        <p class="text-muted">View project information</p>
    </div>

    <div class="card">
        <div class="card-body">
            <div class="row g-3">
                <div class="col-md-6">
                    <div class="p-3 bg-light rounded">
                        <strong class="text-dark">ID:</strong>
                        <span class="ms-2 text-muted">{{ $project->id }}</span>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="p-3 bg-light rounded">
                        <strong class="text-dark">Title:</strong>
                        <span class="ms-2 text-muted">{{ $project->title }}</span>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="p-3 bg-light rounded">
                        <strong class="text-dark">Sub Title:</strong>
                        <span class="ms-2 text-muted">{{ $project->sub_title }}</span>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="p-3 bg-light rounded">
                        <strong class="text-dark">Project ID:</strong>
                        <span class="ms-2 text-muted">{{ $project->project_id }}</span>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="p-3 bg-light rounded">
                        <strong class="text-dark">Location:</strong>
                        <span class="ms-2 text-muted">{{ $project->location }}</span>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="p-3 bg-light rounded">
                        <strong class="text-dark">Voltage:</strong>
                        <span class="ms-2 text-muted">{{ $project->voltage }}</span>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="p-3 bg-light rounded">
                        <strong class="text-dark">Status:</strong>
                        <span class="ms-2 text-muted">{{ $project->status }}</span>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="p-3 bg-light rounded">
                        <strong class="text-dark">Created At:</strong>
                        <span class="ms-2 text-muted">{{ $project->created_at }}</span>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="p-3 bg-light rounded">
                        <strong class="text-dark">Updated At:</strong>
                        <span class="ms-2 text-muted">{{ $project->updated_at }}</span>
                    </div>
                </div>
            </div>

            <div class="d-flex gap-3 mt-4">
                <a href="{{ route('projects.edit', $project) }}" class="btn btn-primary px-4 py-2">
                    Edit Project
                </a>
                <a href="{{ route('projects.index') }}" class="btn btn-outline-primary px-4 py-2">
                    Back to Projects
                </a>
            </div>
        </div>
    </div>
</div>
@endsection
