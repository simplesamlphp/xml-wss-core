<?php

declare(strict_types=1);

namespace SimpleSAML\WebServices\Security\XML\wsse11;

use SimpleSAML\XML\SchemaValidatableElementInterface;
use SimpleSAML\XML\SchemaValidatableElementTrait;
use SimpleSAML\XML\TypedTextContentTrait;
use SimpleSAML\XMLSchema\Type\UnsignedIntValue;

/**
 * Class representing the Iteration element
 *
 * @package simplesamlphp/xml-wss-core
 */
final class Iteration extends AbstractWsse11Element implements SchemaValidatableElementInterface
{
    use SchemaValidatableElementTrait;
    use TypedTextContentTrait;


    public const string TEXTCONTENT_TYPE = UnsignedIntValue::class;
}
