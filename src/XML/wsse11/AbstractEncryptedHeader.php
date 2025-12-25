<?php

declare(strict_types=1);

namespace SimpleSAML\WebServices\Security\XML\wsse11;

use DOMElement;
use SimpleSAML\WebServices\Security\Assert\Assert;
use SimpleSAML\WebServices\Security\Type\IDValue;
use SimpleSAML\WebServices\Security\XML\wsu\IDTrait;
use SimpleSAML\XML\Attribute as XMLAttribute;
use SimpleSAML\XML\ExtendableAttributesTrait;
use SimpleSAML\XMLSecurity\XML\xenc\EncryptedData;

use function array_map;
use function array_unique;

/**
 * Abstract class representing the EncryptedHeaderType
 *
 * @package simplesamlphp/xml-wss-core
 */
abstract class AbstractEncryptedHeader extends AbstractWsse11Element
{
    use ExtendableAttributesTrait;
    use IDTrait;


    /** The namespace-attribute for the xs:anyAttribute element */
    public const array XS_ANY_ATTR_NAMESPACE = [
        'http://schemas.xmlsoap.org/soap/envelope/',
        'http://www.w3.org/2003/05/soap-envelope',
    ];


    /**
     * AbstractEncryptedHeader constructor
     *
     * @param \SimpleSAML\XMLSecurity\XML\xenc\EncryptedData $encryptedData
     * @param \SimpleSAML\WebServices\Security\Type\IDValue|null $Id
     * @param \SimpleSAML\XML\Attribute[] $namespacedAttributes
     */
    final public function __construct(
        protected EncryptedData $encryptedData,
        ?IDValue $Id = null,
        array $namespacedAttributes = [],
    ) {
        $namespaces = array_map(
            function (XMLAttribute $attr) {
                return $attr->getNamespaceURI();
            },
            $namespacedAttributes,
        );

        Assert::maxCount(
            array_unique($namespaces),
            1,
            "Either use namespaces attributes from the SOAP 1.1 specification or of the SOAP 1.2 specification.",
        );

        $this->setId($Id);
        $this->setAttributesNS($namespacedAttributes);
    }


    /**
     * Collect the value of the encryptedData property
     *
     * @return \SimpleSAML\XMLSecurity\XML\xenc\EncryptedData
     */
    public function getEncryptedData(): EncryptedData
    {
        return $this->encryptedData;
    }


    /**
     * @param \DOMElement|null $parent
     */
    final public function toXML(?DOMElement $parent = null): DOMElement
    {
        $e = $this->instantiateParentElement($parent);

        $this->getEncryptedData()->toXML($e);

        $this->getId()?->toAttribute()->toXML($e);

        foreach ($this->getAttributesNS() as $attr) {
            switch ($attr->getNamespaceURI()) {
                case 'http://schemas.xmlsoap.org/soap/envelope/':
                    /** @var \SimpleSAML\XMLSchema\Type\BooleanValue $value */
                    $value = $attr->getAttrValue();
                    if ($attr->getAttrName() === 'mustUnderstand' && $value->getValue() === '0') {
                        continue; // We may not send this
                    }
                    $attr->toXML($e);
                    continue;
                case 'http://www.w3.org/2003/05/soap-envelope':
                    /** @var \SimpleSAML\XMLSchema\Type\BooleanValue $value */
                    $value = $attr->getAttrValue();
                    if (
                        ($attr->getAttrName() === 'mustUnderstand' || $attr->getAttrName() === 'relay')
                        && $value->getValue() === '0'
                    ) {
                        continue; // We may not send this
                    }
                    $attr->toXML($e);
                    continue;
                default:
                    continue;
            }
        }

        return $e;
    }
}
