<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str as SupportStr;
use Str;

class PermissionsFactory extends Factory
{
    public function definition()
    {
        return [
            'name' => SupportStr::random(10).' '.Str::random(10),
            'guard_name' => 'web'
        ];
    }
}
