<?php

use Illuminate\Database\Seeder;

class EnderecoTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('enderecos')->insert([
            'logradouro' => 'Rua Valmir Targino',           
            'numero' => '356',
            'bairro' => 'Centro',                        
            'cep' => '59775-000',
            'cidade' => 'Messias Targino',
            'uf' => 'RN',
            'usuario_cadastro' => '1',
            'created_at' => now(),
            'updated_at' => now()
        ]);
    }
}
