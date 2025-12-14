<?php

declare(strict_types=1);

namespace SimpleSAML\WebServices\Security\XML\wsse;

use SimpleSAML\XML\SchemaValidatableElementInterface;
use SimpleSAML\XML\SchemaValidatableElementTrait;

/**
 * Class defining the SecurityTokenReference element
 *
 * @package simplesamlphp/xml-wss-core
 */
final class SecurityTokenReference extends AbstractSecurityTokenReferenceType implements
    SchemaValidatableElementInterface
{
    use SchemaValidatableElementTrait;
}
