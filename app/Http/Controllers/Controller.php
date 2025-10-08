<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

/**
 * @OA\Info(
 *     title="Progress Monitoring API",
 *     version="1.0.0",
 *     description="API for managing projects and towers in the Progress Monitoring system",
 *     @OA\Contact(
 *         email="admin@example.com"
 *     )
 * )
 * 
 * @OA\Server(
 *     url="http://localhost:8000",
 *     description="Development server"
 * )
 * 
 * @OA\Components(
 *     @OA\SecurityScheme(
 *         securityScheme="bearerAuth",
 *         type="http",
 *         scheme="bearer",
 *         bearerFormat="JWT"
 *     ),
 *     @OA\Schema(
 *         schema="Project",
 *         type="object",
 *         required={"id", "title", "sub_title", "project_id", "location", "voltage", "status"},
 *         @OA\Property(property="id", type="integer", example=1),
 *         @OA\Property(property="title", type="string", example="Power Grid Project"),
 *         @OA\Property(property="sub_title", type="string", example="Main Transmission Line"),
 *         @OA\Property(property="project_id", type="string", example="PROJ-001"),
 *         @OA\Property(property="location", type="string", example="New York, NY"),
 *         @OA\Property(property="voltage", type="number", format="float", example=132),
 *         @OA\Property(property="status", type="string", example="active"),
 *         @OA\Property(property="towers_count", type="integer", example=5, description="Number of towers in this project"),
 *         @OA\Property(property="created_at", type="string", format="date-time", example="2024-01-01T00:00:00.000000Z"),
 *         @OA\Property(property="updated_at", type="string", format="date-time", example="2024-01-01T00:00:00.000000Z")
     *     ),
     *     @OA\Schema(
     *         schema="Tower",
     *         type="object",
     *         required={"id", "project_id", "tower_name", "tower_type", "foundation_progress", "tower_erection_progress", "conductor_progress"},
     *         @OA\Property(property="id", type="integer", example=1),
     *         @OA\Property(property="project_id", type="integer", example=1),
     *         @OA\Property(property="tower_name", type="string", example="Tower-001"),
     *         @OA\Property(property="tower_type", type="string", example="transmission"),
     *         @OA\Property(property="latitude", type="number", format="float", example=40.7128, nullable=true),
     *         @OA\Property(property="longitude", type="number", format="float", example=-74.0060, nullable=true),
     *         @OA\Property(property="foundation_progress", type="integer", example=85, description="Foundation progress percentage (0-100)"),
     *         @OA\Property(property="tower_erection_progress", type="integer", example=90, description="Tower erection progress percentage (0-100)"),
     *         @OA\Property(property="conductor_progress", type="integer", example=75, description="Conductor progress percentage (0-100)"),
     *         @OA\Property(property="overall_progress", type="integer", example=83, description="Overall progress percentage (calculated)"),
     *         @OA\Property(property="problems", type="string", example="Weather delay", nullable=true),
     *         @OA\Property(property="has_issues", type="boolean", example=true, description="Whether tower has any issues/problems"),
     *         @OA\Property(property="project", type="object", nullable=true, description="Project relationship (when included)",
     *             @OA\Property(property="id", type="integer", example=1),
     *             @OA\Property(property="title", type="string", example="Power Grid Project"),
     *             @OA\Property(property="project_id", type="string", example="PROJ-001")
     *         ),
     *         @OA\Property(property="legs", type="array", nullable=true, description="Tower legs relationship (when included)",
     *             @OA\Items(ref="#/components/schemas/TowerLeg")
     *         ),
     *         @OA\Property(property="legs_count", type="integer", example=4, description="Number of legs (when legs relationship is loaded)"),
     *         @OA\Property(property="created_at", type="string", format="date-time", example="2024-01-01T00:00:00.000000Z"),
     *         @OA\Property(property="updated_at", type="string", format="date-time", example="2024-01-01T00:00:00.000000Z")
     *     ),
     *     @OA\Schema(
     *         schema="TowerLeg",
     *         type="object",
     *         required={"id", "tower_id", "leg_name", "kitta_no", "owner", "amount"},
     *         @OA\Property(property="id", type="integer", example=1),
     *         @OA\Property(property="tower_id", type="integer", example=1),
     *         @OA\Property(property="leg_name", type="string", example="Leg-A"),
     *         @OA\Property(property="kitta_no", type="string", example="KITTA-001"),
     *         @OA\Property(property="owner", type="string", example="John Doe"),
     *         @OA\Property(property="amount", type="number", format="float", example=50000.00),
     *         @OA\Property(property="remarks", type="string", example="Completed on time", nullable=true)
     *     ),
     *     @OA\Schema(
     *         schema="Error",
 *         type="object",
 *         @OA\Property(property="message", type="string", example="Error message"),
 *         @OA\Property(property="errors", type="object", example={"field": {"Error message"}})
 *     )
 * )
 */
abstract class Controller extends BaseController
{
    use AuthorizesRequests, ValidatesRequests;
}