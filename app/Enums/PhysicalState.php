<?php

namespace App\Enums;

enum PhysicalState: string
{
    use \HasClassConstants;
    
    case RF_SOLID = 'solid';
    case Liquid = 'liquid';
}
