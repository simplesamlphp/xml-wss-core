<?php

declare(strict_types=1);

namespace SimpleSAML\Test\WebServices\Security\XML\wsse11;

use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\Group;
use PHPUnit\Framework\TestCase;
use SimpleSAML\WebServices\Security\XML\wsse11\AbstractWsse11Element;
use SimpleSAML\WebServices\Security\XML\wsse11\Salt;
use SimpleSAML\XML\DOMDocumentFactory;
use SimpleSAML\XML\TestUtils\SchemaValidationTestTrait;
use SimpleSAML\XML\TestUtils\SerializableElementTestTrait;
use SimpleSAML\XMLSchema\Type\Base64BinaryValue;

use function dirname;
use function strval;

/**
 * Tests for wsse11:Salt.
 *
 * @package simplesamlphp/xml-wss-core
 */
#[Group('wsse11')]
#[CoversClass(Salt::class)]
#[CoversClass(AbstractWsse11Element::class)]
final class SaltTest extends TestCase
{
    use SchemaValidationTestTrait;
    use SerializableElementTestTrait;


    /**
     */
    public static function setUpBeforeClass(): void
    {
        self::$testedClass = Salt::class;

        self::$xmlRepresentation = DOMDocumentFactory::fromFile(
            dirname(__FILE__, 4) . '/resources/xml/wsse11/Salt.xml',
        );
    }


    // test marshalling


    /**
     * Test creating a Salt object from scratch.
     */
    public function testMarshalling(): void
    {
        $content = 'iVBORw0KGgoAAAANSUhEUgAAAAEAAAABCAQAAAC1HAwCAAAAC0lEQVR42mNkYAAAAAYAAjCB0C8AAAAASUVORK5CYII=';

        $salt = new Salt(
            Base64BinaryValue::fromString($content),
        );

        $this->assertEquals(
            self::$xmlRepresentation->saveXML(self::$xmlRepresentation->documentElement),
            strval($salt),
        );
    }
}
