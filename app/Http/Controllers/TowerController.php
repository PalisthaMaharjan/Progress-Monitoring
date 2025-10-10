<?php

namespace App\Http\Controllers;

use App\Models\Project;
use App\Models\Tower;
use App\Models\TowerLeg;
use Illuminate\Http\Request;

class TowerController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Tower::with(['project', 'legs']);

        // Filter by project if project_id is provided
        if ($request->has('project_id') && $request->project_id) {
            $query->where('project_id', $request->project_id);
        }

        $towers = $query->latest()->paginate(10);
        $projects = Project::all();

        return view('towers.index', compact('towers', 'projects'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
        $projects = Project::all();
        $selectedProjectId = $request->get('project_id');
        $selectedProject = $selectedProjectId ? Project::find($selectedProjectId) : null;

        return view('towers.create', compact('projects', 'selectedProject', 'selectedProjectId'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'project_id' => ['required', 'exists:projects,id'],
            'tower_name' => ['required', 'string', 'max:255'],
            'tower_type' => ['required', 'string', 'max:255'],
            'address' => ['nullable', 'string', 'max:500'],
            'latitude' => ['nullable', 'numeric', 'between:-90,90'],
            'longitude' => ['nullable', 'numeric', 'between:-180,180'],
            'foundation_progress' => ['required', 'integer', 'min:0', 'max:100'],
            'tower_erection_progress' => ['required', 'integer', 'min:0', 'max:100'],
            'stringing_progress' => ['required', 'integer', 'min:0', 'max:100'],
            'problems' => ['nullable', 'string'],
            'legs' => ['nullable', 'array'],
            'legs.*.leg_name' => ['required_with:legs', 'string'],
            'legs.*.kitta_no' => ['required_with:legs', 'string'],
            'legs.*.owner' => ['required_with:legs', 'string'],
            'legs.*.amount' => ['required_with:legs', 'numeric', 'min:0'],
            'legs.*.remarks' => ['nullable', 'string'],
        ]);

        $tower = Tower::create($validated);

        // Create tower legs if provided
        if ($request->has('legs') && is_array($request->legs)) {
            foreach ($request->legs as $legData) {
                if (!empty($legData['leg_name'])) {
                    $tower->legs()->create($legData);
                }
            }
        }

        return redirect()->route('towers.index')->with('success', 'Tower created successfully!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Tower $tower)
    {
        $tower->load(['project', 'legs']);
        return view('towers.show', compact('tower'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Tower $tower)
    {
        $projects = Project::all();
        $tower->load('legs');

        return view('towers.edit', compact('tower', 'projects'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Tower $tower)
    {
        $validated = $request->validate([
            'project_id' => ['required', 'exists:projects,id'],
            'tower_name' => ['required', 'string', 'max:255'],
            'tower_type' => ['required', 'string', 'max:255'],
            'address' => ['nullable', 'string', 'max:500'],
            'latitude' => ['nullable', 'numeric', 'between:-90,90'],
            'longitude' => ['nullable', 'numeric', 'between:-180,180'],
            'foundation_progress' => ['required', 'integer', 'min:0', 'max:100'],
            'tower_erection_progress' => ['required', 'integer', 'min:0', 'max:100'],
            'stringing_progress' => ['required', 'integer', 'min:0', 'max:100'],
            'problems' => ['nullable', 'string'],
            'legs' => ['nullable', 'array'],
            'legs.*.id' => ['nullable', 'exists:tower_legs,id'],
            'legs.*.leg_name' => ['required_with:legs', 'string'],
            'legs.*.kitta_no' => ['required_with:legs', 'string'],
            'legs.*.owner' => ['required_with:legs', 'string'],
            'legs.*.amount' => ['required_with:legs', 'numeric', 'min:0'],
            'legs.*.remarks' => ['nullable', 'string'],
        ]);

        $tower->update($validated);

        // Update tower legs
        if ($request->has('legs') && is_array($request->legs)) {
            // Delete existing legs not in the request
            $existingLegIds = collect($request->legs)->pluck('id')->filter();
            $tower->legs()->whereNotIn('id', $existingLegIds)->delete();

            // Update or create legs
            foreach ($request->legs as $legData) {
                if (!empty($legData['leg_name'])) {
                    if (isset($legData['id']) && $legData['id']) {
                        $tower->legs()->where('id', $legData['id'])->update($legData);
                    } else {
                        $tower->legs()->create($legData);
                    }
                }
            }
        }

        return redirect()->route('towers.index')->with('success', 'Tower updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Tower $tower)
    {
        $tower->delete();
        return redirect()->route('towers.index')->with('success', 'Tower deleted successfully!');
    }
}
