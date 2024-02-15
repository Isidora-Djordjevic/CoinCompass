<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class BudgetResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */

    public static $wrap = 'budget';

    public function toArray(Request $request): array
    {
        return [
            'id' => $this->resource->id,
            'sum' => $this->resource->sum,
            'user' => new UserResource($this->resource->user),
        ];
    }
}
