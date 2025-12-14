<?php

declare(strict_types=1);

namespace SimpleSAML\WebServices\Security\XML\wsse;

use SimpleSAML\XML\SchemaValidatableElementInterface;
use SimpleSAML\XML\SchemaValidatableElementTrait;

/**
 * Class defining the TransformationParameters element
 *
 * @package simplesamlphp/xml-wss-core
 */
final class TransformationParameters extends AbstractTransformationParametersType implements
    SchemaValidatableElementInterface
{
    use SchemaValidatableElementTrait;
}
