<?php

namespace App\Services\Parsers;

use App\Contracts\Parser;
use App\Models\Recipe;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;

/**
 * greeny\SatisfactoryTools\bin\parseDocs\recipe.ts
 *
 * todo: clean up and fix
 */
class RecipeParser implements Parser
{
    const MODEL_CLASS = Recipe::class;

    public function __construct() { }

    public function parse($data) : ?Recipe
    {
        if ( in_array($data->ClassName, static::MODEL_CLASS::IGNORED) ) {
            return null;
        }

        return new Recipe([
            'name'                             => $data->mDisplayName,
            'slug'                             => $this->slugify(
              $data->mDisplayName,
              $data->ClassName
            ),
            'description'                      => $data->mDescription,
            'className'                        => $this->correctClassName($data->ClassName),
            'ingredients'                      => $data->mIngredients,
            'product'                          => $data->mProduct,
            'is_alternate'                     => str_contains(
                  $data->mDisplayName,
                  'Alternate: '
              ) || $data->className === 'Recipe_Alternate_Turbofuel_C',
            'manufactoringDuration'            => $data->mManufactoringDuration,
            'manualManufacturingMultiplier'    => $data->mManualManufacturingMultiplier,
            'producedIn'                       => $data->mProducedIn,
            'variablePowerConsumptionConstant' => floatval($data->mVariablePowerConsumptionConstant),
            'variablePowerConsumptionFactor'   => floatval($data->mVariablePowerConsumptionFactor),
            'forBuilding'                      => Arr::hasAny(
              $data->mProducedIn,
              ['BP_BuildGun_C', 'BP_BuildGun_C']
            ),
            'inMachine'                        => !Arr::hasAny($data->mProducedIn, [
              'BP_BuildGun_C',
              'BP_BuildGun_C',
              'BP_WorkBenchComponent_C',
              'FGBuildableAutomatedWorkBench',
              'Desc_AutomatedWorkBench_C',
              'BP_WorkshopComponent_C',
            ]),
            'inWorkshop'                       => Arr::hasAny(
              $data->mProducedIn,
              'BP_WorkshopComponent_C'
            ),
            'inHand'                           => Arr::hasAny($data->mProducedIn, [
              'BP_WorkBenchComponent_C',
              'FGBuildableAutomatedWorkBench',
              'Desc_AutomatedWorkBench_C',
            ]),
            'isVariablePower'                  => floatval(
                  $data->mVariablePowerConsumptionConstant
              ) > 0,
        ]);
    }

    private function slugify(string $name, string $class_name) : string
    {
        return Str::slug($name);
    }

    private function correctClassName(string $class_name) : string
    {
        return static::MODEL_CLASS::NAME_FIXES[$class_name] ?? $class_name;
    }
}