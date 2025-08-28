<h1>Edit Project</h1>

<form action="{{ route('projects.update', $project) }}" method="POST" style="margin-top: 16px;">
	@csrf
	@method('PUT')
	@include('projects._form', ['project' => $project])
	<div style="margin-top: 16px; display: flex; gap: 8px;">
		<button type="submit" style="padding: 8px 12px; background: #2563eb; color: #fff; border: none; border-radius: 4px; cursor: pointer;">Update</button>
		<a href="{{ route('projects.index') }}" style="padding: 8px 12px; background: #6b7280; color: #fff; text-decoration: none; border-radius: 4px;">Cancel</a>
	</div>
</form>
