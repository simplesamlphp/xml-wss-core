<?php

declare(strict_types=1);

namespace SimpleSAML\WebServices\Security\XML\wsse11;

use DOMElement;
use SimpleSAML\SOAP11\Constants as SOAP11;
use SimpleSAML\SOAP11\Type\ActorValue;
use SimpleSAML\SOAP11\Type\MustUnderstandValue as MustUnderstandValueA;
use SimpleSAML\SOAP12\Constants as SOAP12;
use SimpleSAML\SOAP12\Type\MustUnderstandValue as MustUnderstandValueB;
use SimpleSAML\SOAP12\Type\RelayValue;
use SimpleSAML\SOAP12\Type\RoleValue;
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

        $mustUnderstandA = null;
        if ($xml->hasAttributeNS(SOAP11::NS_SOAP_ENV, 'mustUnderstand')) {
            $mustUnderstandA = MustUnderstandValueA::fromString(
                $xml->getAttributeNS(SOAP11::NS_SOAP_ENV, 'mustUnderstand'),
            );
        }

        $actor = null;
        if ($xml->hasAttributeNS(SOAP11::NS_SOAP_ENV, 'actor')) {
            $actor = ActorValue::fromString($xml->getAttributeNS(SOAP11::NS_SOAP_ENV, 'actor'));
        }

        $mustUnderstandB = null;
        if ($xml->hasAttributeNS(SOAP12::NS_SOAP_ENV, 'mustUnderstand')) {
            $mustUnderstandB = MustUnderstandValueB::fromString(
                $xml->getAttributeNS(SOAP12::NS_SOAP_ENV, 'mustUnderstand'),
            );
        }

        $role = null;
        if ($xml->hasAttributeNS(SOAP12::NS_SOAP_ENV, 'role')) {
            $role = RoleValue::fromString($xml->getAttributeNS(SOAP12::NS_SOAP_ENV, 'role'));
        }

        $relay = null;
        if ($xml->hasAttributeNS(SOAP12::NS_SOAP_ENV, 'relay')) {
            $relay = RelayValue::fromString($xml->getAttributeNS(SOAP12::NS_SOAP_ENV, 'relay'));
        }

        return new static(
            $encryptedData[0],
            $Id,
            $mustUnderstandA ?? $mustUnderstandB,
            $actor,
            $role,
            $relay,
        );
    }
}
