<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Api\Users\SuperAdmin;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {

        $this->call([
            CommitteesWithRelationsSeeder::class,
        ]);

    }
}
