<?php


namespace Zenwalker\CommerceML\Collections;

use Zenwalker\CommerceML\Model\Property;
use Zenwalker\CommerceML\Model\Simple;

/**
 * Class ValueProperties
 *
 * @package Zenwalker\CommerceML\Model
 */
class PropertyCollection extends Simple
{
    /**
     * @param $id
     * @return Property|null
     */
    public function getById($id): ?Property
    {
        foreach ($this as $property) {
            if ($property->id === (string)$id) {
                return $property;
            }
        }
        return null;
    }

    protected function loadPropertiesValue(): void
    {
        foreach ($this->xml->ЗначенияСвойства as $property) {
            $properties = $this->owner->classifier->getProperties();
            $object = $properties->getById((string)$property->Ид);
            if ($object) {
                $clone = clone $object;
                $clone->productId = (string)$this->xpath('..')[0]->Ид;
                $clone->init();
                $this->append($clone);
            }
        }
    }

    protected function loadProperties(): void
    {
        foreach ($this->xml->Свойство as $property) {
            $this->append(new Property($this->owner, $property));
        }
    }

    public function init(): void
    {
        if (isset($this->xml->ЗначенияСвойства)) {
            $this->loadPropertiesValue();
        }
        if (isset($this->xml->Свойство)) {
            $this->loadProperties();
        }
        parent::init();
    }
}
