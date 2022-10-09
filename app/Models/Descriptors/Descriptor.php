<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Descriptor extends Model
{
    use HasFactory;
    
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

    const NAME_FIXES = [];
    
//    protected DescriptorMetadata $metadata;
    
    protected $guarded = ['id'];

    /**
     * @return \App\Models\Descriptors\DescriptorMetadata
     *
    public function getMetadata() : DescriptorMetadata
    {
        return $this->metadata;
    }

    /**
     * @param \App\Models\Descriptors\DescriptorMetadata $metadata
     *
    public function setMetadata(DescriptorMetadata $metadata) : void
    {
        $this->metadata = $metadata;
    }
    //*/
}