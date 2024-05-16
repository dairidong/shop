<?php

namespace App\Enums;

enum PaymentNotifyMode: string
{
    case CALLBACK = 'callback';
    case QUERY = 'query';
}
