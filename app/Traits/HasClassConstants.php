<?php

trait HasClassConstants
{
    public static function fromName(string $name)
    {
        return defined(self::class."::$name") ? constant(self::class."::$name") : null;
    }
}