<?php


namespace Zenwalker\CommerceML\Tests;


use Zenwalker\CommerceML\CommerceML;

abstract class TestCase extends \PHPUnit\Framework\TestCase
{
    protected static string $import = __DIR__ . '/xml/import.xml';
    protected static string $offer = __DIR__ . '/xml/offers.xml';
    protected static string $order = __DIR__ . '/xml/orders.xml';
    protected static string $classifier = __DIR__ . '/xml/classifier.xml';
    protected static string $importWoClassifier = __DIR__ . '/xml/import_wo_classifier.xml';

    /**
     * @var null|CommerceML
     */
    protected ?CommerceML $cml;

    public function setUp(): void
    {
        parent::setUp();
        $this->cml = new CommerceML();
    }

    protected function tearDown(): void
    {
        $this->cml = null;
        parent::tearDown();
    }

    /**
     * @return array
     */
    public static function xmlProvider(): array
    {
        return [
            [
                [
                    'import' => self::$import,
                    'offer' => self::$offer,
                    'order' => self::$order,
                    'classifier' => self::$classifier,
                    'importWoClassifier' => self::$importWoClassifier,
                ],
            ],
            [
                [
                    'import' => file_get_contents(self::$import),
                    'offer' => file_get_contents(self::$offer),
                    'order' => file_get_contents(self::$order),
                    'classifier' => file_get_contents(self::$classifier),
                    'importWoClassifier' => file_get_contents(self::$importWoClassifier),
                ],
            ],
        ];
    }
}