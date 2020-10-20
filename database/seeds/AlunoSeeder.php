<?php

use App\Aluno;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Str;

class AlunoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        for ($i = 0; $i < 500; $i++) {
            $auxMes = rand(1, 12);
            $auxMaxDias = [
                0, 31, 28, 31, 30, 31, 30,
                31, 31, 30, 31, 30, 31
            ];
            $auxDia = rand(1, 31);
            $auxDia =
                $auxDia > $auxMaxDias[$auxMes] ?
                $auxMaxDias[$auxMes] :
                $auxDia;
            Aluno::create([
                'nome' => Str::random(15),
                'cpf' => rand(11111111111, 99999999999),
                'email' => Str::random(15) .
                    (rand(1, 100) >= 50 ? '@hotmail.com' : '@gmail.com'),
                'data_nascimento' => rand(1993, 2008) .
                    '-' . $auxMes .
                    '-' . $auxDia,
            ]);
        }
    }
}
