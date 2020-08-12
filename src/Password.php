<?php

namespace Orbital\Generator;

abstract class Password {

    /**
     * Generate random password with the given length
     * @param integer $length
     * @return string
     */
    public static function generate($length = 32){

        $bytes = openssl_random_pseudo_bytes($length / 2);
        $password = bin2hex($bytes);

        return $password;
    }

}