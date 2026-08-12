<?php

namespace App\Enums;

enum MediaStatus: string
{
    case Pending = 'pending';
    case Approved = 'approved';
    case Refused = 'refused';
}
