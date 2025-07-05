<?php

declare(strict_types=1);

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

final class PovSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('povs')->insert([
            ['slug' => 'first-person', 'name' => 'First Person', 'active' => true, 'order' => 1],
            ['slug' => 'second-person', 'name' => 'Second Person', 'active' => true, 'order' => 2],
            ['slug' => 'third-person-limited', 'name' => 'Third Person Limited', 'active' => true, 'order' => 3],
            ['slug' => 'third-person-objective', 'name' => 'Third Person Objective', 'active' => true, 'order' => 4],
            ['slug' => 'third-person-omniscient', 'name' => 'Third Person Omniscient', 'active' => true, 'order' => 5],
            ['slug' => 'multiple', 'name' => 'Multiple', 'active' => true, 'order' => 6],
            ['slug' => 'other', 'name' => 'Other', 'active' => true, 'order' => 7],
        ]);
    }
}
