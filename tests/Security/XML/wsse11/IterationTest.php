<?php

declare(strict_types=1);

namespace SimpleSAML\Test\WebServices\Security\XML\wsse11;

use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\Group;
use PHPUnit\Framework\TestCase;
use SimpleSAML\WebServices\Security\XML\wsse11\AbstractWsse11Element;
use SimpleSAML\WebServices\Security\XML\wsse11\Iteration;
use SimpleSAML\XML\DOMDocumentFactory;
use SimpleSAML\XML\TestUtils\SchemaValidationTestTrait;
use SimpleSAML\XML\TestUtils\SerializableElementTestTrait;
use SimpleSAML\XMLSchema\Type\UnsignedIntValue;

use function dirname;
use function strval;

/**
 * Tests for wsse11:Iteration.
 *
 * @package simplesamlphp/xml-wss-core
 */
#[Group('wsse11')]
#[CoversClass(Iteration::class)]
#[CoversClass(AbstractWsse11Element::class)]
final class IterationTest extends TestCase
{
    use SchemaValidationTestTrait;
    use SerializableElementTestTrait;


    /**
     */
    public static function setUpBeforeClass(): void
    {
        self::$testedClass = Iteration::class;

        self::$xmlRepresentation = DOMDocumentFactory::fromFile(
            dirname(__FILE__, 4) . '/resources/xml/wsse11/Iteration.xml',
        );
    }


    // test marshalling


    /**
     * Test creating a Iteration object from scratch.
     */
    public function testMarshalling(): void
    {
        $iteration = new Iteration(
            UnsignedIntValue::fromInteger(5),
        );

        $this->assertEquals(
            self::$xmlRepresentation->saveXML(self::$xmlRepresentation->documentElement),
            strval($iteration),
        );
    }
}
