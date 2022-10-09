<?php

namespace App\Enums;

enum ResourcePurity: string
{
    use \HasClassConstants;
    
    case Impure = 'impure';
    case Normal = 'normal';
    case Pure = 'pure';
}
