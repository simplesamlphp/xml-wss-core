<?php

declare(strict_types=1);

namespace SimpleSAML\WebServices\Security\XML\wsse;

/**
 * @package simplesamlphp/xml-wss-core
 */
enum Faultcode: string
{
    case UnsupportedSecurityToken = 'wsse:UnsupportedSecurityToken';
    case UnsupportedAlgorithm = 'wsse:UnsupportedAlgorithm';
    case InvalidSecurity = 'wsse:InvalidSecurity';
    case InvalidSecurityToken = 'wsse:InvalidSecurityToken';
    case FailedAuthentication = 'wsse:FailedAuthentication';
    case FailedCheck = 'wsse:FailedCheck';
    case SecurityTokenUnavailable = 'wsse:SecurityTokenUnavailable';
}
