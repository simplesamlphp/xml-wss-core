<?php

declare(strict_types=1);

namespace SimpleSAML\WebServices\Security\XML\wsse;

use DOMElement;
use SimpleSAML\WebServices\Security\Assert\Assert;
use SimpleSAML\WebServices\Security\Constants as C;
use SimpleSAML\WebServices\Security\Type\IDValue;
use SimpleSAML\XMLSchema\Exception\InvalidDOMElementException;
use SimpleSAML\XMLSchema\Type\AnyURIValue;
use SimpleSAML\XMLSchema\Type\StringValue;

/**
 * Class defining the BinarySecurityTokenType element
 *
 * @package simplesamlphp/xml-wss-core
 */
abstract class AbstractBinarySecurityTokenType extends AbstractEncodedString
{
    /**
     * AbstractBinarySecurityTokenType constructor
     *
     * @param \SimpleSAML\XMLSchema\Type\StringValue $content
     * @param \SimpleSAML\WebServices\Security\Type\IDValue|null $Id
     * @param array<\SimpleSAML\XML\Attribute> $namespacedAttributes
     * @param \SimpleSAML\XMLSchema\Type\AnyURIValue|null $valueType
     * @param \SimpleSAML\XMLSchema\Type\AnyURIValue|null $EncodingType
     */
    final public function __construct(
        StringValue $content,
        ?IDValue $Id = null,
        array $namespacedAttributes = [],
        protected ?AnyURIValue $valueType = null,
        ?AnyURIValue $EncodingType = null,
    ) {
        Assert::validBase64Binary($content->getValue());
        parent::__construct($content, $Id, $namespacedAttributes, $EncodingType);
    }


    /**
     * @return \SimpleSAML\XMLSchema\Type\AnyURIValue|null
     */
    public function getValueType(): ?AnyURIValue
    {
        return $this->valueType;
    }


    /**
     * Create an instance of this object from its XML representation.
     *
     * @param \DOMElement $xml
     * @return static
     *
     * @throws \SimpleSAML\XMLSchema\Exception\InvalidDOMElementException
     *   if the qualified name of the supplied element is wrong
     */
    public static function fromXML(DOMElement $xml): static
    {
        Assert::same($xml->localName, static::getLocalName(), InvalidDOMElementException::class);
        Assert::same($xml->namespaceURI, static::NS, InvalidDOMElementException::class);

        $nsAttributes = self::getAttributesNSFromXML($xml);

        $Id = null;
        if ($xml->hasAttributeNS(C::NS_SEC_UTIL, 'Id')) {
            $Id = IDValue::fromString($xml->getAttributeNS(C::NS_SEC_UTIL, 'Id'));
        }

        return new static(
            StringValue::fromString($xml->textContent),
            $Id,
            self::getAttributesNSFromXML($xml),
            self::getOptionalAttribute($xml, 'ValueType', AnyURIValue::class, null),
            self::getOptionalAttribute($xml, 'EncodingType', AnyURIValue::class, null),
        );
    }


    /**
     * Add this username token to an XML element.
     *
     * @param \DOMElement $parent The element we should append this username token to.
     * @return \DOMElement
     */
    public function toXML(?DOMElement $parent = null): DOMElement
    {
        $e = parent::toXML($parent);

        if ($this->getValueType() !== null) {
            $e->setAttribute('ValueType', $this->getValueType()->getValue());
        }

        return $e;
    }
}
