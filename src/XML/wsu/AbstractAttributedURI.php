<?php

declare(strict_types=1);

namespace SimpleSAML\WebServices\Security\XML\wsu;

use DOMElement;
use SimpleSAML\WebServices\Security\Assert\Assert;
use SimpleSAML\WebServices\Security\Type\IDValue;
use SimpleSAML\XML\ExtendableAttributesTrait;
use SimpleSAML\XML\TypedTextContentTrait;
use SimpleSAML\XMLSchema\Exception\InvalidDOMElementException;
use SimpleSAML\XMLSchema\Type\AnyURIValue;
use SimpleSAML\XMLSchema\XML\Constants\NS;

/**
 * Abstract class defining the AttributedURI type
 *
 * @package simplesamlphp/xml-wss-core
 */
abstract class AbstractAttributedURI extends AbstractWsuElement
{
    use ExtendableAttributesTrait;
    use IDTrait;
    use TypedTextContentTrait;


    public const string TEXTCONTENT_TYPE = AnyURIValue::class;

    /** The namespace-attribute for the xs:anyAttribute element */
    public const string XS_ANY_ATTR_NAMESPACE = NS::OTHER;


    /**
     * AbstractAttributedURI constructor
     *
     * @param \SimpleSAML\XMLSchema\Type\AnyURIValue $uri
     * @param \SimpleSAML\WebServices\Security\Type\IDValue|null $Id
     * @param array<\SimpleSAML\XML\Attribute> $namespacedAttributes
     */
    final protected function __construct(
        AnyURIValue $uri,
        ?IDValue $Id = null,
        array $namespacedAttributes = [],
    ) {
        $this->setContent($uri);
        $this->setId($Id);
        $this->setAttributesNS($namespacedAttributes);
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

        $Id = null;
        if ($xml->hasAttributeNS(static::NS, 'Id')) {
            $Id = IDValue::fromString($xml->getAttributeNS(static::NS, 'Id'));
        }

        return new static(AnyURIValue::fromString($xml->textContent), $Id, self::getAttributesNSFromXML($xml));
    }


    /**
     * @param \DOMElement|null $parent
     */
    final public function toXML(?DOMElement $parent = null): DOMElement
    {
        $e = $this->instantiateParentElement($parent);
        $e->textContent = $this->getContent()->getValue();

        $this->getId()?->toAttribute()->toXML($e);

        foreach ($this->getAttributesNS() as $attr) {
            $attr->toXML($e);
        }

        return $e;
    }
}
