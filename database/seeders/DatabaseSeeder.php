<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\User;
use Illuminate\Database\Seeder;


class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    // public function run(): void
    // {
    //     // \App\Models\User::factory(10)->create();

    //     // \App\Models\User::factory()->create([
    //     //     'name' => 'Test User',
    //     //     'email' => 'test@example.com',
    //     // ]);
    public function run(): void
    {


        $this->UserSeeder();
    }
    public function UserSeeder()
    {
        $admin_user = new User();
        $admin_user->name = "Loc";
        $admin_user->username  = "Loc123";
        $admin_user->role  = 1;
        $admin_user->email = "loc@gmail.com";
        $admin_user->password = bcrypt(123456);
        $admin_user->photo = 'Screenshot 2023-08-16 102203.png';
        $admin_user->save();

        $admin_user = new User();
        $admin_user->name = "Phi";
        $admin_user->username  = "phi123";
        $admin_user->role  = 2;
        $admin_user->email = "phi@gmail.com";
        $admin_user->password = bcrypt(123456);
        $admin_user->photo = 'Screenshot 2023-08-16 102203.png';
        $admin_user->save();
    }
}
