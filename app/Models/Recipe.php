<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Recipe extends Model
{
    use HasFactory;
    
    protected $guarded = ['id'];

    const IGNORED = [];

    const NAME_FIXES = [];
    
//    protected RecipeMetadata $metadata;

    /**
     * @return \App\Models\Recipes\RecipeMetadata
     *
    public function getMetadata() : RecipeMetadata
    {
        return $this->metadata;
    }

    /**
     * @param \App\Models\Recipes\RecipeMetadata $metadata
     *
    public function setMetadata(RecipeMetadata $metadata) : void
    {
        $this->metadata = $metadata;
    }
    //*/

}
