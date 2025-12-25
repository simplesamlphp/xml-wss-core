<?php

declare(strict_types=1);

namespace SimpleSAML\Test\WebServices\Security\XML\wsse11;

use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\Group;
use PHPUnit\Framework\TestCase;
use SimpleSAML\WebServices\Security\Type\IDValue;
use SimpleSAML\WebServices\Security\XML\wsse11\AbstractWsse11Element;
use SimpleSAML\WebServices\Security\XML\wsse11\SignatureConfirmation;
use SimpleSAML\XML\DOMDocumentFactory;
use SimpleSAML\XML\TestUtils\SchemaValidationTestTrait;
use SimpleSAML\XML\TestUtils\SerializableElementTestTrait;
use SimpleSAML\XMLSchema\Type\Base64BinaryValue;

use function dirname;
use function strval;

/**
 * Tests for wsse11:SignatureConfirmation.
 *
 * @package simplesamlphp/xml-wss-core
 */
#[Group('wsse11')]
#[CoversClass(SignatureConfirmation::class)]
#[CoversClass(AbstractWsse11Element::class)]
final class SignatureConfirmationTest extends TestCase
{
    use SchemaValidationTestTrait;
    use SerializableElementTestTrait;


    /**
     */
    public static function setUpBeforeClass(): void
    {
        self::$testedClass = SignatureConfirmation::class;

        self::$xmlRepresentation = DOMDocumentFactory::fromFile(
            dirname(__FILE__, 4) . '/resources/xml/wsse11/SignatureConfirmation.xml',
        );
    }


    // test marshalling


    /**
     * Test creating a SignatureConfirmation object from scratch.
     */
    public function testMarshalling(): void
    {
        $content = 'iVBORw0KGgoAAAANSUhEUgAAAAEAAAABCAQAAAC1HAwCAAAAC0lEQVR42mNkYAAAAAYAAjCB0C8AAAAASUVORK5CYII=';

        $signatureConfirmation = new SignatureConfirmation(
            Base64BinaryValue::fromString($content),
            IDValue::fromString('phpunit'),
        );

        $this->assertEquals(
            self::$xmlRepresentation->saveXML(self::$xmlRepresentation->documentElement),
            strval($signatureConfirmation),
        );
    }
}
