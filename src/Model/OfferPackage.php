<?php


namespace Zenwalker\CommerceML\Model;

use SimpleXMLElement;

/**
 * Class OfferPackage
 *
 * @package Zenwalker\CommerceML\Model
 * @property Offer[] offers
 * @property string containsOnlyChanges
 */
class OfferPackage extends Simple
{
    /**
     * @var Offer[]
     */
    protected array $offers = [];
    protected array $stockrooms = [];
    /**
     * @var Simple[] array
     */
    protected array $priceTypes = [];

    public function propertyAliases(): array
    {
        return array_merge(parent::propertyAliases(), [
            'СодержитТолькоИзменения' => 'containsOnlyChanges'
        ]);
    }

    public function loadXml(): ?SimpleXMLElement
    {
        return $this->owner->offersXml->ПакетПредложений ?? null;
    }

    /**
     * @return Offer[]
     */
    public function getOffers(): array
    {
        if (empty($this->offers) && $this->xml && $this->xml->Предложения) {
            foreach ($this->xml->Предложения->Предложение as $offer) {
                $this->offers[] = new Offer($this->owner, $offer);
            }
        }
        return $this->offers;
    }

    /**
     * @return Simple[]
     */
    public function getPriceTypes(): array
    {
        if (empty($this->priceTypes) && $this->xml) {
            foreach ($this->xpath('//c:ТипыЦен/c:ТипЦены') as $type) {
                $this->priceTypes[] = new Simple($this->owner, $type);
            }
        }
        return $this->priceTypes;
    }

    /**
     * @param $id
     * @return null|Offer
     * @deprecated will removed in 0.3.0
     */
    public function getOfferById($id): ?Offer
    {
        foreach ($this->getOffers() as $offer) {
            if ($offer->getClearId() === $id) {
                return $offer;
            }
        }
        return null;
    }

    /**
     * @param $id
     * @return Offer[]
     */
    public function getOffersById($id): array
    {
        $result = [];
        foreach ($this->getOffers() as $offer) {
            if ($offer->getClearId() === $id) {
                $result[] = $offer;
            }
        }
        return $result;
    }

    /**
     * @return Stockroom[]
     */
    public function getStockrooms(): array
    {
        if (empty($this->stockrooms) && isset($this->xml->Склады)) {
            foreach ($this->xml->Склады->Склад as $stockroom) {
                $this->stockrooms[] = new Stockroom($this->owner, $stockroom);
            }
        }
        return $this->stockrooms;
    }
}
