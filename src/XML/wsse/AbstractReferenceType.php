<?php

declare(strict_types=1);

namespace SimpleSAML\WebServices\Security\XML\wsse;

use Dom;
use SimpleSAML\WebServices\Security\Assert\Assert;
use SimpleSAML\XML\ExtendableAttributesTrait;
use SimpleSAML\XMLSchema\Exception\InvalidDOMElementException;
use SimpleSAML\XMLSchema\Type\AnyURIValue;
use SimpleSAML\XMLSchema\XML\Constants\NS;

/**
 * Class defining the ReferenceType element
 *
 * @package simplesamlphp/xml-wss-core
 */
abstract class AbstractReferenceType extends AbstractWsseElement
{
    use ExtendableAttributesTrait;


    /** The namespace-attribute for the xs:anyAttribute element */
    public const string XS_ANY_ATTR_NAMESPACE = NS::OTHER;


    /**
     * AbstractReferenceType constructor
     *
     * @param \SimpleSAML\XMLSchema\Type\AnyURIValue|null $URI
     * @param \SimpleSAML\XMLSchema\Type\AnyURIValue|null $valueType
     * @param array<\SimpleSAML\XML\Attribute> $namespacedAttributes
     */
    final public function __construct(
        protected ?AnyURIValue $URI = null,
        protected ?AnyURIValue $valueType = null,
        array $namespacedAttributes = [],
    ) {
        $this->setAttributesNS($namespacedAttributes);
    }


    /**
     * @return \SimpleSAML\XMLSchema\Type\AnyURIValue|null
     */
    public function getValueType(): ?AnyURIValue
    {
        return $this->valueType;
    }


    /**
     * @return \SimpleSAML\XMLSchema\Type\AnyURIValue|null
     */
    public function getURI(): ?AnyURIValue
    {
        return $this->URI;
    }


    /**
     * Create an instance of this object from its XML representation.
     *
     * @param \Dom\Element $xml
     *
     * @throws \SimpleSAML\XMLSchema\Exception\InvalidDOMElementException
     *   if the qualified name of the supplied element is wrong
     */
    public static function fromXML(Dom\Element $xml): static
    {
        Assert::same($xml->localName, static::getLocalName(), InvalidDOMElementException::class);
        Assert::same($xml->namespaceURI, static::NS, InvalidDOMElementException::class);

        return new static(
            self::getOptionalAttribute($xml, 'URI', AnyURIValue::class, null),
            self::getOptionalAttribute($xml, 'ValueType', AnyURIValue::class, null),
            self::getAttributesNSFromXML($xml),
        );
    }


    /**
     * Add this username token to an XML element.
     *
     * @param \Dom\Element|null $parent The element we should append this username token to.
     */
    public function toXML(?Dom\Element $parent = null): Dom\Element
    {
        $e = parent::instantiateParentElement($parent);

        if ($this->getURI() !== null) {
            $e->setAttribute('URI', $this->getURI()->getValue());
        }

        if ($this->getValueType() !== null) {
            $e->setAttribute('ValueType', $this->getValueType()->getValue());
        }

        foreach ($this->getAttributesNS() as $attr) {
            $attr->toXML($e);
        }

        return $e;
    }
}
