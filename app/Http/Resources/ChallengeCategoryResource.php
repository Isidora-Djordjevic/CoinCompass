<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ChallengeCategoryResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public static $wrap = 'challenge_category';
    public function toArray(Request $request): array
    {
        return [
            'categoryName'=>$this->resource->categoryName,
        ];
    }
}
