<?php

declare(strict_types=1);

namespace SimpleSAML\WebServices\Security\XML\wsse;

use SimpleSAML\XML\SchemaValidatableElementInterface;
use SimpleSAML\XML\SchemaValidatableElementTrait;

/**
 * Class defining the Reference element
 *
 * @package simplesamlphp/xml-wss-core
 */
final class Reference extends AbstractReferenceType implements SchemaValidatableElementInterface
{
    use SchemaValidatableElementTrait;
}
