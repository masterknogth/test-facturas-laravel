<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class ItemsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {   

        $array = [
            '{"description":"Harina de maiz", "price":"1.5"}',
            '{"description":"Harina de trigo","price":"2"}',
            '{"description":"Aceite de soja","price":"2"}',
            '{"description":"Azucar refinada","price":"0.95"}',
            '{"description":"Arroz KG","price":"1"}',
            '{"description":"Pasta KG","price":"1.2"}',
            '{"description":"Pasta de dientes","price":"2.2"}',
            '{"description":"Frijoles negros","price":"2.3"}',
            '{"description":"Detergente para lavar","price":"3"}',
            '{"description":"Jabon para baño","price":"0.5"}',
            '{"description":"Shampoo con acondicionador","price":"2.4"}',       
        ];

        for ($i=0; $i < sizeof($array); $i++) {
            \DB::table("items")->insert(
                array(                      
                    'description' => json_decode( $array[$i] )->description,
                    'price' => json_decode($array[$i])->price,
                    'created_at' =>date('Y-m-d H:m:s'),
                    'updated_at' =>date('Y-m-d H:m:s')                 
                )   
            );
        }
    }
}
