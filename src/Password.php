<?php
declare(strict_types=1);

namespace Orbital\Generator;

abstract class Password {

    /**
     * Generate random password with the given length
     * @param int $length
     * @return string
     */
    public static function generate(int $length = 32): string {

        $bytes = openssl_random_pseudo_bytes($length / 2);
        $password = bin2hex($bytes);

        return $password;
    }

}