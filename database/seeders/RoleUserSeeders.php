<?php

namespace Database\Seeders;

use App\Models\Role;
use App\Models\RoleUser;
use App\Models\User;
use Illuminate\Database\Seeder;

class RoleUserSeeders extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user = User::where('email', 'admin@bs.com')->first();
        $role = Role::where('name', 'admin')->first();

        if ($user && $role) {
            RoleUser::updateOrCreate([
                'role_id' => $role->id,
                'user_id' => $user->id
            ]);
        }
    }
}
