<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ProjectResource extends JsonResource
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
            'title' => $this->title,
            'sub_title' => $this->sub_title,
            'project_id' => $this->project_id,
            'location' => $this->location,
            'voltage' => $this->voltage,
            'status' => $this->status,
            'towers_count' => $this->whenLoaded('towers', function () {
                return $this->towers->count();
            }),
            'towers' => $this->whenLoaded('towers', function () {
                return $this->towers->map(function ($tower) {
                    return [
                        'id' => $tower->id,
                        'tower_name' => $tower->tower_name,
                        'tower_type' => $tower->tower_type,
                        'address' => $tower->address,
                        'latitude' => $tower->latitude,
                        'longitude' => $tower->longitude,
                        'foundation_progress' => $tower->foundation_progress,
                        'tower_erection_progress' => $tower->tower_erection_progress,
                        'stringing_progress' => $tower->stringing_progress,
                        'overall_progress' => $tower->overall_progress,
                        'problems' => $tower->problems,
                        'has_issues' => $tower->hasIssues(),
                        'legs' => $tower->relationLoaded('legs') ? $tower->legs->map(function ($leg) {
                            return [
                                'id' => $leg->id,
                                'leg_name' => $leg->leg_name,
                                'kitta_no' => $leg->kitta_no,
                                'owner' => $leg->owner,
                                'amount' => $leg->amount,
                                'remarks' => $leg->remarks,
                            ];
                        }) : null,
                        'legs_count' => $tower->relationLoaded('legs') ? $tower->legs->count() : null,
                        'created_at' => $tower->created_at?->toISOString(),
                        'updated_at' => $tower->updated_at?->toISOString(),
                    ];
                });
            }),
            'created_at' => $this->created_at?->toISOString(),
            'updated_at' => $this->updated_at?->toISOString(),
        ];
    }
}
