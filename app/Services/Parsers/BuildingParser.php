<?php

namespace App\Services\Parsers;

use App\Contracts\Parser;
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
        // TODO: determine metadata
        $metadata = $this->parseMetadata();
        // determine size
        $size = $this->parseSize($data->mSize ?? null, $data->mWidth ?? null, $data->mHeight ?? null,);

        return new Building([
            'name'                             => $data->mDisplayName,
            'slug'                             => $this->slugify($data->mDisplayName, $data->ClassName),
            'description'                      => $data->mDescription,
            'className'                        => $this->correctClassName($data->ClassName),
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
            'size'                             => $size,
            'estimatedMininumPowerConsumption' => $data->mEstimatedMininumPowerConsumption ?? null,
            'estimatedMaximumPowerConsumption' => $data->mEstimatedMaximumPowerConsumption ?? null,
        ]);
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

    private function parseMetadata()
    {
        /*const metadata: IBuildingMetadataSchema|IManufacturerAnyPowerMetadataSchema = {};

		if (typeof building.mSpeed !== 'undefined') {
			metadata.beltSpeed = parseFloat(building.mSpeed) / 2;
			metadata.firstPieceCostMultiplier = 1;
			metadata.lengthPerCost = 200; // belts don't have lengthPerCost attribute, but they build two meters per cost
			metadata.maxLength = 4900; // belts don't have maxLength attribute, but they have max length of 49 meters
		}

		if (typeof building.mLengthPerCost !== 'undefined') {
			metadata.lengthPerCost = parseFloat(building.mLengthPerCost);
			metadata.firstPieceCostMultiplier = 1;
		}

		if (typeof building.mMaxLength !== 'undefined') {
			metadata.maxLength = parseFloat(building.mMaxLength);
		}

		if (typeof building.mPowerConsumption !== 'undefined') {
			metadata.powerConsumption = parseFloat(building.mPowerConsumption);
		}

		if (typeof building.mPowerConsumptionExponent !== 'undefined') {
			metadata.powerConsumptionExponent = parseFloat(building.mPowerConsumptionExponent);
		}

		if (typeof building.mEstimatedMininumPowerConsumption !== 'undefined' && typeof building.mEstimatedMaximumPowerConsumption !== 'undefined') {
			metadata.isVariablePower = true;
			metadata.minPowerConsumption = parseFloat(building.mEstimatedMininumPowerConsumption);
			metadata.maxPowerConsumption = parseFloat(building.mEstimatedMaximumPowerConsumption);
			metadata.powerConsumption = (metadata.minPowerConsumption + metadata.maxPowerConsumption) / 2;
		}

		if (typeof building.mManufacturingSpeed !== 'undefined') {
			metadata.manufacturingSpeed = parseFloat(building.mManufacturingSpeed);
		}

		if (typeof building.mInventorySizeX !== 'undefined' && typeof building.mInventorySizeY !== 'undefined') {
			metadata.inventorySize = parseInt(building.mInventorySizeX) * parseInt(building.mInventorySizeY);
		}

		if (typeof building.mFlowLimit !== 'undefined') {
			metadata.flowLimit = parseFloat(building.mFlowLimit);
		}

		if (typeof building.mDesignPressure !== 'undefined') {
			metadata.maxPressure = parseFloat(building.mDesignPressure);
		}

		if (typeof building.mStorageCapacity !== 'undefined') {
			metadata.storageCapacity = parseFloat(building.mStorageCapacity);
		}*/
    }
}