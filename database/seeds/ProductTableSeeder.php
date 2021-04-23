<?php

use Illuminate\Database\Seeder;

class ProductTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        { for ($i=0; $i < 20; $i++) {
             DB::table('products')->insert([
                'title' => Str::random(10),
                'img' => 'https://www.rd.com/wp-content/uploads/2018/06/01_killing-em-with-cuteness.jpg',
                'description' => Str::random(30),
                'sort' => rand(0,100),
                 ]); 
                } 
            }
    }
}
