<?php

declare(strict_types=1);

namespace SimpleSAML\WebServices\Security\XML\wsse11;

use SimpleSAML\WebServices\Security\Constants as C;
use SimpleSAML\XML\AbstractElement;

/**
 * Abstract class to be implemented by all the classes in this namespace
 *
 * @see https://docs.oasis-open.org/wss/v1.1/wss-v1.1-spec-pr-SOAPMessageSecurity-01.htm#_Toc106443153
 *
 * @package simplesamlphp/xml-wss-core
 */
abstract class AbstractWsse11Element extends AbstractElement
{
    public const string NS = C::NS_SEC_EXT_11;

    public const string NS_PREFIX = 'wsse11';

    public const string SCHEMA = 'resources/schemas/oasis-wss-wssecurity-secext-1.1.xsd';
}
