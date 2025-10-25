<?php

namespace Database\Seeders;

use App\Models\Activity;
use Arr;
use Illuminate\Database\Seeder;

class ActivitySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $activityIds = [
            'level_1' => [],
            'level_2' => [],
        ];

        for ($i = 0; $i < 5; $i++) {
            $id = Activity::factory()->create(
                ['parent_id' => 0]
            )->id;
            $activityIds['level_1'][] = $id;
        }

        for ($i = 0; $i < 10; $i++) {
            $id = Activity::factory()->create(
                ['parent_id' => Arr::random($activityIds['level_1'])]
            )->id;
            $activityIds['level_2'][] = $id;
        }

        for ($i = 0; $i < 10; $i++) {
            Activity::factory()->create(
                ['parent_id' => Arr::random($activityIds['level_2'])]
            );
        }
    }
}
