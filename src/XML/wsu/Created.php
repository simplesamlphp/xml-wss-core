<?php

declare(strict_types=1);

namespace SimpleSAML\WebServices\Security\XML\wsu;

use SimpleSAML\XML\SchemaValidatableElementInterface;
use SimpleSAML\XML\SchemaValidatableElementTrait;

/**
 * Class defining the Created element
 *
 * @package simplesamlphp/xml-wss-core
 */
final class Created extends AbstractAttributedDateTime implements SchemaValidatableElementInterface
{
    use SchemaValidatableElementTrait;
}
