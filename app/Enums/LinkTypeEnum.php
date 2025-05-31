<?php


namespace App\Enums;

enum LinkTypeEnum: string
{
    case PORTFOLIO = 'portfolio';
    case LINKEDIN = 'linkedin';
    case TWITTER = 'twitter';
    case FACEBOOK = 'facebook';
    case GITHUB = 'github';
    case INSTAGRAM = 'instagram';
    case YOUTUBE = 'youtube';
    case TIKTOK = 'tiktok';
    case BEHANCE = 'behance';
    case DRIBBBLE = 'dribbble';
    case PINTEREST = 'pinterest';

    case THREADS = 'threads';
}
