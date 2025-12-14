<?php

declare(strict_types=1);

namespace SimpleSAML\WebServices\Security\XML\wsu;

use DOMElement;
use SimpleSAML\WebServices\Security\Assert\Assert;
use SimpleSAML\WebServices\Security\Type\IDValue;
use SimpleSAML\XML\ExtendableAttributesTrait;
use SimpleSAML\XML\ExtendableElementTrait;
use SimpleSAML\XMLSchema\Exception\InvalidDOMElementException;
use SimpleSAML\XMLSchema\XML\Constants\NS;

use function array_pop;

/**
 * Abstract class defining the Timestamp type
 *
 * @package simplesamlphp/xml-wss-core
 */
abstract class AbstractTimestamp extends AbstractWsuElement
{
    use ExtendableAttributesTrait;
    use ExtendableElementTrait;


    /** The namespace-attribute for the xs:anyAttribute element */
    public const XS_ANY_ATTR_NAMESPACE = NS::OTHER;

    /** The namespace-attribute for the xs:any element */
    public const XS_ANY_ELT_NAMESPACE = NS::ANY;

    /** The exclusions for the xs:any element */
    public const XS_ANY_ELT_EXCLUSIONS = [
        ['http://docs.oasis-open.org/wss/2004/01/oasis-200401-wss-wssecurity-utility-1.0.xsd', 'Created'],
        ['http://docs.oasis-open.org/wss/2004/01/oasis-200401-wss-wssecurity-utility-1.0.xsd', 'Expires'],
    ];


    /**
     * AbstractTimestamp constructor
     *
     * @param \SimpleSAML\WebServices\Security\XML\wsu\Created|null $created
     * @param \SimpleSAML\WebServices\Security\XML\wsu\Expires|null $expires
     * @param \SimpleSAML\WebServices\Security\Type\IDValue|null $Id
     * @param array<\SimpleSAML\XML\SerializableElementInterface> $elements
     * @param array<\SimpleSAML\XML\Attribute> $namespacedAttributes
     */
    final public function __construct(
        protected ?Created $created = null,
        protected ?Expires $expires = null,
        protected ?IDValue $Id = null,
        array $elements = [],
        array $namespacedAttributes = [],
    ) {
        $this->setElements($elements);
        $this->setAttributesNS($namespacedAttributes);
    }


    /**
     * @return \SimpleSAML\WebServices\Security\Type\IDValue|null
     */
    public function getId(): ?IDValue
    {
        return $this->Id;
    }


    /**
     * @return \SimpleSAML\WebServices\Security\XML\wsu\Created|null
     */
    public function getCreated(): ?Created
    {
        return $this->created;
    }


    /**
     * @return \SimpleSAML\WebServices\Security\XML\wsu\Expires|null
     */
    public function getExpires(): ?Expires
    {
        return $this->expires;
    }


    /**
     * Test if an object, at the state it's in, would produce an empty XML-element
     *
     * @return bool
     */
    public function isEmptyElement(): bool
    {
        return empty($this->getCreated())
            && empty($this->getExpires())
            && empty($this->getId())
            && empty($this->getElements())
            && empty($this->getAttributesNS());
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

        $created = Created::getChildrenOfClass($xml);
        $expires = Expires::getChildrenOfClass($xml);
        $children = self::getChildElementsFromXML($xml);

        $Id = null;
        if ($xml->hasAttributeNS(static::NS, 'Id')) {
            $Id = IDValue::fromString($xml->getAttributeNS(static::NS, 'Id'));
        }

        return new static(
            array_pop($created),
            array_pop($expires),
            $Id,
            $children,
            self::getAttributesNSFromXML($xml),
        );
    }


    /**
     * Convert this Timestamp to XML.
     *
     * @param \DOMElement|null $parent The element we should append this class to.
     * @return \DOMElement The XML element after adding the data corresponding to this Timestamp.
     */
    public function toXML(?DOMElement $parent = null): DOMElement
    {
        $e = $this->instantiateParentElement($parent);

        $attributes = $this->getAttributesNS();
        if ($this->getId() !== null) {
            $this->getId()->toAttribute()->toXML($e);
        }

        foreach ($attributes as $attr) {
            $attr->toXML($e);
        }

        $this->getCreated()?->toXML($e);
        $this->getExpires()?->toXML($e);

        foreach ($this->getElements() as $detail) {
            $detail->toXML($e);
        }

        return $e;
    }
}
