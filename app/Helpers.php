<?php

namespace App;


class Helpers
{
    public static function spellout($number, $lang = 'en') {

        $spell = new \NumberFormatter("{$lang}", \NumberFormatter::SPELLOUT);
        return $spell->format($number);
    }
}