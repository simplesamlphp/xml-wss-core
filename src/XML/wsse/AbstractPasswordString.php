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
 * Abstract class defining the PasswordString type
 *
 * @package simplesamlphp/xml-wss-core
 */
abstract class AbstractPasswordString extends AbstractAttributedString
{
    /**
     * AbstractPasswordString constructor
     *
     * @param \SimpleSAML\XMLSchema\Type\StringValue $content
     * @param \SimpleSAML\WebServices\Security\Type\IDValue|null $Id
     * @param array<\SimpleSAML\XML\Attribute> $namespacedAttributes
     * @param \SimpleSAML\XMLSchema\Type\AnyURIValue|null $Type
     */
    final public function __construct(
        #[\SensitiveParameter]
        StringValue $content,
        ?IDValue $Id = null,
        array $namespacedAttributes = [],
        protected ?AnyURIValue $Type = null,
    ) {
        parent::__construct($content, $Id, $namespacedAttributes);
    }


    /**
     * @return \SimpleSAML\XMLSchema\Type\AnyURIValue|null
     */
    public function getType(): ?AnyURIValue
    {
        return $this->Type;
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
        if ($xml->hasAttributeNS(C::NS_SEC_UTIL, 'Id')) {
            $Id = IDValue::fromString($xml->getAttributeNS(C::NS_SEC_UTIL, 'Id'));
        }

        return new static(
            StringValue::fromString($xml->textContent),
            $Id,
            self::getAttributesNSFromXML($xml),
            self::getOptionalAttribute($xml, 'Type', AnyURIValue::class, null),
        );
    }


    /**
     * @param \DOMElement|null $parent
     */
    public function toXML(?DOMElement $parent = null): DOMElement
    {
        $e = parent::toXML($parent);

        if ($this->getType() !== null) {
            $e->setAttribute('Type', $this->getType()->getValue());
        }

        return $e;
    }
}
