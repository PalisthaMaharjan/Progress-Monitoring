@extends('layouts.app')

@section('title', 'Tower Details')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
	<h1 class="h2 fw-bold text-dark m-0">{{ $tower->tower_name }} Details</h1>
	<div class="d-flex gap-2">
		<a href="{{ route('towers.edit', $tower) }}" class="btn btn-outline-success px-4 py-2">Edit Tower</a>
		<a href="{{ route('towers.index') }}" class="btn btn-outline-primary px-4 py-2">Back to Towers</a>
	</div>
</div>

<div class="row">
	<!-- Tower Information -->
	<div class="col-md-6">
		<div class="card mb-4">
			<div class="card-header">
				<h5 class="card-title mb-0">Tower Information</h5>
			</div>
			<div class="card-body">
				<div class="row mb-3">
					<div class="col-sm-4"><strong>Tower Name:</strong></div>
					<div class="col-sm-8">{{ $tower->tower_name }}</div>
				</div>
				<div class="row mb-3">
					<div class="col-sm-4"><strong>Tower Type:</strong></div>
					<div class="col-sm-8"><span class="badge bg-info">{{ $tower->tower_type }}</span></div>
				</div>
				<div class="row mb-3">
					<div class="col-sm-4"><strong>Address:</strong></div>
					<div class="col-sm-8">
						@if($tower->address)
							{{ $tower->address }}
						@else
							<span class="text-muted">Not set</span>
						@endif
					</div>
				</div>
				<div class="row mb-3">
					<div class="col-sm-4"><strong>Project:</strong></div>
					<div class="col-sm-8">{{ $tower->project->title }} ({{ $tower->project->project_id }})</div>
				</div>
				<div class="row mb-3">
					<div class="col-sm-4"><strong>Location:</strong></div>
					<div class="col-sm-8">
						@if($tower->latitude && $tower->longitude)
							{{ number_format($tower->latitude, 7) }}, {{ number_format($tower->longitude, 7) }}
						@else
							<span class="text-muted">Not set</span>
						@endif
					</div>
				</div>
				@if($tower->problems)
				<div class="row mb-3">
					<div class="col-sm-4"><strong>Problems:</strong></div>
					<div class="col-sm-8">
						<div class="alert alert-warning mb-0">
							{{ $tower->problems }}
						</div>
					</div>
				</div>
				@endif
			</div>
		</div>
	</div>

	<!-- Progress Overview -->
	<div class="col-md-6">
		<div class="card mb-4">
			<div class="card-header">
				<h5 class="card-title mb-0">Progress Overview</h5>
			</div>
			<div class="card-body">
				<div class="mb-3">
					<div class="d-flex justify-content-between align-items-center mb-2">
						<span><strong>Foundation</strong></span>
						<span class="badge bg-primary">{{ $tower->foundation_progress }}%</span>
					</div>
					<div class="progress" style="height: 20px;">
						<div class="progress-bar bg-primary" role="progressbar" style="width: {{ $tower->foundation_progress }}%"></div>
					</div>
				</div>

				<div class="mb-3">
					<div class="d-flex justify-content-between align-items-center mb-2">
						<span><strong>Tower Erection</strong></span>
						<span class="badge bg-success">{{ $tower->tower_erection_progress }}%</span>
					</div>
					<div class="progress" style="height: 20px;">
						<div class="progress-bar bg-success" role="progressbar" style="width: {{ $tower->tower_erection_progress }}%"></div>
					</div>
				</div>

				<div class="mb-3">
					<div class="d-flex justify-content-between align-items-center mb-2">
						<span><strong>Stringing</strong></span>
						<span class="badge bg-warning">{{ $tower->stringing_progress }}%</span>
					</div>
					<div class="progress" style="height: 20px;">
						<div class="progress-bar bg-warning" role="progressbar" style="width: {{ $tower->stringing_progress }}%"></div>
					</div>
				</div>

				<div class="mt-4">
					<div class="d-flex justify-content-between align-items-center mb-2">
						<span><strong>Overall Progress</strong></span>
						<span class="badge bg-info">{{ $tower->overall_progress }}%</span>
					</div>
					<div class="progress" style="height: 25px;">
						<div class="progress-bar bg-info" role="progressbar" style="width: {{ $tower->overall_progress }}%"></div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>

<!-- Tower Legs Details -->
<div class="card">
	<div class="card-header">
		<h5 class="card-title mb-0">Tower Legs Details</h5>
	</div>
	<div class="card-body p-0">
		@if($tower->legs->count() > 0)
			<div class="table-responsive">
				<table class="table table-hover mb-0">
					<thead class="table-light">
						<tr>
							<th class="px-4 py-3">LEG</th>
							<th class="px-4 py-3">KITTA NO</th>
							<th class="px-4 py-3">OWNER</th>
							<th class="px-4 py-3">AMOUNT (NPR)</th>
							<th class="px-4 py-3">REMARKS</th>
						</tr>
					</thead>
					<tbody>
						@foreach($tower->legs as $leg)
							<tr>
								<td class="px-4 py-3"><strong>{{ $leg->leg_name }}</strong></td>
								<td class="px-4 py-3">{{ $leg->kitta_no }}</td>
								<td class="px-4 py-3">{{ $leg->owner }}</td>
								<td class="px-4 py-3">₹{{ number_format($leg->amount, 2) }}</td>
								<td class="px-4 py-3">
									@if($leg->remarks)
										<span class="badge bg-{{ $leg->remarks == 'Completed' ? 'success' : ($leg->remarks == 'In Progress' ? 'warning' : 'secondary') }}">
											{{ $leg->remarks }}
										</span>
									@else
										<span class="text-muted">-</span>
									@endif
								</td>
							</tr>
						@endforeach
					</tbody>
				</table>
			</div>
		@else
			<div class="text-center text-muted py-4">
				No tower legs information available.
			</div>
		@endif
	</div>
</div>
@endsection
