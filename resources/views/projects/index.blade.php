@extends('layouts.app')

@section('title', 'Projects')

@section('content')
@if (session('success'))
	<div class="alert alert-success alert-dismissible fade show mb-4" role="alert">
		{{ session('success') }}
		<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
	</div>
@endif

<div class="d-flex justify-content-between align-items-center mb-4">
	<h1 class="h2 fw-bold text-dark m-0">Projects</h1>
	<a href="{{ route('projects.create') }}" class="btn btn-primary px-4 py-2">
		Create Project
	</a>
</div>

<div class="card">
	<div class="card-body p-0">
		<div class="table-responsive">
			<table class="table table-hover mb-0">
				<thead class="table-dark">
					<tr>
						<th class="table-header px-4 py-3">ID</th>
						<th class="table-header px-4 py-3">Title</th>
						<th class="table-header px-4 py-3">Sub Title</th>
						<th class="table-header px-4 py-3">Project ID</th>
						<th class="table-header px-4 py-3">Location</th>
						<th class="table-header px-4 py-3">Voltage</th>
						<th class="table-header px-4 py-3">Status</th>
						<th class="table-header px-4 py-3">Actions</th>
					</tr>
				</thead>
				<tbody>
					@forelse ($projects as $project)
						<tr>
							<td class="table-cell px-4 py-3">{{ $project->id }}</td>
							<td class="table-cell px-4 py-3">{{ $project->title }}</td>
							<td class="table-cell px-4 py-3">{{ $project->sub_title }}</td>
							<td class="table-cell px-4 py-3">{{ $project->project_id }}</td>
							<td class="table-cell px-4 py-3">{{ $project->location }}</td>
							<td class="table-cell px-4 py-3">{{ $project->voltage }}</td>
							<td class="table-cell px-4 py-3">{{ $project->status }}</td>
							<td class="table-cell px-4 py-3">
								<div class="btn-group" role="group">
									<a href="{{ route('projects.show', $project) }}" class="btn btn-sm btn-outline-primary">Show</a>
									<a href="{{ route('projects.edit', $project) }}" class="btn btn-sm btn-outline-success">Edit</a>
									<form action="{{ route('projects.destroy', $project) }}" method="POST" class="d-inline" onsubmit="return confirm('Are you sure you want to delete this project?');">
										@csrf
										@method('DELETE')
										<button type="submit" class="btn btn-sm btn-outline-danger">Delete</button>
									</form>
								</div>
							</td>
						</tr>
					@empty
						<tr>
							<td colspan="8" class="text-center text-muted py-4">No projects found.</td>
						</tr>
					@endforelse
				</tbody>
			</table>
		</div>
	</div>
</div>

@if($projects->hasPages())
	<div class="mt-4">
		{{ $projects->links() }}
	</div>
@endif
@endsection
