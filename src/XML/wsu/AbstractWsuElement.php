<?php

declare(strict_types=1);

namespace SimpleSAML\WebServices\Security\XML\wsu;

use SimpleSAML\WebServices\Security\Constants as C;
use SimpleSAML\XML\AbstractElement;

/**
 * Abstract class to be implemented by all the classes in this namespace
 *
 * @see https://docs.oasis-open.org/wss/v1.1/wss-v1.1-spec-pr-SOAPMessageSecurity-01.htm#_Toc106443153
 *
 * @package simplesamlphp/xml-wss-core
 */
abstract class AbstractWsuElement extends AbstractElement
{
    /** @var string */
    public const NS = C::NS_SEC_UTIL;

    /** @var string */
    public const NS_PREFIX = 'wsu';

    /** @var string */
    public const SCHEMA = 'resources/schemas/oasis-200401-wss-wssecurity-utility-1.0.xsd';
}
