<?php

namespace App\Enum;

enum LeadStatus: string
{
    //
    case WAITING = 'waiting';
    case ANSWERED = 'answered';
    case NOT_REACHED = 'not_reached';
}
