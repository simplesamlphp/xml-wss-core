<?php

declare(strict_types=1);

namespace SimpleSAML\WebServices\Security\XML\wsse11;

use DOMElement;
use SimpleSAML\WebServices\Security\Type\IDValue;
use SimpleSAML\WebServices\Security\XML\wsu\IDTrait;
use SimpleSAML\XMLSchema\Type\Base64BinaryValue;

/**
 * Abstract class representing the SignatureConfirmationType
 *
 * @package simplesamlphp/xml-wss-core
 */
abstract class AbstractSignatureConfirmation extends AbstractWsse11Element
{
    use IDTrait;


    /**
     * AbstractSignatureConfirmation constructor
     *
     * @param \SimpleSAML\XMLSchema\Type\Base64BinaryValue $value
     * @param \SimpleSAML\WebServices\Security\Type\IDValue|null $Id
     */
    final public function __construct(
        protected Base64BinaryValue $value,
        ?IDValue $Id = null,
    ) {
        $this->setId($Id);
    }


    /**
     * @return \SimpleSAML\XMLSchema\Type\Base64BinaryValue
     */
    public function getValue(): Base64BinaryValue
    {
        return $this->value;
    }


    /**
     */
    public function toXML(?DOMElement $parent = null): DOMElement
    {
        $e = $this->instantiateParentElement($parent);
        $e->setAttribute('Value', $this->getValue()->getValue());

        $this->getId()?->toAttribute()->toXML($e);

        return $e;
    }
}
