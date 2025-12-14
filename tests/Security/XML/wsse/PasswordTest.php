<?php

declare(strict_types=1);

namespace SimpleSAML\Test\WebServices\Security\XML\wsse;

use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\Group;
use PHPUnit\Framework\TestCase;
use SimpleSAML\WebServices\Security\Type\IDValue;
use SimpleSAML\WebServices\Security\XML\wsse\AbstractAttributedString;
use SimpleSAML\WebServices\Security\XML\wsse\AbstractPasswordString;
use SimpleSAML\WebServices\Security\XML\wsse\AbstractWsseElement;
use SimpleSAML\WebServices\Security\XML\wsse\Password;
use SimpleSAML\XML\Attribute as XMLAttribute;
use SimpleSAML\XML\DOMDocumentFactory;
use SimpleSAML\XML\TestUtils\SerializableElementTestTrait;
use SimpleSAML\XMLSchema\Type\AnyURIValue;
use SimpleSAML\XMLSchema\Type\StringValue;

use function dirname;
use function strval;

/**
 * Tests for wsse:Password.
 *
 * @package simplesamlphp/xml-wss-core
 */
#[Group('wsse')]
#[CoversClass(Password::class)]
#[CoversClass(AbstractPasswordString::class)]
#[CoversClass(AbstractAttributedString::class)]
#[CoversClass(AbstractWsseElement::class)]
final class PasswordTest extends TestCase
{
    use SerializableElementTestTrait;


    /**
     */
    public static function setUpBeforeClass(): void
    {
        self::$testedClass = Password::class;

        self::$xmlRepresentation = DOMDocumentFactory::fromFile(
            dirname(__FILE__, 4) . '/resources/xml/wsse/Password.xml',
        );
    }


    // test marshalling


    /**
     * Test creating a Password object from scratch.
     */
    public function testMarshalling(): void
    {
        $attr = new XMLAttribute('urn:x-simplesamlphp:namespace', 'ssp', 'attr1', StringValue::fromString('testval1'));
        $password = new Password(
            StringValue::fromString('secret'),
            IDValue::fromString('SomeID'),
            [$attr],
            AnyURIValue::fromString('SomeType'),
        );

        $this->assertEquals(
            self::$xmlRepresentation->saveXML(self::$xmlRepresentation->documentElement),
            strval($password),
        );
    }
}
