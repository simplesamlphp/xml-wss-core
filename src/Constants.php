<?php

declare(strict_types=1);

namespace SimpleSAML\WebServices\Security;

/**
 * Class holding constants relevant for WS-Security.
 *
 * @package simplesamlphp/xml-wss-core
 */

class Constants extends \SimpleSAML\XML\Constants
{
    /**
     * The namespace for WS-Security extensions.
     */
    public const string NS_SEC_EXT =
        'http://docs.oasis-open.org/wss/2004/01/oasis-200401-wss-wssecurity-secext-1.0.xsd';

    /**
     * The namespace for WS-Security extensions 1.1.
     */
    public const string NS_SEC_EXT_11 =
        'http://docs.oasis-open.org/wss/oasis-wss-wssecurity-secext-1.1.xsd';

    /**
     * The namespace for WS-Security utilities protocol.
     */
    public const string NS_SEC_UTIL =
        'http://docs.oasis-open.org/wss/2004/01/oasis-200401-wss-wssecurity-utility-1.0.xsd';

    /**
     */
    public const string WSU_TIMESTAMP_FAULT = 'MessageExpired';

    /**
     * The format to express a timestamp in WSU
     */
    public const string DATETIME_FORMAT = 'Y-m-d\\TH:i:sp';
}
