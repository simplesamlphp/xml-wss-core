<?php

declare(strict_types=1);

namespace SimpleSAML\WebServices\Security\XML\wsse;

use SimpleSAML\XML\SchemaValidatableElementInterface;
use SimpleSAML\XML\SchemaValidatableElementTrait;

/**
 * Class defining the UsernameToken element
 *
 * @package simplesamlphp/xml-wss-core
 */
final class UsernameToken extends AbstractUsernameTokenType implements SchemaValidatableElementInterface
{
    use SchemaValidatableElementTrait;
}
