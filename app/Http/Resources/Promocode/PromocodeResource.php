<?php

namespace App\Http\Resources\Promocode;

use Illuminate\Http\Resources\Json\JsonResource;

/**
 * Class PromocodeResource
 * @package App\Http\Resources\Promocode
 * @mixin  \App\Models\Promocode
 */
class PromocodeResource extends JsonResource
{
    public static $wrap=false;
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'code' => $this->code,
            'from_date' => $this->from_date->toDateString(),
            'to_date' => $this->to_date->toDateString(),
            'times' => $this->times,
            'percent' => $this->percent,
        ];
    }
}
