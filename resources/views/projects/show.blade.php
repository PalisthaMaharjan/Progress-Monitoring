<h1>Project Details</h1>

<div style="display: grid; gap: 8px; max-width: 640px; margin-top: 12px;">
	<div><strong>ID:</strong> {{ $project->id }}</div>
	<div><strong>Title:</strong> {{ $project->title }}</div>
	<div><strong>Sub Title:</strong> {{ $project->sub_title }}</div>
	<div><strong>Project ID:</strong> {{ $project->project_id }}</div>
	<div><strong>Location:</strong> {{ $project->location }}</div>
	<div><strong>Voltage:</strong> {{ $project->voltage }}</div>
	<div><strong>Status:</strong> {{ $project->status }}</div>
	<div><strong>Created At:</strong> {{ $project->created_at }}</div>
	<div><strong>Updated At:</strong> {{ $project->updated_at }}</div>
</div>

<div style="margin-top: 16px; display: flex; gap: 8px;">
	<a href="{{ route('projects.edit', $project) }}" style="padding: 8px 12px; background: #2563eb; color: #fff; text-decoration: none; border-radius: 4px;">Edit</a>
	<a href="{{ route('projects.index') }}" style="padding: 8px 12px; background: #6b7280; color: #fff; text-decoration: none; border-radius: 4px;">Back</a>
</div>
