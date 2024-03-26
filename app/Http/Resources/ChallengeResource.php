<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ChallengeResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public static $wrap = 'challenge';
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->resource->id,
            'challengeName' => $this->resource->challengeName,
            'user' => new UserResource($this->user),
            'status' => $this->resource->status,
            'value' => $this->resource->value,
            'startDate' => $this->resource->startDate,
            'endDate' => $this->resource->endDate,
            'challengeCategory' => $this->resource->category,
        ];
    }
}
