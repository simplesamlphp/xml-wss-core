<?php

declare(strict_types=1);

namespace SimpleSAML\WebServices\Security\Assert;

use SimpleSAML\XML\Assert\Assert as BaseAssert;

/**
 * @package simplesamlphp/xml-wss-core
 *
 * @method static void validWSUDateTime(mixed $value, string $message = '', string $exception = '')
 * @method static void allWSUDateTime(mixed $value, string $message = '', string $exception = '')
 * @method static void nullOrValueWSUDateTime(mixed $value, string $message = '', string $exception = '')
 */
class Assert extends BaseAssert
{
    use DateTimeTrait;
}
