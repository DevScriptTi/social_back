<?php

namespace Database\Seeders;

use App\Models\Api\Extra\Baladya;
use App\Models\Api\Extra\Wilaya;
use App\Models\Api\User\Admin;
use App\Models\Api\User\Gurdian;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            BaladyaWilayaSeeder::class,
            UsersSeeder::class,
        ]);

        $a = Admin::create([
            'username' => 'admin',
        ]);
        $key = $a->key()->create(['value' => Str::random(32)]);
        $key->user()->create(['email' => 'fouzi-admin@gmail.com', 'password' => 'password']);
        $g =Gurdian::create([
            'username' => 'fouzi-djaafri-12345',
            'name' => 'Djaafri',
            'last' => 'Fouzi',
            'date_of_birth' => '1990-01-01',
            'baladya_id' => Baladya::first()->id,
        ]);
        $g->phones()->create(['number' => '0666000000']);
        $g->phones()->create(['number' => '0777000000']);
        $g->phones()->create(['number' => '0555000000']);
        $key = $g->key()->create(['value' => Str::random(32)]);
        $key->user()->create(['email' => 'fouzi@gmail.com', 'password' => 'password']);

    }
}
