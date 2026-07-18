<?php

declare(strict_types=1);

namespace SimpleSAML\WebServices\Security\Utils;

use Dom;
use SimpleSAML\WebServices\Security\Constants as C;

/**
 * Compilation of utilities for XPath.
 *
 * @package simplesamlphp/xml-wss-core
 */
class XPath extends \SimpleSAML\XPath\XPath
{
    /*
     * Get a Dom\XPath object that can be used to search for WS Security elements.
     *
     * @param \Dom\Node $node The document to associate to the Dom\XPath object.
     * @param bool $autoregister Whether to auto-register all namespaces used in the document
     *
     * @return \Dom\XPath A Dom\XPath object ready to use in the given document, with several
     *   ws-related namespaces already registered.
     */
    public static function getXPath(Dom\Node $node, bool $autoregister = false): Dom\XPath
    {
        $xp = parent::getXPath($node, $autoregister);

        $xp->registerNamespace('wsse', C::NS_SEC_EXT);
        $xp->registerNamespace('wsse11', C::NS_SEC_EXT_11);
        $xp->registerNamespace('wsu', C::NS_SEC_UTIL);

        return $xp;
    }
}
