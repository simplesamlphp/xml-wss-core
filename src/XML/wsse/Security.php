<?php

declare(strict_types=1);

namespace SimpleSAML\WebServices\Security\XML\wsse;

use SimpleSAML\XML\SchemaValidatableElementInterface;
use SimpleSAML\XML\SchemaValidatableElementTrait;

/**
 * Class defining the Security element
 *
 * @package simplesamlphp/xml-wss-core
 */
final class Security extends AbstractSecurityHeaderType implements SchemaValidatableElementInterface
{
    use SchemaValidatableElementTrait;
}
