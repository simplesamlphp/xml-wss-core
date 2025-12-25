<?php

declare(strict_types=1);

namespace SimpleSAML\WebServices\Security\XML\wsse11;

use DOMElement;
use SimpleSAML\WebServices\Security\Assert\Assert;
use SimpleSAML\WebServices\Security\Constants as C;
use SimpleSAML\WebServices\Security\Type\IDValue;
use SimpleSAML\XML\SchemaValidatableElementInterface;
use SimpleSAML\XML\SchemaValidatableElementTrait;
use SimpleSAML\XMLSchema\Exception\InvalidDOMElementException;
use SimpleSAML\XMLSchema\Exception\MissingElementException;
use SimpleSAML\XMLSchema\Exception\TooManyElementsException;
use SimpleSAML\XMLSecurity\XML\xenc\EncryptedData;

/**
 * Class representing the EncryptedHeader element
 *
 * @package simplesamlphp/xml-wss-core
 */
final class EncryptedHeader extends AbstractEncryptedHeader implements SchemaValidatableElementInterface
{
    use SchemaValidatableElementTrait;


    /**
     * Create an instance of this object from its XML representation.
     *
     * @throws \SimpleSAML\XMLSchema\Exception\InvalidDOMElementException
     *   if the qualified name of the supplied element is wrong
     */
    public static function fromXML(DOMElement $xml): static
    {
        Assert::same($xml->localName, static::getLocalName(), InvalidDOMElementException::class);
        Assert::same($xml->namespaceURI, static::NS, InvalidDOMElementException::class);

        $encryptedData = EncryptedData::getChildrenOfClass($xml);
        Assert::minCount($encryptedData, 1, MissingElementException::class);
        Assert::maxCount($encryptedData, 1, TooManyElementsException::class);

        $Id = null;
        if ($xml->hasAttributeNS(C::NS_SEC_UTIL, 'Id')) {
            $Id = IDValue::fromString($xml->getAttributeNS(C::NS_SEC_UTIL, 'Id'));
        }

        return new static(
            $encryptedData[0],
            $Id,
            self::getAttributesNSFromXML($xml),
        );
    }
}
