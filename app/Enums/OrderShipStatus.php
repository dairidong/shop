<?php

namespace App\Enums;

enum OrderShipStatus: string
{
    case PENDING = 'pending';
    case DELIVERED = 'delivered';
    case RECEIVED = 'received';
}
