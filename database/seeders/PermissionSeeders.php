<?php

namespace Database\Seeders;

use App\Models\Permission;
use Illuminate\Database\Seeder;

class PermissionSeeders extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        $arrays = [
            ['name'=>'usuario','description'=>'Usuário'],
            ['name'=>'controle_acesso','description'=>'Controle de acesso'],
            ['name' => 'usuario', 'description' => 'Usuário'],
            ['name' => 'profissional', 'description' => 'Profissional'],
        ];

        foreach($arrays as $array){
            Permission::updateOrCreate(["name"=>$array['name']], $array);
        }
    }
}
