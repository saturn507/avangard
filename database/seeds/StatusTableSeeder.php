<?php

use Illuminate\Database\Seeder;


class StatusTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = ['новый','подтвержден','завершен'];
        
        for ($i = 0; $i < count($data); $i++) {
             \DB::table('status')->insert([ 
                 'name' => $data[$i],
             ]);
        }
    }
}
