<?php

declare(strict_types=1);

namespace SimpleSAML\WebServices\Security\XML\wsse;

use SimpleSAML\WebServices\Security\Constants as C;
use SimpleSAML\XML\AbstractElement;

/**
 * Abstract class to be implemented by all the classes in this namespace
 *
 * @see https://docs.oasis-open.org/wss/v1.1/wss-v1.1-spec-pr-SOAPMessageSecurity-01.htm#_Toc106443153
 *
 * @package simplesamlphp/xml-wss-core
 */
abstract class AbstractWsseElement extends AbstractElement
{
    public const string NS = C::NS_SEC_EXT;

    public const string NS_PREFIX = 'wsse';

    public const string SCHEMA = 'resources/schemas/oasis-200401-wss-wssecurity-secext-1.0.xsd';
}
