<?php

declare(strict_types=1);

namespace SimpleSAML\WebServices\Security\XML\wsse;

use DOMElement;
use SimpleSAML\WebServices\Security\Assert\Assert;
use SimpleSAML\WebServices\Security\Constants as C;
use SimpleSAML\WebServices\Security\Type\IDValue;
use SimpleSAML\WebServices\Security\Type\UsageValue;
use SimpleSAML\WebServices\Security\XML\wsu\IDTrait;
use SimpleSAML\XML\ExtendableAttributesTrait;
use SimpleSAML\XML\ExtendableElementTrait;
use SimpleSAML\XMLSchema\Exception\InvalidDOMElementException;
use SimpleSAML\XMLSchema\XML\Constants\NS;

/**
 * Class defining the SecurityTokenReferenceType element
 *
 * @package simplesamlphp/xml-wss-core
 */
abstract class AbstractSecurityTokenReferenceType extends AbstractWsseElement
{
    use ExtendableAttributesTrait;
    use ExtendableElementTrait;
    use IDTrait;
    use UsageTrait;


    /** The namespace-attribute for the xs:anyAttribute element */
    public const string XS_ANY_ATTR_NAMESPACE = NS::OTHER;

    /** The exclusions for the xs:anyAttribute element */
    public const array XS_ANY_ATTR_EXCLUSIONS = [
        ['http://docs.oasis-open.org/wss/2004/01/oasis-200401-wss-wssecurity-utility-1.0.xsd', 'Id'],
        ['http://docs.oasis-open.org/wss/2004/01/oasis-200401-wss-wssecurity-secext-1.0.xsd', 'Usage'],
    ];

    /** The namespace-attribute for the xs:any element */
    public const string XS_ANY_ELT_NAMESPACE = NS::ANY;


    /**
     * AbstractSecurityReferenceType constructor
     *
     * @param \SimpleSAML\WebServices\Security\Type\IDValue|null $Id
     * @param \SimpleSAML\WebServices\Security\Type\UsageValue|null $Usage
     * @param array<\SimpleSAML\XML\SerializableElementInterface> $children
     * @param array<\SimpleSAML\XML\Attribute> $namespacedAttributes
     */
    final public function __construct(
        ?IDValue $Id = null,
        ?UsageValue $Usage = null,
        array $children = [],
        array $namespacedAttributes = [],
    ) {
        $this->setId($Id);
        $this->setUsage($Usage);
        $this->setElements($children);
        $this->setAttributesNS($namespacedAttributes);
    }


    /**
     * Test if an object, at the state it's in, would produce an empty XML-element
     */
    public function isEmptyElement(): bool
    {
        return empty($this->getId()) &&
            empty($this->getUsage()) &&
            empty($this->getElements()) &&
            empty($this->getAttributesNS());
    }


    /**
     * Create an instance of this object from its XML representation.
     *
     * @param \DOMElement $xml
     * @throws \SimpleSAML\XMLSchema\Exception\InvalidDOMElementException
     *   if the qualified name of the supplied element is wrong
     */
    public static function fromXML(DOMElement $xml): static
    {
        Assert::same($xml->localName, static::getLocalName(), InvalidDOMElementException::class);
        Assert::same($xml->namespaceURI, static::NS, InvalidDOMElementException::class);

        $Id = null;
        if ($xml->hasAttributeNS(C::NS_SEC_UTIL, 'Id')) {
            $Id = IDValue::fromString($xml->getAttributeNS(C::NS_SEC_UTIL, 'Id'));
        }

        $Usage = null;
        if ($xml->hasAttributeNS(C::NS_SEC_EXT, 'Usage')) {
            $Usage = UsageValue::fromString($xml->getAttributeNS(C::NS_SEC_EXT, 'Usage'));
        }

        return new static(
            $Id,
            $Usage,
            self::getChildElementsFromXML($xml),
            self::getAttributesNSFromXML($xml),
        );
    }


    /**
     * Add this SecurityTokenReferenceType token to an XML element.
     *
     * @param \DOMElement|null $parent The element we should append this username token to.
     */
    public function toXML(?DOMElement $parent = null): DOMElement
    {
        $e = parent::instantiateParentElement($parent);

        $this->getId()?->toAttribute()->toXML($e);
        $this->getUsage()?->toAttribute()->toXML($e);

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
