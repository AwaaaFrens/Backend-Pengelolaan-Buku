<?php

namespace Database\Seeders;

use App\Enum\UserRole;
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
        Role::firstOrCreate(['name' => UserRole::Admin->value]);
        Role::firstOrCreate(['name' => UserRole::Member->value]);
    }
}
