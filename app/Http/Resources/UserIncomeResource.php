<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UserIncomeResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->resource->id,
            'incomeName' => $this->resource->incomeName,
            'incomeDate' => $this->resource->incomeDate,
            'incomeValue' => $this->resource->incomeValue,
            'user' => new UserResource($this->resource->user),
        ];
    }
}
