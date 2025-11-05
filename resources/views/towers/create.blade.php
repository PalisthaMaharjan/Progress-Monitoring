@extends('layouts.app')

@section('title', 'Create Tower')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
	<div>
		<h1 class="h2 fw-bold text-dark m-0">Create Tower</h1>
		@if($selectedProject)
			<p class="text-muted mb-0">For Project: <strong>{{ $selectedProject->title }} ({{ $selectedProject->project_id }})</strong></p>
		@endif
	</div>
	<a href="{{ route('towers.index') }}" class="btn btn-outline-primary px-4 py-2">
		Back to Towers
	</a>
</div>

<div class="card">
	<div class="card-body">
		<form action="{{ route('towers.store') }}" method="POST">
			@csrf

			<div class="row">
				<div class="col-md-6">
					<div class="mb-3">
						<label for="project_id" class="form-label">Project <span class="text-danger">*</span></label>
						<select name="project_id" id="project_id" class="form-select @error('project_id') is-invalid @enderror" required>
							<option value="">Select Project</option>
							@foreach($projects as $project)
								<option value="{{ $project->id }}" {{ (old('project_id', $selectedProjectId) == $project->id) ? 'selected' : '' }}>
									{{ $project->title }} ({{ $project->project_id }})
								</option>
							@endforeach
						</select>
						@error('project_id')
							<div class="invalid-feedback">{{ $message }}</div>
						@enderror
					</div>
				</div>

				<div class="col-md-6">
					<div class="mb-3">
						<label for="tower_name" class="form-label">Tower Name <span class="text-danger">*</span></label>
						<input type="text" name="tower_name" id="tower_name" class="form-control @error('tower_name') is-invalid @enderror" value="{{ old('tower_name') }}" required>
						@error('tower_name')
							<div class="invalid-feedback">{{ $message }}</div>
						@enderror
					</div>
				</div>
			</div>

			<div class="row">
				<div class="col-md-6">
					<div class="mb-3">
						<label for="tower_type" class="form-label">Tower Type <span class="text-danger">*</span></label>
						<select name="tower_type" id="tower_type" class="form-select @error('tower_type') is-invalid @enderror" required>
							<option value="">Select Type</option>
							<option value="Suspension Tower" {{ old('tower_type') == 'Suspension Tower' ? 'selected' : '' }}>Suspension Tower</option>
							<option value="Angle Tower" {{ old('tower_type') == 'Angle Tower' ? 'selected' : '' }}>Angle Tower</option>
							<option value="Terminal Tower" {{ old('tower_type') == 'Terminal Tower' ? 'selected' : '' }}>Terminal Tower</option>
							<option value="Tension Tower" {{ old('tower_type') == 'Tension Tower' ? 'selected' : '' }}>Tension Tower</option>
						</select>
						@error('tower_type')
							<div class="invalid-feedback">{{ $message }}</div>
						@enderror
					</div>
				</div>

				<div class="col-md-6">
					<div class="mb-3">
						<label for="address" class="form-label">Address</label>
						<input type="text" name="address" id="address" class="form-control @error('address') is-invalid @enderror" value="{{ old('address') }}" placeholder="Enter tower address or location">
						@error('address')
							<div class="invalid-feedback">{{ $message }}</div>
						@enderror
					</div>
				</div>
			</div>

			<div class="row">
				<div class="col-md-3">
					<div class="mb-3">
						<label for="latitude" class="form-label">Latitude</label>
						<input type="number" name="latitude" id="latitude" class="form-control @error('latitude') is-invalid @enderror" value="{{ old('latitude') }}" step="0.0000001" min="-90" max="90">
						@error('latitude')
							<div class="invalid-feedback">{{ $message }}</div>
						@enderror
					</div>
				</div>

				<div class="col-md-3">
					<div class="mb-3">
						<label for="longitude" class="form-label">Longitude</label>
						<input type="number" name="longitude" id="longitude" class="form-control @error('longitude') is-invalid @enderror" value="{{ old('longitude') }}" step="0.0000001" min="-180" max="180">
						@error('longitude')
							<div class="invalid-feedback">{{ $message }}</div>
						@enderror
					</div>
				</div>
			</div>

			<div class="row">
				<div class="col-md-4">
					<div class="mb-3">
						<label for="foundation_progress" class="form-label">Foundation Progress (%) <span class="text-danger">*</span></label>
						<input type="number" name="foundation_progress" id="foundation_progress" class="form-control @error('foundation_progress') is-invalid @enderror" value="{{ old('foundation_progress', 0) }}" min="0" max="100" required>
						@error('foundation_progress')
							<div class="invalid-feedback">{{ $message }}</div>
						@enderror
					</div>
				</div>

				<div class="col-md-4">
					<div class="mb-3">
						<label for="tower_erection_progress" class="form-label">Tower Erection Progress (%) <span class="text-danger">*</span></label>
						<input type="number" name="tower_erection_progress" id="tower_erection_progress" class="form-control @error('tower_erection_progress') is-invalid @enderror" value="{{ old('tower_erection_progress', 0) }}" min="0" max="100" required>
						@error('tower_erection_progress')
							<div class="invalid-feedback">{{ $message }}</div>
						@enderror
					</div>
				</div>

				<div class="col-md-4">
					<div class="mb-3">
						<label for="stringing_progress" class="form-label">Stringing Progress (%) <span class="text-danger">*</span></label>
						<input type="number" name="stringing_progress" id="stringing_progress" class="form-control @error('stringing_progress') is-invalid @enderror" value="{{ old('stringing_progress', 0) }}" min="0" max="100" required>
						@error('stringing_progress')
							<div class="invalid-feedback">{{ $message }}</div>
						@enderror
					</div>
				</div>
			</div>

			<div class="mb-3">
				<label for="problems" class="form-label">Problems/Issues</label>
				<textarea name="problems" id="problems" class="form-control @error('problems') is-invalid @enderror" rows="3" placeholder="Describe any problems or issues with this tower...">{{ old('problems') }}</textarea>
				@error('problems')
					<div class="invalid-feedback">{{ $message }}</div>
				@enderror
			</div>

			<!-- Tower Legs Section -->
			<div class="mb-4">
				<h5 class="fw-bold mb-3">Tower Legs Details</h5>
				<div id="tower-legs-container">
					<div class="tower-leg-item border rounded p-3 mb-3">
						<div class="row">
							<div class="col-md-2">
								<label class="form-label">Leg</label>
								<input type="text" name="legs[0][leg_name]" class="form-control" placeholder="A" value="A">
							</div>
							<div class="col-md-2">
								<label class="form-label">Kitta No</label>
								<input type="text" name="legs[0][kitta_no]" class="form-control" placeholder="K-001">
							</div>
							<div class="col-md-3">
								<label class="form-label">Owner</label>
								<input type="text" name="legs[0][owner]" class="form-control" placeholder="Owner Name">
							</div>
							<div class="col-md-2">
								<label class="form-label">Amount (NPR)</label>
								<input type="number" name="legs[0][amount]" class="form-control" placeholder="0" step="0.01" min="0">
							</div>
							<div class="col-md-2">
								<label class="form-label">Remarks</label>
								<input type="text" name="legs[0][remarks]" class="form-control" placeholder="Status">
							</div>
							<div class="col-md-1">
								<label class="form-label">&nbsp;</label>
								<button type="button" class="btn btn-outline-danger d-block w-100" onclick="removeTowerLeg(this)">×</button>
							</div>
						</div>
					</div>
				</div>
				<button type="button" class="btn btn-outline-primary" id="addTowerLegBtn" onclick="addTowerLeg()">Add Tower Leg</button>
			</div>

			<div class="d-flex gap-2">
				<button type="submit" class="btn btn-primary px-4 py-2">Create Tower</button>
				<a href="{{ route('towers.index') }}" class="btn btn-outline-primary px-4 py-2">Cancel</a>
			</div>
		</form>
	</div>
</div>

<script>
let legIndex = 1;

function addTowerLeg() {
	const container = document.getElementById('tower-legs-container');
	const addButton = document.getElementById('addTowerLegBtn');
	const legLetters = ['A', 'B', 'C', 'D'];
	
	// Check if we already have 4 legs
	const existingLegs = container.querySelectorAll('.tower-leg-item');
	if (existingLegs.length >= 4) {
		return; // Don't add more than 4 legs
	}

	const legItem = document.createElement('div');
	legItem.className = 'tower-leg-item border rounded p-3 mb-3';
	legItem.innerHTML = `
		<div class="row">
			<div class="col-md-2">
				<label class="form-label">Leg</label>
				<input type="text" name="legs[${legIndex}][leg_name]" class="form-control" placeholder="${legLetters[legIndex] || legIndex + 1}" value="${legLetters[legIndex] || legIndex + 1}">
			</div>
			<div class="col-md-2">
				<label class="form-label">Kitta No</label>
				<input type="text" name="legs[${legIndex}][kitta_no]" class="form-control" placeholder="K-${String(legIndex + 1).padStart(3, '0')}">
			</div>
			<div class="col-md-3">
				<label class="form-label">Owner</label>
				<input type="text" name="legs[${legIndex}][owner]" class="form-control" placeholder="Owner Name">
			</div>
			<div class="col-md-2">
				<label class="form-label">Amount (NPR)</label>
				<input type="number" name="legs[${legIndex}][amount]" class="form-control" placeholder="0" step="0.01" min="0">
			</div>
			<div class="col-md-2">
				<label class="form-label">Remarks</label>
				<input type="text" name="legs[${legIndex}][remarks]" class="form-control" placeholder="Status">
			</div>
			<div class="col-md-1">
				<label class="form-label">&nbsp;</label>
				<button type="button" class="btn btn-outline-danger d-block w-100" onclick="removeTowerLeg(this)">×</button>
			</div>
		</div>
	`;

	container.appendChild(legItem);
	legIndex++;
	
	// Hide the "Add Tower Leg" button if we now have 4 legs
	const updatedLegs = container.querySelectorAll('.tower-leg-item');
	if (updatedLegs.length >= 4) {
		addButton.style.display = 'none';
	}
}

function removeTowerLeg(button) {
	button.closest('.tower-leg-item').remove();
	
	// Show the "Add Tower Leg" button if we now have less than 4 legs
	const container = document.getElementById('tower-legs-container');
	const addButton = document.getElementById('addTowerLegBtn');
	const remainingLegs = container.querySelectorAll('.tower-leg-item');
	
	if (remainingLegs.length < 4) {
		addButton.style.display = 'inline-block';
	}
}
</script>
@endsection
