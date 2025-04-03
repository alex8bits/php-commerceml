<?php


namespace Zenwalker\CommerceML\Model;


use Zenwalker\CommerceML\Collections\PropertyCollection;
use Zenwalker\CommerceML\Collections\SpecificationCollection;

/**
 * Class Offer
 *
 * @package Zenwalker\CommerceML\Model
 * @property Price prices
 * @property SpecificationCollection specifications
 * @property \SimpleXMLElement ХарактеристикиТовара
 */
class Offer extends Simple
{
    /**
     * @var Price
     */
    protected $prices = [];
    protected $stockrooms = [];
    protected $specifications = [];
    protected $properties = [];
    protected $rests;

    /**
     * @return array|SpecificationCollection
     */
    public function getSpecifications()
    {
        if (empty($this->specifications)) {
            $this->specifications = new SpecificationCollection($this->owner, $this->ХарактеристикиТовара);
        }
        return $this->specifications;
    }

    public function getProperties()
    {
        if (!$this->properties) {
            $this->properties = new PropertyCollection($this->owner, $this->xml->ЗначенияСвойств);
        }

        return $this->properties;
    }

    /**
     * @return Price
     */
    public function getPrices()
    {
        if ($this->xml && empty($this->prices)) {
            $this->prices = new Price($this->owner, $this->xml->Цены);
        }
        return $this->prices;
    }

    public function getRests()
    {
        if ($this->xml && empty($this->rests) && isset($this->xml->Остатки->Остаток->Количество)) {
            $this->rests = $this->xml->Остатки->Остаток->Количество;
        }
        return $this->rests;
    }

    public function getStockrooms()
    {
        if ($this->xml && empty($this->stockrooms)) {
            foreach ($this->xml->Склад as $stockroom) {
                $this->stockrooms[] = new Stockroom($this->owner, $stockroom);
            }
        }
        return $this->stockrooms;
    }
}
