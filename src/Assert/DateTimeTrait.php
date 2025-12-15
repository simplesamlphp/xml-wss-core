<?php

declare(strict_types=1);

namespace SimpleSAML\WebServices\Security\Assert;

use SimpleSAML\WebServices\Security\Exception\ProtocolViolationException;

/**
 * @package simplesamlphp/xml-wss-core
 */
trait DateTimeTrait
{
    /**
     * @param string $value
     * @param string $message
     */
    protected static function validDateTime(string $value, string $message = ''): void
    {
        parent::validDateTime($value);
        parent::endsWith(
            $value,
            'Z',
            '%s is not a DateTime expressed in the UTC timezone using the \'Z\' timezone identifier.',
            ProtocolViolationException::class,
        );
    }
}
