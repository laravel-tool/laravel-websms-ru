<?php

namespace LaravelTool\LaravelWebsmsRu;

class Normalize
{
    public static function phone(string $phone): string
    {
        $phone = self::onlyNumbers($phone);
        if (mb_strlen($phone) == 10) {
            return '+7'.$phone;
        }
        if (mb_strlen($phone) == 7) {
            return '+7812'.$phone;
        }
        if (mb_strlen($phone) > 10) {
            return '+7'.mb_substr($phone, -10);
        }
        return $phone;
    }

    public static function onlyNumbers($string): string
    {
        return preg_replace('/[^0-9]/us', '', $string);
    }
}
