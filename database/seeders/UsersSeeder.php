<?php

namespace Database\Seeders;

use App\Models\Api\User\Gurdian;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class UsersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $firstNames = ['Brahimi', 'Benali', 'Haddad', 'Mokhtar', 'Saadi', 'Zeroual', 'Boualem', 'Cherif', 'Djebbar', 'Kacem'];
        $lastNames = ['Ahmed', 'Mohamed', 'Fatima', 'Khadija', 'Youssef', 'Amine', 'Nadia', 'Samira', 'Karim', 'Amina'];

        $gurdians = [];

        for ($i = 1; $i <= 40; $i++) {
            $firstName = $firstNames[array_rand($firstNames)];
            $lastName = $lastNames[array_rand($lastNames)];
            $gurdians[] = [
            'username' => strtolower($firstName . '-' . $lastName . '-' . rand(1000, 9999)),
            'name' => $firstName,
            'last' => $lastName,
            'date_of_birth' => now()->subYears(rand(20, 50))->format('Y-m-d'),
            'baladya_id' => rand(1, 48),
            'phone' => [
            ['number' => '0666' . rand(100000, 999999)],
            ['number' => '0772' . rand(100000, 999999)],
            ['number' => '0552' . rand(100000, 999999)],
            ],
            ];
        }

        foreach ($gurdians as $gurdian) {

            $gurd = Gurdian::create([
            'username' => $gurdian['username'],
            'name' => $gurdian['name'],
            'last' => $gurdian['last'],
            'date_of_birth' => $gurdian['date_of_birth'],
            'baladya_id' => $gurdian['baladya_id'],
            ]);
            foreach ($gurdian['phone'] as $phone) {
            $gurd->phones()->create($phone);
            }

            // Create children for each gurdian
            $childrenCount = rand(0, 4);
            for ($j = 0; $j < $childrenCount; $j++) {
            $childFirstName = $firstNames[array_rand($firstNames)];
            $childLastName = $lastNames[array_rand($lastNames)];
            $child = $gurd->childrens()->create([
                'username' => strtolower($childFirstName . '-' . $childLastName . '-' . rand(1000, 9999)),
                'name' => $childFirstName,
                'last' => $childLastName,
                'date_of_birth' => now()->subYears(rand(1, 18))->format('Y-m-d'),
                'description' => 'Child of ' . $gurdian['name'] . ' ' . $gurdian['last'],
                'baladya_id' => rand(1, 48),
                'gurdian_id' => $gurd->id,
            ]);

            // Create bracelet for each child
            $bracelet = $child->braclet()->create([
                'mac' => Str::random(12),
                'status' => rand(0, 1) ? 'on' : 'off',
            ]);

            // Create location for bracelet
            $bracelet->location()->create([
                'lat' => rand(-90, 90) + rand() / getrandmax(),
                'lng' => rand(-180, 180) + rand() / getrandmax(),
            ]);

            // Create unique circle for bracelet
            $circle = $bracelet->circle()->create([
                'radius' => rand(1, 100),
            ]);
            $circle->location()->create([
                'lat' => rand(-90, 90) + rand() / getrandmax(),
                'lng' => rand(-180, 180) + rand() / getrandmax(),
            ]);
            }
        }
    }
}
