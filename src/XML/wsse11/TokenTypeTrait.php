<?php

declare(strict_types=1);

namespace SimpleSAML\WebServices\Security\XML\wsse11;

use SimpleSAML\XMLSchema\Type\AnyURIValue;

/**
 * @package simplesamlphp/xml-wss-core
 *
 * @phpstan-ignore trait.unused
 */
trait TokenTypeTrait
{
    /** @var \SimpleSAML\XMLSchema\Type\AnyURIValue|null */
    protected ?AnyURIValue $tokenType;


    /**
     * @return \SimpleSAML\XMLSchema\Type\AnyURIValue|null
     */
    public function getTokenType(): ?AnyURIValue
    {
        return $this->tokenType;
    }


    /**
     * @param \SimpleSAML\XMLSchema\Type\AnyURIValue $usage|null
     */
    private function setTokenType(?AnyURIValue $tokenType): void
    {
        $this->tokenType = $tokenType;
    }
}
