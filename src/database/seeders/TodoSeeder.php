<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Todo;

class TodoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Todo::create(['title' => 'Vynést koš']);
        Todo::create(['title' => 'Napsat testy']);
        Todo::create(['title' => 'Zavolat babičce', 'done' => true, 'completed_at' => now()->subHour()]);
    }
}
