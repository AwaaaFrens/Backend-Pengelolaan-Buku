<?php

namespace Database\Seeders;

use App\Enum\UserRoleEnum;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Role::firstOrCreate(['name' => UserRoleEnum::Admin->value]);
        Role::firstOrCreate(['name' => UserRoleEnum::Member->value]);
    }
}
