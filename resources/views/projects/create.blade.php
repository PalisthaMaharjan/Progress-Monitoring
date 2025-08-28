<h1>Create Project</h1>

<form action="{{ route('projects.store') }}" method="POST" style="margin-top: 16px;">
	@csrf
	@include('projects._form')
	<div style="margin-top: 16px; display: flex; gap: 8px;">
		<button type="submit" style="padding: 8px 12px; background: #16a34a; color: #fff; border: none; border-radius: 4px; cursor: pointer;">Save</button>
		<a href="{{ route('projects.index') }}" style="padding: 8px 12px; background: #6b7280; color: #fff; text-decoration: none; border-radius: 4px;">Cancel</a>
	</div>
</form>
