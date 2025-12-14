<?php

declare(strict_types=1);

namespace SimpleSAML\WebServices\Security\Type;

use SimpleSAML\WebServices\Security\Constants as C;
use SimpleSAML\XML\Attribute;
use SimpleSAML\XMLSchema\Type\IDValue as XSDIDValue;
use SimpleSAML\XMLSchema\Type\Interface\AttributeTypeInterface;

/**
 * @package simplesaml/xml-wss-core
 */
class IDValue extends XSDIDValue implements AttributeTypeInterface
{
    /**
     * Convert this value to an attribute
     *
     * @return \SimpleSAML\XML\Attribute
     */
    public function toAttribute(): Attribute
    {
        return new Attribute(C::NS_SEC_UTIL, 'wsu', 'Id', $this);
    }
}
