<?php

declare(strict_types=1);

namespace SimpleSAML\WebServices\Security\XML\wsse11;

use DOMElement;
use SimpleSAML\SOAP11\Type\ActorValue;
use SimpleSAML\SOAP11\Type\MustUnderstandValue as MustUnderstandValueA;
use SimpleSAML\SOAP11\XML\ActorTrait;
use SimpleSAML\SOAP12\Type\MustUnderstandValue as MustUnderstandValueB;
use SimpleSAML\SOAP12\Type\RelayValue;
use SimpleSAML\SOAP12\Type\RoleValue;
use SimpleSAML\SOAP12\XML\RelayTrait;
use SimpleSAML\SOAP12\XML\RoleTrait;
use SimpleSAML\WebServices\Security\Type\IDValue;
use SimpleSAML\XMLSecurity\XML\xenc\EncryptedData;

/**
 * Abstract class representing the EncryptedHeaderType
 *
 * @package simplesamlphp/xml-wss-core
 */
abstract class AbstractEncryptedHeader extends AbstractWsse11Element
{
    use ActorTrait;
    use RoleTrait;
    use RelayTrait;


    /**
     * AbstractEncryptedHeader constructor
     *
     * @param \SimpleSAML\XMLSecurity\XML\xenc\EncryptedData $encryptedData
     * @param \SimpleSAML\WebServices\Security\Type\IDValue|null $Id
     * @param (
     *   \SimpleSAML\SOAP11\Type\MustUnderstandValue|
     *   \SimpleSAML\SOAP12\Type\MustUnderstandValue|
     *   null
     *) $mustUnderstand
     * @param \SimpleSAML\SOAP11\Type\ActorValue $actor
     * @param \SimpleSAML\SOAP12\Type\RoleValue $role
     * @param \SimpleSAML\SOAP12\Type\RelayValue $relay
     */
    final public function __construct(
        protected EncryptedData $encryptedData,
        protected ?IDValue $Id = null,
        protected MustUnderstandValueA|MustUnderstandValueB|null $mustUnderstand = null,
        ?ActorValue $actor = null,
        ?RoleValue $role = null,
        ?RelayValue $relay = null,
    ) {
        $this->setActor($actor);
        $this->setRole($role);
        $this->setRelay($relay);
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
     * Collect the value of the Id property
     *
     * @return \SimpleSAML\WebServices\Security\Type\IDValue|null
     */
    public function getId(): ?IDValue
    {
        return $this->Id;
    }


    /**
     * Collect the value of the mustUnderstand property
     *
     * @return (
     *   \SimpleSAML\SOAP11\Type\MustUnderstandValue|
     *   \SimpleSAML\SOAP12\Type\MustUnderstandValue|
     *   null
     *)
     */
    public function getMustUnderstand(): MustUnderstandValueA|MustUnderstandValueB|null
    {
        return $this->mustUnderstand;
    }


    /**
     * @param \DOMElement|null $parent
     */
    final public function toXML(?DOMElement $parent = null): DOMElement
    {
        $e = $this->instantiateParentElement($parent);

        $this->getEncryptedData()->toXML($e);

        if ($this->getId() !== null) {
            $this->getId()->toAttribute()->toXML($e);
        }

        if (
            $this->getMustUnderstand() !== null
            && $this->getMustUnderstand() instanceof MustUnderstandValueA
            && $this->getMustUnderstand()->toBoolean() !== false
        ) {
            $this->getMustUnderstand()->toAttribute()->toXML($e);
        }

        if ($this->getActor() !== null) {
            $this->getActor()->toAttribute()->toXML($e);
        }

        if (
            $this->getMustUnderstand() !== null
            && $this->getMustUnderstand() instanceof MustUnderstandValueB
            && $this->getMustUnderstand()->toBoolean() !== false
        ) {
            $this->getMustUnderstand()->toAttribute()->toXML($e);
        }

        if ($this->getRole() !== null) {
            $this->getRelay()->toAttribute()->toXML($e);
        }

        if ($this->getRelay() !== null && $this->getRelay()->toBoolean() !== false) {
            $this->getRelay()->toAttribute()->toXML($e);
        }

        return $e;
    }
}
