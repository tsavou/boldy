<?php

namespace App\Enums;

enum SubscriptionPlanEnum: string
{
    case FREE = 'free';
    case PREMIUM = 'premium';
    //case BOOST = 'boost';


    public function price(): string
    {
        return match ($this) {
            self::FREE => 0,
            self::PREMIUM => 39.99,
            //self::BOOST => '20000',
        };
    }
}
