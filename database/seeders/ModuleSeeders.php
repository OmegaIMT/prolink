<?php

namespace Database\Seeders;

use App\Models\Module;
use Illuminate\Database\Seeder;

class ModuleSeeders extends Seeder
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
        ];

        foreach($arrays as $array){
            Module::updateOrCreate(["name"=>$array['name']], $array);
        }
    }
}
