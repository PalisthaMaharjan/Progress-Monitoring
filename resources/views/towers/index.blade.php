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
	<a href="{{ route('towers.create') }}" class="btn btn-primary px-4 py-2">
		Create Tower
	</a>
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
				<a href="{{ route('towers.index') }}" class="btn btn-outline-secondary d-block w-100">Clear</a>
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
						<th class="table-header px-4 py-3">Project</th>
						<th class="table-header px-4 py-3">Location</th>
						<th class="table-header px-4 py-3">Foundation</th>
						<th class="table-header px-4 py-3">Tower Erection</th>
						<th class="table-header px-4 py-3">Conductor</th>
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
										<div class="progress-bar bg-warning" role="progressbar" style="width: {{ $tower->conductor_progress }}%"></div>
									</div>
									<small class="text-muted">{{ $tower->conductor_progress }}%</small>
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
								<div class="btn-group" role="group">
									<a href="{{ route('towers.show', $tower) }}" class="btn btn-sm btn-outline-primary">Show</a>
									<a href="{{ route('towers.edit', $tower) }}" class="btn btn-sm btn-outline-success">Edit</a>
									<form action="{{ route('towers.destroy', $tower) }}" method="POST" class="d-inline" onsubmit="return confirm('Are you sure you want to delete this tower?');">
										@csrf
										@method('DELETE')
										<button type="submit" class="btn btn-sm btn-outline-danger">Delete</button>
									</form>
								</div>
							</td>
						</tr>
					@empty
						<tr>
							<td colspan="10" class="text-center text-muted py-4">No towers found.</td>
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
@endsection
