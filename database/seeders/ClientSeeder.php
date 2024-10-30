<?php

namespace Database\Seeders;

use App\Models\Client;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ClientSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Client::create([
            'name' => 'Cosme Fulanito',            
            'email'=> 'cosmefull@gmail.com',
            'phone_number'=>'+591 75841236',
        ]);
        Client::create([
            'name' => 'Peter Parker',
            'email'=> 'petpark@gmail.com',
            'phone_number'=>'+591 69841236',
        ]);
        Client::create([
            'name' => 'Bruce Wayne',
            'email'=> 'batibruce@gmail.com',
            'phone_number'=>'+591 69841852',
        ]);
    }
}
