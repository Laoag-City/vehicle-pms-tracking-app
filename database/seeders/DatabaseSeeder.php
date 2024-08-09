<?php

namespace Database\Seeders;

use App\Enum\Role as EnumRole;
use App\Models\Component;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Office;
use App\Models\Role;
use App\Models\VehicleClassification;
use App\Models\VehicleMake;
use Illuminate\Support\Str;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $roles = [];
        foreach(EnumRole::cases() as $role)
            $roles[] = ['role' => $role->value];

        Role::insert($roles);

        Office::insert([
            ['name' => 'City Mayor\'s Office', 'abbr' => 'CMO'],

            ['name' => 'City Administrator Office', 'abbr' => 'CA'],

            ['name' => 'City Legal Office', 'abbr' => 'CLO'],

            ['name' => 'Human Resource Management Office', 'abbr' => 'HRMO'],

            ['name' => 'Community Affairs Office', 'abbr' => 'OCAO'],

            ['name' => 'Communications and Media Office', 'abbr' => 'MEDIA'],

            ['name' => 'Information and Communication Technology Office', 'abbr' => 'ICTO'],

            ['name' => 'City Environment and Natural Resources Office', 'abbr' => 'CENRO'],

            ['name' => 'City Vice Mayor\'s Office', 'abbr' => 'CVMO'],

            ['name' => 'Office of the Secretary to the Sanggunian', 'abbr' => 'SP-SEC'],

            ['name' => 'City Planning and Development', 'abbr' => 'CPDO'],

            ['name' => 'City Civil Registrar', 'abbr' => 'CCR'],

            ['name' => 'City Treasury Office', 'abbr' => 'CTO'],

            ['name' => 'City Accounting Office', 'abbr' => 'ACCT'],

            ['name' => 'City Budget Office', 'abbr' => 'CBO'],

            ['name' => 'City Assessor Office', 'abbr' => 'CAO'],

            ['name' => 'General Services Office', 'abbr' => 'GSO'],

            ['name' => 'City Health Office', 'abbr' => 'CHO'],

            ['name' => 'City Social Welfare and Development Office', 'abbr' => 'CSWD'],

            ['name' => 'Persons with Disability Affairs Office', 'abbr' => 'PWD'],

            ['name' => 'City Agriculture Office', 'abbr' => 'AGRI'],

            ['name' => 'City Veterinary Office', 'abbr' => 'VET'],

            ['name' => 'City Engineering Office', 'abbr' => 'CEO'],

            ['name' => 'Laoag City General Hospital', 'abbr' => 'LCGH'],

            ['name' => 'Laoag City Public Market and Commercial Complex', 'abbr' => 'LCPMCC'],

            ['name' => 'Slaugherhouse', 'abbr' => 'SLAUGHTER'],

            ['name' => 'Laoag City Central Terminal', 'abbr' => 'TERMINAL'],

            ['name' => 'Civil Security Unit', 'abbr' => 'CSU'],

            ['name' => 'Administrative and Records Division', 'abbr' => 'ARD'],

            ['name' => 'Internal Control Division', 'abbr' => 'ICD'],

            ['name' => 'Permits and Licenses Division', 'abbr' => 'PLD'],

            ['name' => 'Cooperative Services', 'abbr' => 'COOP'],

            ['name' => 'City Disaster Risk Reduction and Management Office', 'abbr' => 'CDRRMO'],

            ['name' => 'Department of Public Safety', 'abbr' => 'DPS'],

            ['name' => 'Tourism Office', 'abbr' => 'TOURISM'],

            ['name' => 'City Library', 'abbr' => 'LIB'],

            ['name' => 'SP Legislative', 'abbr' => 'SP-LEGIS'],

            ['name' => 'Population Services', 'abbr' => 'POPCOM'],

            ['name' => 'Philippine National Police', 'abbr' => 'PNP'],

            ['name' => 'Bureau of Fire Protection', 'abbr' => 'BFP']
        ]);

        $offices = Office::all();
        $roles = Role::all();
        
        //Administrator
        $administrator_role_id = $roles->where('role', 'Administrator')->first()->id;

        User::insert([
            [
                'office_id' => $offices->where('abbr', 'ICTO')->first()->id,
                'role_id' => $administrator_role_id,
                'name' => 'Administrator',
                'username' => 'administrator',
                'password' => bcrypt('administrator')
            ]
        ]);

        //Executive
        $executive_role_id = $roles->where('role', 'Executive')->first()->id;

        User::insert([
            [
                'office_id' => $offices->where('abbr', 'CA')->first()->id,
                'role_id' => $executive_role_id,
                'name' => 'City Administrator',
                'username' => 'ca_executive',
                'password' => bcrypt('ca_executive')
            ]
        ]);

        //GSO Administrator
        $gso_admin_role_id = $roles->where('role', 'GSO Administrator')->first()->id;

        User::insert([
            [
                'office_id' => $offices->where('abbr', 'GSO')->first()->id,
                'role_id' => $gso_admin_role_id,
                'name' => 'GSO Administrator',
                'username' => 'gso_administrator',
                'password' => bcrypt('gso_administrator')
            ]
        ]);

        //GSO Encoder
        $gso_admin_role_id = $roles->where('role', 'GSO Encoder')->first()->id;

        User::insert([
            [
                'office_id' => $offices->where('abbr', 'GSO')->first()->id,
                'role_id' => $gso_admin_role_id,
                'name' => 'GSO Encoder',
                'username' => 'gso_encoder',
                'password' => bcrypt('gso_encoder')
            ]
        ]);

        //Regular Users
        $regular_role_id = $roles->where('role', 'Regular User')->first()->id;
        $regular_users = [];
        $offices = $offices->whereNotIn('abbr', ['CA', 'GSO']);

        foreach($offices as $office)
            $regular_users[] = [
                'office_id' => $office->id,
                'role_id' => $regular_role_id,
                'name' => Str::of($office->abbr)->ucfirst() . ' User',
                'username' => Str::lower($office->abbr) . '_user',
                'password' => bcrypt(Str::lower($office->abbr) . '_user')
            ];

        User::insert($regular_users);

        VehicleClassification::insert([
            ['classification' => 'Motorcycle'],
            ['classification' => 'Tricycle/Kurong-kurong'],
            ['classification' => 'Sedan'],
            ['classification' => 'Crossover'],
            ['classification' => 'MPV (Multi-Purpose Vehicle)'],
            ['classification' => 'SUV (Sport Utility Vehicle)'],
            ['classification' => 'Van'],
            ['classification' => 'Minibus'],
            ['classification' => 'Mini Truck'],
            ['classification' => 'Pickup Truck'],
            ['classification' => 'Boom Truck'],
            ['classification' => 'Dump Truck'],
            ['classification' => 'Garbage Truck'],
            ['classification' => 'Payloader'],
            ['classification' => 'Self-loading Truck'],
            ['classification' => 'Backhoe'],
            ['classification' => 'Bulldozer'],
            ['classification' => 'Road Grader'],
            ['classification' => 'Compactor'],
            ['classification' => 'Rescue Truck'],
            ['classification' => 'Ambulance'],
            ['classification' => 'Water Truck'],
            ['classification' => 'Fire Truck'],
            ['classification' => 'Non-vehicle Type']
        ]);

        VehicleMake::insert([
            ['make' => 'Honda'],
            ['make' => 'Yamaha'],
            ['make' => 'Kawasaki'],
            ['make' => 'Suzuki'],
            ['make' => 'Bajaj'],
            ['make' => 'Kymco'],
            ['make' => 'Euro'],
            ['make' => 'Motorstar'],
            ['make' => 'Racal'],
            ['make' => 'Toyota'],
            ['make' => 'Mitsubishi'],
            ['make' => 'Ford'],
            ['make' => 'Kia'],
            ['make' => 'Isuzu'],
            ['make' => 'Nissan'],
            ['make' => 'Hyundai'],
            ['make' => 'MG'],
            ['make' => 'Foton'],
            ['make' => 'Mercedes-Benz'],
            ['make' => 'Geely'],
            ['make' => 'Mazda'],
            ['make' => 'Volvo'],
            ['make' => 'GAC'],
            ['make' => 'GWM'],
        ]);

        Component::insert([
            ['component' => 'Engine'],
            ['component' => 'Transmission System'],
            ['component' => 'Fuel System'],
            ['component' => 'Cooling System'],
            ['component' => 'Braking System'],
            ['component' => 'Suspension'],
            ['component' => 'Chassis'],
            ['component' => 'Wheels/Tires'],
            ['component' => 'Exhaust System'],
            ['component' => 'Steering System'],
            ['component' => 'Electrical System'],
            ['component' => 'Auxiliary Components']
        ]);
    }
}
