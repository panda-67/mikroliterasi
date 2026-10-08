<?php

namespace App\Support;

use Mews\Purifier\Facades\Purifier;

class HtmlSanitizer
{
    public function clean(
        ?string $html,
        string $profile = 'default'
    ): ?string {
        if ($html === null) {
            return null;
        }

        return Purifier::clean($html, $profile);
    }

    public function cleanMany(
        array $data,
        array $fields,
        string $profile = 'default'
    ): array {
        foreach ($fields as $field) {
            if (array_key_exists($field, $data)) {
                $data[$field] = $this->clean(
                    $data[$field],
                    $profile
                );
            }
        }

        return $data;
    }
}
