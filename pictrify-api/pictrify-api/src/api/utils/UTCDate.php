<?php

class UTCDate
{
    public static function nowISO(): string
    {
        $date = new DateTime();
        $date->setTimezone(new DateTimeZone('UTC'));
        return substr($date->format('Y-m-d\TH:i:s.u\Z'), 0, -4) . 'Z';
    }

    public static function isValidISO($date): bool
    {
        return preg_match('/^\d{4}-\d{2}-\d{2}T\d{2}:\d{2}:\d{2}.\d{3}Z$/', $date);
    }
}