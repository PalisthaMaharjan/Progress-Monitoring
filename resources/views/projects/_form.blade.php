@php($isEdit = isset($project))

<div style="display: grid; gap: 12px; max-width: 640px;">
	<label>
		<div>Title</div>
		<input type="text" name="title" value="{{ old('title', $project->title ?? '') }}" style="width: 100%; padding: 8px;">
		@error('title')
			<div style="color: #dc2626;">{{ $message }}</div>
		@enderror
	</label>

	<label>
		<div>Sub Title</div>
		<input type="text" name="sub_title" value="{{ old('sub_title', $project->sub_title ?? '') }}" style="width: 100%; padding: 8px;">
		@error('sub_title')
			<div style="color: #dc2626;">{{ $message }}</div>
		@enderror
	</label>

	<label>
		<div>Project ID</div>
		<input type="text" name="project_id" value="{{ old('project_id', $project->project_id ?? '') }}" style="width: 100%; padding: 8px;">
		@error('project_id')
			<div style="color: #dc2626;">{{ $message }}</div>
		@enderror
	</label>

	<label>
		<div>Location</div>
		<input type="text" name="location" value="{{ old('location', $project->location ?? '') }}" style="width: 100%; padding: 8px;">
		@error('location')
			<div style="color: #dc2626;">{{ $message }}</div>
		@enderror
	</label>

	<label>
		<div>Voltage</div>
		<input type="number" step="0.01" name="voltage" value="{{ old('voltage', $project->voltage ?? '') }}" style="width: 100%; padding: 8px;">
		@error('voltage')
			<div style="color: #dc2626;">{{ $message }}</div>
		@enderror
	</label>

	<label>
		<div>Status</div>
		<input type="text" name="status" value="{{ old('status', $project->status ?? '') }}" style="width: 100%; padding: 8px;">
		@error('status')
			<div style="color: #dc2626;">{{ $message }}</div>
		@enderror
	</label>
</div>
