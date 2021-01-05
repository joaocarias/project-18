<?php

use Illuminate\Database\Seeder;

class EmpresaTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('empresas')->insert([           
            'nome' => 'Projeto 18',           
            'email' => 'contato@projeto_18.com',           
            'endereco_id' => 1,       
            'telefone' => '(84) 3615-2901',
            'usuario_cadastro' => 1,
            'created_at' => now(),
            'updated_at' => now()
        ]);
    }
}
