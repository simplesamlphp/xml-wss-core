<?php

declare(strict_types=1);

namespace SimpleSAML\Test\WebServices\Security\XML\wsse;

use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\Group;
use PHPUnit\Framework\TestCase;
use SimpleSAML\WebServices\Security\XML\wsse\AbstractEmbeddedType;
use SimpleSAML\WebServices\Security\XML\wsse\AbstractWsseElement;
use SimpleSAML\WebServices\Security\XML\wsse\Embedded;
use SimpleSAML\XML\Attribute as XMLAttribute;
use SimpleSAML\XML\Chunk;
use SimpleSAML\XML\DOMDocumentFactory;
use SimpleSAML\XML\TestUtils\SchemaValidationTestTrait;
use SimpleSAML\XML\TestUtils\SerializableElementTestTrait;
use SimpleSAML\XMLSchema\Type\AnyURIValue;
use SimpleSAML\XMLSchema\Type\StringValue;

use function dirname;
use function strval;

/**
 * Tests for wsse:Embedded.
 *
 * @package simplesamlphp/xml-wss-core
 */
#[Group('wsse')]
#[CoversClass(Embedded::class)]
#[CoversClass(AbstractEmbeddedType::class)]
#[CoversClass(AbstractWsseElement::class)]
final class EmbeddedTest extends TestCase
{
    use SchemaValidationTestTrait;
    use SerializableElementTestTrait;


    /**
     */
    public static function setUpBeforeClass(): void
    {
        self::$testedClass = Embedded::class;

        self::$xmlRepresentation = DOMDocumentFactory::fromFile(
            dirname(__FILE__, 4) . '/resources/xml/wsse/Embedded.xml',
        );
    }


    // test marshalling


    /**
     * Test creating a Embedded object from scratch.
     */
    public function testMarshalling(): void
    {
        $attr1 = new XMLAttribute('urn:x-simplesamlphp:namespace', 'ssp', 'attr1', StringValue::fromString('testval1'));
        $child = DOMDocumentFactory::fromString(
            '<ssp:Chunk xmlns:ssp="urn:x-simplesamlphp:namespace">SomeChunk</ssp:Chunk>',
        );

        $embedded = new Embedded(
            AnyURIValue::fromString(
                'http://schemas.microsoft.com/5.0.0.0/ConfigurationManager/Enrollment/DeviceEnrollmentUserToken',
            ),
            [new Chunk($child->documentElement)],
            [$attr1],
        );

        $this->assertEquals(
            self::$xmlRepresentation->saveXML(self::$xmlRepresentation->documentElement),
            strval($embedded),
        );
    }


    /**
     */
    public function testMarshallingEmpty(): void
    {
        $embedded = new Embedded();

        $this->assertTrue($embedded->isEmptyElement());
    }
}
