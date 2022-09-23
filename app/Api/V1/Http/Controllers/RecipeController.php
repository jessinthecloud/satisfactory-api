<?php

namespace App\Api\V1\Http\Controllers;

use App\Http\Resources\RecipeResource;
use App\Models\Recipe;
use Illuminate\Http\Request;

class RecipeController extends \App\Http\Controllers\Controller
{
    public function __construct() { }

    public function index(Request $request)
    {
        return RecipeResource::collection(Recipe::all());
    }

    public function show(Recipe $recipe)
    {
        return new RecipeResource($recipe);
    }
}