<?php

namespace App\Enums;

enum TaskStatus: string
{
    case ACTIVE = 'active';
    case COMPLETED = 'completed';
}
