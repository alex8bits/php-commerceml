<?php namespace Zenwalker\CommerceML\Model;

/**
 * Class Property
 *
 * @package Zenwalker\CommerceML\Model
 * @property \SimpleXMLElement[] availableValues
 * @property Simple valueModel
 * @property mixed value
 */
class Property extends Simple
{
    public string $productId;
    protected Simple $_value;

    /**
     * @return \SimpleXMLElement[]
     */
    public function getAvailableValues(): array
    {
        return $this->owner->classifier->getReferenceBookById($this->id);
    }

    /**
     * @return Simple|null
     */
    public function getValueModel(): ?Simple
    {
        if (isset($this->productId) && !isset($this->_value) && ($product = $this->owner->catalog->getById($this->productId))) {
            $xpath = "c:ЗначенияСвойств/c:ЗначенияСвойства[c:Ид = '{$this->id}']";
            $valueXml = $product->xpath($xpath)[0];
            $value = (string)$valueXml->Значение;
            if ($property = $this->owner->classifier->getReferenceBookValueById($value)) {
                $this->_value = new Simple($this->owner, $property);
            } else {
                $this->_value = new Simple($this->owner, $valueXml);
            }
        }
        return $this->_value;
    }

    public function getValue(): ?string
    {
        return $this->getValueModel() ? $this->getValueModel()->value : null;
    }
}