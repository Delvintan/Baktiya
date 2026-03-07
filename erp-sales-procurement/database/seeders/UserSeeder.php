<?php
namespace Database\Seeders;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        User::insert([
            ['name' => 'Admin',          'email' => 'admin@erp.com',       'password' => Hash::make('password'), 'role' => 'admin',       'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Budi Sales',     'email' => 'sales@erp.com',       'password' => Hash::make('password'), 'role' => 'sales',       'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Andi Procure',   'email' => 'procurement@erp.com', 'password' => Hash::make('password'), 'role' => 'procurement', 'created_at' => now(), 'updated_at' => now()],
        ]);
    }
}
