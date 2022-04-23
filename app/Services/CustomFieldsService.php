<?php

namespace App\Services;

use App\Exceptions\InvalidFieldException;
use App\Models\Field;

class CustomFieldsService
{
    public function setCustomFields($fields)
    {
        $customFields = [];

        foreach ($fields as $key => $field) {

            throw_unless($this->validatedCustomField($field), new InvalidFieldException());

            Field::firstOrCreate([
                'title' => $key,
                'type' => $field['type'],
            ]);

            $customFields[$key] = $field['value'];
        }

        return $customFields;
    }

    private function validatedCustomField($field)
    {
        if (is_array($field)) {
            if (array_key_exists('type', $field) && array_key_exists('value', $field)) {
                if (! in_array($field['type'], config('subscriber.fields.allowed'))) {
                    return false;
                } else {
                    return true;
                }
            } else {
                return false;
            }
        } else {
            return false;
        }
    }
}
