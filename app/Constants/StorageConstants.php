<?php


namespace App\Constants;


class StorageConstants
{
    const IMAGES           = 'images/';
    const THUMBNAIL        = 'thumbnail/';
    const VIDEOS           = 'videos/';
    const RESIZED_IMAGES   = self::IMAGES . 'resized/';
    const RESIZED_VIDEOS   = self::VIDEOS . 'resized/';
    const IMAGES_THUMBNAIL = self::IMAGES . self::THUMBNAIL;
    const VIDEOS_THUMBNAIL = self::VIDEOS . self::THUMBNAIL;
    const RESIZED_IMAGES_VALUES = [
        [75, 75],
        [300, 300],
        [640, 480],
    ];
}
