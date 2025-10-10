<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\TowerResource;
use App\Models\Tower;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

/**
 * @OA\Tag(
 *     name="Towers",
 *     description="API endpoints for managing towers"
 * )
 */
class TowerController extends Controller
{
    /**
     * @OA\Get(
     *     path="/api/v1/towers",
     *     summary="Get list of towers",
     *     description="Retrieve a paginated list of towers with optional filtering, searching, and sorting",
     *     operationId="getTowers",
     *     tags={"Towers"},
     *     @OA\Parameter(
     *         name="search",
     *         in="query",
     *         description="Search term to filter towers by tower_name, tower_type, or problems",
     *         required=false,
     *         @OA\Schema(type="string", example="transmission")
     *     ),
     *     @OA\Parameter(
     *         name="project_id",
     *         in="query",
     *         description="Filter towers by project ID",
     *         required=false,
     *         @OA\Schema(type="integer", example=1)
     *     ),
     *     @OA\Parameter(
     *         name="tower_type",
     *         in="query",
     *         description="Filter towers by tower type",
     *         required=false,
     *         @OA\Schema(type="string", example="transmission")
     *     ),
     *     @OA\Parameter(
     *         name="min_progress",
     *         in="query",
     *         description="Filter towers by minimum overall progress percentage",
     *         required=false,
     *         @OA\Schema(type="integer", minimum=0, maximum=100, example=50)
     *     ),
     *     @OA\Parameter(
     *         name="max_progress",
     *         in="query",
     *         description="Filter towers by maximum overall progress percentage",
     *         required=false,
     *         @OA\Schema(type="integer", minimum=0, maximum=100, example=100)
     *     ),
     *     @OA\Parameter(
     *         name="has_issues",
     *         in="query",
     *         description="Filter towers that have issues/problems",
     *         required=false,
     *         @OA\Schema(type="string", enum={"true", "false"}, example="false")
     *     ),
     *     @OA\Parameter(
     *         name="sort_by",
     *         in="query",
     *         description="Field to sort by",
     *         required=false,
     *         @OA\Schema(type="string", enum={"id", "tower_name", "tower_type", "foundation_progress", "tower_erection_progress", "stringing_progress", "created_at", "updated_at"}, default="created_at")
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
     *         name="include_project",
     *         in="query",
     *         description="Include project relationship in response",
     *         required=false,
     *         @OA\Schema(type="string", enum={"true", "false", "1", "0"}, default="false")
     *     ),
     *     @OA\Parameter(
     *         name="include_legs",
     *         in="query",
     *         description="Include legs relationship in response",
     *         required=false,
     *         @OA\Schema(type="string", enum={"true", "false", "1", "0"}, default="false")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Successful operation",
     *         @OA\JsonContent(
     *             @OA\Property(property="data", type="array", @OA\Items(ref="#/components/schemas/Tower")),
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
            'project_id' => 'nullable|integer|exists:projects,id',
            'tower_type' => 'nullable|string|max:255',
            'min_progress' => 'nullable|integer|min:0|max:100',
            'max_progress' => 'nullable|integer|min:0|max:100',
            'has_issues' => 'nullable|in:true,false,1,0,"true","false","1","0"',
            'sort_by' => 'nullable|string|in:id,tower_name,tower_type,foundation_progress,tower_erection_progress,stringing_progress,created_at,updated_at',
            'sort_order' => 'nullable|string|in:asc,desc',
            'per_page' => 'nullable|integer|min:1|max:100',
            'include_project' => 'nullable|in:true,false,1,0,"true","false","1","0"',
            'include_legs' => 'nullable|in:true,false,1,0,"true","false","1","0"',
        ]);

        $query = Tower::query();

        // Add search functionality
        if ($request->has('search') && $request->search) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('tower_name', 'like', "%{$search}%")
                  ->orWhere('tower_type', 'like', "%{$search}%")
                  ->orWhere('problems', 'like', "%{$search}%");
            });
        }

        // Add project filter
        if ($request->has('project_id') && $request->project_id) {
            $query->where('project_id', $request->project_id);
        }

        // Add tower type filter
        if ($request->has('tower_type') && $request->tower_type) {
            $query->where('tower_type', $request->tower_type);
        }

        // Add progress filters
        if ($request->has('min_progress') && $request->min_progress) {
            $query->whereRaw('(foundation_progress + tower_erection_progress + stringing_progress) / 3 >= ?', [$request->min_progress]);
        }

        if ($request->has('max_progress') && $request->max_progress) {
            $query->whereRaw('(foundation_progress + tower_erection_progress + stringing_progress) / 3 <= ?', [$request->max_progress]);
        }

        // Add issues filter
        if ($request->has('has_issues') && $request->has_issues) {
            $hasIssues = filter_var($request->has_issues, FILTER_VALIDATE_BOOLEAN, FILTER_NULL_ON_FAILURE);
            if ($hasIssues === true) {
                $query->whereNotNull('problems')->where('problems', '!=', '');
            } elseif ($hasIssues === false) {
                $query->where(function ($q) {
                    $q->whereNull('problems')->orWhere('problems', '');
                });
            }
        }

        // Add sorting
        $sortBy = $request->get('sort_by', 'created_at');
        $sortOrder = $request->get('sort_order', 'desc');
        $query->orderBy($sortBy, $sortOrder);

        // Load relationships if requested
        if ($request->has('include_project') && $request->include_project) {
            $includeProject = filter_var($request->include_project, FILTER_VALIDATE_BOOLEAN, FILTER_NULL_ON_FAILURE);
            if ($includeProject === true) {
                $query->with('project');
            }
        }

        if ($request->has('include_legs') && $request->include_legs) {
            $includeLegs = filter_var($request->include_legs, FILTER_VALIDATE_BOOLEAN, FILTER_NULL_ON_FAILURE);
            if ($includeLegs === true) {
                $query->with('legs');
            }
        }

        // Pagination
        $perPage = $request->get('per_page', 15);
        $towers = $query->paginate($perPage);

        return response()->json([
            'data' => TowerResource::collection($towers)->items(),
            'meta' => [
                'current_page' => $towers->currentPage(),
                'from' => $towers->firstItem(),
                'last_page' => $towers->lastPage(),
                'per_page' => $towers->perPage(),
                'to' => $towers->lastItem(),
                'total' => $towers->total(),
            ]
        ]);
    }

    /**
     * @OA\Get(
     *     path="/api/v1/towers/{id}",
     *     summary="Get a specific tower",
     *     description="Retrieve a single tower by its ID",
     *     operationId="getTower",
     *     tags={"Towers"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="Tower ID",
     *         required=true,
     *         @OA\Schema(type="integer", example=1)
     *     ),
     *     @OA\Parameter(
     *         name="include_project",
     *         in="query",
     *         description="Include project relationship in response",
     *         required=false,
     *         @OA\Schema(type="string", enum={"true", "false", "1", "0"}, default="false")
     *     ),
     *     @OA\Parameter(
     *         name="include_legs",
     *         in="query",
     *         description="Include legs relationship in response",
     *         required=false,
     *         @OA\Schema(type="string", enum={"true", "false", "1", "0"}, default="false")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Successful operation",
     *         @OA\JsonContent(
     *             @OA\Property(property="data", ref="#/components/schemas/Tower")
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Tower not found",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Tower not found")
     *         )
     *     )
     * )
     */
    public function show(Request $request, Tower $tower): JsonResponse
    {
        // Validate request parameters
        $validated = $request->validate([
            'include_project' => 'nullable|in:true,false,1,0,"true","false","1","0"',
            'include_legs' => 'nullable|in:true,false,1,0,"true","false","1","0"',
        ]);

        // Load relationships if requested
        if ($request->has('include_project') && $request->include_project) {
            $includeProject = filter_var($request->include_project, FILTER_VALIDATE_BOOLEAN, FILTER_NULL_ON_FAILURE);
            if ($includeProject === true) {
                $tower->load('project');
            }
        }

        if ($request->has('include_legs') && $request->include_legs) {
            $includeLegs = filter_var($request->include_legs, FILTER_VALIDATE_BOOLEAN, FILTER_NULL_ON_FAILURE);
            if ($includeLegs === true) {
                $tower->load('legs');
            }
        }

        return response()->json([
            'data' => new TowerResource($tower)
        ]);
    }
}
