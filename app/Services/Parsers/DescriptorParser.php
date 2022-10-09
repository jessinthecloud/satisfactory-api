<?php

namespace App\Services\Parsers;

use App\Contracts\Parser;
use App\Enums\PhysicalState;
use App\Enums\StackSize;
use App\Models\Descriptor;
use Illuminate\Support\Str;

/**
 * greeny\SatisfactoryTools\bin\parseDocs\itemDescriptor.ts
 * greeny\SatisfactoryTools\bin\parseDocs\resourceDescriptor.ts
 * greeny\SatisfactoryTools\bin\parseDocs\buidlingDescriptor.ts
 */
class DescriptorParser implements Parser
{
    const MODEL_CLASS = Descriptor::class;

    public function __construct() { }

    public function parse($data) : ?Descriptor
    {
        if ( in_array($data->ClassName, static::MODEL_CLASS::IGNORED) ) {
            return null;
        }

        return new Descriptor([
            'name'                   => $data->mDisplayName,
            'slug'                   => $this->slugify(
                $data->mDisplayName,
                $data->ClassName
            ),
            'description'            => $data->mDescription,
            'className'              => $this->correctClassName($data->ClassName),
            'stackSize'              => StackSize::fromName($data->mStackSize),
            'canBeDiscarded'         => $data->mCanBeDiscarded,
            'rememberPickUp'         => $data->mRememberPickUp,
            'energyValue'            => floatval($data->mEnergyValue),
            'radioactiveDecay'       => floatval($data->mRadioactiveDecay),
            'resourceSinkPoints'     => intval($data->mResourceSinkPoints),
            'form'                   => PhysicalState::fromName($data->mForm) !== PhysicalState::RF_SOLID,
            'fluidDensity'           => $data->mFluidDensity,
            'fluidViscosity'         => $data->mFluidViscosity,
            'fluidFriction'          => $data->mFluidFriction,
            'fluidColor'             => $data->mFluidColor, // todo: parse color
            'persistentBigIcon'      => $data->mPersistentBigIcon,
            // resource desc specific
            'decalSize'              => $data->mDecalSize,
            'pingColor'              => $data->mPingColor, // todo: parse color
            'collectSpeedMultiplier' => floatval($data->mCollectSpeedMultiplier),
            'manualMiningAudioName'  => $data->mManualMiningAudioName,
            // building desc specific 
            'subCategories'          => $data->mSubCategories, // todo: parse
            'buildMenuPriority'      => floatval($data->mBuildMenuPriority),
//            'categories'             => $data->categories, //string[];
//            'priority'               => $data->priority,   //number;
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