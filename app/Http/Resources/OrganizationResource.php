<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class OrganizationResource extends JsonResource
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
            'name' => $this->name,
            'building' => $this->whenLoaded('building', function () {
                return $this->building->address;
            }),
            'activities' => $this->whenLoaded('activities', function () {
                return $this->activities->map(function ($activity) {
                    return $activity->name;
                });
            }),
            'phones' => $this->whenLoaded('phones', function () {
                return $this->phones->map(function ($phone) {
                    return $phone->number;
                });
            })
        ];
    }
}
