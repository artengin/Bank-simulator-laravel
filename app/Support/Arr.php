<?php

namespace App\Support;

use Illuminate\Support\Arr as BaseArr;

class Arr extends BaseArr
{
    protected static array $mockedCalls = [];

    /**
     * @example
     *
     * [
     *     'methodName' => ['firstCallResult', 'secondCallResult', 'thirdCallResult']
     * ]
     */
    public static function fake(array $calls): void
    {
        self::$mockedCalls = $calls;
    }

    public static function random($array, $number = null, $preserveKeys = false): string
    {
        return self::callWithFakeCheck('random', fn () => parent::random($array, $number, $preserveKeys));
    }

    protected static function callWithFakeCheck(string $method, callable $parentMethod): string
    {
        if (!empty(self::$mockedCalls[$method])) {
            return array_shift(self::$mockedCalls[$method]);
        }

        // @codeCoverageIgnoreStart
        return $parentMethod();
        // @codeCoverageIgnoreEnd
    }
}
