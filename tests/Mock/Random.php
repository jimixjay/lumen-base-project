<?php

namespace Test\Mock;

use DateTime;

class Random
{
    public static function generateText($length = 10)
    {
        $characters   = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ\' ñÑ-';
        $randomString = '';

        for ($i = 0; $i < $length; $i++) {
            $index        = rand(0, strlen($characters) - 1);
            $randomString .= $characters[$index];
        }

        return $randomString;
    }

    public static function generateTextWithLetters($length = 10)
    {
        $characters   = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $randomString = '';

        for ($i = 0; $i < $length; $i++) {
            $index        = rand(0, strlen($characters) - 1);
            $randomString .= $characters[$index];
        }

        return $randomString;
    }

    public static function generateLetter()
    {
        $characters   = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $randomString = '';

        for ($i = 0; $i < 1; $i++) {
            $index        = rand(0, strlen($characters) - 1);
            $randomString .= $characters[$index];
        }

        return $randomString;
    }

    public static function generatePersonName($length = 10)
    {
        return ucfirst(self::generateTextWithLetters($length));
    }

    public static function generateInt($length = 10)
    {
        $characters   = '0123456789';
        $randomString = '';

        for ($i = 0; $i < $length; $i++) {
            $index        = rand(0, strlen($characters) - 1);
            $randomString .= $characters[$index];
        }

        return $randomString;
    }

    public static function generateFloat($min = 2, $max = 100)
    {
        $characters   = '0123456789';
        $randomString = '';

        for ($i = 0; $i < $max; $i++) {
            $index        = rand(0, strlen($characters) - 1);
            $randomString .= $characters[$index];
        }

        return $randomString / 100;
    }



    public static function generateDate($startYear = 1920, $endYear = 2021, $format = null)
    {
        $years = range($startYear, $endYear);
        $months = ['01','02','03','04','05','06','07','08','09','10','11','12'];
        $days = ['01','02','03','04','05','06','07','08','09','10','11','12','13','14','15','16','17','18','19','20','21','22','23','24','25','26','27','28'];

        $date = new DateTime($years[mt_rand(0, count($years) - 1)] . '-' . $months[mt_rand(0, count($months) - 1)] . '-' . $days[mt_rand(0, count($days) - 1)] . ' 00:00:00');

        if (is_null($format)) {
            return $date;
        }

        return $date->format($format);
    }

    public static function generateEmail()
    {
        $characters   = 'abcdefghijklmnopqrstuvwxyz1234567890_';
        $randomString = '';

        for ($i = 0; $i < 10; $i++) {
            $index        = rand(0, strlen($characters) - 1);
            $randomString .= $characters[$index];
        }

        $randomString .= '@';

        for ($i = 0; $i < 5; $i++) {
            $index        = rand(0, strlen($characters) - 1);
            $randomString .= $characters[$index];
        }

        $randomString .= '.com';

        return $randomString;
    }

    public static function generateMsisdn($initialDigit = '6')
    {
        $msisdn = $initialDigit;

        return $msisdn . self::generateInt(8);
    }

}