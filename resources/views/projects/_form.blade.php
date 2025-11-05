@php($isEdit = isset($project))

<div class="row g-3">
	<div class="col-12">
		<label class="form-label fw-medium text-dark mb-2">
			Title
		</label>
		<input
			type="text"
			name="title"
			value="{{ old('title', $project->title ?? '') }}"
			class="form-control input-field"
			placeholder="Enter project title"
			required
		>
		@error('title')
			<div class="invalid-feedback d-block">{{ $message }}</div>
		@enderror
	</div>

	<div class="col-12">
		<label class="form-label fw-medium text-dark mb-2">
			Sub Title
		</label>
		<input
			type="text"
			name="sub_title"
			value="{{ old('sub_title', $project->sub_title ?? '') }}"
			class="form-control input-field"
			placeholder="Enter project subtitle"
			required
		>
		@error('sub_title')
			<div class="invalid-feedback d-block">{{ $message }}</div>
		@enderror
	</div>

	<div class="col-12">
		<label class="form-label fw-medium text-dark mb-2">
			Project ID
		</label>
		<input
			type="text"
			name="project_id"
			value="{{ old('project_id', $project->project_id ?? '') }}"
			class="form-control input-field"
			placeholder="Enter project ID"
			required
		>
		@error('project_id')
			<div class="invalid-feedback d-block">{{ $message }}</div>
		@enderror
	</div>

	<div class="col-12">
		<label class="form-label fw-medium text-dark mb-2">
			Location
		</label>
		<input
			type="text"
			name="location"
			value="{{ old('location', $project->location ?? '') }}"
			class="form-control input-field"
			placeholder="Enter project location"
			required
		>
		@error('location')
			<div class="invalid-feedback d-block">{{ $message }}</div>
		@enderror
	</div>

	<div class="col-12">
		<label class="form-label fw-medium text-dark mb-2">
			Voltage
		</label>
		<input
			type="number"
			step="1"
			min="0"
			name="voltage"
			value="{{ old('voltage', isset($project) && $project->voltage ? number_format($project->voltage, 0) : '') }}"
			class="form-control input-field"
			placeholder="Enter voltage value"
			required
		>
		@error('voltage')
			<div class="invalid-feedback d-block">{{ $message }}</div>
		@enderror
	</div>

	<div class="col-12">
		<label class="form-label fw-medium text-dark mb-2">
			Status
		</label>
		<select
			name="status"
			class="form-select input-field"
			required
		>
			<option value="">Select status</option>
			<option value="Study" {{ (old('status', $project->status ?? '') == 'Study') ? 'selected' : '' }}>Study</option>
			<option value="Under construction" {{ (old('status', $project->status ?? '') == 'Under construction') ? 'selected' : '' }}>Under construction</option>
			<option value="Under operation" {{ (old('status', $project->status ?? '') == 'Under operation') ? 'selected' : '' }}>Under operation</option>
		</select>
		@error('status')
			<div class="invalid-feedback d-block">{{ $message }}</div>
		@enderror
	</div>
</div>
