<?php

use Vinkla\Hashids\Facades\Hashids;

/**
 * @param $val
 * @return mixed
 */
function encode($val) {
    return Hashids::encode($val);
}

/**
 * @param $hash
 * @return mixed
 * @throws Exception
 */
function decode($hash) {
    $val = Hashids::decode($hash);

    if (!$val) {
        throw new Exception($hash);
    }

    return $val[0];
}

/**
 * @param $address
 * @return null|string
 */
function formatAddress($address) {
    if ($address) {
        $parts = array_filter([$address->address, $address->city, $address->postcode]);
        if (count($parts) > 0) {
            return implode(' ', $parts);
        }
    }

    return null;
}
