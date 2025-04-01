<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Api\Extra\Wilaya;
use App\Models\Api\Extra\Baladya;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class BaladyaWilayaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $wilayas = [
            ["name" => "Adrar"],
            ["name" => "Chlef"],
            ["name" => "Laghouat"],
            ["name" => "Oum El Bouaghi"],
            ["name" => "Batna"],
            ["name" => "Béjaïa"],
            ["name" => "Biskra"],
            ["name" => "Béchar"],
            ["name" => "Blida"],
            ["name" => "Bouira"],
            ["name" => "Tamanrasset"],
            ["name" => "Tébessa"],
            ["name" => "Tlemcen"],
            ["name" => "Tiaret"],
            ["name" => "Tizi Ouzou"],
            ["name" => "Algiers"],
            ["name" => "Djelfa"],
            ["name" => "Jijel"],
            ["name" => "Sétif"],
            ["name" => "Saïda"],
            ["name" => "Skikda"],
            ["name" => "Sidi Bel Abbès"],
            ["name" => "Annaba"],
            ["name" => "Guelma"],
            ["name" => "Constantine"],
            ["name" => "Médéa"],
            ["name" => "Mostaganem"],
            ["name" => "M'Sila"],
            ["name" => "Mascara"],
            ["name" => "Ouargla"],
            ["name" => "Oran"],
            ["name" => "El Bayadh"],
            ["name" => "Illizi"],
            ["name" => "Bordj Bou Arréridj"],
            ["name" => "Boumerdès"],
            ["name" => "El Tarf"],
            ["name" => "Tindouf"],
            ["name" => "Tissemsilt"],
            ["name" => "El Oued"],
            ["name" => "Khenchela"],
            ["name" => "Souk Ahras"],
            ["name" => "Tipaza"],
            ["name" => "Mila"],
            ["name" => "Aïn Defla"],
            ["name" => "Naâma"],
            ["name" => "Aïn Témouchent"],
            ["name" => "Ghardaïa"],
            ["name" => "Relizane"]
        ];

        foreach ($wilayas as $wilaya) {
            Wilaya::create($wilaya);
        }

        $baladya = [
            ['name' => 'Adrar' , 'wilaya_id' => '1'],
            ['name' => 'Chlef' , 'wilaya_id' => '2'],
            ['name' => 'Laghouat' , 'wilaya_id' => '3'],
            ['name' => 'Oum El Bouaghi' , 'wilaya_id' => '4'],
            ['name' => 'Batna' , 'wilaya_id' => '5'],
            ['name' => 'Béjaïa' , 'wilaya_id' => '6'],
            ['name' => 'Biskra' , 'wilaya_id' => '7'],
            ['name' => 'Béchar' , 'wilaya_id' => '8'],
            ['name' => 'Blida' , 'wilaya_id' => '9'],
            ['name' => 'Bouira' , 'wilaya_id' => '10'],
            ['name' => 'Tamanrasset' , 'wilaya_id' => '11'],
            ['name' => 'Tébessa' , 'wilaya_id' => '12'],
            ['name' => 'Tlemcen' , 'wilaya_id' => '13'],
            ['name' => 'Tiaret' , 'wilaya_id' => '14'],
            ['name' => 'Tizi Ouzou' , 'wilaya_id' => '15'],
            ['name' => 'Algiers' , 'wilaya_id' => '16'],
            ['name' => 'Djelfa' , 'wilaya_id' => '17'],
            ['name' => 'Jijel' , 'wilaya_id' => '18'],
            ['name' => 'Sétif' , 'wilaya_id' => '19'],
            ['name' => 'Saïda' , 'wilaya_id' => '20'],
            ['name' => 'Skikda' , 'wilaya_id' => '21'],
            ['name' => 'Sidi Bel Abbès' , 'wilaya_id' => '22'],
            ['name' => 'Annaba' , 'wilaya_id' => '23'],
            ['name' => 'Guelma' , 'wilaya_id' => '24'],
            ['name' => 'Constantine' , 'wilaya_id' => '25'],
            ['name' => 'Médéa', 'wilaya_id' => '26'],
            ['name' => 'Mostaganem' , 'wilaya_id' => '27'],
            ['name' => 'M\'Sila' , 'wilaya_id' => '28'],
            ['name' => 'Mascara' , 'wilaya_id' => '29'],
            ['name' => 'Ouargla' , 'wilaya_id' => '30'],
            ['name' => 'Oran' , 'wilaya_id' => '31'],
            ['name' => 'El Bayadh' , 'wilaya_id' => '32'],
            ['name' => 'Illizi' , 'wilaya_id' => '33'],
            ['name' => 'Bordj Bou Arréridj' , 'wilaya_id' => '34'],
            ['name' => 'Boumerdès' , 'wilaya_id' => '35'],
            ['name' => 'El Tarf' , 'wilaya_id' => '36'],
            ['name' => 'Tindouf' , 'wilaya_id' => '37'],
            ['name' => 'Tissemsilt' , 'wilaya_id' => '38'],
            ['name' => 'El Oued' , 'wilaya_id' => '39'],
            ['name' => 'Khenchela' , 'wilaya_id' => '40'],
            ['name' => 'Souk Ahras' , 'wilaya_id' => '41'],
            ['name' => 'Tipaza' , 'wilaya_id' => '42'],
            ['name' => 'Mila' , 'wilaya_id' => '43'],
            ['name' => 'Aïn Defla' , 'wilaya_id' => '44'],
            ['name' => 'Naâma' , 'wilaya_id' => '45'],
            ['name' => 'Aïn Témouchent' , 'wilaya_id' => '46'],
            ['name' => 'Ghardaïa' , 'wilaya_id' => '47'],
            ['name' => 'Relizane' , 'wilaya_id' => '48']
        ];
        foreach ($baladya as $baladiya) {
            Baladya::create($baladiya);
        }
    }
}
