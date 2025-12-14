<?php

declare(strict_types=1);

namespace SimpleSAML\Test\WebServices\Security\XML\wsse;

use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\Group;
use PHPUnit\Framework\TestCase;
use SimpleSAML\WebServices\Security\Type\IDValue;
use SimpleSAML\WebServices\Security\XML\wsse\AbstractSecurityHeaderType;
use SimpleSAML\WebServices\Security\XML\wsse\AbstractWsseElement;
use SimpleSAML\WebServices\Security\XML\wsse\BinarySecurityToken;
use SimpleSAML\WebServices\Security\XML\wsse\Reference;
use SimpleSAML\WebServices\Security\XML\wsse\Security;
use SimpleSAML\WebServices\Security\XML\wsse\SecurityTokenReference;
use SimpleSAML\XML\Attribute as XMLAttribute;
use SimpleSAML\XML\DOMDocumentFactory;
use SimpleSAML\XML\TestUtils\SchemaValidationTestTrait;
use SimpleSAML\XML\TestUtils\SerializableElementTestTrait;
use SimpleSAML\XMLSchema\Type\AnyURIValue;
use SimpleSAML\XMLSchema\Type\Base64BinaryValue;
use SimpleSAML\XMLSchema\Type\StringValue;
use SimpleSAML\XMLSecurity\Constants as C;
use SimpleSAML\XMLSecurity\Type\DigestValue as DigestValueType;
use SimpleSAML\XMLSecurity\XML\ds\CanonicalizationMethod;
use SimpleSAML\XMLSecurity\XML\ds\DigestMethod;
use SimpleSAML\XMLSecurity\XML\ds\DigestValue;
use SimpleSAML\XMLSecurity\XML\ds\KeyInfo;
use SimpleSAML\XMLSecurity\XML\ds\Reference as DSReference;
use SimpleSAML\XMLSecurity\XML\ds\Signature;
use SimpleSAML\XMLSecurity\XML\ds\SignatureMethod;
use SimpleSAML\XMLSecurity\XML\ds\SignatureValue;
use SimpleSAML\XMLSecurity\XML\ds\SignedInfo;

use function dirname;
use function strval;

/**
 * Tests for wsse:Security.
 *
 * @package simplesamlphp/xml-wss-core
 */
#[Group('wsse')]
#[CoversClass(Security::class)]
#[CoversClass(AbstractSecurityHeaderType::class)]
#[CoversClass(AbstractWsseElement::class)]
final class SecurityTest extends TestCase
{
    use SchemaValidationTestTrait;
    use SerializableElementTestTrait;


    /**
     */
    public static function setUpBeforeClass(): void
    {
        self::$testedClass = Security::class;

        self::$xmlRepresentation = DOMDocumentFactory::fromFile(
            dirname(__FILE__, 4) . '/resources/xml/wsse/Security.xml',
        );
    }


    // test marshalling


    /**
     * Test creating a Security object from scratch.
     */
    public function testMarshalling(): void
    {
        $content = '/CTj03d1DB5e2t7CTo9BEzCf5S9NRzwnBgZRlm32REI=';
        $attr1 = new XMLAttribute('urn:x-simplesamlphp:namespace', 'ssp', 'attr1', StringValue::fromString('testval1'));

        $binarySecurityToken = new BinarySecurityToken(
            StringValue::fromString($content),
            IDValue::fromString('X509Token'),
            [$attr1],
            AnyURIValue::fromString(
                'http://schemas.microsoft.com/5.0.0.0/ConfigurationManager/Enrollment/DeviceEnrollmentUserToken',
            ),
            AnyURIValue::fromString(
                'http://docs.oasis-open.org/wss/2004/01/oasis-200401-wss-wssecurity-secext-1.0.xsd#base64binary',
            ),
        );

        $securityTokenReference = new SecurityTokenReference(
            null,
            null,
            [
                new Reference(AnyURIValue::fromString('#X509Token')),
            ],
        );

        $signature = new Signature(
            new SignedInfo(
                new CanonicalizationMethod(
                    AnyURIValue::fromString(C::C14N_EXCLUSIVE_WITHOUT_COMMENTS),
                ),
                new SignatureMethod(
                    AnyURIValue::fromString(C::SIG_RSA_SHA256),
                ),
                [
                    new DSReference(
                        new DigestMethod(AnyURIValue::fromString(C::DIGEST_SHA256)),
                        new DigestValue(DigestValueType::fromString($content)),
                        null,
                        null,
                        null,
                        AnyURIValue::fromString('#MsgBody'),
                    ),
                ],
            ),
            new SignatureValue(Base64BinaryValue::fromString($content)),
            new KeyInfo([$securityTokenReference]),
        );

        $security = new Security(
            [$binarySecurityToken, $signature],
            [$attr1],
        );

        $this->assertEquals(
            self::$xmlRepresentation->saveXML(self::$xmlRepresentation->documentElement),
            strval($security),
        );
    }


    /**
     */
    public function testMarshallingEmpty(): void
    {
        $security = new Security();

        $this->assertTrue($security->isEmptyElement());
    }
}
