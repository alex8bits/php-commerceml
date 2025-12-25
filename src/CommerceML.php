<?php

namespace Zenwalker\CommerceML;

use SimpleXMLElement;
use Zenwalker\CommerceML\Model\Catalog;
use Zenwalker\CommerceML\Model\Classifier;
use Zenwalker\CommerceML\Model\OfferPackage;
use Zenwalker\CommerceML\Model\Order;

/**
 * Class CommerceML
 *
 * @package Zenwalker\CommerceML
 */
class CommerceML
{
    public ?SimpleXMLElement $importXml = null;

    public ?SimpleXMLElement $offersXml = null;

    public ?SimpleXMLElement $ordersXml = null;


    public Catalog $catalog;

    public Classifier $classifier;

    public OfferPackage $offerPackage;

    public Order $order;

    public string $importXmlFilePath;

    public string $offersXmlFilePath;

    public string $ordersXmlFilePath;

    /**
     * Add XML files.
     */
    public function addXmls(?string $importXml = null, ?string $offersXml = null, ?string $ordersXml = null): void
    {
        if ($importXml !== null) {
            $this->loadImportXml($importXml);
        }
        if ($offersXml !== null) {
            $this->loadOffersXml($offersXml);
        }
        if ($ordersXml !== null) {
            $this->loadOrdersXml($ordersXml);
        }
    }

    public function loadImportXml(string $file): void
    {
        $this->importXmlFilePath = $file;
        $this->importXml = $this->loadXml($file);
        $this->catalog = new Catalog($this);
        $this->classifier = new Classifier($this);
    }

    public function loadOffersXml(string $file): void
    {
        $this->offersXmlFilePath = $file;
        $this->offersXml = $this->loadXml($file);
        $this->offerPackage = new OfferPackage($this);
        $this->classifier = new Classifier($this);
    }

    public function loadOrdersXml(string $file): void
    {
        $this->ordersXmlFilePath = $file;
        $this->ordersXml = $this->loadXml($file);
        $this->order = new Order($this);
    }

    /**
     * Load XML form file or string.
     *
     * @param string $xml
     *
     * @return \SimpleXMLElement|null
     */
    private function loadXml(string $xml): ?SimpleXMLElement
    {
        if (is_file($xml)) {
            $xml = file_get_contents($xml);
        }

        $xml = preg_replace('/^\xEF\xBB\xBF/', '', $xml);

        if (extension_loaded('mbstring')) {
            $detectedEncoding = mb_detect_encoding($xml, ['UTF-8', 'Windows-1251', 'ISO-8859-1'], true);

            $xml = (string)mb_convert_encoding($xml, 'UTF-8', $detectedEncoding);
        }

        $simpleXml = simplexml_load_string($xml);
        if ($simpleXml === false) {
            return null;
        }
        return $simpleXml;
    }
}
