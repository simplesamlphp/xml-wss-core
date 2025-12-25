<?php

declare(strict_types=1);

namespace SimpleSAML\WebServices\Security\XML\wsu;

use SimpleSAML\WebServices\Security\Type\IDValue;

/**
 * @package simplesamlphp/xml-wss-core
 */
trait IDTrait
{
    /** @var \SimpleSAML\WebServices\Security\Type\IDValue|null */
    protected ?IDValue $id;


    /**
     * @return \SimpleSAML\WebServices\Security\Type\IDValue|null
     */
    public function getId(): ?IDValue
    {
        return $this->id;
    }


    /**
     * @param \SimpleSAML\WebServices\Security\Type\IDValue $id|null
     */
    private function setId(?IDValue $id): void
    {
        $this->id = $id;
    }
}
