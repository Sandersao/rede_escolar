<?php

use App\Matricula;
use Illuminate\Database\Seeder;

class MatriculaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        for ($i = 1; $i <= 500; $i++) {
            Matricula::create([
                'id_aluno' => $i,
                'id_turma' => rand(1, 31),
                'nota_primeiro_bimestre' => rand(0, 100) / 10,
                'nota_segundo_bimestre' => rand(0, 100) / 10,
                'nota_terceiro_bimestre' => rand(0, 100) / 10,
                'nota_quarto_bimestre' => rand(0, 100) / 10,
            ]);
        }
    }
}
