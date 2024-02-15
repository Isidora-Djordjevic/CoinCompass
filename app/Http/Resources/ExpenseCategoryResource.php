<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ExpenseCategoryResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */

    public static $wrap = 'expense_category';
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->resource->id,
            'categoryName'=>$this->resource->categoryName,
        ];
    }
}
