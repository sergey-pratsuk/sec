<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Material;
use App\Models\User;

class ConstructionSeeder extends Seeder
{
    public function run(): void
    {
        // Олег
        User::factory()->create([
            'name' => 'Олег (КПП-2)',
            'email' => 'oleg@ans.kz',
            'password' => bcrypt('password'),
        ]);

        // Жандос
        User::factory()->create([
            'name' => 'Жандос (КПП-2)',
            'email' => 'zhandos@ans.kz',
            'password' => bcrypt('password'),
        ]);


        // Я
        User::factory()->create([
            'name' => 'Сергей (КПП-2)',
            'email' => 'sergey@ans.kz',
            'password' => bcrypt('password'),
        ]);

        // Материалы
        $materials = [
            ['name' => 'Песок строительный (карьерный)', 'unit' => 'м3'],
            ['name' => 'Щебень гранитный фр. 20-40', 'unit' => 'м3'],
            ['name' => 'Бетон товарный БСТ В25 (М350)', 'unit' => 'м3'],
            ['name' => 'Арматура рифленая А500С 12мм', 'unit' => 'т'],
            ['name' => 'Кирпич рядовой полнотелый М150', 'unit' => 'шт'],
            ['name' => 'Цемент М500 (в мешках)', 'unit' => 'кг'],
        ];

        foreach ($materials as $material) {
            Material::updateOrCreate(['name' => $material['name']], $material);
        }
    }
}
