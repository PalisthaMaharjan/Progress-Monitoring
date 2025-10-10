@extends('layouts.app')

@section('title', 'Projects')

@section('content')


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
								<div class="d-flex gap-2">
									<a href="{{ route('projects.show', $project) }}" class="btn btn-sm btn-outline-primary" data-bs-toggle="tooltip" title="View Project Details">
										<svg class="w-4 h-4" width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24">
											<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
											<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
										</svg>
									</a>
									<a href="{{ route('projects.edit', $project) }}" class="btn btn-sm btn-outline-success" data-bs-toggle="tooltip" title="Edit Project">
										<svg class="w-4 h-4" width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24">
											<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
										</svg>
									</a>
									<a href="{{ route('towers.create', ['project_id' => $project->id]) }}" class="btn btn-sm btn-outline-info" data-bs-toggle="tooltip" title="Create Tower for this Project">
										<svg class="w-4 h-4" width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24">
											<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
										</svg>
									</a>
									<button type="button" class="btn btn-sm btn-outline-danger" data-bs-toggle="tooltip" title="Delete Project" onclick="showDeleteModal({{ $project->id }}, '{{ $project->title }}')">
										<svg class="w-4 h-4" width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24">
											<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
										</svg>
									</button>
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

<!-- Delete Confirmation Modal -->
<div class="modal fade delete-modal" id="deleteModal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
	<div class="modal-dialog modal-dialog-centered modal-sm">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="deleteModalLabel">Delete Project</h5>
				<!-- <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button> -->
			</div>
			<div class="modal-body">
				<p>Are you sure you want to delete the project <strong id="projectTitle"></strong>?</p>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
				<form id="deleteForm" method="POST" class="d-inline">
					@csrf
					@method('DELETE')
					<button type="submit" class="btn btn-danger">Delete Project</button>
				</form>
			</div>
		</div>
	</div>
</div>

@push('scripts')
<script>
	// Initialize tooltips
	document.addEventListener('DOMContentLoaded', function() {
		var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
		var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
			return new bootstrap.Tooltip(tooltipTriggerEl);
		});
	});

	// Function to show delete confirmation modal
	function showDeleteModal(projectId, projectTitle) {
		// Set the project title in the modal
		document.getElementById('projectTitle').textContent = projectTitle;

		// Set the form action URL
		document.getElementById('deleteForm').action = '{{ route("projects.destroy", ":id") }}'.replace(':id', projectId);

		// Show the modal
		var deleteModal = new bootstrap.Modal(document.getElementById('deleteModal'));
		deleteModal.show();
	}
</script>
@endpush
@endsection
