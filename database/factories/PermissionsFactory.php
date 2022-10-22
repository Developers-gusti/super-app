<?php

namespace Database\Factories;

use App\Models\Permissions;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str as SupportStr;
use Str;

class PermissionsFactory extends Factory
{
    protected $model = Permissions::class;
    public function definition()
    {
        return [
            'name' => SupportStr::random(10).' '.Str::random(10),
            'guard_name' => 'web'
        ];
    }
}
