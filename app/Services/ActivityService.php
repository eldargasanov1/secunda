<?php

namespace App\Services;

use App\Models\Activity;

class ActivityService
{
    public static function flattenTree(Activity $activity): array
    {
        $subactivities = $activity->allSubactivities->toArray();
        $activityArr = $activity->toArray();
        unset($activityArr['all_subactivities']);
        return [$activityArr, ...self::flattenAllSubactivites($subactivities, 'all_subactivities')];
    }

    private static function flattenAllSubactivites($tree, $childrenKey = 'all_subactivites'): array
    {
        $flattened = [];

        foreach ($tree as $node) {
            $flattened[] = $node;

            if (!empty($node[$childrenKey])) {
                $flattened = array_merge($flattened, self::flattenAllSubactivites($node[$childrenKey], $childrenKey));
            }
        }

        foreach ($flattened as &$node) {
            unset($node[$childrenKey]);
        }

        return $flattened;
    }
}
