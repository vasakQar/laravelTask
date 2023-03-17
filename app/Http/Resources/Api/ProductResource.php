<?php

namespace App\Http\Resources\Api;

use Carbon\Carbon;
use Illuminate\Http\Resources\Json\JsonResource;

class ProductResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        $prodLocalization = $this->getName($request->lang_id);
        $name = $prodLocalization['name'];
        $langId = $prodLocalization['lang_id'];

        return [
            'id' => $this->id,
            'name' => $name,
            'price' => $this->price,
            'currency' => $this->currency,
            'stock' => $this->stock,
            'price' => $this->price,
            'lang_id' => $langId,
            'created_at' => Carbon::parse($this->created_at)->format('Y-m-d H:i:s')
        ];
    }
}
