<?php

class UTCDate
{
    public static function getUTCDateISO(): string
    {
        $date = new DateTime();
        $date->setTimezone(new DateTimeZone('UTC'));
        return substr($date->format('Y-m-d\TH:i:s.u\Z'), 0, -3) . 'Z';
    }
}