<?php

namespace App\Api\V1\Http\Controllers;

use App\Http\Resources\BuildingResource;
use App\Models\Building;
use Illuminate\Http\Request;

class BuildingController extends \App\Http\Controllers\Controller
{
    public function __construct() { }

    public function index(Request $request)
    {
        return BuildingResource::collection(Building::all());
    }

    public function show(Building $building)
    {
        return new BuildingResource($building);
    }
}