<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;

class BudgetCollection extends ResourceCollection
{
    /**
     * Transform the resource collection into an array.
     *
     * @return array<int|string, mixed>
     */

     public static $wrap = 'budgets';
    public function toArray(Request $request): array
    {
        return parent::toArray($request);
    }
}