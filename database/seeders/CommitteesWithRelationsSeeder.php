<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Api\Core\Daira;
use App\Models\Api\Core\Key;
use App\Models\Api\Users\Committee;
use App\Models\Api\Users\Employee;
use App\Models\Api\Main\Applicant;
use App\Models\Api\Main\Wife;
use App\Models\Api\Main\Application;
use App\Models\Api\Main\Professional;
use App\Models\Api\Main\Housing;
use App\Models\Api\Main\File;
use App\Models\Api\Main\Health;
use App\Models\Api\Main\Grade;
use App\Models\Api\Main\Social;
use App\Models\Api\Main\Photo;
use App\Models\Api\Users\SuperAdmin;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class CommitteesWithRelationsSeeder extends Seeder
{
    private $algerianFirstNames = [
        'Mohamed',
        'Ahmed',
        'Ali',
        'Youssef',
        'Abdellah',
        'Mustapha',
        'Karim',
        'Samir',
        'Adel',
        'Nassim',
        'Farid',
        'Rachid',
        'Said',
        'Hakim',
        'Bilal',
        'Amine',
        'Fatima',
        'Amina',
        'Khadija',
        'Zohra',
        'Yasmina',
        'Samira',
        'Nadia',
        'Leila',
        'Soraya',
        'Djamila',
        'Hafsa',
        'Meriem',
        'Salima',
        'Rym',
        'Nawel',
        'Imane',
        'Lamia',
        'Sabrina',
        'Nour',
        'Hana',
        'Souad',
        'Malika',
        'Asma',
        'Ikram',
        'Yasmine',
        'Lina',
        'Aya',
        'Sara',
        'Ines',
        'Amira',
        'Rania',
        'Nesrine',
        'Hiba',
        'Warda',
        'Aicha',
        'Soumia',
        'Nourhane',
        'Selma',
        'Houda',
        'Ferial',
        'Nabila',
        'Latifa',
        'Chahinez',
        'Mounia',
        'Siham',
        'Fadila',
        'Naima',
        'Zineb',
        'Amel',
        'Ilhem',
        'Kenza',
        'Lynda',
        'Maya',
        'Nouria',
        'Rim',
        'Sarra',
        'Sonia',
        'Yamina',
        'Zakia',
        'Ahlam',
        'Amina',
        'Baya',
        'Dounia',
        'Fatiha',
        'Ghania',
        'Hind',
        'Jamila',
        'Karima',
        'Lamia',
        'Meriem',
        'Nadia',
        'Noura',
        'Rachida',
        'Samia',
        'Souhila',
        'Wissam',
        'Yasmina',
        'Zohra',
        'Amani',
        'Anissa'
    ];

    private $algerianLastNames = [
        'Benzema',
        'Boukherroub',
        'Chaoui',
        'Dahmani',
        'Fellah',
        'Gacem',
        'Hamdi',
        'Iberaken',
        'Khelifi',
        'Lounis',
        'Mansouri',
        'Nait',
        'Ouali',
        'Rahmani',
        'Saadi',
        'Taleb',
        'Zitouni',
        'Abbas',
        'Bouchene',
        'Cherif',
        'Draoui',
        'Ait',
        'Belaid',
        'Bendjebbar',
        'Bensalem',
        'Boudjemaa',
        'Chabane',
        'Djebbar',
        'Fekir',
        'Guediri',
        'Haddad',
        'Ibrahim',
        'Kaci',
        'Lahmar',
        'Mahdi',
        'Nacer',
        'Omar',
        'Rabah',
        'Salah',
        'Tarek',
        'Zaki',
        'Abdelkader',
        'Bachir',
        'Belkacem',
        'Boualem',
        'Chikh',
        'Djamel',
        'Farouk',
        'Ghani',
        'Hamza',
        'Ismail',
        'Kamel',
        'Lotfi',
        'Mehdi',
        'Nadir',
        'Othmane',
        'Rafik',
        'Slimane',
        'Tahar',
        'Walid',
        'Yacine',
        'Zahir',
        'Ammar',
        'Bachir',
        'Belhadj',
        'Bouaziz',
        'Charef',
        'Djebbour',
        'Fethi',
        'Goucem',
        'Halim',
        'Ilyes',
        'Khaled',
        'Lyes',
        'Mokhtar',
        'Nourredine',
        'Oussama',
        'Riad',
        'Sofiane',
        'Tewfik',
        'Wassim',
        'Younes',
        'Zoubir',
        'Abdelhak',
        'Belaid',
        'Bendjelloul',
        'Benslimane',
        'Boukhari',
        'Chikhi',
        'Djebli',
        'Fares'
    ];

    private $jobs = [
        'Enseignant',
        'Médecin',
        'Ingénieur',
        'Infirmier',
        'Comptable',
        'Administrateur',
        'Technicien',
        'Secrétaire',
        'Chauffeur',
        'Ouvrier'
    ];

    private $publicSectorJobs = [
        'Fonctionnaire',
        'Employé de mairie',
        'Agent administratif',
        'Enseignant',
        'Policier',
        'Militaire'
    ];
    private $privateSectorJobs = [
        'Employé de banque',
        'Agent de sécurité',
        'Vendeur',
        'Serveur',
        'Technicien de maintenance',
        'Commercial'
    ];

    private function getRandomName()
    {
        return $this->algerianFirstNames[array_rand($this->algerianFirstNames)];
    }
    private function getRandomLast()
    {
        return $this->algerianLastNames[array_rand($this->algerianLastNames)];
    }
    private function getRandomJob()
    {
        return $this->jobs[array_rand($this->jobs)];
    }
    private function getRandomPublicSectorJob()
    {
        return $this->publicSectorJobs[array_rand($this->publicSectorJobs)];
    }
    private function getRandomPrivateSectorJob()
    {
        return $this->privateSectorJobs[array_rand($this->privateSectorJobs)];
    }
    private function getRandomDateOfBirth()
    {
        return now()->subYears(random_int(25, 60))->format('Y-m-d');
    }
    private function getRandomPhoneNumber()
    {
        return '+213' . random_int(600000000, 699999999);
    }
    private function getRandomAddress()
    {
        return 'Alger, ' . $this->getRandomName() . ' Street, ' . random_int(1, 100);
    }
    private function getRandomEmail($name, $last)
    {
        return strtolower(str_replace(' ', '_', $name . ' ' . $last)) . '@example.com';
    }
    private function getRandomNationalId()
    {
        return random_int(10000000, 99999999);
    }
    private function getRandomSalary()
    {
        return random_int(30000, 100000);
    }


    public function run()
    {
        $name = $this->getRandomName();
        $last = $this->getRandomLast();
        $superAdmin = SuperAdmin::create([
            'username' => strtolower(str_replace(' ', '_', $name . ' ' . $last . ' ' . str()->random(5))),
            'name' => $name,
            'last' => $last,
            'is_super' => true,
        ]);
        $superAdmin->key()->create([
            'value' => str()->random(10),
        ]);
        $superAdmin->photo()->create([
            'path' => 'photos/' . $superAdmin->username . '/' . str()->random(10) . '.jpg',
        ]);
        $dairas = Daira::all();
        foreach ($dairas as $daira) {
            // create committees
            for ($i = 0; $i < random_int(0, 1); $i++) {
                $name = $this->getRandomName();
                $last = $this->getRandomLast();
                $committee = Committee::create([
                    'username' => strtolower(str_replace(' ', '_', $name . ' ' . $last . '_' . str()->random(5))),
                    'name' => $name,
                    'last' => $last,
                    'date_of_birth' => $this->getRandomDateOfBirth(),
                    'daira_id' => $daira->id,
                ]);
                $committee->key()->create([
                    'value' => str()->random(10),
                ]);
                $committee->photo()->create([
                    'path' => 'photos/' . $committee->username . '/' . str()->random(10) . '.jpg',
                ]);

                // employees creation
                for ($i = 0; $i < random_int(0, 5); $i++) {
                    $name = $this->getRandomName();
                    $last = $this->getRandomLast();
                    $employe = $committee->employees()->create([
                        'username' => strtolower(str_replace(' ', '_', $name . ' ' . $last . '_' . str()->random(5))),
                        'name' => $name,
                        'last' => $last,
                        'date_of_birth' => $this->getRandomDateOfBirth(),
                        'daira_id' => $daira->id,
                    ]);
                    $employe->key()->create([
                        'value' => str()->random(10),
                    ]);
                    $employe->photo()->create([
                        'path' => 'photos/' . $employe->username . '/' . str()->random(10) . '.jpg',
                    ]);
                }
            }
        }
    }
}
