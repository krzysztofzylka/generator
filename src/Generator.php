<?php

namespace Krzysztofzylka\Generator;

use Random\RandomException;

class Generator
{

    /**
     * Generate a unique identifier.
     *
     * @param int|null $length The desired length of the generated identifier. Defaults to null.
     * @return string The generated unique identifier.
     * @throws RandomException
     */
    public static function uniqId(?int $length = null) : string {
        $uniqId = str_pad(random_int(1, 99999), 5, 0, STR_PAD_LEFT);
        $uniqId .= time();
        $uniqId .= str_replace('.', '', uniqid('', true));
        $uniqId .= uniqid();

        $uniqId = hash('sha512', $uniqId);

        if (!is_null($length)) {
            $uniqId = substr($uniqId, 0, $length);
        }

        return $uniqId;
    }

    /**
     * Generate a unique hash using the xxHash algorithm.
     * @param string $salt The salt used to generate the hash. Defaults to empty string.
     * @return string The generated unique hash.
     * @throws RandomException
     */
    public static function uniqHash(string $salt = '') : string {
        return hash('xxh128', $salt . self::uniqId());
    }

    /**
     * Generate UUID
     * @return string The generated UUID.
     * @throws RandomException
     */
    public static function uuid() : string {
        $data = random_bytes(16);
        $data[6] = chr(ord($data[6]) & 0x0f | 0x40);
        $data[8] = chr(ord($data[8]) & 0x3f | 0x80);

        return vsprintf('%s%s-%s-%s-%s-%s%s%s', str_split(bin2hex($data), 4));
    }

}