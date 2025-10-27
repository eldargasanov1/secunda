<?php

namespace App\Http\Controllers;

use App\Models\Activity;
use App\Models\Building;
use App\Models\Organization;
use App\Services\ActivityService;
use App\Services\BuildingService;

class OrganizationController extends Controller
{
    public function getByBuilding(Building $building)
    {
        $paginatedData = Organization::query()->whereRelation('building', 'id', $building->id)->paginate();
        return response()->json($paginatedData);
    }

    public function getByActivity(Activity $activity)
    {
        $paginatedData = Organization::query()->whereRelation('activities', 'activities.id', $activity->id)->paginate();
        return response()->json($paginatedData);
    }

    public function getByMapRadius()
    {
        $latitude = request()->query('latitude');
        $longitude = request()->query('longitude');
        $radius = request()->query('radius');

        if (empty($latitude) || empty($longitude) || empty($radius)) {
            abort(400, 'Latitude, longitude and radius query params required!');
        }

        $buildings = BuildingService::getByRadius($latitude, $longitude, $radius);
        $buildingsIds = $buildings->pluck('id');

        $organizations = Organization::query()->whereIn('building_id', $buildingsIds)->paginate();
        return response()->json($organizations);
    }

    public function getByMapRectangle()
    {
        $latitude = request()->query('latitude');
        $longitude = request()->query('longitude');
        $distance = request()->query('distance');

        if (empty($latitude) || empty($longitude) || empty($distance)) {
            abort(400, 'Latitude, longitude and distance query params required!');
        }

        $buildings = BuildingService::getByRectangle($latitude, $longitude, $distance);
        $buildingsIds = $buildings->pluck('id');

        $organizations = Organization::query()->whereIn('building_id', $buildingsIds)->paginate();
        return response()->json($organizations);
    }

    public function getById(Organization $organization)
    {
        return response()->json($organization);
    }

    public function getByActivityTree(Activity $activity)
    {
        $ids = collect(ActivityService::flattenTree($activity))->pluck('id')->toArray();
        $paginatedData = Organization::query()->whereRelation('activities', 'activities.id', $ids)->paginate();
        return response()->json($paginatedData);
    }

    public function getByName($name)
    {
        $res = Organization::query()->whereLike('name', "%{$name}%")->paginate();
        return response()->json($res);
    }
}
