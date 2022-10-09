<?php

namespace App\Models\Buildables;

use App\Models\Buildables\BuildingMetadata;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Building extends Model
{
    use HasFactory;
    
    // Classes to ignore
    const IGNORED = [
        'Build_JumpPadTilted_C',
        'Build_JumpPad_C',
        'Build_Stair_1b_C',
        'Build_Snowman_C',
        'Build_WreathDecor_C',
        'Build_XmassLightsLine_C',
        'Build_XmassTree_C',
        'Build_CandyCaneDecor_C',
    ];

    const NAME_FIXES = [
        'Build_WalkwayTrun_C'             => 'Desc_WalkwayTurn_C', // nice typo CSS
        'Build_CatwalkCorner_C'           => 'Desc_CatwalkTurn_C', // to match descriptor name
        'Build_PowerPoleWall_Mk2_C'       => 'Desc_PowerPoleWallMk2_C',
        'Build_PowerPoleWall_Mk3_C'       => 'Desc_PowerPoleWallMk3_C',
        'Build_PowerPoleWallDouble_Mk2_C' => 'Desc_PowerPoleWallDoubleMk2_C',
        'Build_PowerPoleWallDouble_Mk3_C' => 'Desc_PowerPoleWallDoubleMk3_C',
    ];
    
    protected BuildingMetadata $metadata;
    
    protected $guarded = ['id'];

    /**
     * @return \App\Models\Buildables\BuildingMetadata
     */
    public function getMetadata() : BuildingMetadata
    {
        return $this->metadata;
    }

    /**
     * @param \App\Models\Buildables\BuildingMetadata $metadata
     */
    public function setMetadata(BuildingMetadata $metadata) : void
    {
        $this->metadata = $metadata;
    }
    
    

}
