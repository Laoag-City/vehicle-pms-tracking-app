<?php

namespace App\Enum;

use Illuminate\Support\Collection;

enum Role: string
{
    case Administrator = 'Administrator';
    case Executive = 'Executive';
    case GSO_Administrator = 'GSO Administrator';
    case GSO_Encoder = 'GSO Encoder';
    case Regular_User = 'Regular User';

    public static function toCollection(): Collection
    {
        return collect(self::cases())->transform(function($item, $key) {
            return ['role' => $item->value];
        });
    }
}
