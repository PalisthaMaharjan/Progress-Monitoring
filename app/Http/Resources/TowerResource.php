<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class TowerResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'project_id' => $this->project_id,
            'tower_name' => $this->tower_name,
            'tower_type' => $this->tower_type,
            'latitude' => $this->latitude,
            'longitude' => $this->longitude,
            'foundation_progress' => $this->foundation_progress,
            'tower_erection_progress' => $this->tower_erection_progress,
            'stringing_progress' => $this->stringing_progress,
            'overall_progress' => $this->overall_progress,
            'problems' => $this->problems,
            'has_issues' => $this->hasIssues(),
            'project' => $this->whenLoaded('project', function () {
                return [
                    'id' => $this->project->id,
                    'title' => $this->project->title,
                    'project_id' => $this->project->project_id,
                ];
            }),
            'legs' => $this->whenLoaded('legs', function () {
                return $this->legs->map(function ($leg) {
                    return [
                        'id' => $leg->id,
                        'leg_name' => $leg->leg_name,
                        'kitta_no' => $leg->kitta_no,
                        'owner' => $leg->owner,
                        'amount' => $leg->amount,
                        'remarks' => $leg->remarks,
                    ];
                });
            }),
            'legs_count' => $this->whenLoaded('legs', function () {
                return $this->legs->count();
            }),
            'created_at' => $this->created_at?->toISOString(),
            'updated_at' => $this->updated_at?->toISOString(),
        ];
    }
}
