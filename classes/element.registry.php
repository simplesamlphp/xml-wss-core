<?php

declare(strict_types=1);

return [
    'http://docs.oasis-open.org/wss/2004/01/oasis-200401-wss-wssecurity-secext-1.0.xsd' => [
        'BinarySecurityToken' => '\SimpleSAML\WebServices\Security\XML\wsse\BinarySecurityToken',
        'Embedded' => '\SimpleSAML\WebServices\Security\XML\wsse\Embedded',
        'KeyIdentifier' => '\SimpleSAML\WebServices\Security\XML\wsse\KeyIdentifier',
        'Nonce' => '\SimpleSAML\WebServices\Security\XML\wsse\Nonce',
        'Password' => '\SimpleSAML\WebServices\Security\XML\wsse\Password',
        'Reference' => '\SimpleSAML\WebServices\Security\XML\wsse\Reference',
        'Security' => '\SimpleSAML\WebServices\Security\XML\wsse\Security',
        'SecurityTokenReference' => '\SimpleSAML\WebServices\Security\XML\wsse\SecurityTokenReference',
        'TransformationParameters' => '\SimpleSAML\WebServices\Security\XML\wsse\TransformationParameters',
        'UsernameToken' => '\SimpleSAML\WebServices\Security\XML\wsse\UsernameToken',
    ],
    'http://docs.oasis-open.org/wss/2004/01/oasis-200401-wss-wssecurity-utility-1.0.xsd' => [
        'Created' => '\SimpleSAML\WebServices\Security\XML\wsu\Created',
        'Expires' => '\SimpleSAML\WebServices\Security\XML\wsu\Expires',
        'Timestamp' => '\SimpleSAML\WebServices\Security\XML\wsu\Timestamp',
    ],
];
