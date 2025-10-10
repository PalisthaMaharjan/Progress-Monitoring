@extends('layouts.app')

@section('title', 'Towers')

@section('content')
@if (session('success'))
	<div class="alert alert-success alert-dismissible fade show mb-4" role="alert">
		{{ session('success') }}
		<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
	</div>
@endif

<div class="d-flex justify-content-between align-items-center mb-4">
	<h1 class="h2 fw-bold text-dark m-0">Towers</h1>
	<!-- <a href="{{ route('towers.create') }}" class="btn btn-primary px-4 py-2">
		Create Tower
	</a> -->
</div>

<!-- Filter Section -->
<div class="card mb-4">
	<div class="card-body">
		<form method="GET" action="{{ route('towers.index') }}" class="row g-3">
			<div class="col-md-4">
				<label for="project_id" class="form-label">Filter by Project</label>
				<select name="project_id" id="project_id" class="form-select">
					<option value="">All Projects</option>
					@foreach($projects as $project)
						<option value="{{ $project->id }}" {{ request('project_id') == $project->id ? 'selected' : '' }}>
							{{ $project->title }} ({{ $project->project_id }})
						</option>
					@endforeach
				</select>
			</div>
			<div class="col-md-2">
				<label class="form-label">&nbsp;</label>
				<button type="submit" class="btn btn-outline-primary d-block w-100">Filter</button>
			</div>
			<div class="col-md-2">
				<label class="form-label">&nbsp;</label>
				<a href="{{ route('towers.index') }}" class="btn btn-outline-primary d-block w-100">Clear</a>
			</div>
		</form>
	</div>
</div>

<div class="card">
	<div class="card-body p-0">
		<div class="table-responsive">
			<table class="table table-hover mb-0">
				<thead class="table-dark">
					<tr>
						<th class="table-header px-4 py-3">ID</th>
						<th class="table-header px-4 py-3">Tower Name</th>
						<th class="table-header px-4 py-3">Type</th>
						<th class="table-header px-4 py-3">Address</th>
						<th class="table-header px-4 py-3">Project</th>
						<th class="table-header px-4 py-3">Location</th>
						<th class="table-header px-4 py-3">Foundation</th>
						<th class="table-header px-4 py-3">Tower Erection</th>
						<th class="table-header px-4 py-3">Stringing</th>
						<th class="table-header px-4 py-3">Issues</th>
						<th class="table-header px-4 py-3">Actions</th>
					</tr>
				</thead>
				<tbody>
					@forelse ($towers as $tower)
						<tr>
							<td class="table-cell px-4 py-3">{{ $tower->id }}</td>
							<td class="table-cell px-4 py-3">{{ $tower->tower_name }}</td>
							<td class="table-cell px-4 py-3">
								<span class="badge bg-info">{{ $tower->tower_type }}</span>
							</td>
							<td class="table-cell px-4 py-3">
								@if($tower->address)
									<span class="text-truncate d-inline-block" style="max-width: 200px;" title="{{ $tower->address }}">{{ $tower->address }}</span>
								@else
									<span class="text-muted">Not set</span>
								@endif
							</td>
							<td class="table-cell px-4 py-3">{{ $tower->project->title }}</td>
							<td class="table-cell px-4 py-3">
								@if($tower->latitude && $tower->longitude)
									{{ number_format($tower->latitude, 4) }}, {{ number_format($tower->longitude, 4) }}
								@else
									<span class="text-muted">Not set</span>
								@endif
							</td>
							<td class="table-cell px-4 py-3">
								<div class="d-flex align-items-center">
									<div class="progress flex-grow-1 me-2" style="height: 8px;">
										<div class="progress-bar bg-primary" role="progressbar" style="width: {{ $tower->foundation_progress }}%"></div>
									</div>
									<small class="text-muted">{{ $tower->foundation_progress }}%</small>
								</div>
							</td>
							<td class="table-cell px-4 py-3">
								<div class="d-flex align-items-center">
									<div class="progress flex-grow-1 me-2" style="height: 8px;">
										<div class="progress-bar bg-success" role="progressbar" style="width: {{ $tower->tower_erection_progress }}%"></div>
									</div>
									<small class="text-muted">{{ $tower->tower_erection_progress }}%</small>
								</div>
							</td>
							<td class="table-cell px-4 py-3">
								<div class="d-flex align-items-center">
									<div class="progress flex-grow-1 me-2" style="height: 8px;">
										<div class="progress-bar bg-warning" role="progressbar" style="width: {{ $tower->stringing_progress }}%"></div>
									</div>
									<small class="text-muted">{{ $tower->stringing_progress }}%</small>
								</div>
							</td>
							<td class="table-cell px-4 py-3">
								@if($tower->hasIssues())
									<span class="badge bg-danger">Issues</span>
								@else
									<span class="badge bg-success">No Issues</span>
								@endif
							</td>
							<td class="table-cell px-4 py-3">
								<div class="d-flex gap-2">
									<a href="{{ route('towers.show', $tower) }}" class="btn btn-sm btn-outline-primary" data-bs-toggle="tooltip" title="View Tower Details">
										<svg class="w-4 h-4" width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24">
											<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
											<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
										</svg>
									</a>
									<a href="{{ route('towers.edit', $tower) }}" class="btn btn-sm btn-outline-success" data-bs-toggle="tooltip" title="Edit Tower">
										<svg class="w-4 h-4" width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24">
											<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
										</svg>
									</a>
									<button type="button" class="btn btn-sm btn-outline-danger" data-bs-toggle="tooltip" title="Delete Tower" onclick="showDeleteTowerModal({{ $tower->id }}, '{{ $tower->tower_name }}')">
										<svg class="w-4 h-4" width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24">
											<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
										</svg>
									</button>
								</div>
							</td>
						</tr>
					@empty
						<tr>
							<td colspan="11" class="text-center text-muted py-4">No towers found.</td>
						</tr>
					@endforelse
				</tbody>
			</table>
		</div>
	</div>
</div>

@if($towers->hasPages())
	<div class="mt-4">
		{{ $towers->links() }}
	</div>
@endif

<!-- Delete Tower Confirmation Modal -->
<div class="modal fade delete-modal" id="deleteTowerModal" tabindex="-1" aria-labelledby="deleteTowerModalLabel" aria-hidden="true">
	<div class="modal-dialog modal-dialog-centered modal-sm">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="deleteTowerModalLabel">Delete Tower</h5>
			</div>
			<div class="modal-body">
				<p>Are you sure you want to delete the tower <strong id="towerName"></strong>?</p>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
				<form id="deleteTowerForm" method="POST" class="d-inline">
					@csrf
					@method('DELETE')
					<button type="submit" class="btn btn-danger">Delete Tower</button>
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

	// Function to show delete tower confirmation modal
	function showDeleteTowerModal(towerId, towerName) {
		// Set the tower name in the modal
		document.getElementById('towerName').textContent = towerName;

		// Set the form action URL
		document.getElementById('deleteTowerForm').action = '{{ route("towers.destroy", ":id") }}'.replace(':id', towerId);

		// Show the modal
		var deleteTowerModal = new bootstrap.Modal(document.getElementById('deleteTowerModal'));
		deleteTowerModal.show();
	}
</script>
@endpush
@endsection
