<?php

namespace App\Http\Resources;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class TaskResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  Request  $request
     * @return array<string, mixed>
     */
    public function toArray($request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'description' => $this->description,
            'delivered_at' => $this->delivered_at ? Carbon::make($this->delivered_at)->format('Y-m-d') : null,
            'created_at' => Carbon::make($this->created_at)->format('Y-m-d'),
            'updated_at' => Carbon::make($this->updated_at)->format('Y-m-d'),
        ];
    }
}
