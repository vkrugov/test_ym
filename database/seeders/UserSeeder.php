<?php

namespace Database\Seeders;

use App\Models\Company;
use App\Models\Profile;
use App\Models\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::factory()->count(5)->create()->each(function (User $user) {
            $user->profile()->save(Profile::factory()->make());
            for ($i = 0; $i <= 2; $i++) {
                $company = Company::factory()->create();
                $user->companies()->attach($company);
            }
        });
    }
}
