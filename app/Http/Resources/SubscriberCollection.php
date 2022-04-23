<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\ResourceCollection;

class SubscriberCollection extends ResourceCollection
{
    /**
     * Transform the resource collection into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'data' => SubscriberResource::collection($this->collection),
            'meta' => [
                "current_page" => $this->currentPage(),
                "last_page" =>  $this->lastPage(),
                "per_page" =>  $this->perPage(),
                "total" =>  $this->total(),
                "path" =>  $this->getOptions()['path']
            ],
            'links' => [
                "first" =>  $this->getOptions()['path'].'?'.$this->getOptions()['pageName'].'=1',
                "prev" =>  $this->previousPageUrl(),
                "next" =>  $this->nextPageUrl(),
                "last" =>  $this->getOptions()['path'].'?'.$this->getOptions()['pageName'].'='.$this->lastPage(),
            ]
        ];
    }
}
