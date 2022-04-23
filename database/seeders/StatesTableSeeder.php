<?php

namespace Database\Seeders;

use App\Models\State;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class StatesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */

    public function run()
    {
        $this->truncate();

        $states = [
            ['name' => "active"],
            ['name' => "unsubscribed"],
            ['name' => "junk"],
            ['name' => "bounced"],
            ['name' => "unconfirmed"],
        ];

        collect($states)->each(function ($state) { State::create($state); });
    }

    private function truncate()
    {
        Model::unguard();

        DB::table('states')->truncate();

        Model::reguard();
    }
}
