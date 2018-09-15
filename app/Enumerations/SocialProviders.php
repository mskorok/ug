<?php

namespace App\Enumerations;

class SocialProviders
{
    private static function getData()
    {
        return $data = [
            'facebook' => 1,
            'google' => 2
        ];
    }

    public static function getId(string $name)
    {

        if (! array_key_exists($name, self::getData())) {
            throw new \Exception('Not supported social service provider: ' . ucfirst($name));
        }

        return self::getData()[strtolower($name)];
    }
}