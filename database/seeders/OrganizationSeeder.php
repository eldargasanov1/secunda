<?php

namespace Database\Seeders;

use App\Models\Activity;
use App\Models\Building;
use App\Models\Organization;
use App\Models\Phone;
use Illuminate\Database\Seeder;

class OrganizationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $buildings = Building::query()->get();
        $activities = Activity::query()->get();

        for ($i = 0; $i < 100; $i++) {
            $randomBuilding = $buildings->random();
            $randomActivities = $activities->random(rand(1, 3));

            $organization = Organization::factory()->hasAttached($randomActivities)->create([
                'building_id' => $randomBuilding->id,
            ]);

            Phone::factory()->count(rand(1, 3))->for($organization)->create();
        }
    }
}
