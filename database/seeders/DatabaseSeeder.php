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
        $admin = SuperAdmin::create([
            'username' => 'Dev_Script_FD',
            'name' => 'Dev',
            'last' => 'Script',
            'is_super' => true,
        ]);
        $key = $admin->key()->create([
            'value' => str()->random(10),
        ]);
        $key->user()->create([
            'email' => 'superadmin@gmail.com',
            'password' =>'password',
        ]);

        $this->call([
            DairasSeeders::class,
            CommitteesWithRelationsSeeder::class,
        ]);

    }
}
