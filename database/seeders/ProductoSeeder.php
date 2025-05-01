<?php

namespace Database\Seeders;

use App\Models\Producto;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class ProductoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        for ($i = 1; $i <= 50; $i++) {
            Producto::create([
                'referencia' => 'REF-' . Str::upper(Str::random(6)),
                'nombre' => 'Producto ' . $i,
                'precio' => $precio = rand(100, 1000) / 10,
                'precio_publico' => $precio + rand(10, 100) / 10,
                'cantidad' => rand(1, 100),
            ]);
        }
    }
}
