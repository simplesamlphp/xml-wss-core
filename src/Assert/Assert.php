<?php

declare(strict_types=1);

namespace SimpleSAML\WebServices\Security\Assert;

use SimpleSAML\XML\Assert\Assert as BaseAssert;

/**
 * @package simplesamlphp/xml-wss-core
 *
 * @method static void validDateTime(mixed $value, string $message = '', string $exception = '')
 * @method static void allDateTime(mixed $value, string $message = '', string $exception = '')
 * @method static void nullOrValueDateTime(mixed $value, string $message = '', string $exception = '')
 */
class Assert extends BaseAssert
{
    use DateTimeTrait;
}
