<?php

declare(strict_types=1);

namespace SimpleSAML\Test\WebServices\Security\XML\wsse;

use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\Group;
use PHPUnit\Framework\TestCase;
use SimpleSAML\WebServices\Security\Type\IDValue;
use SimpleSAML\WebServices\Security\XML\wsse\AbstractUsernameTokenType;
use SimpleSAML\WebServices\Security\XML\wsse\AbstractWsseElement;
use SimpleSAML\WebServices\Security\XML\wsse\Username;
use SimpleSAML\WebServices\Security\XML\wsse\UsernameToken;
use SimpleSAML\XML\Attribute as XMLAttribute;
use SimpleSAML\XML\Chunk;
use SimpleSAML\XML\DOMDocumentFactory;
use SimpleSAML\XML\TestUtils\SchemaValidationTestTrait;
use SimpleSAML\XML\TestUtils\SerializableElementTestTrait;
use SimpleSAML\XMLSchema\Type\StringValue;

use function dirname;
use function strval;

/**
 * Tests for wsse:UsernameToken.
 *
 * @package simplesamlphp/xml-wss-core
 */
#[Group('wsse')]
#[CoversClass(UsernameToken::class)]
#[CoversClass(AbstractUsernameTokenType::class)]
#[CoversClass(AbstractWsseElement::class)]
final class UsernameTokenTest extends TestCase
{
    use SchemaValidationTestTrait;
    use SerializableElementTestTrait;


    /**
     */
    public static function setUpBeforeClass(): void
    {
        self::$testedClass = UsernameToken::class;

        self::$xmlRepresentation = DOMDocumentFactory::fromFile(
            dirname(__FILE__, 4) . '/resources/xml/wsse/UsernameToken.xml',
        );
    }


    // test marshalling


    /**
     * Test creating a UsernameToken object from scratch.
     */
    public function testMarshalling(): void
    {
        $attr1 = new XMLAttribute('urn:x-simplesamlphp:namespace', 'ssp', 'attr1', StringValue::fromString('testval1'));
        $attr2 = new XMLAttribute('urn:x-simplesamlphp:namespace', 'ssp', 'attr2', StringValue::fromString('testval2'));
        $username = new Username(
            StringValue::fromString('johndoe@example.com'),
            IDValue::fromString('OtherID'),
            [$attr2],
        );
        $child = DOMDocumentFactory::fromString(
            '<ssp:Chunk xmlns:ssp="urn:x-simplesamlphp:namespace">SomeChunk</ssp:Chunk>',
        );

        $usernameToken = new UsernameToken(
            $username,
            IDValue::fromString('SomeID'),
            [new Chunk($child->documentElement)],
            [$attr1],
        );

        $this->assertEquals(
            self::$xmlRepresentation->saveXML(self::$xmlRepresentation->documentElement),
            strval($usernameToken),
        );
    }
}
