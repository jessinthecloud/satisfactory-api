<?php

namespace App\Models\Buildables;

class BuildingMetadata
{
    public ?int $beltSpeed;
    public ?int $firstPieceCostMultiplier;
    public ?int $lengthPerCost;
    public ?int $maxLength;
    public ?int $storageSize;
    public ?int $powerConsumption;
    public ?int $powerConsumptionExponent;
    public ?int $manufacturingSpeed;
    public ?int $inventorySize;
    public ?int $flowLimit;
    public ?int $maxPressure;
    public ?int $storageCapacity;
    public ?bool $isVariablePower;
    public ?int $minPowerConsumption;
    public ?int $maxPowerConsumption;
}