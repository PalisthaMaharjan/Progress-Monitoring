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