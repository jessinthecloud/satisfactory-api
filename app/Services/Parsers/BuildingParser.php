<?php

namespace App\Services\Parsers;

use App\Contracts\Parser;
use App\Models\Buildables\BuildingMetadata;
use App\Models\Building;
use Illuminate\Support\Str;

class BuildingParser implements Parser
{
    const MODEL_CLASS = Building::class;

    public function __construct() { }

    public function parse($data) : ?Building
    {
        if ( in_array($data->ClassName, static::MODEL_CLASS::IGNORED) ) {
            return null;
        }
        
        $metadata = $this->parseMetadata($data);
        $size = $this->parseSize($data->mSize ?? null, $data->mWidth ?? null, $data->mHeight ?? null,);

        $building = new Building([
            'name'                             => $data->mDisplayName,
            'slug'                             => $this->slugify($data->mDisplayName, $data->ClassName),
            'description'                      => $data->mDescription,
            'className'                        => $this->correctClassName($data->ClassName),
            'size'                             => $size,
            'speed'                            => $data->mSpeed ?? null,
            'lengthPerCost'                    => $data->mLengthPerCost ?? null,
            'maxLength'                        => $data->mMaxLength ?? null,
            'manufacturingSpeed'               => $data->mManufacturingSpeed ?? null,
            'powerConsumption'                 => $data->mPowerConsumption ?? null,
            'powerConsumptionExponent'         => $data->mPowerConsumptionExponent ?? null,
            'inventorySizeX'                   => $data->mInventorySizeX ?? null,
            'inventorySizeY'                   => $data->mInventorySizeY ?? null,
            'flowLimit'                        => $data->mFlowLimit ?? null,
            'designPressure'                   => $data->mDesignPressure ?? null,
            'storageCapacity'                  => $data->mStorageCapacity ?? null,
            'estimatedMininumPowerConsumption' => $data->mEstimatedMininumPowerConsumption ?? null,
            'estimatedMaximumPowerConsumption' => $data->mEstimatedMaximumPowerConsumption ?? null,
        ]);
        
        $building->setMetadata($metadata);
        
        return $building;
    }

    private function parseSize($building_size, $width, $height) : array
    {
        $size = [
			'width' => 0,
			'length' => 0,
			'height' => 0,
		];
		if ($building_size) {
			$size['width'] = $size['length'] = $building_size / 100;
		}
		if ($height) {
			$size['height'] = $height / 100;
		}
		if ($width) {
			$size['width'] = $width / 100;
		}
		
		return $size;
    }

    private function correctClassName(string $class_name) : string
    {
        return static::MODEL_CLASS::NAME_FIXES[$class_name] ?? $class_name;
    }

    private function slugify(string $name, string $class_name) : string
    {
        $slug = Str::slug($name);
        
        if (str_contains($class_name, 'Steel') || $class_name === 'Build_Wall_8x4_02_C') {
			return $slug . '-steel';
		}
		if (str_contains($class_name, 'Polished')) {
			return $slug . '-polished';
		}
		if (str_contains($class_name, 'Metal')) {
			return $slug . '-metal';
		}
		if (str_contains($class_name, 'Concrete')) {
			return $slug . '-concrete';
		}
		if (str_contains($class_name, 'Asphalt')) {
			return $slug . '-asphalt';
		}
		
		return $slug;
    }

    private function parseMetadata($building) : BuildingMetadata
    {
        $metadata = new BuildingMetadata;

		if (isset($building->mSpeed)) {
			$metadata->beltSpeed = floatval($building->mSpeed) / 2;
			$metadata->firstPieceCostMultiplier = 1;
			$metadata->lengthPerCost = 200; // belts don't have lengthPerCost attribute, but they build two meters per cost
			$metadata->maxLength = 4900; // belts don't have maxLength attribute, but they have max length of 49 meters
		}

		if (isset($building->mLengthPerCost)) {
			$metadata->lengthPerCost = floatval($building->mLengthPerCost);
			$metadata->firstPieceCostMultiplier = 1;
		}

		if (isset($building->mMaxLength)) {
			$metadata->maxLength = floatval($building->mMaxLength);
		}

		if (isset($building->mPowerConsumption)) {
			$metadata->powerConsumption = floatval($building->mPowerConsumption);
		}

		if (isset($building->mPowerConsumptionExponent)) {
			$metadata->powerConsumptionExponent = floatval($building->mPowerConsumptionExponent);
		}

		if (isset($building->mEstimatedMininumPowerConsumption) && isset($building->mEstimatedMaximumPowerConsumption)) {
			$metadata->isVariablePower = true;
			$metadata->minPowerConsumption = floatval($building->mEstimatedMininumPowerConsumption);
			$metadata->maxPowerConsumption = floatval($building->mEstimatedMaximumPowerConsumption);
			$metadata->powerConsumption = ($metadata->minPowerConsumption + $metadata->maxPowerConsumption) / 2;
		}

		if (isset($building->mManufacturingSpeed)) {
			$metadata->manufacturingSpeed = floatval($building->mManufacturingSpeed);
		}

		if (isset($building->mInventorySizeX) && isset($building->mInventorySizeY)) {
			$metadata->inventorySize = parseInt($building->mInventorySizeX) * parseInt($building->mInventorySizeY);
		}

		if (isset($building->mFlowLimit)) {
			$metadata->flowLimit = floatval($building->mFlowLimit);
		}

		if (isset($building->mDesignPressure)) {
			$metadata->maxPressure = floatval($building->mDesignPressure);
		}

		if (isset($building->mStorageCapacity)) {
			$metadata->storageCapacity = floatval($building->mStorageCapacity);
		}
        
		return $metadata;
    }
}