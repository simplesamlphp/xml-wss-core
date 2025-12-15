<?php

declare(strict_types=1);

namespace SimpleSAML\WebServices\Security\Type;

use SimpleSAML\WebServices\Security\Assert\Assert;
use SimpleSAML\WebServices\Security\Exception\ProtocolViolationException;
use SimpleSAML\XMLSchema\Type\DateTimeValue as BaseDateTimeValue;

/**
 * @package simplesaml/xml-wss-core
 */
class DateTimeValue extends BaseDateTimeValue
{
    /**
     * Lowercase p as opposed to the base-class to covert the timestamp to UTC as required
     * by the WSSecurity specifications
     */
    public const DATETIME_FORMAT = 'Y-m-d\\TH:i:sp';


    /**
     * Validate the value.
     *
     * @param string $value
     * @return void
     */
    protected function validateValue(string $value): void
    {
        // Note: value must already be sanitized before validating
        Assert::validDateTime($this->sanitizeValue($value), ProtocolViolationException::class);
    }
}
