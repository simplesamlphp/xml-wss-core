<?php

declare(strict_types=1);

namespace SimpleSAML\WebServices\Security\XML\wsse;

use DOMElement;
use SimpleSAML\WebServices\Security\Assert\Assert;
use SimpleSAML\XML\ExtendableAttributesTrait;
use SimpleSAML\XML\ExtendableElementTrait;
use SimpleSAML\XMLSchema\Exception\InvalidDOMElementException;
use SimpleSAML\XMLSchema\Type\AnyURIValue;
use SimpleSAML\XMLSchema\XML\Constants\NS;

/**
 * Class defining the EmbeddedType element
 *
 * @package simplesamlphp/xml-wss-core
 */
abstract class AbstractEmbeddedType extends AbstractWsseElement
{
    use ExtendableAttributesTrait;
    use ExtendableElementTrait;


    /** The namespace-attribute for the xs:anyAttribute element */
    public const string XS_ANY_ATTR_NAMESPACE = NS::OTHER;

    /** The namespace-attribute for the xs:any element */
    public const string XS_ANY_ELT_NAMESPACE = NS::ANY;


    /**
     * AbstractEmbeddedType constructor
     *
     * @param \SimpleSAML\XMLSchema\Type\AnyURIValue|null $valueType
     * @param array<\SimpleSAML\XML\SerializableElementInterface> $children
     * @param array<\SimpleSAML\XML\Attribute> $namespacedAttributes
     */
    final public function __construct(
        protected ?AnyURIValue $valueType = null,
        array $children = [],
        array $namespacedAttributes = [],
    ) {
        $this->setElements($children);
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
     * Test if an object, at the state it's in, would produce an empty XML-element
     */
    public function isEmptyElement(): bool
    {
        return empty($this->getValueType()) &&
            empty($this->getElements()) &&
            empty($this->getAttributesNS());
    }


    /**
     * Create an instance of this object from its XML representation.
     *
     * @param \DOMElement $xml
     *
     * @throws \SimpleSAML\XMLSchema\Exception\InvalidDOMElementException
     *   if the qualified name of the supplied element is wrong
     */
    public static function fromXML(DOMElement $xml): static
    {
        Assert::same($xml->localName, static::getLocalName(), InvalidDOMElementException::class);
        Assert::same($xml->namespaceURI, static::NS, InvalidDOMElementException::class);

        return new static(
            self::getOptionalAttribute($xml, 'ValueType', AnyURIValue::class, null),
            self::getChildElementsFromXML($xml),
            self::getAttributesNSFromXML($xml),
        );
    }


    /**
     * Add this username token to an XML element.
     *
     * @param \DOMElement|null $parent The element we should append this username token to.
     */
    public function toXML(?DOMElement $parent = null): DOMElement
    {
        $e = parent::instantiateParentElement($parent);

        if ($this->getValueType() !== null) {
            $e->setAttribute('ValueType', $this->getValueType()->getValue());
        }

        foreach ($this->getAttributesNS() as $attr) {
            $attr->toXML($e);
        }

        foreach ($this->getElements() as $child) {
            if (!$child->isEmptyElement()) {
                $child->toXML($e);
            }
        }

        return $e;
    }
}
