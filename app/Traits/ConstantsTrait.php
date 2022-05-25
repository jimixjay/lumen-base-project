<?php

namespace App\Traits;

use ReflectionClass;

/**
 * GetConstantsListTrait.
 */
trait ConstantsTrait
{
    /**
     * @return array
     */
    public static function getList(): array
    {
        $class = new ReflectionClass(__CLASS__);

        return $class->getConstants();
    }

    /**
     * @return array
     */
    public static function getListOrderedByKeys(): array
    {
        $constants = self::getList();
        ksort($constants);

        return $constants;
    }

    /**
     * @return array
     */
    public static function getListOrderedByValues(): array
    {
        $constants = self::getList();
        asort($constants);

        return $constants;
    }

    /**
     * @param string $key
     *
     * @return string
     */
    public static function getName($key)
    {
        $names = self::getNames();
        foreach ($names as $name => $value) {
            if ($value == $key) {
                return $name;
            }
        }
    }

    /**
     * @return array
     */
    public static function getNames(): array
    {
        $class = new ReflectionClass(__CLASS__);

        return array_flip($class->getConstants());
    }
}
