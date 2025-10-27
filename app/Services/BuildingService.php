<?php

namespace App\Services;

use App\Models\Building;
use Clickbar\Magellan\Data\Geometries\Point;
use Clickbar\Magellan\Database\PostgisFunctions\ST;
use Illuminate\Database\Eloquent\Collection;

class BuildingService
{
    public static function getByRadius(int $latitude, int $longitude, int $radius): Collection|array
    {
        $point = Point::makeGeodetic($latitude, $longitude);

        return Building::query()
            ->where(ST::distance($point, 'location'), '<=', $radius)
            ->get();
    }

    public static function getByRectangle(int $latitude, int $longitude, int $distance): Collection|array
    {
        $degPerMeter = 1 / 111320;
        $delta = $distance * 1000 * $degPerMeter;

        $minLng = $longitude - $delta;
        $maxLng = $longitude + $delta;
        $minLat = $latitude - $delta;
        $maxLat = $latitude + $delta;

        return Building::select('*')
            ->whereRaw(
                "ST_Intersects(location, ST_MakeEnvelope(?, ?, ?, ?, 4326))",
                [$minLng, $minLat, $maxLng, $maxLat]
            )
            ->get();
    }
}
