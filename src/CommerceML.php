<?php namespace Zenwalker\CommerceML;

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
    public $classCatalog;
    public $classClassifier;
    public $classOfferPackage;

    /**
     * @var \SimpleXMLElement|false
     */
    public $importXml;
    /**
     * @var \SimpleXMLElement|false
     */
    public $offersXml;
    /**
     * @var \SimpleXMLElement|false
     */
    public $ordersXml;
    /**
     * @var \SimpleXMLElement|false
     */
    public $pricesXml;
    /**
     * @var Catalog
     */
    public $catalog;
    /**
     * @var Classifier
     */
    public $classifier;

    /**
     * @var OfferPackage
     */
    public $offerPackage;

    /**
     * @var Order
     */
    public $order;

    public $importXmlFilePath;

    public $offersXmlFilePath;

    public $ordersXmlFilePath;

    public $pricesXmlFilePath;

    /**
     * Add XML files.
     *
     * @param string|bool $importXml
     * @param string|bool $offersXml
     * @param bool $ordersXml
     */
    public function addXmls($importXml = false, $offersXml = false, $ordersXml = false)
    {
        $this->loadImportXml($importXml);
        $this->loadOffersXml($offersXml);
        $this->loadOrdersXml($ordersXml);
    }

    /**
     * @param $file
     */
    public function loadImportXml($file)
    {
        $this->importXmlFilePath = $file;
        $this->importXml = $this->loadXml($file);
        $this->catalog = new Catalog($this);
        $this->classifier = new Classifier($this);
    }

    /**
     * @param $file
     */
    public function loadOffersXml($file)
    {
        $this->offersXmlFilePath = $file;
        $this->offersXml = $this->loadXml($file);
        $this->offerPackage = new OfferPackage($this);
        $this->classifier = new Classifier($this);
    }

    /**
     * @param $file
     */
    public function loadOrdersXml($file)
    {
        $this->ordersXmlFilePath = $file;
        $this->ordersXml = $this->loadXml($file);
        $this->order = new Order($this);
    }

    public function loadPricesXml($file)
    {
        $this->pricesXmlFilePath = $file;
        $this->pricesXml = $this->loadXml($file);
        $this->offerPackage = new OfferPackage($this);
        $this->classifier = new Classifier($this);
    }


    /**
     * Load XML form file or string.
     *
     * @param string $xml
     *
     * @return \SimpleXMLElement|false
     */
    private function loadXml($xml)
    {
        if (is_file($xml)) {
            return simplexml_load_string(file_get_contents($xml));
        }

        $xml = preg_replace('/^\xEF\xBB\xBF/', '', $xml);
        $xml = mb_convert_encoding($xml, 'UTF-8', mb_detect_encoding($xml, 'UTF-8, Windows-1251, ISO-8859-1', true));
        $simple = simplexml_load_string($xml);

        return $simple;
    }
}
