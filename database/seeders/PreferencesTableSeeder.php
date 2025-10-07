<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class PreferencesTableSeeder extends Seeder
{
    public function run()
    {
        $preferences = [
            'Profile Pic',
            'Name',
            'Email',
            'Mobile',
            'Preferred Time',
            'Date of Birth',
            'Address',
            'Goal',
        ];

        foreach ($preferences as $pref) {
            DB::table('tbl_preferences')->insert([
                'name' => $pref,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]);
        }
    }
}
