<?php

namespace App\Enums;

/**
 * StatusResult
 *
 * Simple way to represent whether the operation of generating a
 * quotation succeed or failed
 */
enum StatusResult
{
    case Ok;
    case Error;

    /**
     * Return true if the case is error
     *
     * @return bool
     */
    public function failed(): bool
    {
        return $this === self::Error;
    }

    /**
     * Return true if the case is ok
     */
    public function succeed(): bool
    {
        return $this === self::Ok;
    }
}
