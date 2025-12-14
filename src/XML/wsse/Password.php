<?php

declare(strict_types=1);

namespace SimpleSAML\WebServices\Security\XML\wsse;

use SimpleSAML\XML\SchemaValidatableElementInterface;
use SimpleSAML\XML\SchemaValidatableElementTrait;

/**
 * Class defining the Password element
 *
 * @package simplesamlphp/xml-wss-core
 */
final class Password extends AbstractPasswordString implements SchemaValidatableElementInterface
{
    use SchemaValidatableElementTrait;
}
