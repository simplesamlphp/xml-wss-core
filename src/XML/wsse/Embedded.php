<?php

declare(strict_types=1);

namespace SimpleSAML\WebServices\Security\XML\wsse;

use SimpleSAML\XML\SchemaValidatableElementInterface;
use SimpleSAML\XML\SchemaValidatableElementTrait;

/**
 * Class defining the Embedded element
 *
 * @package simplesamlphp/xml-wss-core
 */
final class Embedded extends AbstractEmbeddedType implements SchemaValidatableElementInterface
{
    use SchemaValidatableElementTrait;
}
