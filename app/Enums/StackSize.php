<?php

namespace App\Enums;

enum StackSize: int
{
    use \HasClassConstants;
    
    case SS_ONE = 1;
    case SS_SMALL = 50;
    case SS_MEDIUM = 100;
    case SS_BIG = 200;
    case SS_HUGE = 500;
    case SS_FLUID = 50000;
}
