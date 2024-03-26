<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */

    public static $wrap = 'user';

    public function toArray(Request $request): array
    {


        return [
            'username'=>  $this->resource->username,
            //'name'=>  $this->resource->name,
            'email'=>  $this->resource->email,
            'budget'=> $this->resource->budget,
            'incomes_sum' => $this->resource->incomes_sum,
            'expenses_sum'=> $this->resource->expenses_sum,
        ];
    }
}
