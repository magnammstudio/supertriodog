<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;

class addressResource extends ResourceCollection
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        // return parent::toArray($request);
        return [
            'data'=>$this->collection
            // 'id'=>$this->id,
            // 'province'=>$this->Province,
            // 'district'=>$this->District,
            // 'tambon'=>$this->Tambon,
        ];
    }
}
