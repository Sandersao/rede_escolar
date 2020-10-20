<?php

use App\Turma;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class TurmaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $randAnoLetivo = date('Y');
        for ($i = 0; $i < 31; $i++) {
            Turma::create([
                'serie' => rand(1, 9),
                'ano' => $randAnoLetivo,
                'letra_identificadora' => strtoupper(Str::random(1)),
                'fk_escola' => rand(1, 5),
            ]);
        }
    }
}
