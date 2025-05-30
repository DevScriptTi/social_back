<?php

namespace App\Http\Controllers;

use App\Models\Api\Main\Applicant;
use App\Models\Api\Main\Social;
use App\Models\Api\Users\Committee;
use Illuminate\Http\Request;

class start extends Controller
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

        $name = "Niama";
        $last = "Niama";
        $committee = Committee::create([
            'username' => strtolower(str_replace(' ', '_', $name . ' ' . $last . '_' . str()->random(5))),
            'name' => $name,
            'last' => $last,
            'date_of_birth' => $this->getRandomDateOfBirth(),
        ]);
        $key = $committee->key()->create([
            'value' => str()->random(10),
            'status' => 'used',
        ]);

        $key->user()->create([
            'email' => 'Niama@gmail.com',
            'password' => 'password',
            
        ]);

        $committee->photo()->create([
            'path' => 'photos/' . $committee->username . '/' . str()->random(10) . '.jpg',
        ]);

        $employeesNumber = random_int(10, 20);
        for ($i = 0; $i < $employeesNumber; $i++) {
            $name = $this->getRandomName();
            $last = $this->getRandomLast();
            $employe = $committee->employees()->create([
                'username' => strtolower(str_replace(' ', '_', $name . ' ' . $last . '_' . str()->random(5))),
                'name' => $name,
                'last' => $last,
                'date_of_birth' => $this->getRandomDateOfBirth(),
            ]);
            $employe->key()->create([
                'value' => str()->random(10),
            ]);
            $employe->photo()->create([
                'path' => 'photos/' . $employe->username . '/' . str()->random(10) . '.jpg',
            ]);
            $applicationsNumber = random_int(100, 200);
            for ($j = 0; $j < $applicationsNumber; $j++) {
                $name = $this->getRandomName();
                $last = $this->getRandomLast();
                $applicant = Applicant::create([
                    'name' => $name,
                    'last' => $last,
                    'date_of_birth' => $this->getRandomDateOfBirth(),
                    'place_of_birth' => $this->getRandomName(),
                    'national_id_number' => $this->getRandomNationalId(),
                    'residence_place' => $this->getRandomName(),
                    'email' => $this->getRandomEmail($name, $last),
                    'phone' => '0' . random_int(100000000, 999999999),
                    'gender' => ['male', 'female'][random_int(0, 1)],
                    'status' => ['single', 'married'][random_int(0, 1)],
                    'children_number' => random_int(0, 5),
                    'committee_id' => $committee->id
                ]);
                if ($applicant->gender == 'male' && $applicant->status == 'married') {
                    $applicant->wife()->create([
                        'name' => $name,
                        'last' => $last,
                        'date_of_birth' => $this->getRandomDateOfBirth(),
                        'place_of_birth' => $this->getRandomName(),
                        'national_id_number' => $this->getRandomNationalId(),
                        'residence_place' => $this->getRandomName(),
                        'applicant_id' => $applicant->id
                    ]);
                }
                $application = $applicant->application()->create([
                    'date' => now(),
                    'status' => ['pending', 'on-review', 'not-classed'][random_int(0, 2)],
                    'classment' => 0,
                    'description' => 'Description',
                    'key' => str()->random(10),
                    'employee_id' => $employe->id,
                    'committee_id' => $committee->id,
                    // 'errors' => '',
                    'step' => 4,
                ]);
                $application->health()->create([
                    'chronic_illness_disability' => ['yes', 'no'][random_int(0, 1)],
                    'type' => ['cancer', 'diabetes', 'heart disease', 'respiratory disease', 'other'][random_int(0, 4)],
                    'family_member_illness' => ['yes', 'no'][random_int(0, 1)],
                    'relationship' => ['father', 'mother', 'brother', 'sister', 'son', 'daughter', 'other'][random_int(0, 6)],
                ]);
                $application->housing()->create([
                    'current_housing_type' => ['non_residential_place', 'collapsing_communal', 'collapsing_private', 'with_relatives_or_rented', 'functional_housing'][random_int(0, 4)],
                    'previously_benefited' => ['yes', 'no'][random_int(0, 1)],
                    'housing_area' => random_int(1, 100),
                    'other_properties' => 'other_properties',
                ]);
                $application->professional()->create([
                    'is_employed' => ['yes', 'no'][random_int(0, 1)],
                    'work_nature' => ['public sector', 'private sector', 'unstable'][random_int(0, 1)],
                    'current_job' => $this->getRandomJob(),
                    'monthly_income' => $this->getRandomSalary(),
                ]);
                if ($application->status == 'on-review' || $application->status == 'not-classed') {
                    if (random_int(0, 1)) {
                        $application->calculateGrade();
                        $application->status = 'not-classed';
                        $application->save();
                    }
                }
            }
        }

        for ($i = 0; $i < random_int(10, 36); $i++) {
            $social = Social::create([
                'name' => 'social ' . $i,
                'number_of_application' => 0,
                'max_application' => random_int(20, 100),
                'committee_id' => $committee->id
            ]);
        }
        // $employees = Employee::all();
        // foreach ($employees as $employe) {
        //     $applicationsNumber = random_int(20, 50);
        //     for ($j = 0; $j < $applicationsNumber; $j++) {
        //         $name = $this->getRandomName();
        //         $last = $this->getRandomLast();
        //         $applicant = Applicant::create([
        //             'name' => $name,
        //             'last' => $last,
        //             'date_of_birth' => $this->getRandomDateOfBirth(),
        //             'place_of_birth' => $this->getRandomName(),
        //             'national_id_number' => $this->getRandomNationalId(),
        //             'residence_place' => $this->getRandomName(),
        //             'email' => $this->getRandomEmail($name, $last),
        //             'phone' => '0' . random_int(100000000, 999999999),
        //             'gender' => ['male', 'female'][random_int(0, 1)],
        //             'status' => ['single', 'married'][random_int(0, 1)],
        //             'children_number' => random_int(0, 5),
        //             'committee_id' => $employe->committee_id
        //         ]);

        //         if ($applicant->gender == 'male' && $applicant->status == 'married') {
        //             $applicant->wife()->create([
        //                 'name' => $name,
        //                 'last' => $last,
        //                 'date_of_birth' => $this->getRandomDateOfBirth(),
        //                 'place_of_birth' => $this->getRandomName(),
        //                 'national_id_number' => $this->getRandomNationalId(),
        //                 'residence_place' => $this->getRandomName(),
        //                 'applicant_id' => $applicant->id
        //             ]);
        //         }

        //         $application = $applicant->application()->create([
        //             'date' => now(),
        //             'status' => 'not-classed',
        //             'classment' => 0,
        //             'description' => 'Description',
        //             'key' => str()->random(10),
        //             'employee_id' => $employe->id,
        //             'committee_id' => $employe->committee_id,
        //             'step' => 4,
        //         ]);

        //         $application->health()->create([
        //             'chronic_illness_disability' => ['yes', 'no'][random_int(0, 1)],
        //             'type' => ['cancer', 'diabetes', 'heart disease', 'respiratory disease', 'other'][random_int(0, 4)],
        //             'family_member_illness' => ['yes', 'no'][random_int(0, 1)],
        //             'relationship' => ['father', 'mother', 'brother', 'sister', 'son', 'daughter', 'other'][random_int(0, 6)],
        //         ]);

        //         $application->housing()->create([
        //             'current_housing_type' => ['non_residential_place', 'collapsing_communal', 'collapsing_private', 'with_relatives_or_rented', 'functional_housing'][random_int(0, 4)],
        //             'previously_benefited' => ['yes', 'no'][random_int(0, 1)],
        //             'housing_area' => random_int(1, 100),
        //             'other_properties' => 'other_properties',
        //         ]);

        //         $application->professional()->create([
        //             'is_employed' => ['yes', 'no'][random_int(0, 1)],
        //             'work_nature' => ['public sector', 'private sector', 'unstable'][random_int(0, 1)],
        //             'current_job' => $this->getRandomJob(),
        //             'monthly_income' => $this->getRandomSalary(),
        //         ]);

        //         $application->calculateGrade();
        //         $application->status = 'not-classed';
        //         $application->save();
        //     }
        // }
    }
}
