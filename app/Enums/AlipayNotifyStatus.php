<?php

namespace App\Enums;

enum AlipayNotifyStatus: string
{
    case WAIT_BUYER_PAY = 'WAIT_BUYER_PAY';
    case TRADE_CLOSED = 'TRADE_CLOSED';
    case TRADE_SUCCESS = 'TRADE_SUCCESS';
    case TRADE_FINISHED = 'TRADE_FINISHED';

    public static function success(string $status): bool
    {
        return $status === AlipayNotifyStatus::TRADE_SUCCESS->name
            || $status === AlipayNotifyStatus::TRADE_FINISHED->name;
    }
}
