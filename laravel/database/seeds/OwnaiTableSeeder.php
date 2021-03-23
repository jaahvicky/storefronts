<?php

use Illuminate\Database\Seeder;

class OwnaiTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        if (Schema::hasTable('ownai_system'))
        {
            DB::table('ownai_system')->insert([
                'url' => 'http://ownai_march.anthonyg.56.dev/'
            ]);
        }
    }
}
