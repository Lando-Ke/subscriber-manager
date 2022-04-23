<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class SubscriberResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'email_address' => $this->email_address,
            'created_at' => (string) $this->created_at,
            'updated_at' => (string) $this->updated_at,
            'state' => $this->state->name,
            'fields' => $this->getCustomFields($this->meta)
        ];
    }

    private function getCustomFields($fields)
    {
        $customFields = [];
        foreach ($fields as $field) {
            $customFields[$field->key] = $field->value;
        }

        return $customFields;
    }

}
