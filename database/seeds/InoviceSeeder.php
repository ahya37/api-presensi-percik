<?php

use Illuminate\Database\Seeder;
use App\Invoice;

class InoviceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = [
            ['name' => 'Sales'],
            ['name' => 'Purchase']
        ];

        foreach ($data as  $value) {
            Invoice::create($value);
        }
    }
}
