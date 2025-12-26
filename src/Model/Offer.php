<?php


namespace Zenwalker\CommerceML\Model;


use SimpleXMLElement;
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
    protected Price|array $prices = [];
    protected array $stockrooms = [];
    protected SpecificationCollection|array $specifications = [];
    protected PropertyCollection|array $properties = [];
    protected ?float $rests = null;

    /**
     * @return array|SpecificationCollection
     */
    public function getSpecifications(): SpecificationCollection|array
    {
        if (empty($this->specifications)) {
            $this->specifications = new SpecificationCollection($this->owner, $this->ХарактеристикиТовара);
        }
        return $this->specifications;
    }

    public function getProperties(): PropertyCollection|array
    {
        if (!$this->properties) {
            $this->properties = new PropertyCollection($this->owner, $this->xml->ЗначенияСвойств);
        }

        return $this->properties;
    }

    /**
     * @return Price
     */
    public function getPrices(): Price
    {
        if ($this->xml && empty($this->prices)) {
            $this->prices = new Price($this->owner, $this->xml->Цены);
        }
        return $this->prices;
    }

    public function getRests(): ?float
    {
        if ($this->xml && empty($this->rests) && isset($this->xml->Остатки->Остаток->Количество)) {
            $this->rests = (float) $this->xml->Остатки->Остаток->Количество;
        }
        return $this->rests;
    }

    public function getStockrooms(): array
    {
        if ($this->xml && empty($this->stockrooms)) {
            foreach ($this->xml->Склад as $stockroom) {
                $this->stockrooms[] = new Stockroom($this->owner, $stockroom);
            }
        }
        return $this->stockrooms;
    }
}
