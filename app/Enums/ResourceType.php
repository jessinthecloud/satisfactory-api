<?php

namespace App\Enums;

enum ResourceType : string
{
    case Natural = 'Natural';
    case Part = 'Part';
    case Equipment = 'Equipment';
    case Building = 'Building';
}
