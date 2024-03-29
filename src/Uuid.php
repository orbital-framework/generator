<?php
declare(strict_types=1);

namespace Orbital\Generator;

abstract class Uuid {

    /**
     * Generate short UUID v4, without dashes
     * @return string
     */
    public static function generateShort(): string {
        $uuid = str_replace('-', '', self::generate());
        return $uuid;
    }

    /**
     * Generate full UUID v4
     * @see http://tools.ietf.org/html/rfc4122#section-4.4
     * @see http://en.wikipedia.org/wiki/UUID
     * @return string
     */
    public static function generate(): string {

        $prBits = null;
        $fp = @fopen('/dev/urandom', 'rb');

        if( $fp !== false ){
            $prBits .= @fread($fp, 16);
            @fclose($fp);

        }else{

            $prBits = "";

            for( $cnt = 0; $cnt < 16; $cnt++ ){
                $prBits .= chr(mt_rand(0, 255));
            }
        }

        $timeLow = bin2hex(substr($prBits,0, 4));
        $timeMid = bin2hex(substr($prBits,4, 2));
        $timeHiAndVersion = bin2hex(substr($prBits,6, 2));
        $clockSeqHiAndReserved = bin2hex(substr($prBits,8, 2));
        $node = bin2hex(substr($prBits,10, 6));

        $timeHiAndVersion = hexdec($timeHiAndVersion);
        $timeHiAndVersion = $timeHiAndVersion >> 4;
        $timeHiAndVersion = $timeHiAndVersion | 0x4000;

        $clockSeqHiAndReserved = hexdec($clockSeqHiAndReserved);
        $clockSeqHiAndReserved = $clockSeqHiAndReserved >> 2;
        $clockSeqHiAndReserved = $clockSeqHiAndReserved | 0x8000;

        return sprintf(
            '%08s-%04s-%04x-%04x-%012s',
            $timeLow,
            $timeMid,
            $timeHiAndVersion,
            $clockSeqHiAndReserved,
            $node
        );
    }

}