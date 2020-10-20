<?php

use App\Escola;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class EscolaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        for ($i = 0; $i < 5; $i++) {
            Escola::create([
                'nome' => Str::random(30)
            ]);
        }
    }
}
