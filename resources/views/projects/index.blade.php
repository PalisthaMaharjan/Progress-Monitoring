@if (session('success'))
	<div style="color: green; margin-bottom: 16px;">{{ session('success') }}</div>
@endif

<div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 16px;">
	<h1 style="margin: 0;">Projects</h1>
	<a href="{{ route('projects.create') }}" style="padding: 8px 12px; background: #2563eb; color: #fff; text-decoration: none; border-radius: 4px;">Create Project</a>
</div>

<table border="1" cellpadding="8" cellspacing="0" width="100%">
	<thead>
		<tr>
			<th>ID</th>
			<th>Title</th>
			<th>Sub Title</th>
			<th>Project ID</th>
			<th>Location</th>
			<th>Voltage</th>
			<th>Status</th>
			<th>Actions</th>
		</tr>
	</thead>
	<tbody>
		@forelse ($projects as $project)
			<tr>
				<td>{{ $project->id }}</td>
				<td>{{ $project->title }}</td>
				<td>{{ $project->sub_title }}</td>
				<td>{{ $project->project_id }}</td>
				<td>{{ $project->location }}</td>
				<td>{{ $project->voltage }}</td>
				<td>{{ $project->status }}</td>
				<td style="white-space: nowrap;">
					<a href="{{ route('projects.show', $project) }}">Show</a>
					|
					<a href="{{ route('projects.edit', $project) }}">Edit</a>
					|
					<form action="{{ route('projects.destroy', $project) }}" method="POST" style="display: inline;" onsubmit="return confirm('Delete this project?');">
						@csrf
						@method('DELETE')
						<button type="submit" style="background: #dc2626; color: #fff; border: none; padding: 4px 8px; border-radius: 4px; cursor: pointer;">Delete</button>
					</form>
				</td>
			</tr>
		@empty
			<tr>
				<td colspan="8" style="text-align: center;">No projects found.</td>
			</tr>
		@endforelse
	</tbody>
</table>

<div style="margin-top: 16px;">
	{{ $projects->links() }}
</div>
