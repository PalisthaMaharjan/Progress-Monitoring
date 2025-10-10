<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\ProjectResource;
use App\Models\Project;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

/**
 * @OA\Tag(
 *     name="Projects",
 *     description="API endpoints for managing projects"
 * )
 */
class ProjectController extends Controller
{
    /**
     * @OA\Get(
     *     path="/api/v1/projects",
     *     summary="Get list of projects",
     *     description="Retrieve a paginated list of projects with optional filtering, searching, and sorting",
     *     operationId="getProjects",
     *     tags={"Projects"},
     *     @OA\Parameter(
     *         name="search",
     *         in="query",
     *         description="Search term to filter projects by title, sub_title, project_id, location, or status",
     *         required=false,
     *         @OA\Schema(type="string", example="power")
     *     ),
     *     @OA\Parameter(
     *         name="status",
     *         in="query",
     *         description="Filter projects by status",
     *         required=false,
     *         @OA\Schema(type="string", example="active")
     *     ),
     *     @OA\Parameter(
     *         name="voltage",
     *         in="query",
     *         description="Filter projects by voltage",
     *         required=false,
     *         @OA\Schema(type="number", example=132)
     *     ),
     *     @OA\Parameter(
     *         name="sort_by",
     *         in="query",
     *         description="Field to sort by",
     *         required=false,
     *         @OA\Schema(type="string", enum={"id", "title", "sub_title", "project_id", "location", "voltage", "status", "created_at", "updated_at"}, default="created_at")
     *     ),
     *     @OA\Parameter(
     *         name="sort_order",
     *         in="query",
     *         description="Sort order",
     *         required=false,
     *         @OA\Schema(type="string", enum={"asc", "desc"}, default="desc")
     *     ),
     *     @OA\Parameter(
     *         name="per_page",
     *         in="query",
     *         description="Number of items per page",
     *         required=false,
     *         @OA\Schema(type="integer", minimum=1, maximum=100, default=15)
     *     ),
     *     @OA\Parameter(
     *         name="include_towers_count",
     *         in="query",
     *         description="Include towers count in response",
     *         required=false,
     *         @OA\Schema(type="boolean", default=false)
     *     ),
     *     @OA\Parameter(
     *         name="include_towers",
     *         in="query",
     *         description="Include towers with their details in response",
     *         required=false,
     *         @OA\Schema(type="boolean", default=false)
     *     ),
     *     @OA\Parameter(
     *         name="include_tower_legs",
     *         in="query",
     *         description="Include tower legs when towers are included",
     *         required=false,
     *         @OA\Schema(type="boolean", default=false)
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Successful operation",
     *         @OA\JsonContent(
     *             @OA\Property(property="data", type="array", @OA\Items(ref="#/components/schemas/Project")),
     *             @OA\Property(property="meta", type="object",
     *                 @OA\Property(property="current_page", type="integer", example=1),
     *                 @OA\Property(property="from", type="integer", example=1),
     *                 @OA\Property(property="last_page", type="integer", example=5),
     *                 @OA\Property(property="per_page", type="integer", example=15),
     *                 @OA\Property(property="to", type="integer", example=15),
     *                 @OA\Property(property="total", type="integer", example=75)
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=422,
     *         description="Validation error",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string"),
     *             @OA\Property(property="errors", type="object")
     *         )
     *     )
     * )
     */
    public function index(Request $request): JsonResponse
    {
        // Validate request parameters
        $validated = $request->validate([
            'search' => 'nullable|string|max:255',
            'status' => 'nullable|string|max:255',
            'voltage' => 'nullable|numeric|min:0',
            'sort_by' => 'nullable|string|in:id,title,sub_title,project_id,location,voltage,status,created_at,updated_at',
            'sort_order' => 'nullable|string|in:asc,desc',
            'per_page' => 'nullable|integer|min:1|max:100',
            'include_towers_count' => 'nullable|in:true,false,1,0,"true","false","1","0"',
            'include_towers' => 'nullable|in:true,false,1,0,"true","false","1","0"',
            'include_tower_legs' => 'nullable|in:true,false,1,0,"true","false","1","0"',
        ]);

        $query = Project::query();

        // Add search functionality
        if ($request->has('search') && $request->search) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhere('sub_title', 'like', "%{$search}%")
                  ->orWhere('project_id', 'like', "%{$search}%")
                  ->orWhere('location', 'like', "%{$search}%")
                  ->orWhere('status', 'like', "%{$search}%");
            });
        }

        // Add status filter
        if ($request->has('status') && $request->status) {
            $query->where('status', $request->status);
        }

        // Add voltage filter
        if ($request->has('voltage') && $request->voltage) {
            $query->where('voltage', $request->voltage);
        }

        // Add sorting
        $sortBy = $request->get('sort_by', 'created_at');
        $sortOrder = $request->get('sort_order', 'desc');
        $query->orderBy($sortBy, $sortOrder);

        // Load towers count if requested
        if ($request->has('include_towers_count') && $request->include_towers_count) {
            $includeTowersCount = filter_var($request->include_towers_count, FILTER_VALIDATE_BOOLEAN, FILTER_NULL_ON_FAILURE);
            if ($includeTowersCount === true) {
                $query->withCount('towers');
            }
        }

        // Load towers with details if requested
        if ($request->has('include_towers') && $request->include_towers) {
            $includeTowers = filter_var($request->include_towers, FILTER_VALIDATE_BOOLEAN, FILTER_NULL_ON_FAILURE);
            if ($includeTowers === true) {
                $includeTowerLegs = false;
                if ($request->has('include_tower_legs') && $request->include_tower_legs) {
                    $includeTowerLegs = filter_var($request->include_tower_legs, FILTER_VALIDATE_BOOLEAN, FILTER_NULL_ON_FAILURE);
                }
                
                if ($includeTowerLegs === true) {
                    $query->with('towers.legs');
                } else {
                    $query->with('towers');
                }
            }
        }

        // Pagination
        $perPage = $request->get('per_page', 15);
        $projects = $query->paginate($perPage);

        return response()->json([
            'data' => ProjectResource::collection($projects)->items(),
            'meta' => [
                'current_page' => $projects->currentPage(),
                'from' => $projects->firstItem(),
                'last_page' => $projects->lastPage(),
                'per_page' => $projects->perPage(),
                'to' => $projects->lastItem(),
                'total' => $projects->total(),
            ]
        ]);
    }

    /**
     * @OA\Get(
     *     path="/api/v1/projects/{id}",
     *     summary="Get a specific project",
     *     description="Retrieve a single project by its ID",
     *     operationId="getProject",
     *     tags={"Projects"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="Project ID",
     *         required=true,
     *         @OA\Schema(type="integer", example=1)
     *     ),
     *     @OA\Parameter(
     *         name="include_towers",
     *         in="query",
     *         description="Include towers with their details in response",
     *         required=false,
     *         @OA\Schema(type="boolean", default=false)
     *     ),
     *     @OA\Parameter(
     *         name="include_tower_legs",
     *         in="query",
     *         description="Include tower legs when towers are included",
     *         required=false,
     *         @OA\Schema(type="boolean", default=false)
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Successful operation",
     *         @OA\JsonContent(
     *             @OA\Property(property="data", ref="#/components/schemas/Project")
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Project not found",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Project not found")
     *         )
     *     )
     * )
     */
    public function show(Request $request, Project $project): JsonResponse
    {
        // Validate request parameters
        $validated = $request->validate([
            'include_towers' => 'nullable|in:true,false,1,0,"true","false","1","0"',
            'include_tower_legs' => 'nullable|in:true,false,1,0,"true","false","1","0"',
        ]);

        if ($request->has('include_towers') && $request->include_towers) {
            $includeTowers = filter_var($request->include_towers, FILTER_VALIDATE_BOOLEAN, FILTER_NULL_ON_FAILURE);
            if ($includeTowers === true) {
                $includeTowerLegs = false;
                if ($request->has('include_tower_legs') && $request->include_tower_legs) {
                    $includeTowerLegs = filter_var($request->include_tower_legs, FILTER_VALIDATE_BOOLEAN, FILTER_NULL_ON_FAILURE);
                }
                
                if ($includeTowerLegs === true) {
                    $project->load('towers.legs');
                } else {
                    $project->load('towers');
                }
            }
        }

        return response()->json([
            'data' => new ProjectResource($project)
        ]);
    }

    /**
     * @OA\Get(
     *     path="/api/v1/projects/{id}/with-towers",
     *     summary="Get a specific project with all tower details",
     *     description="Retrieve a single project by its ID with all towers and their legs included",
     *     operationId="getProjectWithTowers",
     *     tags={"Projects"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="Project ID",
     *         required=true,
     *         @OA\Schema(type="integer", example=1)
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Successful operation",
     *         @OA\JsonContent(
     *             @OA\Property(property="data", ref="#/components/schemas/Project")
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Project not found",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Project not found")
     *         )
     *     )
     * )
     */
    public function showWithTowers(Project $project): JsonResponse
    {
        // Load towers with their legs
        $project->load('towers.legs');

        return response()->json([
            'data' => new ProjectResource($project)
        ]);
    }
}
