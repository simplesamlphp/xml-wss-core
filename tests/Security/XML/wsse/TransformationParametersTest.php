<?php

declare(strict_types=1);

namespace SimpleSAML\Test\WebServices\Security\XML\wsse;

use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\Group;
use PHPUnit\Framework\TestCase;
use SimpleSAML\WebServices\Security\XML\wsse\AbstractTransformationParametersType;
use SimpleSAML\WebServices\Security\XML\wsse\AbstractWsseElement;
use SimpleSAML\WebServices\Security\XML\wsse\TransformationParameters;
use SimpleSAML\XML\Attribute as XMLAttribute;
use SimpleSAML\XML\Chunk;
use SimpleSAML\XML\DOMDocumentFactory;
use SimpleSAML\XML\TestUtils\SchemaValidationTestTrait;
use SimpleSAML\XML\TestUtils\SerializableElementTestTrait;
use SimpleSAML\XMLSchema\Type\StringValue;

use function dirname;
use function strval;

/**
 * Tests for wsse:TransformationParameters.
 *
 * @package simplesamlphp/xml-wss-core
 */
#[Group('wsse')]
#[CoversClass(TransformationParameters::class)]
#[CoversClass(AbstractTransformationParametersType::class)]
#[CoversClass(AbstractWsseElement::class)]
final class TransformationParametersTest extends TestCase
{
    use SchemaValidationTestTrait;
    use SerializableElementTestTrait;


    /**
     */
    public static function setUpBeforeClass(): void
    {
        self::$testedClass = TransformationParameters::class;

        self::$xmlRepresentation = DOMDocumentFactory::fromFile(
            dirname(__FILE__, 4) . '/resources/xml/wsse/TransformationParameters.xml',
        );
    }


    // test marshalling


    /**
     * Test creating a TransformationParameters object from scratch.
     */
    public function testMarshalling(): void
    {
        $attr1 = new XMLAttribute('urn:x-simplesamlphp:namespace', 'ssp', 'attr1', StringValue::fromString('testval1'));
        $child = DOMDocumentFactory::fromString(
            '<ssp:Chunk xmlns:ssp="urn:x-simplesamlphp:namespace">SomeChunk</ssp:Chunk>',
        );

        $transformationParameters = new TransformationParameters(
            [new Chunk($child->documentElement)],
            [$attr1],
        );

        $this->assertEquals(
            self::$xmlRepresentation->saveXML(self::$xmlRepresentation->documentElement),
            strval($transformationParameters),
        );
    }


    /**
     */
    public function testMarshallingEmpty(): void
    {
        $transformationParameters = new TransformationParameters();

        $this->assertTrue($transformationParameters->isEmptyElement());
    }
}
