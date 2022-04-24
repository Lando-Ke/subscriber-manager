<?php

namespace Database\Seeders;

use App\Models\Subscriber;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SubscribersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->truncate();

        Subscriber::factory(15)->hasFields(3)
            ->create();
    }


    private function truncate()
    {
        Model::unguard();

        DB::table('subscribers')->truncate();

        Model::reguard();
    }
}
