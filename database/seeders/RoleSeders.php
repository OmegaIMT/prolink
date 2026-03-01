<?php

namespace Database\Seeders;

use App\Models\Role;
use Illuminate\Database\Seeder;

class RoleSeders extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $arrays = [
            ['name'=>'admin','description'=>'Administrador'],
            ['name'=>'usuario','description'=>'Usuário'],
        ];
        foreach($arrays as $array){
           Role::updateOrCreate(
                ['name' => $array['name']],
                $array
            );
        }
    }
}
