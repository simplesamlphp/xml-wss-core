<?php

declare(strict_types=1);

namespace SimpleSAML\WebServices\Security\XML\wsse11;

use DOMElement;
use SimpleSAML\WebServices\Security\Type\IDValue;
use SimpleSAML\XMLSchema\Type\Base64BinaryValue;

/**
 * Abstract class representing the SignatureConfirmationType
 *
 * @package simplesamlphp/xml-wss-core
 */
abstract class AbstractSignatureConfirmation extends AbstractWsse11Element
{
    /**
     * AbstractSignatureConfirmation constructor
     *
     * @param \SimpleSAML\XMLSchema\Type\Base64BinaryValue $value
     * @param \SimpleSAML\WebServices\Security\Type\IDValue|null $Id
     */
    final public function __construct(
        protected Base64BinaryValue $value,
        protected ?IDValue $Id = null,
    ) {
    }


    /**
     * @return \SimpleSAML\XMLSchema\Type\Base64BinaryValue
     */
    public function getValue(): Base64BinaryValue
    {
        return $this->value;
    }


    /**
     * @return \SimpleSAML\WebServices\Security\Type\IDValue|null
     */
    public function getID(): ?IDValue
    {
        return $this->Id;
    }


    /**
     */
    public function toXML(?DOMElement $parent = null): DOMElement
    {
        $e = $this->instantiateParentElement($parent);
        $e->setAttribute('Value', $this->getValue()->getValue());

        if ($this->getId() !== null) {
            $this->getId()->toAttribute()->toXML($e);
        }

        return $e;
    }
}
