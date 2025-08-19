<?php

namespace Database\Seeders;

use App\Models\Curso;
use App\Models\Estudiante;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        Estudiante::factory()->times(15)->create();
        Curso::factory()->times(8)->create()->each(
            function($curso){
                $curso->estudiantes()->sync(
                    Estudiante::all()->random(3));
            }
        );
        // User::factory(10)->create();

        //User::factory()->create([
        //    'name' => 'Test User',
        //    'email' => 'test@example.com',
        //]);
    }
}
