<?php

declare(strict_types=1);

namespace SimpleSAML\WebServices\Security\XML\wsse;

use SimpleSAML\WebServices\Security\Type\UsageValue;

/**
 * @package simplesamlphp/xml-wss-core
 */
trait UsageTrait
{
    /** @var \SimpleSAML\WebServices\Security\Type\UsageValue|null */
    protected ?UsageValue $usage;


    /**
     * @return \SimpleSAML\WebServices\Security\Type\UsageValue|null
     */
    public function getUsage(): ?UsageValue
    {
        return $this->usage;
    }


    /**
     * @param \SimpleSAML\WebServices\Security\Type\UsageValue|null $usage
     */
    private function setUsage(?UsageValue $usage): void
    {
        $this->usage = $usage;
    }
}
