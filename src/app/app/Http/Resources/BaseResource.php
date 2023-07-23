<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Carbon;

class BaseResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param \Illuminate\Http\Request $request
     * @return array
     */
    public function toArray($request)
    {
        return parent::toArray($request);
    }

    /**
     * @return string
     */
    public function createdAtToString(): string
    {
        return $this->dateToString($this->created_at);
    }

    /**
     * @return string
     */
    public function updatedAtToString(): string
    {
        return $this->dateToString($this->updated_at);
    }

    private function dateToString(string $time): string
    {
        return Carbon::createFromFormat('Y-m-d H:i:s', $time)->format('Y年m月d日 H:i');
    }
}
