<?php

declare(strict_types=1);

namespace SimpleSAML\Test\WebServices\Security\XML\wsse11;

use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\Group;
use PHPUnit\Framework\TestCase;
use SimpleSAML\SOAP11\Type\ActorValue;
use SimpleSAML\SOAP11\Type\MustUnderstandValue;
use SimpleSAML\WebServices\Security\Type\IDValue;
use SimpleSAML\WebServices\Security\XML\wsse11\AbstractWsse11Element;
use SimpleSAML\WebServices\Security\XML\wsse11\EncryptedHeader;
use SimpleSAML\XML\DOMDocumentFactory;
use SimpleSAML\XML\TestUtils\SchemaValidationTestTrait;
use SimpleSAML\XML\TestUtils\SerializableElementTestTrait;
use SimpleSAML\XMLSchema\Type\AnyURIValue;
use SimpleSAML\XMLSchema\Type\Base64BinaryValue;
use SimpleSAML\XMLSchema\Type\IDValue as BaseIDValue;
use SimpleSAML\XMLSchema\Type\StringValue;
use SimpleSAML\XMLSecurity\Constants as C;
use SimpleSAML\XMLSecurity\XML\ds\KeyInfo;
use SimpleSAML\XMLSecurity\XML\xenc\CipherData;
use SimpleSAML\XMLSecurity\XML\xenc\CipherValue;
use SimpleSAML\XMLSecurity\XML\xenc\EncryptedData;
use SimpleSAML\XMLSecurity\XML\xenc\EncryptedKey;
use SimpleSAML\XMLSecurity\XML\xenc\EncryptionMethod;

use function dirname;
use function strval;

/**
 * Tests for wsse11:EncryptedHeader.
 *
 * @package simplesamlphp/xml-wss-core
 */
#[Group('wsse11')]
#[CoversClass(EncryptedHeader::class)]
#[CoversClass(AbstractWsse11Element::class)]
final class EncryptedHeaderTest extends TestCase
{
    use SchemaValidationTestTrait;
    use SerializableElementTestTrait;


    /**
     */
    public static function setUpBeforeClass(): void
    {
        self::$testedClass = EncryptedHeader::class;

        self::$xmlRepresentation = DOMDocumentFactory::fromFile(
            dirname(__FILE__, 4) . '/resources/xml/wsse11/EncryptedHeader.xml',
        );
    }


    // test marshalling


    /**
     * Test creating a EncryptedHeader object from scratch.
     */
    public function testMarshalling(): void
    {
        $mustUnderstand = MustUnderstandValue::fromBoolean(true);
        $actor = ActorValue::fromString('urn:x-simplesamlphp:namespace');

        $encryptedData = new EncryptedData(
            new CipherData(
                new CipherValue(
                    Base64BinaryValue::fromString('/CTj03d1DB5e2t7CTo9BEzCf5S9NRzwnBgZRlm32REI='),
                ),
            ),
            BaseIDValue::fromString('MyID'),
            AnyURIValue::fromString(C::XMLENC_ELEMENT),
            StringValue::fromString('text/plain'),
            AnyURIValue::fromString('urn:x-simplesamlphp:encoding'),
            new EncryptionMethod(
                AnyURIValue::fromString(C::BLOCK_ENC_AES128),
            ),
            new KeyInfo(
                [
                    new EncryptedKey(
                        new CipherData(
                            new CipherValue(
                                Base64BinaryValue::fromString('/CTj03d1DB5e2t7CTo9BEzCf5S9NRzwnBgZRlm32REI='),
                            ),
                        ),
                        null,
                        null,
                        null,
                        null,
                        null,
                        null,
                        new EncryptionMethod(
                            AnyURIValue::fromString(C::SIG_RSA_SHA256),
                        ),
                    ),
                ],
            ),
        );

        $encryptedHeader = new EncryptedHeader(
            $encryptedData,
            IDValue::fromString('phpunit'),
            $mustUnderstand,
            $actor,
        );

        $this->assertEquals(
            self::$xmlRepresentation->saveXML(self::$xmlRepresentation->documentElement),
            strval($encryptedHeader),
        );
    }
}
