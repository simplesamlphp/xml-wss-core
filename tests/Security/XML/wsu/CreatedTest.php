<?php

declare(strict_types=1);

namespace SimpleSAML\Test\WebServices\Security\XML\wsu;

use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\Group;
use PHPUnit\Framework\TestCase;
use SimpleSAML\WebServices\Security\Type\DateTimeValue;
use SimpleSAML\WebServices\Security\XML\wsu\AbstractAttributedDateTime;
use SimpleSAML\WebServices\Security\XML\wsu\AbstractWsuElement;
use SimpleSAML\WebServices\Security\XML\wsu\Created;
use SimpleSAML\XML\DOMDocumentFactory;
use SimpleSAML\XML\TestUtils\SchemaValidationTestTrait;
use SimpleSAML\XML\TestUtils\SerializableElementTestTrait;

use function dirname;
use function strval;

/**
 * Tests for wsu:Created.
 *
 * @package simplesamlphp/xml-wss-core
 */
#[Group('wsu')]
#[CoversClass(Created::class)]
#[CoversClass(AbstractAttributedDateTime::class)]
#[CoversClass(AbstractWsuElement::class)]
final class CreatedTest extends TestCase
{
    use SchemaValidationTestTrait;
    use SerializableElementTestTrait;


    /**
     */
    public static function setUpBeforeClass(): void
    {
        self::$testedClass = Created::class;

        self::$xmlRepresentation = DOMDocumentFactory::fromFile(
            dirname(__FILE__, 4) . '/resources/xml/wsu/Created.xml',
        );
    }


    // test marshalling


    /**
     * Test creating an Created object from scratch.
     */
    public function testMarshalling(): void
    {
        $created = new Created(DateTimeValue::fromString('2001-09-13T08:42:00Z'));

        $this->assertEquals(
            self::$xmlRepresentation->saveXML(self::$xmlRepresentation->documentElement),
            strval($created),
        );
    }
}
