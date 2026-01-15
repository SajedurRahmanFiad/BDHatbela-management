<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class Permissions extends Seeder
{
    public function run()
    {
        $seeder = new \Database\Seeds\Permissions();
        $seeder->run();
    }
}
