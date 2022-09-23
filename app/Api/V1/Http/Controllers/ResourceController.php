<?php

namespace App\Api\V1\Http\Controllers;

use App\Http\Resources\ResourceResource;
use App\Models\Resource;
use Illuminate\Http\Request;

class ResourceController extends \App\Http\Controllers\Controller
{
    public function __construct() { }

    public function index(Request $request)
    {
        return ResourceResource::collection(Resource::all());
    }

    public function show(Resource $resource)
    {
        return new ResourceResource($resource);
    }
}