<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        DB::table('zakats')->insert(array(
            array('name' => 'Zakat Fitrah Uang', 'type' => 'Uang', 'nominal' => '30000'),
            array('name' => 'Zakat Fitrah Beras', 'type' => 'Beras', 'nominal' => '2.5'),
            array('name' => 'Zakat Mal', 'type' => 'Uang', 'nominal' => ''),
            array('name' => 'Fidyah Beras', 'type' => 'Beras', 'nominal' => ''),
            array('name' => 'Fidyah Uang', 'type' => 'Uang', 'nominal' => ''),
            array('name' => 'Infaq', 'type' => 'Uang', 'nominal' => ''),
        ));
    }
}
