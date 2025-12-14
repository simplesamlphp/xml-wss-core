<?php

declare(strict_types=1);

namespace SimpleSAML\WebServices\Security\XML\wsse;

use SimpleSAML\XML\SchemaValidatableElementInterface;
use SimpleSAML\XML\SchemaValidatableElementTrait;

/**
 * Class defining the KeyIdentifier element
 *
 * @package simplesamlphp/xml-wss-core
 */
final class KeyIdentifier extends AbstractKeyIdentifierType implements SchemaValidatableElementInterface
{
    use SchemaValidatableElementTrait;
}
